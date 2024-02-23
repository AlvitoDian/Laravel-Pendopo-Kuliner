@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Daftar Ketersediaan Barang</h1>

        <div class="d-flex flex-row flex-wrap mb-4">
            @foreach ($products as $product)
                    <div class="card mr-3 mt-3 shadow" style="width: 18rem; border-radius: 15px;">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->category->name }} " class=""
                            alt="Products" style="height: 200px; object-fit: contain;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <h5 class="text-danger" style="font-weight: 700">@money($product->price)</h5>
                            <p class="text-info" style="font-weight: 400">{{ $product->category->name }}</p>
                            <a href="{{ route('detail', $product->slug) }}" class="btn btn-primary">Check!</a>
                        </div>
                    </div>
            @endforeach
        </div>

    </div>
    {{--   <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td><a href="{{ route('detail', $product->slug) }}"
                                            class="btn btn-info btn-icon-split"><span class="icon text-white-50">
                                                <i class="fas fa-eye"></i>
                                            </span><span class="text">Lihat</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> --}}
    <!-- /.container-fluid -->
@endsection
