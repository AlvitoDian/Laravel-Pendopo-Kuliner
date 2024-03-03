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
                                                                    $totalPrice += $product['harga'];
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

                            </div>
                        </div>
                        @if (auth()->user()->hasRole('USER'))
                            <div class="card shadow mb-2">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Lakukan Pembayaran</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <form action="{{ route('transaction-proof', $transactions->id) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Upload Bukti Pembayaran</label>
                                                    <p class="mt-4">Cara Pembayaran : </p>
                                                    <p>1. Pembayaran dilakukan menggunakan
                                                        {{ $transactions->payment_method }}</p>
                                                    <p>2. Transfer ke Nomer 082132123123 dengan total Pembayaran
                                                        @money($transactions->total_price)</p>
                                                    <p>3. Screenshot dan kirim bukti pembayaran pada kolom di bawah ini</p>
                                                    <input type="file" class="form-control" id="exampleInputPassword1"
                                                        name="payment_proof" id="submit-image">
                                                </div>
                                                <button type="submit" class="btn btn-primary"
                                                    id="submit-button">Kirim</button>
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
                                                @if ($transactions->payment_proof)
                                                    <div class="alert alert-success mt-3">
                                                        Bukti Pembayaran Telah Terkirim
                                                    </div>
                                                @endif
                                                {{-- @if (session('success'))
                                                    <div class="alert alert-success mt-3">
                                                        {{ session('success') }}
                                                    </div>
                                                @endif --}}
                                            </form>

                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{--  <form action="{{ route('transaction-proof', $transactions->id) }}" method="POST"
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
                            </form> --}}
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
                                    /* submitButton.setAttribute("disabled", true);
                                    paymentProofInput.setAttribute('disabled', true); */
                                    paymentProofInput.style.display = 'none';
                                    submitButton.style.display = 'none';
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
