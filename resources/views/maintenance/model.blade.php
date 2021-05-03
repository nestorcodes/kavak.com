@extends('layouts.app', ['activePage' => 'maintenance.model', 'titlePage' => __('Modelo')])

@section('content')
    <div id="main" class="content">
        <div class="container-fluid">
            <div class="card mt-2">
                <div class="card-body">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelModal">
                        Crear
                    </button>
                    <table id="modelTbl" class="table table-sm table-striped">
                        <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Creado en</th>
                            <th>Actualizado en</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modelModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="modelCode" name="code" value="">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="modelName">
                                        <span class="text-danger">*</span> Nombre
                                    </label>
                                    <input type="text" name="name" id="modelName" class="form-control" placeholder="Nombre">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="modelBrand">
                                        Marca
                                    </label>
                                    <select name="brand" id="modelBrand" class="form-control">
                                        <option value="" selected>Seleccione</option>
                                        @foreach($brands as $brand)
                                            <option value="{{$brand->id}}">{{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <small><span class="text-danger">*</span> Son campos requeridos</small>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" value="{{ route('maint.model.create') }}" class="btn btn-primary fm-i fm-c">Crear</button>
                        <button type="button" style="display: none;" value="{{ route('maint.model.update') }}" class="btn btn-primary fm-i fm-u">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            var cont = $('#main'), tbl = null, mdl = $('#modelModal');

            tbl = cont.find('#modelTbl')
                .DataTable( {
                    "processing": false,
                    "serverSide": true,
                    scrollY: 400,
                    "ajax": {
                        "url": "{{ route('maint.model.load') }}",
                        "type": "POST",
                        "beforeSend": function () {
                            _loader(true);
                        },
                        "data": function (params) {
                            return $.param({
                                "_token": $('meta[name="csrf-token"]').attr('content'),
                            }, {}, params)
                        },

                    },
                    "columns": [
                        { "data": "id", "width": "50px", "render": function (d, t, r, m) {
                                return `
                                <div class="btn-group">
                                  <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    ${d}
                                  </button>
                                  <div class="dropdown-menu">
                                    <a class="dropdown-item selrow btn-edit" href="javascript:void(0);">Editar</a>
                                    <a class="dropdown-item selrow btn-delete" href="javascript:void(0);">Eliminar</a>
                                  </div>
                                </div>
                                `;

                                return r.id;
                            }
                        },
                        { "data": "brand" },
                        { "data": "name" },
                        { "data": "created_at" },
                        { "data": "updated_at" },
                    ],
                    "drawCallback": function () {
                        _loader(false);

                        var table = $(this);

                        table.find('.selrow')
                            .click(function () {
                                tbl.selrow = $(this).closest('tr');
                            });

                        table.find('.btn-edit')
                            .click(function () {
                                var code = tbl.row(tbl.selrow).data().id;

                                $.get('{{ route("maint.model.get") }}', {
                                    _token: $('meta[name="csrf-token"]').attr('content'),
                                    code: code
                                })
                                    .done(function (r) {
                                        if (r.d) {
                                            mdl.find('.modal-title').html('Editar');
                                            mdl.find('form').trigger('reset');
                                            mdl.find('.fm-i').hide();
                                            mdl.find('.fm-u').show();

                                            mdl.find('#modelCode').val(r.d.id);
                                            mdl.find('#modelName').val(r.d.name);
                                            mdl.find('#modelBrand').val(r.d.brand_id);
                                            mdl.modal('show');
                                        }
                                    })
                                    .fail(function (e) {
                                        if (e.responseJSON) {
                                            _ajaxFails(e.responseJSON);
                                        }
                                    })
                            });

                        table.find('.btn-delete')
                            .click(function () {
                                if (confirm('Esta seguro?')) {
                                    _loader(true);

                                    $.post('{{ route("maint.model.delete") }}', {
                                        _token: $('meta[name="csrf-token"]').attr('content'),
                                        code: tbl.row(tbl.selrow).data().id
                                    })
                                        .done(function (r) {
                                            if (r.m) {
                                                _alert('', r.m, 'success');
                                                tbl.draw();
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
                                }
                            })
                    }
                } )

            mdl.find('form')
                .on('reset', function () {
                    $(this).find('#modelCode').val('');
                })
                .on('submit', function (e) {
                    e.preventDefault();

                    var formData = new FormData(mdl.find('form')[0]);

                    _loader(true);

                    $.post({
                        url: mdl.find('form').attr('action'),
                        data: formData,
                        processData: false,
                        contentType: false,
                    })
                        .done(function (r) {
                            if (r.m) {
                                mdl.modal('hide');
                                tbl.draw();
                                _alert('', r.m, 'success');
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
                    return false;
                });

            mdl.find('.btn.fm-i')
                .click(function () {
                    mdl.find('form').attr('action', this.value);
                    mdl.find('form').trigger('submit');
                });

            mdl.on('hidden.bs.modal', function () {
                mdl.find('.modal-title').html('Crear');
                mdl.find('form').trigger('reset');
                mdl.find('.fm-i').hide();
                mdl.find('.fm-c').show();
            }).trigger('hidden.bs.modal');
        });
    </script>
@endpush
