@extends('layouts.plantilla')
@section('title', 'Administradores')
@section('content')

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Directorio de administradores</h4>
                        <div>
                            <a class="mr-3 pointer d-none d-sm-none d-md-inline-flex"
                                onclick="$('#dataTab').DataTable().ajax.reload();"><i class="fa fa-refresh"></i></a>
                        </div>
                    </div>
                    <p class="mb-4">Presiona <span class="text-info text-bold">editar</span> para modificar datos del
                        usuario o <span class="text-danger text-bold">eliminar</span> para eliminar permanentemente el
                        registro del administrador (incluyendo todos sus registros relacionados como las órdenes de
                        servicio atendidas).</p>

                    <div class="table-responsive">
                        <table id="dataTab" class="display table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Username</th>
                                    <th>Perfil de acceso</th>
                                    <th>Creación</th>
                                    <th>Estado</th>
                                    <th>Cuenta</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Username</th>
                                    <th>Perfil</th>
                                    <th>Creación</th>
                                    <th>Estado</th>
                                    <th>Cuenta</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script>
    var editor;
        var editorTab;
        var url = '/SGPI/crud/admins';
        var jsontype = 'application/json';
        var token = $("meta[name='csrf-token']").attr('content');
        let array_catalogo = @json($catalogo, JSON_PRETTY_PRINT);

        $(document).ready(function() {
            let parentId;
            editor = new $.fn.dataTable.Editor({
                ajax: {
                    edit: {
                        type: 'POST',
                        url: url,
                        contentType: jsontype,
                        data: function(editData) {
                            var id = Object.keys(editData.data);
                            editData.data[id[0]]['_token'] = token;
                            editData.data[id[0]]['id'] = id[0];
                            editData.data[id[0]]['index'] = 'update';
                            return JSON.stringify(editData.data[id[0]]);
                        },
                        complete: function() {
                            editorTab.row({
                                selected: true
                            }).deselect();
                            $('#dataTab').DataTable().ajax.reload();
                        },
                        error: function(e) {
                            toask_error(e);
                        }
                    }
                },

                table: '#dataTab',
                idSrc: 'id',
                fields: [{
                    label: 'ID:',
                    name: 'id',
                    multiEditable: false
                },{
                    label: "Perfil:",
                    name: "perfil",
                    type: "select",
                    options: array_catalogo
                },{
                    label: "Disponibilidad:",
                    name: "disponible",
                    type: "radio",
                    options: [{
                            label: "Disponible",
                            value: '1'
                        },
                        {
                            label: "No disponible",
                            value: '2'
                        }
                    ],
                    def: 0
                },{
                    label: "Cuenta:",
                    name: "confirmacion",
                    type: "radio",
                    options: [{
                            label: "Habilitada",
                            value: '1'
                        },
                        {
                            label: "Deshabilitada",
                            value: '2'
                        }
                    ],
                    def: 0
                }],
            });

            editor.on('initEdit', function() {
                editor.show();
                editor.hide('id');
            });

            editorTab = $('#dataTab').DataTable({
                initComplete: function() {
                    this.api()
                        .columns()
                        .every(function() {
                            var column = this,
                                text = '';
                            if ((column.slice(0, 1).shift()) == 4 || (column.slice(0, 1).shift()) ==
                                6) {
                                column.slice(0, 1).shift() == 4 ? text = 'Filtrar columna' : text =
                                    'Filtrar';
                                var element = "custom-select bg-ghost form-control form-control-sm";
                            } else {
                                var element =
                                    "custom-select bg-ghost form-control form-control-sm invisible";
                            }
                            var select = $('<select class="' + element + '"><option value="">' +
                                    text + '</option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function() {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                    column.search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                                });

                                if((column.slice(0, 1).shift()) == 4){
                                    for (i = 0; i < array_catalogo.length; i++) {
                                        select.append('<option value="' + array_catalogo[i].label + '">' + array_catalogo[i].label + '</option>');
                                    }
                                }else{
                                    select.append('<option value="Disponible">Disponible</option>');
                                    select.append('<option value="No Disponible">No Disponible</option>');
                                }

                        });
                },
                dom: 'Bfrtip',
                idSrc: 'id',
                ajax: {
                    type: 'POST',
                    url: url,
                    data: {
                        '_token': token,
                        'index': 'load',
                    },
                    complete: function(json) {
                        $('.select-checkbox, .row-add, .row-view').addClass('pointer');
                        $('td').addClass('td-short');
                    },
                    error: function(e) {
                        toask_error(e);
                    }
                },
                columns: [{
                        data: null,
                        defaultContent: '',
                        className: 'select-checkbox',
                        orderable: false
                    },{
                        data: 'id'
                    },{
                        data: 'nombre'
                    },{
                        data: 'username'
                    },{
                        data: 'perfil',
                        render: function(val, type, row) {
                            for (i = 0; i < array_catalogo.length; i++) {
                                if (val == array_catalogo[i].value) {
                                    return array_catalogo[i].label;
                                }
                            }
                        }
                    },
                    {
                        data: 'created_at',
                    },
                    {
                        data: 'disponible',
                        render: function(val, type, row) {
                            return val == 1 ? "Disponible" : "No Disponible";
                        }
                    },
                    {
                        data: 'confirmacion',
                        render: function(val, type, row) {
                            return val == 1 ? "Habilitada" : "Deshabilitada";
                        }
                    }
                ],
                lengthMenu: [
                    [10]
                ],
                order: [5, 'desc'],
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },
                language: lenguaje,
                buttons: editor_buttons(editor, 2)
            });
        });
        
</script>
@endsection