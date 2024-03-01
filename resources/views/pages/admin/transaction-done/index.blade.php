@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Transaction Done</h1>
        <form class="d-none d-sm-inline-block form-inline mr-auto my-2 my-md-0 mw-100 navbar-search w-50">
            <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small shadow" placeholder="Search for..."
                    aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
        <!-- section content-->
        <div class="section-content section-dashboard-home" data-aos="fade-up">


            <div class="dashboard-content">

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="unpayed" role="tabpanel" aria-labelledby="sell-tab">
                        <div class="row mt-3">
                            <div class="col-12 mt-2">
                                @foreach ($transactions as $transaction)
                                    @if ($transaction->transaction_status === 'DONE')
                                        <div class="card shadow mb-2">
                                            <div class="card-header py-3">
                                                <h6 class="m-0 font-weight-bold text-primary"> {{ $transaction->code }}</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">

                                                    <div class="col-lg-12 col-md-6">
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
                                                <a href="{{ route('transaction-details-admin-done', $transaction->id) }}"
                                                    class="btn btn-primary btn-icon-split">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-money-bill"></i>
                                                    </span>
                                                    <span class="text">Cek</span>
                                                </a>
                                            </div>
                                        </div>
                                    @else
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
