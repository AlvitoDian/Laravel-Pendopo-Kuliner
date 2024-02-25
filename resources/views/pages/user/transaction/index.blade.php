@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Transactions</h1>
        <!-- section content-->
        <div class="section-content section-dashboard-home" data-aos="fade-up">


            <div class="dashboard-content">
                <ul class="nav nav-pills" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="sell-tab" data-toggle="tab" href="#unpayed" role="tab"
                            aria-controls="sell" aria-selected="true">Menunggu Pembayaran</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="buy-tab" data-toggle="tab" href="#payed" role="tab"
                            aria-controls="buy" aria-selected="false">Pembayaran Terverifikasi</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="buy-tab" data-toggle="tab" href="#ready" role="tab"
                            aria-controls="buy" aria-selected="false">Barang Siap Diambil</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="unpayed" role="tabpanel" aria-labelledby="sell-tab">
                        <div class="row mt-3">
                            <div class="col-12 mt-2">
                                @foreach ($transactions as $transaction)
                                    @if ($transaction->transaction_status === 'PENDING')
                                        {{--  <a href="{{ route('transaction-details', $transaction->id) }}"> --}}
                                        <div class="card shadow mb-2">
                                            <div class="card-header py-3">
                                                <h6 class="m-0 font-weight-bold text-primary"> {{ $transaction->code }}</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-2 col-md-6">
                                                        <div style="width: 100%; height: 150px; overflow: hidden;">
                                                            @php
                                                                $getTransactionDetail = \App\Models\TransactionDetail::with('product')
                                                                    ->where('transactions_id', $transaction->id)
                                                                    ->first();

                                                                // Check if $getTransactionDetail is not null before accessing its properties
                                                                if ($getTransactionDetail) {
                                                                    $imageFirst = $getTransactionDetail->product->image;
                                                            @endphp

                                                            <img src="{{ asset('storage/' . $imageFirst) }}" alt=""
                                                                style="width: 100%; height: 100%; object-fit: contain; border-radius: 14px;">

                                                            @php
                                                                // Close the if statement
                                                                }
                                                            @endphp
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-10 col-md-6">
                                                        <p>
                                                            <span style="font-weight: 700">Nama :
                                                            </span>{{ $transaction->user->name }}
                                                        </p>
                                                        <p>
                                                            <span style="font-weight: 700">
                                                                Status :
                                                            </span>
                                                            <span class="text-danger" style="font-weight: 700">
                                                                {{ $transaction->transaction_status }}
                                                            </span>
                                                        </p>
                                                        <p>
                                                            <span style="font-weight: 700">Tanggal :
                                                            </span>{{ $transaction->created_at }}
                                                        </p>
                                                        <p>
                                                            <span style="font-weight: 700">Harga :
                                                            </span>
                                                            <span
                                                                style="font-weight: 700; color:rgb(214, 150, 11);">@money($transaction->total_price)</span>
                                                        </p>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="card-body mt-n4">
                                                <a href="{{ route('transaction-details', $transaction->id) }}"
                                                    class="btn btn-primary btn-icon-split">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-money-bill"></i>
                                                    </span>
                                                    <span class="text">Bayar</span>
                                                </a>
                                            </div>
                                        </div>
                                        {{--   <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-1">
                                                        {{ $transaction->code }}
                                                    </div>
                                                    <div class="col-md-1">
                                                        {{ $transaction->user->name }}
                                                    </div>
                                                    <div class="col-md-4">
                                                        {{ $transaction->created_at }}
                                                    </div>
                                                    <div class="col-md-3">
                                                        {{ $transaction->transaction_status }}
                                                    </div>
                                                    <div class="col-md-3">
                                                        @money($transaction->total_price)
                                                    </div>
                                                    <div class="col-md-1 d-none d-md-block">
                                                        <img src="/images/dashboard-arrow-right.svg" alt="" />
                                                    </div>
                                                </div>
                                            </div> --}}
                                        {{--   </a> --}}
                                    @else
                                        {{-- <div class="card-body">
                          <p>Tidak ada transaksi</p>
                        </div> --}}
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="payed" role="tabpanel" aria-labelledby="buy-tab">
                        <div class="row mt-3">
                            <div class="col-12 mt-2">
                                @foreach ($transactions as $transaction)
                                    @if ($transaction->transaction_status === 'PEMBAYARAN TERVERIFIKASI')
                                        <a class="card card-list d-block"
                                            href="{{ route('transaction-details', $transaction->id) }}">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-1">
                                                        {{ $transaction->code }}
                                                    </div>
                                                    <div class="col-md-4">
                                                        {{ $transaction->created_at }}
                                                    </div>
                                                    <div class="col-md-3">
                                                        {{ $transaction->transaction_status }}
                                                    </div>
                                                    <div class="col-md-3">
                                                        @money($transaction->total_price)
                                                    </div>
                                                    <div class="col-md-1 d-none d-md-block">
                                                        <img src="/images/dashboard-arrow-right.svg" alt="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @else
                                        {{-- <div class="card-body">
                          <p>Tidak ada transaksi</p>
                        </div> --}}
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="ready" role="tabpanel" aria-labelledby="buy-tab">
                        <div class="row mt-3">
                            <div class="col-12 mt-2">
                                @foreach ($transactions as $transaction)
                                    @if ($transaction->transaction_status === 'READY TAKE')
                                        <a class="card card-list d-block"
                                            href="{{ route('transaction-details', $transaction->id) }}">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-1">
                                                        {{ $transaction->code }}
                                                    </div>
                                                    <div class="col-md-4">
                                                        {{ $transaction->created_at }}
                                                    </div>
                                                    <div class="col-md-3">
                                                        {{ $transaction->transaction_status }}
                                                    </div>
                                                    <div class="col-md-3">
                                                        @money($transaction->total_price)
                                                    </div>
                                                    <div class="col-md-1 d-none d-md-block">
                                                        <img src="/images/dashboard-arrow-right.svg" alt="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @else
                                        {{-- <div class="card-body">
                          <p>Tidak ada transaksi</p>
                        </div> --}}
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
