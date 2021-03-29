@extends('layouts.app', ['activePage' => 'cars.index', 'titlePage' => __('Listado de Vehiculos')])

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/paginationjs/css/pagination.css') }}">
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div id="toolbar" class="d-flex justify-content-between">
                        <div class="btn-toolbar">
                            <div class="input-group mr-3">
                                <div class="input-group-prepend bg-default">
                                    <span class="input-group-text">Filas:</span>
                                </div>
                                <select name="rows" id="toolbar-rows" class="custom-select">
                                    <option value="15" selected="selected">15</option>
                                    <option value="30">30</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>

                            @auth
                            <a href="{{ route('cars.create') }}" class="btn btn-info m-0">Crear Vehiculo</a>
                            @endauth
                        </div>

                        <div class="btn-toolbar">
                            <div class="btn-group m-0 mr-3">
                                <input type="search" name="search" class="form-control" placeholder="Búsqueda Rápida">
                            </div>
                        </div>
                    </div>

                    <div id="items">
                        <div id="data"></div>
                        <div id="pager"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="{{ asset('vendor/paginationjs/js/pagination.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            const cont = $('.content');

            cont.find('#items #pager').pagination({
                dataSource: '{{ route('vehicle.list') }}',
                locator: 'items',
                totalNumber: 1,
                pageSize: 15,
                ajax: {
                    beforeSend: () => {
                        //_loader(true);
                    },
                },
                callback: (data, pagination) => {
                    console.log(data, pagination);
                }
            });
        });
    </script>
@endpush
