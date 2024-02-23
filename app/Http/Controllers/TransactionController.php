<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
       $transactions = Transaction::with('user')
        ->where('users_id', Auth::user()->id)
        ->get();

        return view('pages.user.transaction.index',[
            'transactions' => $transactions
        ]);
    }
    
    public function indexAdmin()
    { 
      
       $transactions = Transaction::with('user')
        ->get();

        return view('pages.transaction-admin.transaction',[
            'transactions' => $transactions
        ]);
    }

    public function details(Request $request, $id)
    {   
        $transactionProducts = TransactionDetail::with(['transaction.user','product'])
            ->where('transactions_id', $id)
            ->get();
        $transactions = Transaction::with('user')
        ->where('id', $id)->first();
            /* dd($transactions); */
         return view('pages.user.transaction.details', [
        'transactionProducts' => $transactionProducts,
        'transactions' => $transactions
    ]);  
    }
    
    public function detailProducts(Request $request, $id)
    {   
        $productTransDetails = TransactionDetail::with(['transaction.user','product'])
            ->where('id', $id)
            ->first();
           /*  dd($productTransDetails); */
         return view('pages.user.transaction.details-product', [
        'productTransDetails' => $productTransDetails
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
        //
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

        if ($item->payment_proof) {
            return redirect()->route('transaction-details', $id)->with('error', 'Anda sudah mengunggah bukti pembayaran sebelumnya.');
        }

        $data['payment_proof'] = $request->file('payment_proof')->store('payment-proof-users','public');

        $item->update($data);

        return redirect()->route('transaction-details', $id)->with('success', 'Bukti Pembayaran Telah Terkirim');
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
