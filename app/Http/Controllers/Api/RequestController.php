<?php

namespace App\Http\Controllers\Api;

use App\Models\Request;
use App\Http\Controllers\Controller;

class RequestController extends Controller
{
    public function contact($contact_id)
    {
        $requests = Request::where('contact_id', $contact_id)->where('status', 'pending')->get();

        return response()->json($requests);

    }
}
