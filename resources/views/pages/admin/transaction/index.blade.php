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
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="unpayed" role="tabpanel" aria-labelledby="sell-tab">
                        <div class="row mt-3">
                            <div class="col-12 mt-2">
                                @foreach ($transactions as $transaction)
                                    @if ($transaction->transaction_status === 'PENDING')
                                        <div class="card shadow mb-2">
                                            <div class="card-header py-3">
                                                <h6 class="m-0 font-weight-bold text-primary"> {{ $transaction->code }}</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                  <div class="col-lg-2 col-md-2 center">
                                                        <div style="width: 150px; height: 150px; overflow: hidden;">
                                                            @php
                                                                $getUserProfile = \App\Models\User::where('id', $transaction->users_id)
                                                                    ->first();
                                                                if ($getUserProfile) {
                                                                    $photoProfile = $getUserProfile->photo_profile;
                                                            @endphp

                                                            <img src="{{ asset('storage/' . $photoProfile) }}" alt=""
                                                                style="width: 100%; height:100%; object-fit: cover; border-radius: 100%;">

                                                            @php
                                                                }
                                                            @endphp
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10">
                                                        <p>
                                                            <span style="font-weight: 700">Nama :
                                                            </span>{{ $transaction->user->name }}
                                                        </p>
                                                        <p>
                                                            <span style="font-weight: 700">
                                                                Status :
                                                            </span>
                                                            <span class="text-success" style="font-weight: 700">
                                                                {{ $transaction->transaction_status }}
                                                            </span>
                                                        </p>
                                                        <p>
                                                            <span style="font-weight: 700">Waktu Pembelian :
                                                            </span>{{ $transaction->created_at->diffForHumans() }}
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
                                                <a href="{{ route('transaction-details-admin', $transaction->id) }}"
                                                    class="btn btn-primary btn-icon-split">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-money-bill"></i>
                                                    </span>
                                                    <span class="text">Cek</span>
                                                </a>
                                            </div>
                                        </div>
                                        {{-- <a
                          class="card card-list d-block"
                          href="{{ route('transaction-details-admin', $transaction->id) }}"
                        >
                          <div class="card-body">
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
                                <img
                                  src="/images/dashboard-arrow-right.svg"
                                  alt=""
                                />
                              </div>
                            </div>
                          </div>
                        </a> --}}
                                    @else
                                        {{-- <div class="card-body">
                          <p>Transaksi ini telah ber-status {{ $transaction->transaction_status }}</p>
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
                                    @if ($transaction->transaction_status === 'DONE')
                                        <a class="card card-list d-block"
                                            href="{{ route('transaction-details-admin', $transaction->id) }}">
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
                <div class="d-flex justify-content-end">

                                {{ $transactions->links() }}

                            </div>
            </div>

        </div>
    </div>
@endsection
