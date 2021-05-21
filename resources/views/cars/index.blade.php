@extends('layouts.app', ['activePage' => 'cars.index', 'titlePage' => __('Listado de Vehiculos')])

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/paginationjs/css/pagination.css') }}">
    <style>
        .card-car dl { margin: 0 !important;}
        .card-car dd:last-child { margin: 0 !important;}
        .card-car { height: 175px; }
        .card-image {
            background-size: cover;
        }
        .card-overlay {
            background-color: rgba(0, 0, 0, 0.3);
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card mt-2">
                <div class="card-body">
                    <div id="toolbar" class="d-flex justify-content-between">
                        <div class="btn-toolbar">
                            <div class="input-group mr-3">
                                <div class="input-group-prepend bg-default">
                                    <span class="input-group-text">Filas:</span>
                                </div>
                                <select name="rows" id="toolbar-rows" class="custom-select">
                                    <option value="12" selected="selected">12</option>
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

                            <a id="btn-filter" href="javascript:void(0)" class="btn btn-secondary m-0"><i class="fa fa-filter"></i> Filtros</a>
                        </div>
                    </div>

                    <div class="row flex-row">
                        <form action="#" id="dt-filter" class="d-none col-sm-2">
                            <div class="d-flex flex-column" style="max-width: 650px; over">
                                <div class="btn-toolbar w-100">
                                    <button type="button" class="btn btn-sm btn-clean">Limpiar</button>
                                    <button type="submit" class="btn btn-sm btn-primary">Aplicar</button>
                                </div>

                                <div class="form-group w-100">
                                    <label for="filter-brand" class="control-label"><small>Marca</small></label>
                                    <select name="brand" id="filter-brand" class="form-control form-control-sm">
                                        <option value="">Seleccione</option>
                                        @foreach($brands as $brand)
                                            <option value="{{$brand->id}}">{{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group w-100">
                                    <label for="filter-model" class="control-label"><small>Modelo</small></label>
                                    <select name="model" id="filter-model" class="form-control form-control-sm">
                                        <option value="">Seleccione</option>
                                        @foreach($models as $model)
                                            <option value="{{$model->id}}" class="br br-{{$model->brand_id}}" style="display: none;">{{$model->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group w-100">
                                    <label for="filter-year" class="control-label"><small>Año</small></label>
                                    <select name="year" id="filter-year" class="form-control form-control-sm">
                                        <option value="">Seleccione</option>
                                        @foreach($years as $year)
                                            <option value="{{$year->year}}">{{$year->year}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group w-100">
                                    <label for="filter-traction" class="control-label"><small>Tracción</small></label>
                                    <select name="traction" id="filter-traction" class="form-control form-control-sm">
                                        <option value="">Seleccione</option>
                                        @foreach($tractions as $traction)
                                            <option value="{{$traction->traction}}">{{$traction->traction}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group w-100">
                                    <label for="filter-seats" class="control-label"><small>Asientos</small></label>
                                    <select name="seats" id="filter-seats" class="form-control form-control-sm">
                                        <option value="">Seleccione</option>
                                        @foreach($seats as $seat)
                                            <option value="{{$seat->seats}}">{{$seat->seats}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                        <div id="items" class="col-sm">
                            <div id="data" class="row mt-2 mb-2" style="height: 550px; overflow-y: auto;"></div>
                            <div id="pager"></div>
                        </div>
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
            let dtFilter = {};

            (function Filter() {
                function applyFilters() {
                    dtFilter = {};

                    var fd = new FormData(cont.find('#dt-filter')[0]);

                    for (var p of fd.entries()) {
                        dtFilter[p[0]] = p[1];
                    }

                    dtFilter['all'] = cont.find('input[type="search"]').val();
                }

                cont.find('#btn-filter').click(function () {
                    if (cont.find('#dt-filter').hasClass('d-none')) {
                        cont.find('#dt-filter').removeClass('d-none');
                    } else {
                        cont.find('#dt-filter').addClass('d-none');
                    }
                });

                cont.find('#filter-brand').change(function () {
                    cont.find('#filter-model').find('.br').hide();

                    if (this.value !== '') {
                        cont.find('#filter-model').find('.br-'+this.value).show();
                    }
                })

                cont.find('#dt-filter')
                    .on('submit', function () {
                        applyFilters();
                        cont.find('#items #pager').pagination('go', 1);

                        return false;
                    });

                cont.find('#dt-filter').find('.btn-clean')
                    .click(function () {
                        cont.find('#dt-filter')[0].reset();
                        applyFilters();
                        cont.find('#items #pager').pagination('go', 1);
                    });

                cont.find('#dt-filter')[0].reset();
                applyFilters();
            })();

            const _renderPrice = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            });

            cont.find('#toolbar-rows').change(function () {
                cont.find('#items #pager').pagination('destroy');
                _initTbl(parseInt(this.value, 10));
            });

            function _initTbl(pageSize) {
                cont.find('#items #pager').pagination({
                    dataSource: '{{ route('vehicle.list') }}',
                    locator: 'items',
                    totalNumberLocator: function (r) {
                        return r.total_items ? r.total_items : 1;
                    },
                    totalNumber: 1,
                    pageSize: pageSize,
                    ajax: {
                        type: 'POST',
                        beforeSend: (c) => {
                            _loader(true);
                        },
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            filter: function (params) {return $.param(dtFilter); },
                        }
                    },
                    callback: (data, pagination) => {
                        console.log(pagination);
                        _loader(false);
                        const c = cont.find('#data');
                        let html = '';

                        $.each(data, function (k, v) {
                            html += `
                            <div class="col-sm-3">
                                <div class="card-image card-car card m-0 mt-2 mb-2 p-0" style="background-image: url(${v.image});">
                                    <div class="card-overlay d-flex justify-content-between flex-column h-100">
                                        <h4 class="text-right m-0 p-2">
                                            @if(auth()->user())
                            <i class="${v.favorite ? 'fas text-danger' : 'far text-default'} fa-heart" value="${v.code}"></i>
                                            @endif
                            </h4>
                            <div class="d-flex">
                                <dl class="p-2">
                                    <dt>${_renderPrice.format(v.price)}</dt>
                                                <dd>
                                                    <small>
                                                    ${v.brand} ${v.model}<br>
                                                    ${v.car_year} | ${v.trs}
                                                    </small>
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        });

                        c.html(html);

                        @if(auth()->user())
                        c.find('.fa-heart').click(function () {
                            const item = $(this);
                            const status = item.hasClass('far') ? 1 : 0;

                            _loader(true);
                            $.post('{{ route("vehicle.favorite") }}', {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                car: item.attr('value'),
                                status: status,
                            })
                                .done(function (r) {
                                    if (r.m) {
                                        if (status) {
                                            item.removeClass('far').addClass('fas');
                                            item.removeClass('text-default').addClass('text-danger');
                                        } else {
                                            item.removeClass('fas').addClass('far');
                                            item.removeClass('text-danger').addClass('text-default');
                                        }
                                    }
                                })
                                .fail(function (e) {
                                    if (e.responseJSON) {
                                        _ajaxFails(e.responseJSON);
                                    }
                                })
                                .always(function () {
                                    _loader(false);
                                });
                        });
                        @endif
                    }
                });
            };

            _initTbl(12);
        });
    </script>
@endpush
