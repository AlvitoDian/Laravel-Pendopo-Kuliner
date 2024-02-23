@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Selamat Datang di Pendopo Kuliner</h1>
            {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
        </div>

        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Figure-nime Shop</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quidem, voluptatibus obcaecati mollitia
                            possimus reprehenderit dicta et sapiente adipisci nulla quod nobis cum, recusandae dolor odio,
                            atque architecto deleniti inventore voluptatum?</p>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Distinctio, omnis. Lorem ipsum dolor
                            sit amet consectetur adipisicing elit. Tempora, vel. Lorem ipsum dolor sit amet consectetur
                            adipisicing elit. Reiciendis ipsa quaerat blanditiis tempore ad doloribus, maiores eum
                            laudantium. Culpa illo ipsam dicta explicabo eveniet qui, repellendus, exercitationem nam et,
                            possimus quis. Consectetur asperiores dolorem aperiam nostrum quam impedit, officia velit
                            doloremque iure, vitae laborum dolores unde esse voluptatem itaque voluptate.</p>

                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Distinctio, omnis. Lorem ipsum dolor
                            sit amet consectetur adipisicing elit. Tempora, vel. Lorem ipsum dolor sit amet consectetur
                            adipisicing elit. Reiciendis ipsa quaerat blanditiis tempore ad doloribus, maiores eum
                            laudantium. Culpa illo ipsam dicta explicabo eveniet qui, repellendus, exercitationem nam et,
                            possimus quis. Consectetur asperiores dolorem aperiam nostrum quam impedit, officia velit
                            doloremque iure, vitae laborum dolores unde esse voluptatem itaque voluptate.</p>

                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">New Item Arrival</h6>
                        {{-- <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div> --}}
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">

                        {{--  <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> Direct
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Social
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Referral
                                        </span>
                                    </div> --}}
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('storage/' . $productsNew->image) }}" alt=""
                                style="width: 100%; height: 100%; object-fit: contain;">
                        </div>

                        <div class="d-flex justify-content-center">
                            <h4>{{ $productsNew->name }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

     

    </div>
    <!-- /.container-fluid -->
@endsection
