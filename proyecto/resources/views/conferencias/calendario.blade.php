@extends('layouts.plantilla')
@section('title','Calendario')
@section ('content')
<meta charset='utf-8' />
  <link rel="stylesheet" type="text/css" href="{{ url('/css/calendar/main.css') }}" />
  <script>
    $(document).ready(function(){
      var initialLocaleCode = 'es';
      var localeSelectorEl = document.getElementById('locale-selector');
      var calendarEl = document.getElementById('calendar');
      var array_confe = @json($vc, JSON_PRETTY_PRINT);
      console.log(array_confe[0]);

      var calendar = new FullCalendar.Calendar(calendarEl, {
        width: '100%',
        themeSystem: 'bootstrap',
        headerToolbar: {
          left: 'prevYear,prev,next,nextYear today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
        locale: initialLocaleCode,
        buttonIcons: false,
        weekNumbers: true,
        navLinks: true,
        editable: false,
        selectable: true,
        selectMirror: true,
        select: function(arg) {
          var check = moment(arg.start).format('YYYY-MM-DD');
          var today = moment(new Date()).format('YYYY-MM-DD');

        if(check >= today){
          document.getElementById("ini").value = check+"T12:00";
          document.getElementById("fin").value = check+"T12:00";
          $("#calendarModal").modal("show");

        }else if(check < today){
          $('#alerta').fadeIn('slow').delay(4500).hide(0);
        }
        calendar.unselect()
      },
      eventClick: function(arg) {
        
      },
        dayMaxEvents: true,
        events: array_confe
      });
      calendar.render();
    });

  </script>
  <style>

    body {
      margin: 0;
      padding: 0;
      font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
      font-size: 14px;
    }

    #top {
      background: #eee;
      border-bottom: 1px solid #ddd;
      padding: 0 10px;
      line-height: 40px;
      font-size: 12px;
    }

    #calendar {
      padding: 0 10px;
    }

    .fc-col-header, .fc-daygrid-body, .fc-scrollgrid-sync-table {
      width: 100%!important;
    }

    label, .form-label{
      margin-bottom: 2px!important;
    }

  </style>

  <div class="container-fluid card p-4 ">
    <p id="text-nota" class="text-{{$bg->customcolor}} d-none text-sm">Para solicitar una nueva videoconferencia da click en el calendario o <b class="pointer" onclick="$('#calendarModal').modal('show');">aquí</b>. A continuación solo serán visibles las conferencias agendadas, para ver las demás conferencias ve a <b>Mis conferencias</b>.</p>
    <button id="new" class="btn btn-{{$bg->customcolor}} btn-sm float-right my-3 d-none" onclick="$('#calendarModal').modal('show');">Crear videoconferencia</button>
    <div class="fc fc-media-screen fc-direction-ltr fc-theme-bootstrap5 table-responsive" id='calendar'>
      <input type="text" class="d-none" id="color" value="{{$bg->customcolor}}">
    </div>
  </div>

  <div class="modal fade" id="calendarModal"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="dialog">
      <div class="modal-content">
        <div class="modal-header {{$bg->custombackground}}">
          <h5 class="modal-title text-md text-white">Nueva videoconferencia</h5>
          <button type="button" onclick="$('#calendarModal').modal('hide');" class="close" data-dismiss="modal" aria-label="Close" > 
            <span aria-hidden="true" >&times;</span>
          </button>
        </div>
        {!! Form::open(array('route' => array('archivos.store'),'method'=>'post','class'=>'container', 'id'=>'formi')) !!}
        @csrf
        <div id="modalBody" class="modal-body">
          <div class="container-fluid">
            <nav class="mb-3">
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
               <a class="nav-item nav-link active" id="nav-uno-tab" data-toggle="tab" href="#nav-uno" role="tab" aria-controls="nav-uno" aria-selected="true" style="pointer-events: none;">Solicitante</a>
               <a class="nav-item nav-link" id="nav-dos-tab" data-toggle="tab" href="#nav-dos" role="tab" aria-controls="nav-dos" aria-selected="false" style="pointer-events: none;">Detalles conferencia</a>
             </div>
           </nav>
           <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-uno" role="tabpanel" aria-labelledby="nav-uno-tab">
              <div class="form-row">
                <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                  {!! Form::label('','Nombre') !!}
                  {!! Form::text('nombre',Auth::user()->nombreCompleto,array('class' => 'form-control form-gray px-2', 'placeholder'=>'Nombre completo', 'required'))!!}
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                 {!! Form::label('','Cargo') !!}
                 <select class="form-control form-gray pointer custom-select" id="cargo" name="cargo" required>
                  <option value="">Seleccionar</option>
                  <option value="Director">Director</option>
                  <option value="Subdirector">Subdirector</option>
                  <option value="Jefe de departamento">Jefe de departamento</option>
                  <option value="Apoyo administrativo">Apoyo administrativo</option>
                  <option value="Coordinador">Coordinador</option>
                  <option value="Encargado">Encargado</option>
                </select>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
               {!! Form::label('','Dirección') !!}
               {{ Form::select('direccion', $cat_dir, '', ['class' => 'form-control form-gray','id'=>'cat_dir','placeholder'=>'Seleccione una dirección','required'])}}
             </div>
             <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
               {!! Form::label('','Subdirección') !!} <span class="text-xs text-muted">(Primero seleccione una dirección)</span>
               {{ Form::select('subdireccion', $cat_sub, '', ['class' => 'form-control form-gray','id'=>'cat_sub','placeholder'=>'Seleccione una subdirección','disabled'])}}
             </div>
             <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
               {!! Form::label('','Departamento') !!} <span class="text-xs text-muted">(Primero seleccione una subdirección)</span>
               {{ Form::select('departamento', $cat_dep, '', ['class' => 'form-control form-gray','id'=>'cat_dep','placeholder'=>'Seleccione un departamento','disabled'])}}
             </div>
             <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
               {!! Form::label('','E-mail') !!}
               {!! Form::email('email',Auth::user()->email,array('class' => 'form-control form-gray px-2', 'placeholder'=>'Ingrese su correo electrónico', 'required'))!!}
             </div>
             <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
               {!! Form::label('','Teléfono extensión') !!}
               {!! Form::text('telefono',Auth::user()->telefono,array('class' => 'form-control form-gray px-2', 'placeholder'=>'Extensión IP', 'required', 'pattern' => '[0-9]{4,10}', 'title'=> 'Ingrese mínimo una extensión a cuatro dígitos'))!!}
             </div>
             <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
               {!! Form::label('','Celular') !!}
               {!! Form::text('celular','',array('class' => 'form-control form-gray px-2', 'placeholder'=>'Ingrese un número de celular', 'required','pattern' => '[0-9]{10}', 'title'=> 'Ingrese mínimo 10 dígitos'))!!}
             </div>
           </div>
         </div>
         <div class="tab-pane fade" id="nav-dos" role="tabpanel" aria-labelledby="nav-dos-tab">
          <div class="form-row">
            <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
             {!! Form::label('','Fecha y hora inicio') !!}
             {{ Form::input('dateTime-local', 'ini', '', ['id' => 'ini', 'class' => 'form-control form-gray px-2', 'required']) }}
           </div>
           <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
             {!! Form::label('','Fecha y hora fin') !!}
             {{ Form::input('dateTime-local', 'fin', '', ['id' => 'fin', 'class' => 'form-control form-gray px-2', 'required']) }}
           </div>
           <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
             {!! Form::label('','No. participantes') !!}
             {!! Form::number('participantes','',array('class' => 'form-control form-gray px-2', 'placeholder'=>'Ingrese el número', 'required'))!!}
           </div>
           <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
             {!! Form::label('','Nombre del evento') !!}
             {!! Form::text('evento','',array('class' => 'form-control form-gray px-2', 'placeholder'=>'Nombre del evento', 'required'))!!}
           </div>
           <div class="col-lg-8 col-md-8 col-sm-12 mt-3">
            {!! Form::label('','Programa (en caso de aplicar)') !!}
            {!! Form::text('programa','',array('class' => 'form-control form-gray px-2', 'placeholder'=>'Nombre del programa'))!!}
          </div>
           <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
             {!! Form::label('','Tipo evento') !!}
             <select class="form-control form-gray pointer" id="tipo" name="tipo" required>
              <option value="">Seleccionar</option>
              <option value="Capacitación">Capacitación</option>
              <option value="Administrativo">Administrativo</option>
            </select>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
           {!! Form::label('','Sede emisora') !!}
           {{ Form::select('sede', $cat_sed, '', ['class' => 'form-control form-gray','id'=>'cat_sed','placeholder'=>'Seleccione una sede','required'])}}
         </div>
         <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
           {!! Form::label('','Lugar de emisión') !!}
           {!! Form::text('emision','',array('class' => 'form-control form-gray px-2', 'placeholder'=>'Ingrese un lugar', 'required'))!!}
         </div>
         <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
           {!! Form::label('','Sedes participantes') !!}
           {{ Form::select('receptores[]', $cat_sed, '', ['class' => 'form-control form-gray px-2','id'=>'cat_rec','required','multiple' =>'multiple'])}}
         </div>
         <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
           {!! Form::label('','Comentarios') !!}
           {!! Form::textarea('comentarios','',array('class' => 'form-control form-gray px-2', 'placeholder'=>'Ingrese comentarios a la solicitud', 'required', 'rows'=>'2'))!!}

           <div class="form-check form-switch ps-0 is-filled mt-2 ml-1">
            <input class="form-check-input ms-auto" type="checkbox" id="grabar" name="grabar">
            <label class="form-check-label text-{{$bg->customcolor}} ms-3 text-truncate w-80 mb-0 noactive" for="flexSwitchCheckDefault">Grabar videoconferencia (No)</label>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div id="alert" class="alert alert-danger-opacity text-sm my-1 mx-4" role="alert">
    Las horas de solicitud en la fechas no pueden ser iguales.
  </div>
  <div id="alert2" class="row justify-content-center mt-4">
    <div class="col-1">
      <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <span class="text-xs text-center text-primary">Cargando...</span>
  </div>
  <br>

  <div class="modal-footer text-center mt-2">
    <button type="button" class="btn btn-outline-dark btn-rounded" data-dismiss="modal" onclick="$('#calendarModal').modal('hide')">Cerrar</button>
    <button id="sig" type="submit" class="btn btn-{{$bg->customcolor}} btn-rounded">Siguiente</button>
    <button id="sol" type="submit" class="btn btn-{{$bg->customcolor}} btn-rounded">Solicitar</button>
  </div>
  {!! Form::close() !!}
  </div>
  </div>
  </div>
</div>
  <div id="alerta" class="position-fixed top-5 end-2 alert alert-primary-opacity alert-dismissible fade show" role="alert" style="display: none;"><a class="text-white text-sm" href="#"><i class="material-icons text-white text-sm scale px-1">event_busy</i> No se pueden crear eventos en fechas anteriores al día de hoy</a>
   <button type="button" class="close pt-2" data-dismiss="alert" aria-label="Close">
     <span aria-hidden="true">×</span>
   </button>
  </div>
  {{--  <script type="text/javascript" src="{{ URL::asset('js/table.js') }}"></script>  --}}
  <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('js/calendar/main.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('js/calendar/locales-all.js') }}"></script>

  <script type="text/javascript">
    $(document).ready(function() {
    var clase = '{{ $bg->customcolor }}';
    const boxes = document.querySelectorAll('.fc-header-toolbar .btn');
        for (const box of boxes) {
        box.classList.replace('btn-primary', 'btn-'+clase);
        }
      $('#alert').hide();
      $('#alert2').hide();
      $('#sol').hide();
      var today = moment(new Date()).format('YYYY-MM-DD');
      document.getElementById("ini").value = "";
      document.getElementById("fin").value = "";

      if ($(window).width() < 700) {
        $('.fc-listMonth-button').click();
        $("#new").removeClass('d-none');
        $('.fc-prevYear-button').addClass('d-none');
        $('.fc-nextYear-button').addClass('d-none');
        $('.fc-dayGridMonth-button').addClass('d-none');
        $('.fc-timeGridWeek-button').addClass('d-none');
        $('.fc-timeGridDay-button').addClass('d-none');
        $('.fc-listMonth-button').addClass('d-none');
        $(".fc-prev-button").css({"border-radius": "10px","margin-right": "5px"});
        $(".fc-next-button").css({"border-radius": "10px"});
      }else{
        $("#text-nota").removeClass('d-none');
      }

      $(".btn-group").on('click',function(event){
        var clase = '{{ $bg->customcolor }}';
        const boxes = document.querySelectorAll('.fc-header-toolbar .btn');
            for (const box of boxes) {
            box.classList.replace('btn-primary', 'btn-'+clase);
            }
      });
    });

    

    @if (session('ok'))
    setTimeout(() => {
     $("#successToast").toast("show");
   }, 200);
    @endif
    @if (session('nook'))
    setTimeout(() => {
     $("#dangerToast").toast("show");
   }, 200);
    @endif

    $("#cat_dir").select2({});
    $("#cat_sub").select2({});
    $("#cat_dep").select2({});
    $("#cat_sed").select2({});
    $("#cat_rec").select2({});
    
    $("input[name='grabar']").click(function() {
      $('.form-check-label').text('Grabar videoconferencia (No)');
      if(this.checked){
       $(this).next().text('Grabar videoconferencia (Si)');
      }
    });
    
    $("#cat_dir").on('change',function(){ 
     cargar_sub(this.value);
     $("#cat_sub").prop("disabled", false);
   });

    $("#cat_sub").on('change',function(){ 
     cargar_dep(this.value);
     $("#cat_dep").prop("disabled", false);
   });

    function cargar_sub(dir){
      $.ajax({
        url: '/SOS/detalles/subdireccion',
        method:'POST',
        dataType: "json",
        data: {
          "_token": $("meta[name='csrf-token']").attr("content"),
          "dir":dir
        },
        async: false,
        success: function (respuesta) {                         
          $("#cat_sub").html("");
          $("#cat_sub").select2({ data: respuesta, theme: 'bootstrap4', width: '100%' });
        },
      });
    }
    function cargar_dep(sub){
      $.ajax({
        url: '/SOS/detalles/departamento',
        method:'POST',
        dataType: "json",
        data: {
          "_token": $("meta[name='csrf-token']").attr("content"),
          "sub":sub
        },
        async: false,
        success: function (respuesta) {                         
          $("#cat_dep").html("");
          $("#cat_dep").select2({ data: respuesta, theme: 'bootstrap4', width: '100%' });
        },
      });
    }

    $('#sig').on('click',function(event){
      var il =/^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/
      if($('input[name=celular]').val().length >= 10 && $('input[name=telefono]').val().length >= 4 && $('input[name=email]').val()!='' && il.exec($('input[name=email]').val()) && $('input[name=nombre]').val()!='' && $('#cargo').val() !== null && $('#cargo').val() !== ''){
        $('#nav-dos-tab').css({"pointer-events": "auto"});
        $('#nav-dos-tab').trigger('click');
        $('#sig').hide();
        $('#sol').show();
      }
    });

    $('#sol').on('click',function(event){
      console.log($('input[name=ini]').val());
      if($('input[name=ini]').val() == $('input[name=fin]').val()){
        $('#sol').attr('type', 'button');
        $('#alert').fadeIn('slow').delay(3500).hide(0);
      }else{
        $('#sol').attr('type', 'submit');
      }
      if($('input[name=participantes]').val().length >= 1 && $('input[name=evento]').val()!='' && $('input[name=email]').val()!='' && $('input[name=nombre]').val()!='' && $('#cargo').val() !== null && $('#tipo').val() !== null && $('#tipo').val() !== '' && $('#sede').val()!== null && $('#sede').val() !== '' && $('input[name=emision]').val()!='' && $('#cat_rec').val()!='' && $('#cat_rec').val()!== null && $('textarea[name=comentarios]').val()!='' && $('input[name=ini]').val() !== $('input[name=fin]').val()){
        $('#sol').prop('disabled', true);
        $('#alert2').show();
        $('#formi').submit();
      }

    });

  </script>
@endsection
