<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function customers()
    {
        return view('pages.contacts.customers');
    }

    public function suppliers()
    {
        return view('pages.contacts.suppliers');
    }

    public function show(Contact $contact)
    {
        // dd($contact);
        return view('pages.contacts.show', compact('contact'));
    }
}
