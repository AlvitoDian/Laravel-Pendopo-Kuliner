@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Transactions</h1>
        <!-- section content-->
        <div class="section-content section-dashboard-home" data-aos="fade-up">


            <div class="dashboard-content">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="sell" role="tabpanel" aria-labelledby="sell-tab">
                        <div class="row mt-3">
                            <div class="col-12 mt-2">
                                {{-- @foreach ($transactionProducts as $transaction)
                                    <div class="card shadow mb-2">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary"> {{ $transaction->code }}</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-2 col-md-6">
                                                    <div style="width: 100%; height: 150px; overflow: hidden;">
                                                        <img src="{{ asset('storage/' . $transaction->product->image) }}"
                                                            alt=""
                                                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 14px;">

                                                    </div>
                                                </div>
                                                <div class="col-lg-10 col-md-6">
                                                    <p>
                                                        <span style="font-weight: 700">Nama Barang :
                                                        </span>{{ $transaction->product->name }}
                                                    </p>

                                                    <p>
                                                        <span style="font-weight: 700">Waktu Pembelian :
                                                        </span>{{ $transaction->created_at->diffForHumans() }}
                                                    </p>
                                                    <p>
                                                        <span style="font-weight: 700">Harga :
                                                        </span>
                                                        <span
                                                            style="font-weight: 700; color:rgb(214, 150, 11);">@money($transaction->product->price)</span>
                                                    </p>

                                                </div>
                                            </div>

                                        </div>
                                        <div class="card-body mt-n4">
                                            <a href="{{ route('transaction-details-product', $transaction->id) }}"
                                                class="btn btn-primary btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-money-bill"></i>
                                                </span>
                                                <span class="text">Cek Barang</span>
                                            </a>
                                        </div>
                                    </div>
                                    <a class="card card-list d-block"
                                        href="{{ route('transaction-details-product-admin-done', $transaction->id) }}">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-1">
                                                    {{ $transaction->code }}
                                                </div>
                                                <div class="col-md-4">
                                                    {{ $transaction->product->name }}
                                                </div>
                                                <div class="col-md-3">
                                                    {{ $transaction->product->price }}
                                                </div>

                                                <div class="col-md-1 d-none d-md-block">
                                                    <img src="/images/dashboard-arrow-right.svg" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach --}}
                            </div>
                        </div>

                        <div class="card shadow mb-2">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Daftar Barang</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Nama Barang</th>
                                                    <th scope="col">Kuantitas</th>
                                                    <th scope="col">Harga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              @php
                                              $totalPrice = 0;    
                                              @endphp
                                                @foreach ($transactionProducts as $index => $product)
                                                    <tr>
                                                        <th>{{ $index + 1 }}</th>
                                                        <td>{{ $product['nama_barang'] }}</td>
                                                        <td>{{ $product['kuantitas'] }}</td>
                                                        <td>@money($product['harga'])</td>
                                                        @php
                                                            $totalPrice += $product['harga']
                                                        @endphp
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <th></th>
                                                    <td></td>
                                                    <td>Total Harga</td>
                                                    <td style="font-weight: 700">@money($totalPrice)</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                            </div>
                        </div>

                        @if (auth()->user()->hasRole('ADMIN'))
                            <div class="card shadow mb-2">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Konfirmasi Pembayaran</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <p>
                                                <span style="font-weight: 700">Bukti Pembayaran :
                                                </span>
                                                @if ($transactions->payment_proof)
                                                    <img src="{{ asset('storage/' . $transactions->payment_proof) }}"
                                                        alt="">
                                                @else
                                                    <span style="font-weight: 700" class="text-danger">Belum Ada</span>
                                                @endif

                                            </p>

                                            <p>
                                            <form action="{{ route('transaction-update-status', $transactions->id) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1">Perbarui Status
                                                        Pembayaran</label>
                                                    <select class="form-control" id="exampleFormControlSelect1"
                                                        name="transaction_status">
                                                        <option value="PENDING">PENDING</option>
                                                        <option value="DONE">DONE</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Perbarui</button>
                                            </form>
                                            </p>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
