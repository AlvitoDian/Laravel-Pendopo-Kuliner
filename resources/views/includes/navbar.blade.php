<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                @php
                    $notificationCount = count(Auth::user()->notifications);
                @endphp
                <span
                    class="badge badge-danger badge-counter">{{ $notificationCount > 0 ? $notificationCount : '' }}</span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Alerts Center
                </h6>
                @foreach (Auth::user()->notifications as $notification)
                    @if ($notification->data['category'] === 'user_transaction')
                        <div class="dropdown-item d-flex align-items-center">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class="fas fa-coins text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                                <span class="font-weight-bold"><span
                                        class="text-success">{{ $notification->data['user_name'] }}</span> Telah
                                    Melakukan Transaksi</span>
                            </div>
                            <a class="mark-as-read" href="#" data-notification-id="{{ $notification->id }}">
                                <span>Telah Dibaca</span>
                            </a>
                        </div>
                    @endif
                    @if ($notification->data['category'] === 'product_stock')
                        <div class="dropdown-item d-flex align-items-center">
                            <div class="mr-3">
                                <div class="icon-circle bg-danger">
                                    <i class="fas fa-exclamation text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                                <span class="font-weight-bold">Barang <span
                                        class="text-danger">{{ $notification->data['product_name'] }}</span> Telah
                                    Habis</span>
                            </div>
                            <a class="mark-as-read" href="#" data-notification-id="{{ $notification->id }}">
                                <span>Telah Dibaca</span>
                            </a>
                        </div>
                    @endif
                @endforeach
                {{-- <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a> --}}
            </div>
        </li>

        <!-- Nav Item - Cart -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="{{ route('cart') }}">
                <i class="fas fa-shopping-cart fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">{{ $cartItems > 0 ? $cartItems : '' }}</span>
            </a>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>

                <img class="img-profile rounded-circle"
                    @if (Auth::user()->photo_profile) src="{{ asset('storage/' . Auth::user()->photo_profile) }}"
                                     @else
                                         src="{{ asset('img/undraw_profile.svg') }}" @endif>
            </a>

            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                </a>
                <div class="dropdown-divider"></div>
                {{-- <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a> --}}

                <form action="/logout" method="post">
                    @csrf
                    <button type="submit" class="dropdown-item" href="#" data-toggle="modal"
                        data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </button>
                </form>
            </div>
        </li>
        <!-- - User Information End -->

        {{-- <li class="nav-item dropdown no-arrow">
                             <a class="nav-link" href="/login" style="color: blue"
                                >
                               Login
                            </a>
                        </li> --}}

    </ul>

</nav>
@push('addon-script')
    <script>
        $(document).ready(function() {
            $('.mark-as-read').on('click', function() {
                var notificationId = $(this).data('notification-id');

                $.ajax({
                    url: '/mark-as-read/' + notificationId,
                    method: 'GET',
                    success: function(response) {
                        console.log('Notifikasi telah dibaca');
                        location.reload();
                    },
                    error: function(error) {
                        console.error('Gagal menandai notifikasi sebagai telah dibaca');
                    }
                });
            });
        });
    </script>
@endpush
<!-- End of Topbar -->
