<?php

namespace App\Http\Controllers;

use App\Models\Cardon;
use Illuminate\Http\Request;

class CardonController extends Controller
{
    public function index()
    {

        $cardons = Cardon::orderBy('name')->get();

        return view('pages.cardons.index', compact('cardons'));
    }

    public function create()
    {
        return view('pages.cardons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'width' => 'required|numeric',
            'length' => 'required|numeric',
            'layer' => 'required|numeric',
            'salary_percent' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $cardon = Cardon::create([
            'name' => $request->name,
            'width' => $request->width,
            'length' => $request->length,
            'layer' => $request->layer,
            'salary_percent' => $request->salary_percent,
            'price' => $request->price,
        ]);

        return redirect()->route('cardons.index')->with('success', 'Кардон успешно добавлен');
    }

    public function edit(Cardon $cardon)
    {
        return view('pages.cardons.edit', compact('cardon'));
    }

    public function update(Request $request, Cardon $cardon)
    {
        $request->validate([
            'name' => 'required|min:3',
            'width' => 'required|numeric',
            'length' => 'required|numeric',
            'layer' => 'required|numeric',
            'salary_percent' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $cardon->update([
            'name' => $request->name,
            'width' => $request->width,
            'length' => $request->length,
            'layer' => $request->layer,
            'salary_percent' => $request->salary_percent,
            'price' => $request->price,
        ]);

        return redirect()->route('cardons.index')->with('success', 'Кардон успешно обновлен');
    }

    public function destroy(Cardon $cardon)
    {
        $cardon->delete();
        return redirect()->route('cardons.index')->with('success', 'Кардон успешно удален');
    }


}
