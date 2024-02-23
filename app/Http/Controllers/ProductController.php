<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category'])->get();
        return view('pages.user.product.index',[
            'products' => $products
        ]);
    }

    public function show($slug)
    {
        return view('product-detail', [
            "product" => Product::find($slug)
        ]);
    }
}
