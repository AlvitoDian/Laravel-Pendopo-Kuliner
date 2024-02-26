<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;

class DashboardTransactionAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $transactions = Transaction::with('user')->get();

        return view('pages.admin.transaction.index', [
            'transactions' => $transactions,
        ]);
    }

    public function details(Request $request, $id)
    {
        $transactionProducts = TransactionDetail::with(['transaction.user', 'product'])
            ->where('transactions_id', $id)
            ->get();
        $transactions = Transaction::with('user')->where('id', $id)->first();
        /* dd($transactions); */
        return view('pages.admin.transaction.details', [
            'transactionProducts' => $transactionProducts,
            'transactions' => $transactions,
        ]);
    }

    public function detailProducts(Request $request, $id)
    {
        $productTransDetails = TransactionDetail::with(['transaction.user', 'product'])
            ->where('id', $id)
            ->first();
        $transactions = Transaction::with('user')->where('id', $id)->first();
        /*  dd($productTransDetails); */
        return view('pages.admin.transaction.details-product', [
            'productTransDetails' => $productTransDetails,
            'transactions' => $transactions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransactionRequest $request)
    {
 
        $productsData = $request->all();
        Log::info('Allitem:', $productsData);
        foreach ($productsData as $item) {
            Log::info('Processing item:', ['item' => $item]);

            Transaction::create([
                'users_id' => Auth::user()->id,
                'tax_price' => 0,
                'total_price' => $item['totalPrice'],
                'transaction_status' => 'PENDING',
                'payment_method' => $item['name'],
                'notes' => 'THIS NOTES',
                'code' => 'ss2',
            ]);
        }

        // Proses Checkout
        // $code = 'TRX-' . mt_rand(000000, 999999);
        // /*         $carts = Cart::with(['product', 'user'])
        //     ->where('users_id', Auth::user()->id)
        //     ->get(); */

        // // Transaction Create
        // Transaction::create([
        //     'users_id' => /* Auth::user()->id */ 3,
        //     'tax_price' => 0,
        //     'total_price' => 423,
        //     'transaction_status' => 'PENDING',
        //     'code' => $code,
        //     'payment_method' => $request->name,
        //     'notes' => 'THIS NOTES',
        // ]);

        return response()->json('successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransactionRequest  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransactionRequest $request, $id)
    {
        $data = $request->all();

        $item = Transaction::findOrFail($id);

        /* dd($item); */

        $item->update($data);

        return redirect()->route('transaction-admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
