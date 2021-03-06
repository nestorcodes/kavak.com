@extends('layouts.app', ['activePage' => 'cars.show', 'titlePage' => __('Mostrar vehiculo')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            Detalles de vehiculo
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