@extends('layouts.plantilla')
@section('title','Permisos')
@section ('content')

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Directorio de permisos</h4>
                        <div>
                            <a class="mr-3 pointer d-none d-sm-none d-md-inline-flex"
                                onclick="$('#dataTab').DataTable().ajax.reload();"><i class="fa fa-refresh"></i></a>
                        </div>
                    </div>
                    <p class="mb-4">Presiona <span class="text-success text-bold">nuevo</span> para crear un permiso. Para
                        <span class="text-info text-bold">editar</span> o <span class="text-danger text-bold">eliminar</span>
                         seleccione la fila <span class="text-md">☑</span> y presione el botón correspondiente.
                    </p>

                    <div class="table-responsive">
                        <table id="dataTab" class="display table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Perfiles</th>
                                    <th>Creación</th>
                                    <th>Estado</th>
                                    <th>Info.</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Perfiles</th>
                                    <th>Creación</th>
                                    <th>Estado</th>
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
    var url = '/SGPI/crud/accesos';
    var jsontype = 'application/json';
    var token = $("meta[name='csrf-token']").attr('content');
    let array_cats = @json($accesos, JSON_PRETTY_PRINT);
    let array_catalogo = @json($catalogo, JSON_PRETTY_PRINT);

    $(document).ready(function() {
        let parentId;
        editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: url,
                    contentType: jsontype,
                    data: function(addData) {
                        addData.data[0]['_token'] = token;
                        addData.data[0]['index'] = 'save';
                        return JSON.stringify(addData.data[0]);
                    },
                    error: function(e) {
                        toask_error(e);
                    },
                    success: function(respuesta){
                        parentId = respuesta['data'][0].id;
                    }
                },
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
                },
                remove: {
                    type: 'POST',
                    url: url,
                    contentType: jsontype,
                    data: function(editData) {
                        var idSelected;
                        $.each(editData.data, function(key, value) {
                            idSelected = value.id;
                        });
                        editData.data[idSelected]['_token'] = token;
                        editData.data[idSelected]['index'] = 'remove';
                        return JSON.stringify(editData.data[idSelected]);
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
                    label: 'Nombre:',
                    fieldInfo: "Ejemplo: home.index",
                    name: 'nombre',
                    multiEditable: false
                },{
                    label: 'Ruta:',
                    fieldInfo: "Ejemplo: home/save",
                    name: 'ruta',
                    multiEditable: false
                },{
                    label: "Perfiles:",
                    name:  "perfiles",
                    type:  "checkbox",
                    options: array_catalogo
                },{
                    label: "Estado:",
                    name:  "iactivo",
                    type:  "radio",
                    options: [
                        { label: "Activo", value: '1' },
                        { label: "No Activo",  value: '2' }
                    ],
                    def: 0
                }
            ],
        });

        editor.on( 'preSubmit', function ( e, o, action ) {
            if (action !== 'remove' ) {
                var nombre = this.field( 'nombre' );
                var ruta = this.field( 'ruta' );
                var estado = this.field( 'iactivo' );
                if (!nombre.isMultiValue() ) {
                    if (!nombre.val()) {
                        nombre.error('Debe ingresar un nombre');
                    }
                    if (nombre.val().length >= 30) {
                        nombre.error('La longitud debe ser menor a 30 caracteres');
                    }
                    if (!ruta.val()) {
                        ruta.error('Debe ingresar una ruta');
                    }
                    if (ruta.val().length >= 100) {
                        ruta.error('La longitud debe ser menor a 100 caracteres');
                    }
                    if (estado.val() == 0) {
                        estado.error('Debe seleccionar un estado');
                    }
                }
                if ( this.inError() ) {
                    return false;
                }
            }
        });

        function createChild(row) {
            var rowData = row.data();
            table = editor_children('Nombre de la ruta',rowData.ruta,1);
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
                        if((column.slice(0, 1).shift()) == 3 || (column.slice(0, 1).shift()) == 5){
                            column.slice(0, 1).shift() == 3 ? text = 'Filtrar columna' : text = 'Filtrar';
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
                        
                        if((column.slice(0, 1).shift()) == 3){
                            select.append('<option value="Máster">Máster</option>');
                            select.append('<option value="Máster, Admin">Máster, Admin</option>');
                            select.append('<option value="Normal, Máster, Admin, Técnico">Normal, Máster, Admin, Técnico</option>');
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
                    data: 'perfiles',
                    render: function (val, type, row) {
                        let perfiles = '';
                        for (i=0; i<val.length; i++) {
                            for (j=0; j<array_cats.length; j++) {
                                if(val[i] == array_cats[j].id){
                                    perfiles += array_cats[j].nombre + ', ';
                                }
                            }
                        }
                        return perfiles.slice(0,-2);
                    }
                },{
                    data: 'created_at',
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
            lengthMenu: [[10]],
            order: [1, 'desc'],
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
            language: lenguaje,
            buttons: editor_buttons(editor, 3)
        });
    });

</script>
@endsection