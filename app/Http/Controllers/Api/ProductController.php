<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }
}
