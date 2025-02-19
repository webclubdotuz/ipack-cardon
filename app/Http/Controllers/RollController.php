<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Roll;
use App\Models\RollUsed;
use App\Models\Transaction;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RollController extends Controller
{
    public function index()
    {

        $rolls = Roll::orderBy('created_at', 'desc')->where('used', false)->get();

        return view('pages.rolls.index', compact('rolls'));
    }

    public function used(Request $request)
    {

        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-d');

        $rolls = Roll::orderBy('created_at', 'desc')
            ->whereBetween('used_date', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
            ->where('used', true)->get();

        return view('pages.rolls.used', compact('rolls', 'start_date', 'end_date'));
    }

    public function create()
    {
        return view('pages.rolls.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'rolls' => 'required|array',
            'rolls.*.size' => 'required|numeric',
            'rolls.*.weight' => 'required|numeric',
            'rolls.*.paper_weight' => 'required|numeric',
            'rolls.*.glue' => 'required',
            'rolls.*.price' => 'required|numeric',
            'contact_id' => 'required|exists:contacts,id',
            'amount' => 'required|numeric',
            'method' => 'required',
            'created_at' => 'nullable|date_format:Y-m-d',
        ]);

        DB::beginTransaction();

        try {
            $transaction = Transaction::create([
                'contact_id' => $request->contact_id,
                'user_id' => auth()->user()->id,
                'type' => 'roll',
                'status' => 'completed',
                'payment_status' => 'debt',
                'total' => 0,
                'description' => $request->description,
                'created_at' => $request->created_at . ' ' . date('H:i:s'),
            ]);

            foreach ($request->rolls as $roll) {
                Roll::create([
                    'transaction_id' => $transaction->id,
                    'user_id' => auth()->user()->id,
                    'size' => $roll['size'],
                    'weight' => $roll['weight'],
                    'paper_weight' => $roll['paper_weight'],
                    'glue' => $roll['glue'],
                    'price' => $roll['price'],
                    'total' => $roll['price'] * $roll['weight'],
                    'created_at' => $request->created_at . ' ' . date('H:i:s'),
                ]);
            }

            $transaction->update([
                'total' => $transaction->rolls()->sum('total'),
            ]);

            if ($request->amount > 0 && $request->amount == $transaction->total) {
                $transaction->update([
                    'payment_status' => 'paid',
                ]);

                Payment::create([
                    'contact_id' => $request->contact_id,
                    'transaction_id' => $transaction->id,
                    'user_id' => auth()->user()->id,
                    'amount' => $transaction->total,
                    'method' => $request->method,
                    'created_at' => $request->created_at . ' ' . date('H:i:s'),
                ]);
            } elseif ($request->amount > 0 && $request->amount < $transaction->total) {
                $transaction->update([
                    'payment_status' => 'debt',
                ]);

                Payment::create([
                    'contact_id' => $request->contact_id,
                    'transaction_id' => $transaction->id,
                    'user_id' => auth()->user()->id,
                    'amount' => $request->amount,
                    'method' => $request->method,
                    'created_at' => $request->created_at . ' ' . date('H:i:s'),
                ]);
            }

            DB::commit();

            $message = "🔔🔔🔔🔔🔔🔔\n";
            $message .= "📥Покупки\n";
            $message .= "🙎🏻‍♂️ Поставщик : " . $transaction->contact->fullname . "\n";
            $message .= "📱 Телефон: " . $transaction->contact->phone . "\n";

            foreach ($transaction->rolls as $roll) {
                $message .= "📦Товары: Рулон " . $roll->size . " см / " . $roll->paper_weight . " гр / " . $roll->weight . " кг\n";
                $message .= "💲Цена: " . nf($roll->price) . "\n";
                $message .= "💰 Сумма " . nf($roll->total) . "\n";
                $message .= "____________________\n";
            }

            $message .= "💰 Общий сумма: " . nf($transaction->total) . "\n";
            $message .= "💰 Оплачено: " . nf($transaction->paid) . "\n";
            $message .= "❗️ Остаток: " . nf($transaction->debt) . "\n";
            $message .= "📅 Дата: " . $transaction->created_at->format('j M Y H:i') . "\n";
            $message .= "👨‍💻 Сотрудник: " . $transaction->user->fullname . "\n";

            // send message to telegram
            TelegramService::sendChannel($message);

            return redirect()->back()->with('success', 'Успешно добавлено.');
        } catch (\Exception $e) {
            DB::rollback();

            dd($e->getMessage());

            return redirect()->back()->with('error', 'Something went wrong.' . $e->getMessage());
        }
    }

    public function storeUsed(Request $request)
    {
        $request->validate([
            'used_weight' => 'required|numeric',
            'roll_id' => 'required|exists:rolls,id',
            'used_date' => 'required|date',
        ]);

        $roll = Roll::find($request->roll_id);

        if ($roll->used) {
            return redirect()->back()->with('error', 'Этот рулон уже использован.');
        }

        if ($request->used_weight > $roll->balance) {
            return redirect()->back()->with('error', 'Вес использованного рулона больше остатка.');
        }

        DB::beginTransaction();
        try {
            $roll->roll_useds()->create([
                'user_id' => auth()->user()->id,
                'weight' => $request->used_weight,
                'description' => $request->used_description,
                'date' => $request->used_date,
            ]);

            $roll->refresh();

            if ($roll->balance == 0) {
                $roll->update([
                    'used' => true,
                    'used_date' => $request->used_date,
                    'used_description' => $request->used_description,
                    'used_user_id' => auth()->user()->id,
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Успешно использовано.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            dd($th->getMessage());
        }
    }

    public function destroyUsed(RollUsed $roll)
    {

        $rollUsed = $roll;

        $rollUsed->roll->update([
            'used' => false,
            'used_date' => null,
            'used_description' => null,
            'used_user_id' => null,
        ]);

        $rollUsed->delete();


        return redirect()->back()->with('success', 'Успешно удалено.');
    }
}
