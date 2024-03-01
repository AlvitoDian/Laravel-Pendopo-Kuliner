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
                                @foreach ($transactionProducts as $transaction)
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
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
