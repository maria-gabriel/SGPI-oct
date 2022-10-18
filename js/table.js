let editorTab;
$(document).ready(function() {
    editorTab = $('#table').DataTable({
    "language": {
        "lengthMenu": "Registros por página _MENU_",
        "zeroRecords": "No se encontraron registros",
        "info": "Página  _PAGE_ de _PAGES_",
        "infoEmpty": "Sin registros",
        "infoFiltered": "(Filtardo de _MAX_ total registros)",
        'search':'Buscar:',
        'paginate':{
           'next':'Siguiente',
           'previous':'Anterior'
       }
     }
  });
});

