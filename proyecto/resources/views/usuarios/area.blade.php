@extends('layouts.modal')
@section ('content')

<div class="w-100" style="background-image: url({{URL::asset('/image/animations/background-simple.gif')}}); filter: hue-rotate(45deg); height: 450px; position:absolute">
</div>
{!! Form::open(array('route' => array('usuarios.update2', Auth::user()->id),'method'=>'post','class'=>'area-form mx-0 px-2 mb-0')) !!}
<div class="row m-4 text-center">
    <div class="col-12 mt-4">
        {!! Form::label('','Sede') !!}
        {{ Form::select('sede', $cat_sed, '', ['class' => 'form-control form-gray','id'=>'cat_sed','placeholder'=>'Seleccione sede perteneciente','required'])}}
    </div>
    <div class="servisalud d-none">
        <div class="col-12 mt-4">
            {!! Form::label('','Dirección') !!}
            {{ Form::select('direccion', $cat_dir, '', ['class' => 'form-control form-gray','id'=>'cat_dir','placeholder'=>'Seleccione su dirección'])}}
        </div>
        <div class="col-12 mt-2">
            {!! Form::label('','Subdirección') !!}<span class="text-xs text-danger"> (en caso de pertenecer a una)</span>
            {{ Form::select('subdireccion', $cat_sub, '', ['class' => 'form-control form-gray','id'=>'cat_sub','placeholder'=>'Seleccione su subdirección','disabled'])}}
        </div>
        <div class="col-12 mt-2">
            {!! Form::label('','Departamento') !!}<span class="text-xs text-danger"> (en caso de pertenecer a uno)</span>
            {{ Form::select('departamento', $cat_dep, '', ['class' => 'form-control form-gray','id'=>'cat_dep','placeholder'=>'Seleccione su departamento','disabled'])}}
        </div>
    </div>
</div>

<div class="text-center mt-2">
    <button type="submit"class="btn btn-{{ $bg->customcolor }} btn-rounded">Guardar </button>
</div>
<br>
{!! Form::close() !!}

 <script type="text/javascript">
    
    $('#cat_sed').on('change', function() {
        if(this.value == 301){
            $(".servisalud").removeClass('d-none');
            $("#cat_dir").prop("required", true);
        }else{
            $(".servisalud").addClass('d-none');
            $("#cat_dir").prop("required", false);
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
        url: '/SGPI/details/subdireccion',
        method:'POST',
        dataType: "json",
        data: {
          "_token": $("meta[name='csrf-token']").attr("content"),
          "dir":dir
        },
        async: false,
        success: function (respuesta) {                         
          $("#cat_sub").html("");
          $("#cat_sub").select2({ data: respuesta });
          $(".select2-selection[aria-labelledby='select2-cat_sub-container']").addClass('bg-ghost');
          $(".select2-selection[aria-labelledby='select2-cat_sub-container']").removeClass('disabled');
        },
      });
    }
    function cargar_dep(sub){
      $.ajax({
        url: '/SGPI/details/departamento',
        method:'POST',
        dataType: "json",
        data: {
          "_token": $("meta[name='csrf-token']").attr("content"),
          "sub":sub
        },
        async: false,
        success: function (respuesta) {                         
          $("#cat_dep").html("");
          $("#cat_dep").select2({ data: respuesta });
          $(".select2-selection[aria-labelledby='select2-cat_dep-container']").addClass('bg-ghost');
          $(".select2-selection[aria-labelledby='select2-cat_dep-container']").removeClass('disabled');
        },
      });
    }

    localStorage.setItem('modal-response','');
        @if(session('ok'))
        localStorage.setItem('modal-response','ok');
        window.parent.closeModal();
        @elseif(session('nook'))
        localStorage.setItem('modal-response','{{Session::get('nook')}}');
        window.parent.closeModal();
        @endif
  </script>

@endsection