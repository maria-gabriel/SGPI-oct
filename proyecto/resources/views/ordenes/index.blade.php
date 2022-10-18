@extends('layouts.plantilla')
@section('title','Ordenes')
@section ('content')

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Mis órdenes</h4>
                        <div>
                            <a class="mr-3 pointer d-none d-sm-none d-md-inline-flex text-info" title="Recargar tabla" data-toggle="tooltip" data-placement="left"
                                onclick="$('#dataTab').DataTable().ajax.reload();"><i class="fa fa-refresh"></i></a>
                            <a class="mr-3 pointer d-none d-sm-none d-md-inline-flex text-warning" title="Necesito ayuda" data-toggle="tooltip" data-placement="left"
                            href="{{route('faqs')}}"><i class="fa fa-question"></i></a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="dataTab" class="display table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Tarea</th>
                                    <th>Técnico</th>
                                    <th>Creación</th>
                                    <th>Estado</th>
                                    <th>Info.</th>
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
    var url = '/SGPI/crud/ordenes';
    var jsontype = 'application/json';
    var token = $("meta[name='csrf-token']").attr('content');

    $(document).ready(function() {
        function createChild(row) {
            var rowData = row.data();
            table = editor_children('Nombre de la ruta',rowData.name,1);
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
                    data: 'id_servicio'
                },{
                    data: 'id_admin'
                },{
                    data: 'created_at'
                },{
                    data: 'estado',
                    render: function (val, type, row) {
                        return val == 1 ? "Pendiente" : "Finalizada";
                    }
                },{
                    data: null,
                    defaultContent: '',
                    className: 'dt-control dt-center',
                    orderable: false
                }
            ],
            lengthMenu: [[10]],
            order: [1, 'asc'],
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
            language: lenguaje,
        });
    });

</script>
@endsection
