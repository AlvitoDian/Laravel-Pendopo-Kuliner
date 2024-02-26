@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-4-lg col-md-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Kuantitas</th>
                            <th scope="col">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Jahe Maklimah Biadab</td>
                            <td>12</td>
                            <td>Rp. 20.000</td>
                        </tr>
                        <tr>
                            <td>Jahe Maklimah Biadab</td>
                            <td>12</td>
                            <td>Rp. 20.000</td>
                        </tr>
                        <tr>
                            <td>Jahe Maklimah Biadab</td>
                            <td>12</td>
                            <td>Rp. 20.000</td>
                        </tr>
                        <tr>
                            <td>Jahe Maklimah Biadab</td>
                            <td>12</td>
                            <td>Rp. 20.000</td>
                        </tr>
                        <tr>
                            <td>Jahe Maklimah Biadab</td>
                            <td>12</td>
                            <td>Rp. 20.000</td>
                        </tr>
                        {{-- Total --}}
                        <tr>
                            <td>Total</td>
                            <td></td>
                            <td>Rp. 350.000</td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-danger">Batal</button>
                <button type="button" class="btn btn-success">Kirim</button>
            </div>

            <div class="col-8-lg col-md-8">
                <div class="d-flex flex-row flex-wrap mb-4">
                    @foreach ($products as $product)
                        <div class="card mr-3 mt-3 shadow" style="width: 12rem; border-radius: 15px;">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->category->name }} "
                                class="" alt="Products" style="height: 200px; object-fit: contain;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <h5 class="text-danger" style="font-weight: 700">@money($product->price)</h5>
                                <p class="text-info" style="font-weight: 400">{{ $product->category->name }}</p>
                                <a href="" class="btn btn-primary">Tambah</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
