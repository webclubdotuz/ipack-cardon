<?php

namespace App\Http\Controllers;

use App\Models\Invenst;
use Illuminate\Http\Request;

class InvenstController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-d');
        $method = $request->method ?? '';

        $invensts = Invenst::whereBetween('date', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
        ->when($method, function ($query, $method) {
            return $query->where('method', $method);
        })
        ->orderBy('date', 'desc')
        ->get();

        return view('pages.invensts.index', compact('invensts', 'start_date', 'end_date'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.invensts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'user_id',
            'amount' => 'required|numeric',
            'method' => 'required',
            'description' => 'nullable',
            'date' => 'required|date',
        ]);

        Invenst::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'method' => $request->method,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        flash('Инвестиция добавлена', 'success');

        return redirect()->route('invensts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invenst $invenst)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invenst $invenst)
    {
        return view('pages.invensts.edit', compact('invenst'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invenst $invenst)
    {
        $request->validate([
            // 'user_id',
            'amount' => 'required|numeric',
            'method' => 'required',
            'description' => 'nullable',
            'date' => 'required|date',
        ]);

        $invenst->update([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'method' => $request->method,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        flash('Инвестиция обновлена', 'success');

        return redirect()->route('invensts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invenst $invenst)
    {
        $invenst->delete();

        flash('Инвестиция удалена', 'success');

        return redirect()->route('invensts.index');
    }
}
