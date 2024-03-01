<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ProductNotification;
use Illuminate\Support\Facades\Notification;
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

    public function indexDone()
    {
        $transactions = Transaction::with('user')->get();

        return view('pages.admin.transaction-done.index', [
            'transactions' => $transactions,
        ]);
    }

    public function details(Request $request, $id)
    {
        $transactionProducts = TransactionDetail::with(['transaction.user', 'product'])
            ->where('transactions_id', $id)
            ->get();
        $transactions = Transaction::with('user')->where('id', $id)->first();

        return view('pages.admin.transaction.details', [
            'transactionProducts' => $transactionProducts,
            'transactions' => $transactions,
        ]);
    }

    public function detailsDone(Request $request, $id)
    {
        $transactionProducts = TransactionDetail::with(['transaction.user', 'product'])
            ->where('transactions_id', $id)
            ->get();
        $transactions = Transaction::with('user')->where('id', $id)->first();

        return view('pages.admin.transaction-done.details', [
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
        return view('pages.admin.transaction.details-product', [
            'productTransDetails' => $productTransDetails,
            'transactions' => $transactions,
        ]);
    }

    public function detailProductsDone(Request $request, $id)
    {
        $productTransDetails = TransactionDetail::with(['transaction.user', 'product'])
            ->where('id', $id)
            ->first();
        $transactions = Transaction::with('user')->where('id', $id)->first();
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
        try {
            // Start a database transaction
            DB::beginTransaction();

            $productsData = $request->all();
            Log::info('All item:', $productsData);

            $userId = Auth::user()->id;

            // Transaction Create
            $code = 'TRX-' . mt_rand(000000, 999999);
            $transaction = Transaction::create([
                'users_id' => $userId,
                'tax_price' => 0,
                'total_price' => $request->allProductPrice,
                'transaction_status' => 'DONE',
                'code' => $code,
                'payment_method' => 'ON CASHIER',
                'notes' => 'No Notes',
            ]);

            // Detail Transaction Create
            $singProduct = $request->carts;
            foreach ($singProduct as $item) {
                Log::info('Single item:', $item);
                $trx = 'STF-' . mt_rand(000000, 999999);

                $products = Product::with(['category'])->get();

                $quantity = $item['quantity'];

                for ($i = 0; $i < $quantity; $i++) {
                    $product = $products->find($item['product_id']);

                    if ($product->quantity < 0) {
                        // Rollback the transaction and return an error response
                        DB::rollBack();
                        return response()->json('Error: Insufficient Product Quantity');
                    }

                    TransactionDetail::create([
                        'transactions_id' => $transaction->id,
                        'products_id' => $item['product_id'],
                        'price' => $product->price,
                        'delivery_status' => 'PENDING',
                        'code' => $trx,
                        'notes' => 'No Notes',
                        'payment_method' => 'ON CASHIER',
                    ]);

                    $product->decrement('quantity');
                    if ($product->quantity == 0) {
                        Notification::send(User::find($userId), new ProductNotification($product));
                    }
                }
            }

            // Commit the transaction
            DB::commit();
      
            return response()->json('Success: Product Successfully Stored');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json('Error: ' . $e->getMessage());
        }
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
