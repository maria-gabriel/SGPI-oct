@extends('layouts.modal')
@section('content')
    <div class="row bg-white p-10 m-10 rounded">
        <div class="col-12 py-3">
            <p class="mb-4">Presiona <span class="text-success text-bold">nuevo</span> para crear una tarea. Para
                <span class="text-info text-bold">editar</span>, <span class="text-danger text-bold">eliminar</span>
                o <span class="text-secondary text-bold">finalizar</span>, seleccione la fila <span
                    class="text-md">☑</span> y presione el botón correspondiente. <br><span class="text-muted text-xs">Al eliminar o finalizar una tarea, las subtareas subyacentes serán alteradas respectivamente.</span>
            </p>
            <div class="table-responsive">
                <table id="dataTab" class="display table2" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nombre</th>
                            <th>Inicio</th>
                            <th>Final</th>
                            <th>Estado</th>
                            <th>Subtareas</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

<script type="text/javascript">
let array_proyecto = @json($proyecto, JSON_PRETTY_PRINT);
var editor;
var url = '/SGPI/crud/tarea';
var url2 = '/SGPI/crud/subtarea';
var jsontype = 'application/json';
var token = $("meta[name='csrf-token']").attr('content');

$(document).ready(function() {
    editor = new $.fn.dataTable.Editor({
        ajax: {
            create: {
                type: 'POST',
                url: url,
                contentType: jsontype,
                data: function(addData) {
                    addData.data[0]["_token"] = token;
                    addData.data[0]["id_proyecto"] = array_proyecto['id'];
                    addData.data[0]['index'] = 'save';
                    return JSON.stringify(addData.data[0]);
                },
                error: function(e) {
                    toask_error(e);
                }
            },
            edit: {
                type: 'POST',
                url: url,
                contentType: jsontype,
                data: function(editData) {
                    var id = Object.keys(editData.data);
                    editData.data[id[0]]["_token"] = token;
                    editData.data[id[0]]["id"] = id[0];
                    editData.data[id[0]]['index'] = 'update';
                    return JSON.stringify(editData.data[id[0]]);
                },
                complete: function() {
                    editorTab.row({
                        selected: true
                    }).deselect();
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
                    editData.data[idSelected]["_token"] = token;
                    editData.data[idSelected]['index'] = 'remove';
                    return JSON.stringify(editData.data[idSelected]);
                },
                success: function() {},
                error: function(e) {
                    toask_error(e);
                }
            }
        },
        table: "#dataTab",
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
    });

    editor.on('initCreate', function() {
        editor.show();
        editor.hide('estado');
    });
    editor.on('initEdit', function() {
        editor.show();
        editor.hide('estado');
    });

    function createChild(row) {
    var table = $('<table id="dataTab2" class="display table2" width="100%"/>');
    row.child(table).show();

    var rowData = row.data();
    var editor2 = new $.fn.dataTable.Editor({
        ajax: {
            create: {
                type: 'POST',
                url: url2,
                contentType: jsontype,
                data: function(addData) {
                    addData.data[0]["_token"] = token;
                    addData.data[0]["id_tarea"] = rowData.id;
                    addData.data[0]['index'] = 'save';
                    return JSON.stringify(addData.data[0]);
                },
                error: function(e) {
                    toask_error(e);
                }
            },
            edit: {
                type: 'POST',
                url: url2,
                contentType: jsontype,
                data: function(editData) {
                    var id = Object.keys(editData.data);
                    editData.data[id[0]]["_token"] = token;
                    editData.data[id[0]]["id"] = id[0];
                    editData.data[id[0]]["index"] = 'update';
                    return JSON.stringify(editData.data[id[0]]);
                },
                complete: function() {
                    editorTab2.row({
                        selected: true
                    }).deselect();
                },
                error: function(e) {
                    toask_error(e);
                }
            },
            remove: {
                type: 'POST',
                url: url2,
                contentType: jsontype,
                data: function(editData) {
                    var idSelected;
                    $.each(editData.data, function(key, value) {
                        idSelected = value.id;
                    });
                    editData.data[idSelected]["_token"] =token;
                    editData.data[idSelected]['index'] = 'remove';
                    return JSON.stringify(editData.data[idSelected]);
                },
                error: function(e) {
                    toask_error(e);
                }
            }
        },
        table: table,
        idSrc: 'id',
        fields: editor_createTextareaForm()
    });

    editor2.on( 'preSubmit', function ( e, o, action ) {
        if (action !== 'remove' ) {
            var nombre = this.field('nombre'), descripcion = this.field('descripcion'), inicio = this.field('inicio'), final = this.field( 'final' );
            editor_validateTextareaForm(nombre, descripcion, inicio, final);
            if ( this.inError() ) {
                return false;
            }
        }
    });

    editor2.on('initCreate', function() {
        editor2.show();
        editor2.hide('estado');
    });
    editor2.on('initEdit', function() {
        editor2.show();
        editor2.hide('estado');
    });

    var editorTab2 = table.DataTable({
        dom: "Bfrtip",
        paging: false,
        info: false,
        idSrc: 'id',
        ajax: {
            type: 'POST',
            url: url2,
            data: {
                '_token':token,
                'id_tarea': rowData.id,
                'index': 'get',
            },
            complete: function() {
                var t = document.getElementById("dataTab2");
                t.getElementsByTagName("th")[0].style.width = "10px";
                t.getElementsByTagName("th")[1].textContent = "Nombre";
                t.getElementsByTagName("th")[1].style.width = "181px";
                t.getElementsByTagName("th")[2].textContent = "Inicio";
                t.getElementsByTagName("th")[3].textContent = "Final";
                t.getElementsByTagName("th")[4].textContent = "Estado";
                $("td").css({
                    "line-height": "9px"
                });
            },
        },
        columnDefs: editor_columnsDefSimple(5),
        columns: editor_columnSimple('NA'),
        lengthMenu: [
            [5],
        ],
        select: {
            style: 'os',
            selector: 'td:first-child'
        },
        buttons: editor_buttons(editor2,3).concat([{
            extend: 'selectedSingle',
            text: 'Finalizar',
            className: 'buttons-finish',
            action: function(e, dt, node, config) {
                editor2.edit(editorTab2.row({
                    selected: true
                }).index(), false).set('estado', 'Finalizado').submit();
            }
        }
        ]),
        language: lenguaje,
    });
    $(".buttons-create").removeClass("dt-button").addClass("btn btn-success btn-sm");
    $(".buttons-edit").removeClass("dt-button").addClass("btn btn-info btn-sm");
    $(".buttons-remove").removeClass("dt-button").addClass("btn btn-danger btn-sm");
    $('.buttons-finish').removeClass('dt-button').addClass('btn btn-secondary btn-sm');
    $("#dataTab2_filter input").addClass("border border-none bg-lavender opacity-4 mt-1");
    }

    function destroyChild(row) {
        var table = $("dataTab", row.child());
        table.detach();
        table.DataTable().destroy();
        row.child.hide();
    }

    $("#dataTab").on("click", "tbody td.dt-control", function(e) {
        var tr = $(this).closest("tr");
        var row = editorTab.row(tr);
        if (row.child.isShown()) {
            destroyChild(row);
            tr.removeClass("shown");
        } else {
            createChild(row);
            tr.addClass("shown");
            $(".shown").next().addClass("bg-ghost");
        }
    });

    var editorTab = $('#dataTab').DataTable({
        dom: "Bfrtip",
        idSrc: 'id',
        ajax: {
            type: 'POST',
            url: url,
            data: {
                '_token': token,
                'id_proyecto': array_proyecto['id'],
                'index': 'get',
            },
            complete: function() {
                $("td").css({
                    "line-height": "10px"
                });
            },
        },
        columnDefs: editor_columnsDefSimple(null),
        columns: editor_columnSimple(null),
        lengthMenu: [
            [5],
        ],
        select: {
            style: 'os',
            selector: 'td:first-child'
        },
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
        ]),
        language: lenguaje,
    });
});
</script>
@endsection
