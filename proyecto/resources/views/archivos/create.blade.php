@extends('layouts.modal')

@section('content')
{!! Form::open(['route' => ['archivos.store', $documento], 'method' => 'post', 'class' => 'container', 'enctype' => 'multipart/form-data']) !!}
<br>
<div class="container">
    <div class="row justify-content-center">
        @csrf
        <div class="col-10 mt-2">
            {!! Form::label('', 'Nombre') !!}
            {!! Form::text('nombre', $documento->nombre, ['class' => 'form-control form-gray px-2','placeholder' => 'Nombre','required',]) !!}
        </div>
        <div class="col-10 mt-2">
            {!! Form::label('', 'Descripción') !!}
            {!! Form::text('descripcion', $documento->descripcion, ['class' => 'form-control form-gray px-2','placeholder' => 'Descripción','required',]) !!}
        </div>
        <div class="col-10 mt-2">
            {!! Form::label('', 'Tipo documento') !!}
            {{ Form::select('tipo', $cat_doc, $documento->cat_doc, ['class' => 'custom-select form-control form-gray', 'id' => 'cat_doc', 'placeholder' => 'Seleccione un tipo', 'required']) }}
        </div>
        <div class="col-10 input-group mt-2">
            {!! Form::label('', 'Documento') !!}
            <div class="input-group">
              <div class="custom-file">
                  <input type="file" class="custom-file-input" id="archivo" name="archivo" value="{{$documento->nombre_doc}}" required accept="image/*,.doc,.docx,.pds,.csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,text/plain,.pdf">
                  <label class="custom-file-label border-0 h-auto" id="label-dictamen" for="dictamen">{{$documento->nombre_doc ? $documento->nombre_doc : 'Seleccione un archivo'}}</label>
                </div>
            </div>
        </div>
        <br>

    </div>
    <div class="modal-footer text-center mt-2">
        <button type="button" onclick=" window.parent.closeModal();" class="btn btn-outline-dark btn-rounded"
            data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-{{ $bg->customcolor }} btn-rounded">Guardar </button>
    </div>


</div>

{!! Form::close() !!}

<script type="text/javascript">
    $('#archivo').on('change',function(){
        var fileName = $(this).val();
        $(this).next('#label-dictamen').html('Archivo seleccionado');
    });

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