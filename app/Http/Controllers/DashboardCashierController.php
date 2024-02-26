<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;

class DashboardCashierController extends Controller
{
    public function index()
    {
        $products = Product::with(['category'])->get();
        return view('pages.admin.cashier.index', [
            'products' => $products,
        ]);
    }
}
