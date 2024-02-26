<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;

class DashboardCashierController extends Controller
{
    public function index()
    {
        return view('pages.admin.cashier.index');
    }

    public function getProduct()
    {
        $products = Product::with(['category'])->get();

        return response()->json(['products' => $products]);
    }
}
