@extends('layouts.app', ['activePage' => 'cars.index', 'titlePage' => __('Listado de Vehiculos')])

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/paginationjs/css/pagination.css') }}">
    <style>
        .card-car dl { margin: 0 !important;}
        .card-car dd:last-child { margin: 0 !important;}
        .card-car { height: 175px; }
        .card-image {
            background-image: url(https://images.unsplash.com/photo-1552519507-da3b142c6e3d?ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8Y2Fyc3xlbnwwfHwwfHw%3D&ixlib=rb-1.2.1&w=1000&q=80);
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
                        <div id="data" class="row mt-2 mb-2" style="height: 525px; overflow-y: auto;"></div>
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

            const _renderPrice = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            });

            cont.find('#items #pager').pagination({
                dataSource: '{{ route('vehicle.list') }}',
                locator: 'items',
                totalNumber: 1,
                pageSize: 15,
                ajax: {
                    beforeSend: () => {
                        _loader(true);
                    },
                },
                callback: (data, pagination) => {
                    _loader(false);

                    const c = cont.find('#data');
                    let html = '';

                    $.each(data, function (k, v) {
                        html += `
                            <div class="col-sm-2">
                                <div class="card-image card-car card m-0 p-0">
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
                                                    ${v.brand} ${v.model}
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
        });
    </script>
@endpush
