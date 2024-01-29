<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Roll;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RollController extends Controller
{
    public function index()
    {

        $rolls = Roll::orderBy('created_at', 'desc')->where('used', false)->get();

        return view('pages.rolls.index', compact('rolls'));
    }

    public function used()
    {

        $rolls = Roll::orderBy('created_at', 'desc')->where('used', true)->get();

        return view('pages.rolls.used', compact('rolls'));
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
            'rolls.*.glue' => 'required|boolean',
            'rolls.*.price' => 'required|numeric',
            'contact_id' => 'required|exists:contacts,id',
            'amount' => 'required|numeric',
            'method' => 'required',
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
                ]);
            }elseif ($request->amount > 0 && $request->amount < $transaction->total) {
                $transaction->update([
                    'payment_status' => 'debt',
                ]);

                Payment::create([
                    'contact_id' => $request->contact_id,
                    'transaction_id' => $transaction->id,
                    'user_id' => auth()->user()->id,
                    'amount' => $request->amount,
                    'method' => $request->method,
                ]);
            }

            DB::commit();

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
            'roll_id' => 'required|exists:rolls,id',
            'used_date' => 'required|date',
        ]);

        $roll = Roll::find($request->roll_id);

        if ($roll->used) {
            return redirect()->back()->with('error', 'Этот рулон уже использован.');
        }

        $roll->update([
            'used' => true,
            'used_date' => $request->used_date,
            'used_description' => $request->used_description,
            'used_user_id' => auth()->user()->id,
        ]);

        return redirect()->back()->with('success', 'Успешно использовано.');
    }

    public function destroyUsed(Roll $roll)
    {
        $roll->update([
            'used' => false,
            'used_date' => null,
            'used_description' => null,
            'used_user_id' => null,
        ]);

        return redirect()->back()->with('success', 'Успешно удалено.');
    }
}
