$(document).ready(function () {
    $('.sel-pen').click(function() {
        editorTab.columns(5).search('En curso|Atrasado|Entrega hoy',true,false).draw();
        $('.sel-text').text('No finalizados');
        $('.dropdown, .dropdown-menu-right').removeClass('show');
    });
    $('.sel-fin').click(function() {
        editorTab.columns(5).search('Finalizado').draw();
        $('.sel-text').text('Finalizados');
        $('.dropdown, .dropdown-menu-right').removeClass('show');
    });
    $('.sel-all').click(function() {
        editorTab.columns(5).search('').draw();
        $('.sel-text').text('Todos los registros');
        $('.dropdown, .dropdown-menu-right').removeClass('show');
    });

    $('.buttons-create').removeClass('dt-button').addClass('btn btn-success btn-sm');
    $('.buttons-edit').removeClass('dt-button').addClass('btn btn-info btn-sm');
    $('.buttons-remove').removeClass('dt-button').addClass('btn btn-danger btn-sm');
    $('.buttons-finish').removeClass('dt-button').addClass('btn btn-secondary btn-sm');
    $(".buttons-excel").removeClass("dt-button").addClass("btn btn-success btn-sm");
    $(".buttons-pdf").removeClass("dt-button").addClass("btn btn-danger btn-sm");
    $(".buttons-print").removeClass("dt-button").addClass("btn btn-info btn-sm");
    $(".buttons-page-length").removeClass("dt-button").addClass("btn btn-outline-secondary btn-sm");
    $(".buttons-rows").removeClass("dt-button").addClass("btn btn-outline-success btn-sm");
    $(".buttons-colvis").removeClass("dt-button").addClass("btn btn-warning btn-sm");
    $('#dataTab_filter input').addClass('border border-none');
    $('.dataTables_paginate').click(function() {
        $('td').addClass('td-short');
    });
    $('#table_length').addClass('ml-3');
    
});

function editor_children(title, data, options) { //options = 1-oneRow 2-twoRow 3-threeRow
    if(options == 1){
        var table = '<table class="table m-0" border="0" style="max-with: 100%">' +
        '<tr>' +
        '<td style="width: 10%;"> '+title+':' +
        '</td>' +
        '<td class="td-large" style="width: 90%;">' +
        data +
        '</td>' +
        '</tr>' +
        '</table>';
    }
    return table;
  }

  function editor_createSimpleForm() {
    var form = [
        {
            label: 'Nombre:',
            name: 'nombre',
            multiEditable: false
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
    ];
    return form;
  }

  function editor_createTextareaForm() {
    var form = [{
        label: 'Estado:',
        name: 'estado',
        multiEditable: false
    },{
        label: "Nombre:",
        name: "nombre",
        multiEditable: false
    }, {
        label: "Descripción:",
        name: "descripcion",
        type: 'textarea',
        multiEditable: false
    }, {
        label: "Fecha inicio:",
        name: "inicio",
        type: "datetime",
        multiEditable: false
    }, {
        label: "Fecha final:",
        name: "final",
        type: "datetime",
        multiEditable: false
    }];
    return form;
  }

  function editor_createTextareaForm2() {
    var form = [{
        label: "Nombre:",
        name: "nombre",
        multiEditable: false
    }, {
        label: "Descripción:",
        name: "descripcion",
        type: 'textarea',
        multiEditable: false
    }, {
        label: "Fecha inicio:",
        name: "inicio",
        type: "datetime",
        multiEditable: false
    }, {
        label: "Fecha final:",
        name: "final",
        type: "datetime",
        multiEditable: false
    }];
    return form;
  }

  function editor_createDoubleForm(label, name) {
    var form = [
        {
            label: 'Nombre:',
            name: 'nombre',
            multiEditable: false
        },{
            label: label,
            name:  name,
            multiEditable: false
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
    ];
    return form;
  }

  function editor_createSelectForm(label, name, array) {
    var form = [
        {
            label: 'Nombre:',
            name: 'nombre',
            multiEditable: false
        },{
            label: label,
            name:  name,
            type:  "select",
            options: array
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
    ];
    return form;
  }

  function editor_validateTextareaForm(nombre, descripcion, inicio, final) {
    if (!nombre.isMultiValue() ) {
        if (!nombre.val()) {
            nombre.error('Debe ingresar un nombre');
        }
        if (nombre.val().length > 200) {
            nombre.error('La longitud debe ser menor a 200 caracteres');
        }
        if (!descripcion.val()) {
            descripcion.error('Debe ingresar una descripción');
        }
        if (descripcion.val().length > 300) {
            descripcion.error('La longitud debe ser menor a 300 caracteres');
        }
        if (!inicio.val()) {
            inicio.error('Debe ingresar una fecha de inicio');
        }
        if (!final.val()) {
            final.error('Debe ingresar una fecha de finalización');
        }
    }
  }
  
  function editor_buttons(editor, options) { //options = 3-create/edit/delete 2-edit/delete 1-edit
        var buttons = [{
            extend: 'create',
            text: 'Nuevo',
            editor: editor,
            formButtons: [
                { text: 'Cancelar', className:'bg-dark-blue', action: function () { this.close(); } },
                'Crear'
            ]
            },{
                extend: 'edit',
                text: 'Editar',
                editor: editor,
                formButtons: [
                { text: 'Cancelar', className:'bg-dark-blue', action: function () { this.close(); } },
                'Actualizar'
            ]
            },{
                extend: 'remove',
                text: 'Eliminar',
                editor: editor,
                formButtons: [
                { text: 'Cancelar', className:'bg-dark-blue', action: function () { this.close(); } },
                'Eliminar'
            ]
            }
        ];

        if(options == 2){
            buttons.splice(0,1);
        }
        if(options == 1){
            buttons.splice(0,1);
            buttons.splice(2,1);
        }
    
    return buttons;
  }

  function editor_export() { //options = 3-create/edit/delete 2-edit/delete 1-edit
    var buttons = [
        {
            extend: 'excel',
            title: 'SGPI SSM',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdf',
            title: 'SGPI SSM',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'print',
            title: 'SGPI SSM',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pageLength',
        }
    ];

    return buttons;
}

  function editor_columns(column3) {
    var column = [{
        data: null,
        defaultContent: '',
        className: 'select-checkbox',
        orderable: false,
    },{
        data: 'nombre',
    },{
        data: column3,
    }, {
        data: 'inicio',
    },{
        data: 'final',
    },{
        data: 'estado',
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
    },{
        data: null,
        defaultContent: '<i class="fa fa-plus"/>',
        className: 'row-add dt-center',
        orderable: false
    },{
        data: null,
        defaultContent: '',
        className: 'dt-control dt-center',
        orderable: false
    }];
        if(column3 == 'id_user'){
        column.splice(6,1);
        }
    return column;
  }

  function editor_columnSimple(column6) {
    var column = [{
        data: null,
        defaultContent: '',
        className: 'select-checkbox',
        orderable: false
        },
        {
            data: "nombre"
        },
        {
            data: "inicio"
        },
        {
            data: "final"
        },
        {
            data: "estado",
            className: "dt-center",
            orderable: false,
            render: function (val, type, row) {
                if (val == 'En curso') {
                    return '<span class="badge"><i class="fa fa-clock-o text-warning"></i></span>';
                }else{
                    return '<span class="badge"><i class="fa fa-check text-success"></i></span>';
                }
            }
        },
        {
            className: "dt-control dt-center",
            orderable: false,
            data: null,
            defaultContent: ""
        },
    ];
        if(column6 == 'NA'){
        column.splice(5,1);
        }
    return column;
  }

  function editor_columnsDefs(num) {
    var column = [
        {targets: [0], className: "px-0 pointer", width: "1%"},
        {targets: [1], className: "td-short"},
        {targets: [2], className: "td-short"},
        {targets: [3], width: "1%"},
        {targets: [4], width: "1%"},
        {targets: [5], width: "1%"},
        {targets: [6], className: "px-0 pointer", width: "1%"},
        {targets: [7], className: "px-0 pointer", width: "1%"},
        ];
        if(num == 6){
        column.splice(7,1);
        }
    return column;
  }

  function editor_columnsDefSimple(num) {
    var column = [
        {targets: [0], className: "px-0 pointer", width: "1%"},
        {targets: [1], className: "td-short"},
        {targets: [2], width: "1%"},
        {targets: [3], width: "1%"},
        {targets: [4], width: "1%", className: "px-0"},
        {targets: [5], className: "px-0 pointer", width: "1%"},
        ];
        if(num == 5){
        column.splice(5,1);
        }
    return column;
  }

 function editor_filterCol(column, num, col1, col2) {
    var text = "Filtrar";
    if(num == 'one'){
        if((column.slice(0, 1).shift()) == col2){
            var element = "custom-select-white bg-secondary-fade form-control form-control-sm";
        }else{
            var element = "custom-select-white bg-secondary-fade form-control form-control-sm invisible";
        }
    }else if(num == 'two'){
        if((column.slice(0, 1).shift()) == col1 || (column.slice(0, 1).shift()) == col2){
            var element = "custom-select-white bg-secondary-fade form-control form-control-sm";
            (column.slice(0, 1).shift()) == col1 ? element+= " select-areas" : element+='';
        }else{
            var element = "custom-select-white bg-secondary-fade form-control form-control-sm invisible";
        }
        (column.slice(0, 1).shift()) != col2 ? text = "Filtrar columna" : text = "Filtrar";
    }
    
    var select = $('<select class="'+element+'"><option value="">'+text+'</option></select>')
        .appendTo($(column.footer()).empty())
        .on('change', function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            column.search(val ? '^' + val + '$' : '', true, false).draw();
        });

    $(".select-areas").select2({});
    $(".select2-selection__rendered").addClass('bg-secondary-fade font-weight-450 rounded');
    $('.select2-container--default .select2-selection--single .select2-selection__arrow b').addClass('b-color-white');
    
    column.data().unique().sort()
        .each(function (d, j) {
            select.append('<option value="' + d + '">' + d + '</option>');
        });
 }  