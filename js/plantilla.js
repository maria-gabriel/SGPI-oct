  $(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
      $('#sidebar, #content').toggleClass('active');
    });

    if($(window).width() < 700) {
      $('.embed-responsive').css({"height": "100%"});
      $(".modal-content").css({"height": "90vh"});
    }

    $(document).on('click', 'a.tour', function(){
        var enjoyhint_instance = new EnjoyHint({});
           enjoyhint_instance.set([
           {'next .header': 'Herramientas rápidas [Accesos, Notas, Pantalla completa, Configuración...]'},
           {'next .navigation-menu-tab': 'Menú lateral de navegación [Proyectos, SOS, Soporte técico, Videoconferencias...]'},
           {'next .navigation-menu-body': 'Barra de opciones dependiendo del menú lateral que se seleccione.'},
           {'next .navigation-toggler': 'Oculta la barra de opciónes, el menú lateral o vuelve a mostrarlos.'},
           {'next .navi-user': 'Configura tu perfil (datos personales y de trabajo) o cierra tu sesión.'},
           {'next .tour': 'Cuando tengas dudas presiona los íconos de interrogación ？que aparecerán en la mayoría de las vistas.'}]);
           enjoyhint_instance.run();
           return false;
        });


    //READY CONFIG MENU -------------------------------
    var config1 = localStorage.getItem('title-response');
    var config2 = localStorage.getItem('date-response');
    var config3 = localStorage.getItem('icons-response');
    var config4 = localStorage.getItem('text-response');
    
    if(config1 == 'ok'){
    $(".page-header").show();
    $("#customSwitch1").prop("checked",true);
    }else if(config1 == 'nook'){
    $(".page-header").hide();
    $("#customSwitch1").prop("checked",false);
    }else if(config1 == null){
    config1 = localStorage.setItem('title-response','');
    }
    if(config2 == 'ok'){
    $(".today-header").show();
    $("#customSwitch2").prop("checked",true);
    }else if(config2 == 'nook'){
    $(".today-header").hide();
    $("#customSwitch2").prop("checked",false);
    }else if(config2 == null){
    config2 = localStorage.setItem('date-response','');
    }
    if(config3 == 'ok'){
    $(".icon-header").show();
    $("#customSwitch3").prop("checked",true);
    }else if(config3 == 'nook'){
    $(".icon-header").hide();
    $("#customSwitch3").prop("checked",false);
    }else if(config3 == null){
    config3 = localStorage.setItem('icons-response','');
    }
    if(config4 == 'ok'){
    $("body").addClass("body-font-lg");
    $("#customSwitch4").prop("checked",true);
    }else if(config4 == 'nook'){
    $("body").removeClass("body-font-lg");
    $("#customSwitch4").prop("checked",false);
    }else if(config4 == null){
    config4 = localStorage.setItem('text-response','');
    }
  });

  function getDuracion(ini, fin, est, opc) {
      var aFecha0 = new Date().toJSON().slice(0,10).replace(/-/g,'/').split('/');
      var aFecha1 = ini.split('-');
      var aFecha2 =fin.split('-');
      var fFecha0 = Date.UTC(aFecha0[0],aFecha0[1]-1,aFecha0[2]);
      var fFecha1 = Date.UTC(aFecha1[0],aFecha1[1]-1,aFecha1[2]);
      var fFecha2 = Date.UTC(aFecha2[0],aFecha2[1]-1,aFecha2[2]);
      var dif = fFecha2 - fFecha1;
      var dif2 = fFecha0 - fFecha2;
      var dif3 = fFecha2 - fFecha0;
      if(opc == 1){
         return Math.floor(dif / (1000 * 60 * 60 * 24));
      }else if(opc == 2){
         return est != 'Finalizado' ? Math.floor(dif2 / (1000 * 60 * 60 * 24)) : 0;
      }else{
         return Math.floor(dif3 / (1000 * 60 * 60 * 24));
      }
  }

  function openiframe(titulo,marca){
    $('#modaltitulo').text(titulo);
    $('#iframemarca').attr("src",marca);
    $('#modaliframe').modal('show');
  }

  function openiframe2(titulo,marca){
    $('#modaltitulo2').text(titulo);
    $('#iframemarca2').attr("src",marca);
    $('#modaliframe2').modal('show');
  }

  function openiframe3(titulo,marca){
    $('#modaltitulo3').text(titulo);
    $('#iframemarca3').attr("src",marca);
    $('#modaliframe3').modal('show');
  }

  //DATATABLES EDITOR -------------------------------------------------------------------------------------
  

  var lenguaje = {
      "lengthMenu": "Registros por página",
      "zeroRecords": "Sin registros ",
      "info": "Página  _PAGE_ de _PAGES_",
      "infoEmpty": "Sin registros",
      "infoFiltered": "(Filtrado de _MAX_ registros)",
      'search':'Buscar ',
      paginate:{
        'next':'Siguiente',
        'previous':'Anterior'
      },
      
      select: {
          "rows": {
            "1": "1 fila seleccionada",
            "_": "%d filas seleccionadas"
        },
    },
    buttons: {
        "pageLength": {
           "-1": "Todas las filas",
           "_": "Mostrar %d filas"
      },
      "colvis": "Columnas",
    },
        thousands: ".",
        datetime: {
          "previous": "Anterior",
          "next": "Siguiente",
          "hours": "Horas",
          "minutes": "Minutos",
          "seconds": "Segundos",
          "unknown": "-",
          "amPm": [
          "AM",
          "PM"
          ],
          months: {
            "0": "Enero",
            "1": "Febrero",
            "10": "Noviembre",
            "11": "Diciembre",
            "2": "Marzo",
            "3": "Abril",
            "4": "Mayo",
            "5": "Junio",
            "6": "Julio",
            "7": "Agosto",
            "8": "Septiembre",
            "9": "Octubre"
        },
        weekdays: [
        "Dom",
        "Lun",
        "Mar",
        "Mie",
        "Jue",
        "Vie",
        "Sab"
        ]
      },
          editor: {
              "close": "Cerrar",
              "create": {
                "button": "Nuevo",
                "title": "Crear nuevo",
                "submit": "Crear"
            },
            edit: {
                "button": "Editar",
                "title": "Editar fila",
                "submit": "Actualizar"
            },
            remove: {
                "button": "Eliminar",
                "title": "Eliminar fila",
                "submit": "Eliminar",
                "confirm": {
                  "_": "¿Está seguro que desea eliminar %d filas?",
                  "1": "¿Está seguro que desea eliminar 1 fila?"
              }
          },
          error: {
            "system": "Ha ocurrido un error en el sistema."
          },
          multi: {
            "title": "Múltiples Valores",
            "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
            "restore": "Deshacer Cambios",
            "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
          }
      },
  }

  var lengthmenu = [[ 10, 25, 50, -1 ],[ '10 filas', '25 filas', '50 filas', 'Todas' ]];
  
$(".select-checkbox, .row-add, .row-view").addClass("pointer");


//FUNCTIONS TASK MENU ---------------------------------------------------------------------------------------------

function taskmenubtn() {
    $("#taskmenu").click();
 }
 let noteurl = '/SGPI/crud/notas';
 function finalizeTasks() {
    var incomplete=document.querySelectorAll("#incomplete-tasks li");
    var incompleteInput=document.querySelectorAll("#incomplete-tasks li input[type=checkbox]");
    var incompleteEdit=document.querySelectorAll("#incomplete-tasks li .check-edit");
    var completedList=document.getElementById("completed-tasks");
    for (var i=0; i<incomplete.length; i++) {
       console.log(incompleteInput[i]);
       completedList.appendChild(incomplete[i]);
       incompleteInput[i].checked = true;
       incompleteEdit[i].classList.add("disabled");
     }

     $("#non-pen").removeClass("d-none").addClass("d-block");
     $("#non-fin").removeClass("d-block").addClass("d-none");
    
   $.ajax({
       url: noteurl,
       method:'POST',
       dataType: "json",
       data: {
         "_token": $("meta[name='csrf-token']").attr("content"),
         "index": "finalize"
       },
       async: false,
       success: function (respuesta) { 
          
       },
     });
 }

 function removeTasks() {
    var complete=document.querySelectorAll("#completed-tasks li");
    var completedList=document.getElementById("completed-tasks");
    for (var i=0; i<complete.length; i++) {
       completedList.removeChild(complete[i]);
     }
     $("#non-fin").removeClass("d-none").addClass("d-block");

     $.ajax({
       url: noteurl,
       method:'POST',
       dataType: "json",
       data: {
         "_token": $("meta[name='csrf-token']").attr("content"),
         "index": "reset"
       },
       async: false,
       success: function (respuesta) { 
          
       },
     });
 }

 document.getElementById("taskmenu").addEventListener('click', function (event) {
 event.stopPropagation();
 var taskInput=document.getElementById("new-task")
 var addButton=document.getElementById("add-task");
 var incompleteTaskHolder=document.getElementById("incomplete-tasks");
 var completedTasksHolder=document.getElementById("completed-tasks");
 var incompleteTaskCount=$("#incomplete-tasks li").length;
 var completedTasksCount=$("#completed-tasks li").length;

 var createNewTaskElement=function(taskString){
    var listItem=document.createElement("li");
    var checkBox=document.createElement("input");
    var label=document.createElement("label");
    var editInput=document.createElement("input");
    var editButton=document.createElement("button");
    var deleteButton=document.createElement("button");

    label.innerText=taskString;
    checkBox.type="checkbox";
    editInput.type="text";
    editInput.className="form-control bg-gray";

    editButton.innerHTML='<i class="fa fa-pencil"></i>';
    editButton.className="check-edit btn btn-link text-{{$bg->customcolor}} btn-sm m-1";
    deleteButton.innerHTML='<i class="fa fa-times"></i>';
    deleteButton.className="check-delete btn btn-link text-danger btn-sm m-1";

    listItem.appendChild(checkBox);
    listItem.appendChild(label);
    listItem.appendChild(editInput);
    listItem.appendChild(editButton);
    listItem.appendChild(deleteButton);

    $.ajax({
       url: noteurl,
       method:'POST',
       dataType: "json",
       data: {
         "_token": $("meta[name='csrf-token']").attr("content"),
         "nombre":taskString,
         "index": "save"
       },
       async: false,
       success: function (respuesta) { 
          console.log(respuesta['data'][0].id);
          listItem.id = respuesta['data'][0].id;
       },
     });
    return listItem;
 }

 var addTask=function(){
    var listItem=createNewTaskElement(taskInput.value);
    incompleteTaskHolder.appendChild(listItem);
    bindTaskEvents(listItem, taskCompleted);
    taskInput.value="";
    $("#non-pen").removeClass("d-block").addClass("d-none");
    $(".nav-link-nota").addClass("nav-link-notify");
 }

 var editTask = function() {
    var listItem=this.parentNode;
    var editInput=listItem.querySelector('input[type=text]');
    var label=listItem.querySelector("label");
    var btn=listItem.querySelector("button");
    var containsClass=listItem.classList.contains("editMode");

    if(containsClass){
       label.innerText=editInput.value;
       btn.innerHTML='<i class="fa fa-pencil"></i>';
       $.ajax({
          url: noteurl,
          method:'POST',
          dataType: "json",
          data: {
            "_token": $("meta[name='csrf-token']").attr("content"),
            "id":this.parentNode.id,
            "nombre":editInput.value,
            "index": "update"
          },
          async: false,
          success: function (respuesta) { 
             
          },
        });
    }else{
       editInput.value=label.innerText;
       btn.innerHTML='<i class="fa fa-check"></i>';
    }
    
    listItem.classList.toggle("editMode");
 }

 var deleteTask = function() {
    var listItem=this.parentNode;
    var ul=listItem.parentNode;
    ul.removeChild(listItem);

    if($("#completed-tasks li").length == 0){
       $("#non-fin").removeClass("d-none").addClass("d-block");
    }else{
       $("#non-fin").removeClass("d-block").addClass("d-none");
    }
    if($("#incomplete-tasks li").length == 0){
       $(".nav-link-nota").removeClass("nav-link-notify");
       $("#non-pen").removeClass("d-none").addClass("d-block");
    }else{
       $("#non-pen").removeClass("d-block").addClass("d-none");
    }

    $.ajax({
       url: noteurl,
       method:'POST',
       dataType: "json",
       data: {
         "_token": $("meta[name='csrf-token']").attr("content"),
         "id":this.parentNode.id,
         "index": "remove"
       },
       async: false,
       success: function (respuesta) { 
          
       },
     });
 }

 var taskCompleted=function(){
    var listItem=this.parentNode;
    completedTasksHolder.appendChild(listItem);
    var btn=listItem.querySelector("button");
    var containsClass=listItem.classList.contains("editMode");
    btn.disabled = true;
    btn.classList.add("disabled");
    if(containsClass){
       btn.innerHTML='<i class="fa fa-pencil"></i>';
       listItem.classList.toggle("editMode");
    }

    if($("#incomplete-tasks li").length == 0){
       $("#non-pen").removeClass("d-none").addClass("d-block");
    }else{
       $("#non-pen").removeClass("d-block").addClass("d-none");
    }
    if($("#completed-tasks li").length == 0){
       $("#non-fin").removeClass("d-none").addClass("d-block");
    }else{
       $("#non-fin").removeClass("d-block").addClass("d-none");
    }

    $.ajax({
       url: noteurl,
       method:'POST',
       dataType: "json",
       data: {
         "_token": $("meta[name='csrf-token']").attr("content"),
         "id":this.parentNode.id,
         "index": "active"
       },
       async: false,
       success: function (respuesta) { 
          
       },
     });
    
    bindTaskEvents(listItem, taskIncomplete);
 }

 var taskIncomplete=function(){
    var listItem=this.parentNode;
    var containsClass=listItem.querySelector("button");
    containsClass.disabled = false;
    containsClass.classList.remove("disabled");
    incompleteTaskHolder.appendChild(listItem);

    if($("#incomplete-tasks li").length == 0){
       $("#non-pen").removeClass("d-none").addClass("d-block");
    }else{
       $("#non-pen").removeClass("d-block").addClass("d-none");
    }
    if($("#completed-tasks li").length == 0){
       $("#non-fin").removeClass("d-none").addClass("d-block");
    }else{
       $("#non-fin").removeClass("d-block").addClass("d-none");
    }

    $.ajax({
       url: noteurl,
       method:'POST',
       dataType: "json",
       data: {
         "_token": $("meta[name='csrf-token']").attr("content"),
         "id":this.parentNode.id,
         "index": "inactive"
       },
       async: false,
       success: function (respuesta) { 
          
       },
     });
    bindTaskEvents(listItem,taskCompleted);
 }

 var ajaxRequest=function(){
    console.log("AJAX Request");
 }

 addButton.onclick=addTask;
 addButton.addEventListener("click",ajaxRequest);

 var bindTaskEvents=function(taskListItem,checkBoxEventHandler){
    var checkBox=taskListItem.querySelector("input[type=checkbox]");
    var editButton=taskListItem.querySelector("button.check-edit");
    var deleteButton=taskListItem.querySelector("button.check-delete");
    editButton.onclick = editTask;
    deleteButton.onclick = deleteTask;
    checkBox.onchange=checkBoxEventHandler;
 }

 for (var i=0; i<incompleteTaskHolder.children.length;i++){
    bindTaskEvents(incompleteTaskHolder.children[i],taskCompleted);
 }

 for (var i=0; i<completedTasksHolder.children.length;i++){
    bindTaskEvents(completedTasksHolder.children[i],taskIncomplete);
 }

});



//FUNCTIONS CONFIG MENU --------------------------------------------------------------------------------------------

$(".config-title").click(function() {
    $(".page-header").toggle();
     if($("#customSwitch1").is(':checked')) {  
        localStorage.setItem('title-response','nook');
     } else {  
        localStorage.setItem('title-response','ok'); 
     } 
    });
    $(".config-date").click(function() {
    $(".today-header").toggle();
    if($("#customSwitch2").is(':checked')) {  
     localStorage.setItem('date-response','nook');
  } else {  
     localStorage.setItem('date-response','ok'); 
  } 
    });
    $(".config-icons").click(function() {
    $(".icon-header").toggle();
    if($("#customSwitch3").is(':checked')) {
     localStorage.setItem('icons-response','nook');
  } else {  
     localStorage.setItem('icons-response','ok'); 
  } 
    });
    $(".config-text").click(function() {
    $("body").toggleClass('body-font-lg');
    if($("#customSwitch4").is(':checked')) {  
     localStorage.setItem('text-response','nook');
  } else {  
     localStorage.setItem('text-response','ok'); 
  } 
    });