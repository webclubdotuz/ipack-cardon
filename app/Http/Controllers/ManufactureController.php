<?php

namespace App\Http\Controllers;

use App\Models\Manufacture;
use Illuminate\Http\Request;

class ManufactureController extends Controller
{
    public function index()
    {
        return view('pages.manufactures.index');
    }

    public function create()
    {
        return view('pages.manufactures.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cardon_id' => 'required|exists:cardons,id',
            'quantity' => 'required|numeric',
        ]);

        $manufacture = Manufacture::create([
            'cardon_id' => $request->cardon_id,
            'user_id' => auth()->user()->id,
            'quantity' => $request->quantity,
            'description' => $request->description,
        ]);

        return redirect()->route('manufactures.create')->with('success', 'Успешно добавлено!');

    }
}
