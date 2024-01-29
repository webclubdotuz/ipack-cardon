<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PressController extends Controller
{
    public function index()
    {
        return view('pages.press.index');
    }

    public function create()
    {
        return view('pages.press.create');
    }
}
