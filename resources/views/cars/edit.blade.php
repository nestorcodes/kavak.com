@extends('layouts.app', ['activePage' => 'cars.edit', 'titlePage' => __('Editar vehiculo')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            formulario para editar coche
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