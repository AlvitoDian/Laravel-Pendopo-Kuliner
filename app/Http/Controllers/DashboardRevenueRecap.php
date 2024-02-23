<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Exports\ExportRevenue;
use App\Models\TransactionDetail;
use Maatwebsite\Excel\Facades\Excel;

class DashboardRevenueRecap extends Controller
{
    public function index()
    {
        $totalRevenue = Transaction::where('transaction_status', 'DONE')->sum('total_price');
        $stuffSold = TransactionDetail::with('transaction')
            ->whereHas('transaction', function ($query) {
                $query->where('transaction_status', 'DONE');
            })
            ->count();
        $doneTransaction = Transaction::where('transaction_status', 'DONE')->count();
        $totalUser = User::where('roles', 'USER')->count();
        return view('pages.admin.money-recap', [
            'totalRevenue' => $totalRevenue,
            'stuffSoild' => $stuffSold,
            'doneTransaction' => $doneTransaction,
            'totalUser' => $totalUser,
        ]);
    }

    public function export_excel()
    {
        return Excel::download(new ExportRevenue(), 'total_revenue.xlsx');
    }
}
