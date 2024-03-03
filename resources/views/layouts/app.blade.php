<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    {{-- Style --}}
    @include('includes.style')
    @viteReactRefresh
    @vite('resources/js/app.js')
    @vite('resources/js/bootstrap.js')


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        {{-- Sidebar --}}
        @include('includes.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                {{-- Navbar --}}
                @include('includes.navbar')

                @yield('content')

            </div>
            <!-- End of Main Content -->

            {{-- Footer --}}
            @include('includes.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    {{-- Script --}}
    @include('includes.script')
    @stack('prepend-script')
    @stack('addon-script')

    {{-- //?Admin Broadcoast Handler --}}
    @php
        $admin = \App\Models\User::where('roles', 'ADMIN')->first();
    @endphp

    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            function calculateTimeDifference(created_at) {
                const currentTime = new Date();
                const createdAtTime = new Date(created_at);
                const timeDifference = currentTime - createdAtTime;

                const seconds = Math.floor(timeDifference / 1000);
                const minutes = Math.floor(seconds / 60);
                const hours = Math.floor(minutes / 60);
                const days = Math.floor(hours / 24);

                if (days > 0) {
                    return days + " hari yang lalu";
                } else if (hours > 0) {
                    return hours + " jam yang lalu";
                } else if (minutes > 0) {
                    return minutes + " menit yang lalu";
                } else {
                    return seconds + " detik yang lalu";
                }
            }

            Echo.channel('admin.' + {{ $admin->id }})
                .listen('TransactionEvent', (e) => {
                    console.log("ini Event", e);
                    const notificationCountElement = document.getElementById('notification-count');

                    notificationCountElement.classList.add('badge', 'badge-danger', 'badge-counter');

                    // Tambahkan 1 pada notifikasi count
                    let notificationCount = parseInt(notificationCountElement.innerText) || 0;
                    notificationCount += 1;

                    // Perbarui elemen HTML
                    notificationCountElement.innerText = notificationCount;

                    const createdAtFormatted = calculateTimeDifference(e.created_at);

                    const newNotification = document.createElement('div');
                    newNotification.innerHTML = `
                    <div class="dropdown-item d-flex align-items-center">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-coins text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">${createdAtFormatted}</div>
                            <span class="font-weight-bold"><span class="text-success">${e.user_name}</span> Telah Melakukan Transaksi</span>
                        </div>
                        <a class="mark-as-read" href="#" data-notification-id="${e.id}">
                            <span>Telah Dibaca</span>
                        </a>
                    </div>`;

                    let notificationParent = document.getElementById('notification');
                    if (notificationParent) {
                        // Dapatkan elemen <h6>
                        let headerElement = notificationParent.querySelector('h6');

                        // Periksa apakah elemen <h6> ditemukan sebelum menambahkan elemen baru
                        if (headerElement) {
                            headerElement.insertAdjacentElement('afterend', newNotification);
                        } else {
                            console.error(
                                "Elemen <h6> tidak ditemukan di dalam elemen dengan ID 'notification'.");
                        }
                    } else {
                        console.error("Elemen dengan ID 'notification' tidak ditemukan.");
                    }
                });
        });
    </script>

    {{-- //?Admin Broadcoast Handler End --}}
</body>

</html>
