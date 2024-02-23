@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Daftar User</h1>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">

            <div class="card-header py-3">
              {{--   <a href="{{ route('product.create') }}" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Tambah User</span>
                </a> --}}
                @if (session()->has('deleted'))
                    <div class="alert alert-danger mt-4" role="alert">
                        {{ session('deleted') }}
                    </div>
                @endif
                @if (session()->has('added'))
                    <div class="alert alert-success mt-4" role="alert">
                        {{ session('added') }}
                    </div>
                @endif
                @if (session()->has('edited'))
                    <div class="alert alert-warning mt-4" role="alert">
                        {{ session('edited') }}
                    </div>
                @endif
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>No HP</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->roles }}</td>
                                    <td>{{ $user->phone_number }}</td>
                                    <td>
                                        <a href="{{ route('user-manage.update', $user->id) }}" class="btn btn-warning btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                            <span class="text">Edit</span>
                                        </a>

                                        {{--  <a href="{{ route('user.destroy', $user->id) }}" class="btn btn-info btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                        <span class="text">Detail</span>
                                    </a> --}}

                                        <form action="{{-- {{ route('user.destroy', $user->id) }} --}}" method="post" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger btn-icon-split"
                                                onclick="return confirm('Are you sure?')"><span
                                                    class="icon text-white-50"><i class="fas fa-trash"></i></span><span
                                                    class="text">Hapus</span></button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
