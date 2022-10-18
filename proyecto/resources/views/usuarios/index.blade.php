@extends('layouts.plantilla')
@section('title','Usuarios')
@section ('content')

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Directorio de usuarios</h4>
                        <div>
                            <a class="mr-3 pointer d-none d-sm-none d-md-inline-flex"
                                onclick="$('#dataTab').DataTable().ajax.reload();"><i class="fa fa-refresh"></i></a>
                        </div>
                    </div>
                    <p class="mb-4">Presiona <span class="text-info text-bold">editar</span> para modificar datos del
                        usuario o <span class="text-danger text-bold">eliminar</span> para eliminar permanentemente el
                        registro del usuario (incluyendo todos sus registros relacionados como órdenes, conferencias,
                        proyectos, notas y documentos).</p>

                    <div class="table-responsive">
                        <table id="dataTab" class="display table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Username</th>
                                    <th>Tipo de usuario</th>
                                    <th>Creación</th>
                                    <th>Activo</th>
                                    <th>Info.</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Username</th>
                                    <th>Tipo de usuario</th>
                                    <th>Creación</th>
                                    <th>Activo</th>
                                    <th>Info.</th>
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
    var url = '/SGPI/crud/usuarios';
    var jsontype = 'application/json';
    var token = $("meta[name='csrf-token']").attr('content');
    let array_areas = @json($areas, JSON_PRETTY_PRINT);

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
            fields: [
                {
                    label: 'ID:',
                    name: 'id',
                    multiEditable: false
                },{
                    label: 'Email:',
                    name: 'email',
                    multiEditable: false
                },{
                    label: 'Teléfono:',
                    name: 'telefono',
                    multiEditable: false
                },{
                    label: "Area:",
                    name:  "area",
                    type:  "select",
                    options: array_areas
                },{
                    label: "Cuenta:",
                    name:  "iactivo",
                    type:  "radio",
                    options: [
                        { label: "Activa", value: '1' },
                        { label: "Inactiva",  value: '2' }
                    ],
                    def: 0
                }
            ],
        });

        editor.on('initEdit', function() {
            editor.show();
            editor.hide('id');
        });

        function createChild(row) {
            var rowData = row.data();
            var table = '<table class="table m-0" border="0" style="max-with: 100%">' +
                '<tr>' +
                    '<td style="width: 10%;"> Área:' +
                    '</td>' +
                    '<td class="td-large" style="width: 90%;">' +
                    rowData.apema +
                    '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td style="width: 10%;"> Teléfono:' +
                    '</td>' +
                    '<td class="td-large" style="width: 90%;">' +
                    rowData.telefono +
                    '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td style="width: 10%;"> Email:' +
                    '</td>' +
                    '<td class="td-large" style="width: 90%;">' +
                    rowData.email +   
                        '</td>' +
                    '</tr>' +
                '</table>'
            row.child(table).show();
        }

        function destroyChild(row) {
            var table = $('dataTab', row.child());
            table.detach();
            table.DataTable().destroy();
            row.child.hide();
        }

        $('#dataTab').on('click', 'tbody td.dt-control', function() {
            var tr = $(this).closest('tr');
            var row = editorTab.row(tr);
            if (row.child.isShown()) {
                destroyChild(row);
                tr.removeClass('shown');
            } else {
                createChild(row);
                tr.addClass('shown');
                $('.shown').next().addClass('bg-ghost');
            }
        });
    

        editorTab = $('#dataTab').DataTable({
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function () {
                        var column = this, text = '';
                        if((column.slice(0, 1).shift()) == 4 || (column.slice(0, 1).shift()) == 6){
                            column.slice(0, 1).shift() == 4 ? text = 'Filtrar columna' : text = 'Filtrar';
                            var element = "custom-select bg-ghost form-control form-control-sm";
                        }else{
                            var element = "custom-select bg-ghost form-control form-control-sm invisible";
                        }
                        var select = $('<select class="'+element+'"><option value="">'+text+'</option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });
        
                            if((column.slice(0, 1).shift()) == 4){
                                select.append('<option value="Normal">Normal</option>');
                                select.append('<option value="Administrador">Administrador</option>');
                            }else{
                                select.append('<option value="Activo">Activo</option>');
                                select.append('<option value="No Activo">No Activo</option>');
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
                    data: 'tipo_usuario',
                    render: function (val, type, row) {
                        return val == 1 ? "Normal" : "Administrador";
                    }
                },{
                    data: 'created_at'
                },{
                    data: 'iactivo',
                    render: function (val, type, row) {
                        return val == 1 ? "Activo" : "No Activo";
                    }
                },{
                    data: null,
                    defaultContent: '',
                    className: 'dt-control dt-center',
                    orderable: false
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