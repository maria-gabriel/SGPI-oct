@extends('layouts.modal')

@section('content')
{!! Form::open(['route' => ['proyectos.store2', $proyecto], 'method' => 'post', 'class' => 'container', 'enctype' => 'multipart/form-data']) !!}
<br>
<div class="container">
    <div class="row justify-content-center">
        @csrf
        <div class="colarea col-10 mt-5 d-block invisible">
            {!! Form::label('', 'Áreas responsables') !!}
            {{ Form::select('responsables[]', $areas, $areas2, ['class' => 'custom-select form-control form-gray', 'id' => 'cat_res', 'multiple','required']) }}
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

    $(document).ready(function() {
        $(".colarea").removeClass("invisible");
    });


    localStorage.setItem('modal-response','');
        @if(session('ok'))
        localStorage.setItem('modal-response','okok');
        window.parent.closeModal();
        @elseif(session('nook'))
        localStorage.setItem('modal-response','{{Session::get('nook')}}');
        window.parent.closeModal();
        @endif
</script>
@endsection