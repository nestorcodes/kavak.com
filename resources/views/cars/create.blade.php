@extends('layouts.app', ['activePage' => 'cars.create', 'titlePage' => __('Crear vehiculo')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            formulario para crear coche
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