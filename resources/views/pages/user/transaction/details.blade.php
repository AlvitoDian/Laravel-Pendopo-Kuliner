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
                                    <div class="card shadow mb-2">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary"> {{ $transaction->code }}</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-2 col-md-6">
                                                    <div style="width: 100%; height: 150px; overflow: hidden;">
                                                        <img src="{{ asset('storage/' . $transaction->product->image) }}" alt=""
                                                            style="width: 100%; height: 100%; object-fit: contain; border-radius: 14px;">

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
                                @endforeach
                            </div>
                        </div>
                        @if (auth()->user()->hasRole('USER'))

                            <form action="{{ route('transaction-proof', $transactions->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Upload Bukti Pembayaran</label>
                                    <p class="mt-4">Cara Pembayaran : </p>
                                    <p>1. Pembayaran dilakukan menggunakan {{ $transactions->payment_method }}</p>
                                    <p>2. Transfer ke Nomer 082132123123 dengan total Pembayaran @money($transactions->total_price)</p>
                                    <p>3. Screenshot dan kirim bukti pembayaran pada kolom di bawah ini</p>
                                    <input type="file" class="form-control" id="exampleInputPassword1"
                                        name="payment_proof" id="submit-image">
                                </div>
                                <button type="submit" class="btn btn-primary" id="submit-button">Kirim</button>
                                @if ($errors->any())
                                    <div class="alert alert-danger mt-3">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger mt-3">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                @if (session('success'))
                                    <div class="alert alert-success mt-3">
                                        {{ session('success') }}
                                    </div>
                                @endif
                            </form>
                            <script>
                                // Mengambil elemen form dan tombol submit
                                const form = document.querySelector('form');
                                const submitButton = document.getElementById('submit-button');
                                const paymentProofInput = document.querySelector('input[name="payment_proof"]');

                                // Mengganti teks tombol submit ketika formulir dikirim
                                form.addEventListener('submit', function() {
                                    submitButton.innerHTML = 'Mengirim...';
                                });
                            </script>
                            @if ($transactions->payment_proof)
                                <!-- Tambahkan kondisi ini -->
                                <script>
                                    // Menonaktifkan form jika bukti pembayaran telah diunggah
                                    submitButton.setAttribute("disabled", true);
                                    paymentProofInput.setAttribute('disabled', true);
                                    submitButton.innerHTML = 'Terkirim';
                                </script>
                            @endif
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
