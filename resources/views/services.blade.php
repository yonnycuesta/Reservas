@extends('adminlte::page')
@section('title', 'Servicios')
@livewireStyles
@section('content')
    <livewire:admin.service-component>
        <!-- Toastr CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    @stop
    @section('css')
        <link rel="stylesheet" href="/css/admin_custom.css">
    @stop
    @section('js')

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"
            integrity="sha512-3P8rXCuGJdNZOnUx/03c1jOTnMn3rP63nBip5gOP2qmUh5YAdVAvFZ1E+QLZZbC1rtMrQb+mah3AfYW11RUrWA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- SweetAlert2-->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
            integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/popper.min.js"
            integrity="sha512-eHo1pysFqNmmGhQ8DnYZfBVDlgFSbv3rxS0b/5+Eyvgem/xk0068cceD8GTlJOZsUrtjANIrFhhlwmsL1K3PKg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- Toastr -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        @yield('scripts')
        @livewireScripts

    @stop
