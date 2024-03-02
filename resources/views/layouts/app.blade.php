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
            Echo.channel('admin.' + {{ $admin->id }})
                .listen('TransactionEvent', (e) => {
                    console.log("ini Event", e);
                });
        });
    </script>
    {{-- //?Admin Broadcoast Handler End --}}
</body>

</html>
