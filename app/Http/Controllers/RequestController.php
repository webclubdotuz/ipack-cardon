<?php

namespace App\Http\Controllers;

use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;

class RequestController extends Controller
{

    public function index(Request $request)
    {

        $status = $request->status ? $request->status : 'pending';

        $requests = ModelsRequest::where('status', $status)->get();

        return view('pages.requests.index', compact('requests'));
    }


    public function create()
    {
        return view('pages.requests.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'cardon_id' => 'required|exists:cardons,id',
            'quantity' => 'required|numeric',
            'deadline' => 'required|date|after:today', // '2022-02-02'
            'description' => 'required',
        ]);

        $request = ModelsRequest::create([
            'contact_id' => $request->contact_id,
            'cardon_id' => $request->cardon_id,
            'quantity' => $request->quantity,
            'user_id' => $request->user()->id,
            'deadline' => $request->deadline,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return redirect()->route('requests.index')->with('success', 'Успешно добавлено');
    }

    public function show(ModelsRequest $request)
    {
        return view('pages.requests.show', compact('request'));
    }

    public function destroy(ModelsRequest $request)
    {

        if ($request->status !== 'pending') {
            return redirect()->route('requests.index')->with('error', 'Нельзя удалить заявку в статусе ' . $request->status);
        }

        $request->delete();
        return redirect()->route('requests.index')->with('success', 'Успешно удалено');
    }
}
