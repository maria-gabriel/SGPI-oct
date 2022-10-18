@extends('layouts.modal')
@section('content')
    <div class="row bg-white p-10 m-10 rounded">
        <div class="col-12 py-3">
            <p class="mb-4">Presiona <span class="text-secondary text-bold">Más detalles</span> para ver la tabla de
                <b>subtareas</b> completa.</p>
            <div class="table-responsive">
                <table id="dataTab" class="display table2" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nombre</th>
                            <th>Inicio</th>
                            <th>Final</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

<script type="text/javascript">
    let array_tarea = @json($tarea, JSON_PRETTY_PRINT);
    var editor;
    var url = '/SGPI/mycrud/subtarea';
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
                        addData.data[0]["id_tarea"] = array_tarea['id'];
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
            var rowData = row.data();
            var table = $('<table class="display" width="100%"/>');
            row.child(table).show();

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
            }
        });

        $('#dataTab').on('click', 'tbody td.row-add', function(e) {
            console.log(this.parentNode);
        });

        var editorTab = $('#dataTab').DataTable({
            dom: "Bfrtip",
            idSrc: 'id',
            ajax: {
                type: 'POST',
                url: url,
                data: {
                    "_token": token,
                    "id_tarea": array_tarea['id'],
                    'index': 'get'
                },
                complete: function() {
                    $(".select-checkbox, .row-add, .row-view").addClass("pointer");
                    $("td").css({
                        "line-height": "10px"
                    });
                    $("td").addClass("td-short");

                    var myDiv = document.getElementsByClassName("dt-buttons");
                    var button = document.createElement("BUTTON");
                    button.innerHTML = "Más detalles";
                    button.className = "more btn btn-outline-secondary btn-sm";
                    myDiv[0].appendChild(button);
                    $(".more").click(function() {
                        localStorage.setItem('modal-response', 'subtareas');
                        window.parent.closeModal();
                    });
                },
                error: function(e) {
                    toask_error(e);
                }
            },
            columns: editor_columnSimple('NA'),
            lengthMenu: [[5]],
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
            buttons: editor_buttons(editor, 3).concat([{
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
