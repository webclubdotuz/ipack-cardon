<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $contact_count = \App\Models\Contact::count();
        $product_count = \App\Models\Product::count();


        return view('blank', compact('contact_count', 'product_count'));
    }
}
