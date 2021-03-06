@extends('layouts.app', ['activePage' => 'cars.index', 'titlePage' => __('Listado de Vehiculos')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            Listado de Vehiculos
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            // JQuery y JS va aqui
        });
    </script>
@endpush