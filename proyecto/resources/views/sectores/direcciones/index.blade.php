@extends('layouts.plantilla')
@section('title','Direcciones')
@section ('content')

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Catálogo de Direcciones</h4>
                        <div>
                            <a class="mr-3 pointer d-none d-sm-none d-md-inline-flex"
                                onclick="$('#dataTab').DataTable().ajax.reload();"><i class="fa fa-refresh"></i></a>
                        </div>
                    </div>
                    <p class="mb-4">Presiona <span class="text-success text-bold">nuevo</span> para crear una dirección. Para
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
                                    <th>Creación</th>
                                    <th>Modifcación</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
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
    var url = '/SGPI/crud/direcciones';
    var jsontype = 'application/json';
    var token = $("meta[name='csrf-token']").attr('content');

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
            fields: editor_createSimpleForm()
        });

        editor.on( 'preSubmit', function ( e, o, action ) {
            if (action !== 'remove' ) {
                var nombre = this.field( 'nombre' );
                var estado = this.field( 'iactivo' );
                if (!nombre.isMultiValue() ) {
                    if (!nombre.val()) {
                        nombre.error('Debe ingresar un nombre');
                    }
                    if (nombre.val().length >= 250) {
                        nombre.error('La longitud debe ser menor a 250 caracteres');
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

        editorTab = $('#dataTab').DataTable({
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
                    data: 'created_at'
                },{
                    data: 'updated_at'
                },{
                    data: 'iactivo',
                    render: function (val, type, row) {
                        return val == 1 ? "Activo" : "No Activo";
                    }
                }
            ],
            lengthMenu: [[10]],
            order: [1, 'asc'],
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
