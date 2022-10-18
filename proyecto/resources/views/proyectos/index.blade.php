@extends('layouts.plantilla')
@section('title','Proyectos')
@section ('content')

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Exportar proyectos</h4>
                    </div>
                    <p class="mb-4">Presiona <span class="text-success text-bold">Excel</span>, <span class="text-danger text-bold">PDF</span> 
                        o <span class="text-info text-bold">Print</span> para exportar o imprimir todos los proyectos. Para exportar proyectos
                        específicos, pulsa la tecla <span class="border-symbol text-xxs p-1">Ctrl</span> y selecciona los proyectos correspondientes. Para personalizar las 
                        columnas a exportar, presiona la opción <span class="text-warning text-bold">Columnas</span> de la parte inferior. 
                        <br><span class="text-muted text-xs">Los proyectos a exportar también pueden ser filtrados a través de las columnas <b>AREA</b> y/o <b>ESTADO</b>.</span>
                    </p>
                    <div class="tabla-responsiva">
                        <table id="table" class="display table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Area</th>
                                    <th>Responsables</th>
                                    <th>Inicio</th>
                                    <th>Final</th>
                                    <th>Estado</th>
                                    <th>INFO.</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Area</th>
                                    <th>Responsables</th>
                                    <th>Inicio</th>
                                    <th>Final</th>
                                    <th>Estado</th>
                                    <th>INFO.</th>
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
    var numRows;

    $(document).ready(function(){
    $('#thead-table').addClass('bg-none');

    editorTab = $('#table').DataTable({
        dom: 'Bfrtip',
        initComplete: function () {
            this.api()
                .columns()
                .every(function () {
                    var column = this;
                    editor_filterCol(column, 'two', 3, 7);
                });
            },
            ajax: {
                type: 'POST',
                url: '/SGPI/crud/proyecto',
                data: {
                    '_token': $("meta[name='csrf-token']").attr('content'),
                    'index': 'load',
                },
                complete: function(json) {
                    numRows = editorTab.rows( ).count();
                },
                error: function(e) {
                    toask_error(e);
                }
            },
            select: true,
            lengthMenu: lengthmenu,
            columnDefs:[
            {targets: [0], width: "1%"},
            {targets: [1], className: "td-short"},
            {targets: [2], visible: false, className: "td-short"},
            {targets: [3], className: "td-short"},
            {targets: [4], visible: false , className: "td-short"},
            {targets: [5], width: "1%"},
            {targets: [6], width: "1%"},
            {targets: [7], width: "1%"},
            {targets: [8], width: "1%"}
            ],
            columns: [
                { data: 'id' },
                { data: 'nombre' },
                { data: 'descripcion' },
                { data: 'area' },
                { data: 'responsables' },
                { data: 'inicio' },
                { data: 'final' },
                { data: 'estado',
                render: function (val, type, row) {
                    if (val == 'En curso') {
                        return '<span class="badge badge-info">En curso</span>';
                    }else if(val == 'Atrasado') {
                        return '<span class="badge badge-danger">Atrasado</span>';
                    }else if(val == 'Entrega hoy') {
                        return '<span class="badge badge-warning">Entrega hoy</span>';
                    }else if(val == 'Finalizado') {
                        return '<span class="badge badge-success">Finalizado</span>';
                    }else{
                        return '<span class="badge badge-info">'+val+'</span>';
                    }
                    }
                },
                {
                    data: null,
                    defaultContent: '',
                    className: 'dt-control dt-center',
                    orderable: false
                }
            ],
            language: lenguaje,
            buttons: editor_export(),
        });
        new $.fn.dataTable.Buttons( editorTab, {
            buttons: [
                {
                    popoverTitle: 'Columnas visibles',
                    extend: 'colvis',
                },
                {
                    text: 'Mostrar total',
                    className: 'buttons-rows',
                    action: function ( e, dt, node, conf ) {
                        numRows = editorTab.rows( ).count();
                        toastr.options = {timeOut: 3000,progressBar: true,showMethod: "slideDown",hideMethod: "slideUp",showDuration: 200,hideDuration: 200,positionClass:"toast-bottom-center"};
                        toastr.success('Hay un total de '+ numRows +' proyectos.');
                    }
                }
            ]
        } );
     
        editorTab.buttons( 1, null ).container().appendTo(
            editorTab.table().container()
        );

        function destroyChild(row) {
            var table = $('table', row.child());
            table.detach();
            table.DataTable().destroy();
            row.child.hide();
        }
    
        $('#table').on('click', 'tbody td.dt-control', function() {
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

        function createChild(row) {
            var rowData = row.data();
            var dias = getDuracion(rowData.inicio, rowData.final, null, 1);
            var strArray = rowData.responsables.split(",");
            var responsables = '';
            for(var i = 0; i < strArray.length; i++){
                responsables += '<li><span class="tree_label"><span class="bold-1">'+strArray[i]+'</span></span></li>';
            }
            var table =  '<div class="card-body py-2">'+
                    '<ul class="lk-tree-menu">'+
                        '<li>'+
                            '<input type="checkbox" checked="checked" id="smCB-1-'+rowData.id+'" />'+
                            '<label class="tree_label" for="smCB-1-'+rowData.id+'">'+rowData.nombre +'</label>'+
                            '<ul>'+
                                '<li>'+
                                    '<input type="checkbox" checked="checked" id="smCB-2-'+rowData.id+'" />'+
                                    '<label class="tree_label" for="smCB-2-'+rowData.id+'">Propiedades</label>'+
                                    '<ul>'+
                                        '<li><span class="tree_label"><span class="bold-1">Sector:</span> '+rowData.area +'</span></li>'+
                                        '<li><span class="tree_label"><span class="bold-1">Descripción:</span> '+rowData.descripcion +'</span></li>'+
                                        '<li><span class="tree_label"><span class="bold-1">Duración:</span> '+            
                                            dias + ' días <span></span></li>'+
                                    '</ul>'+
                                '</li>'+
                                '<li>'+
                                    '<input type="checkbox" id="smCB-3-'+rowData.id+'" />'+
                                    '<label class="tree_label" for="smCB-3-'+rowData.id+'">Responsables</label>'+
                                    '<ul>'+responsables+ '</ul>'+
                                '</li>'+
                           '</ul>'+
                        '</li>'+
                    '</ul>'+
                '</div>';
            row.child(table).show();
        }

    });
    
</script>

@endsection
