@extends('layouts.plantilla')
@section('title','Tareas')
@section ('content')

<div class="container-fluid p-0">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12">
			<div class="card">
				<div class="card-body">
					<div class="d-flex justify-content-between">
						<h4 class="card-title">Tareas</h4>
						<div>
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <button type="button" class="btn btn-secondary btn-sm" onclick="location.href='{{route('faqs')}}';" data-toggle="tooltip" data-placement="left" title="Ayuda">
                                    <i class="ti-help"></i></button>
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-dark btn-sm dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ti-filter"></i></button>
                                    <span class="dropdown-menu dropdown-menu-right" x-placement="bottom-end"
                                    style="position: absolute; transform: translate3d(-100px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <a href="#" class="dropdown-item sel-all">Filtrar Todos</a>
                                    <a href="#" class="dropdown-item sel-fin">Filtrar Finalizados</a>
                                    <a href="#" class="dropdown-item sel-pen">Filtrar No Finalizados</a>
                                </span></div></div>
                        </div>
					</div>
					<p class="mb-4">Presiona <span class="text-success text-bold">nuevo</span> para crear una <span class="text-secondary text-bold">tarea independiente</span> (desvinculada de un proyecto raíz). Para
						<span class="text-info text-bold">editar</span>, <span
							class="text-danger text-bold">eliminar</span> o <span
							class="text-secondary text-bold">finalizar</span>, seleccione la fila <span
							class="text-md">☑</span> y presione el botón correspondiente.</p>
   
					<div class="tabla-responsiva">
						<table id="dataTab" class="display table" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th></th>
									<th>Nombre</th>
									<th>Proyecto raíz</th>
									<th>Inicio</th>
									<th>Final</th>
									<th>Estado</th>
									<th>Subtareas</th>
									<th>Info.</th>
								</tr>
							</thead>
                            <tfoot>
								<tr>
									<th></th>
									<th>Nombre</th>
									<th>Proyecto raíz</th>
									<th>Inicio</th>
									<th>Final</th>
									<th>Estado</th>
									<th>Subtareas</th>
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

<script>
var editor;
var editorTab;
var url = '/SGPI/mycrud/tarea';
var jsontype = 'application/json';
var token = $("meta[name='csrf-token']").attr('content');

function opendocument(id) {    
    var url = '{{ route("tareas.documentos", ":id") }}';
    url = url.replace(':id', id);
    var id = url.replace(/[^0-9]/ig, '');
    openiframe3('Documentos', url);
}

function openmanager(id) {    
    var url = '{{ route("tareas.responsable", ":id") }}';
    url = url.replace(':id', id);
    var id = url.replace(/[^0-9]/ig, '');
    openiframe('Responsables', url);
}

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
                    editorTab.columns(5).search('En curso|Atrasado|Entrega hoy',true,false).draw();
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
        fields: editor_createTextareaForm()
	});

    editor.on( 'preSubmit', function ( e, o, action ) {
        if (action !== 'remove' ) {
            var nombre = this.field('nombre'), descripcion = this.field('descripcion'), inicio = this.field('inicio'), final = this.field( 'final' );
            editor_validateTextareaForm(nombre, descripcion, inicio, final);
            if ( this.inError() ) {
                return false;
            }
        }
    } );

		editor.on('initCreate', function() {
        editor.show();
        editor.hide('estado');
    });
    editor.on('initEdit', function() {
        editor.show();
        editor.hide('estado');
    });

    $('#dataTab').on('click', 'tbody td.row-add', function(e) {
        var url = '{{ route("subtareas.create", ":id") }}';
        if(this.parentNode.id == null || this.parentNode.id == '') {
            this.parentNode.id = parentId;
        }
        url = url.replace(':id', this.parentNode.id);
        var id = url.replace(/[^0-9]/ig, '');
        openiframe3('Crear nueva subtarea', url);
    });

    function createChild(row) {
        var rowData = row.data();
        var dias = getDuracion(rowData.inicio, rowData.final, null, 1);
        var dias2 = getDuracion(rowData.inicio, rowData.final, rowData.estado, 2);
        var dias3 = getDuracion(rowData.inicio, rowData.final, null, 3);
        var table = '';
        $.ajax({
            url: '/SGPI/details/proyecto',
            method:'POST',
            dataType: "json",
            data: {
              "_token": $("meta[name='csrf-token']").attr("content"),
              "ide":rowData.id_proyecto,
              "apd":'proyecto'
            },
            async: false,
            success: function (respuesta) { 
                table = '<div class="card-body py-2">'+
                    '<ul class="lk-tree-menu">'+
                        '<li>'+
                            '<input type="checkbox" checked="checked" id="smCB-1-'+rowData.id+'" />'+
                            '<label class="tree_label" for="smCB-1-'+rowData.id+'">'+(respuesta.nombre != "Tarea independiente" ? respuesta.nombre : "") +'<span class="text-xs text-muted ml-2">'+respuesta.descripcion+'</span></label>'+
                            '<ul>'+
                                '<li>'+
                                    '<input type="checkbox" checked="checked" id="smCB-2-'+rowData.id+'" />'+
                                    '<label class="tree_label" for="smCB-2-'+rowData.id+'">'+rowData.nombre+'</label>'+
                                    '<ul>'+
                                        '<li>'+
                                            '<input type="checkbox" checked="checked" id="smCB-3-'+rowData.id+'" />'+
                                            '<label class="tree_label" for="smCB-3-'+rowData.id+'">Propiedades</label>'+
                                            '<ul>'+
                                                '<li><span class="tree_label"><span class="bold-1">Descripción:</span> '+rowData.descripcion +'</span></li>'+
                                                '<li><span class="tree_label"><span class="bold-1">Duración:</span> '+            
                                                dias + ' días <span class="'+ (dias3 == 0 ? 'text-info' : dias3 > 0 ? 'text-warning' : 'text-danger') +' text-xs">' + (dias2 > 0 ? "(" + dias2 + " días de atraso)" : "") + (dias3 == 0 ? "(Se entrega hoy)" : dias3 > 0 ? "(" + dias3 + " días restantes)" : "") +'</span></li>'+
                                            '</ul>'+
                                        '</li>'+
                                    '</ul>'+
                                '</li>'+
                            '</ul>'+
                        '</li>'+
                    '</ul>'+
                '</div>'+
                '<div class="mx-5 my-2"><button class=" btn btn-success btn-sm mr-1" type="button" onclick="openmanager('+rowData.id+');">Responsables</button><button class=" btn btn-info btn-sm mr-1" type="button" onclick="opendocument('+rowData.id+');">Añadir documento</button></div>'
            },
          });
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
                    var column = this;
                    editor_filterCol(column, 'two', 2, 5);
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
                editorTab.columns(5).search('En curso|Atrasado|Entrega hoy',true,false).draw();
            },
            error: function(e) {
                toask_error(e);
            }
        },
        columnDefs: editor_columnsDefs(7),
        columns: editor_columns('id_proyecto'),
        lengthMenu: [
            [10]
        ],
        order: [4, 'asc'],
        select: {
            style: 'os',
            selector: 'td:first-child'
        },
        language: lenguaje,
        buttons: editor_buttons(editor,3).concat([{
                extend: 'selectedSingle',
                text: 'Finalizar',
                className: 'buttons-finish',
                action: function(e, dt, node, config) {
                    editor.edit(editorTab.row({
                        selected: true
                    }).index(), false).set('estado', 'Finalizado').submit();
                }
            }
        ])
    });
});

</script>

@endsection