<?php

namespace App\Http\Controllers\Api;

use App\Models\Cardon;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CardonController extends Controller
{
    public function show($id)
    {
        $cardon = Cardon::findOrFail($id);
        return response()->json($cardon);
    }
}
