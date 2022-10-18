@extends('layouts.modal')

@section('content')
<br><br>
<div class="container">
    <br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>
                @if(!empty($errorlog))
                        <div class="alert alert-danger" role="alert"> {{ $errorlog }}</div>
                @endif
                <div class="card-body">
                    <form method="POST" action="{{route('admins.cuenta',$admin)}}">
                        @csrf
                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">Nombre de usuario</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" required autocomplete="username" autofocus >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">Tipo de usario</label>

                            <div class="col-md-6">
                                <input id="tipo_usuario" type="text" class="form-control @error('username') is-invalid @enderror" name="tipo_usuario" required autocomplete="tipo_usuario" autofocus >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">CLUES</label>

                            <div class="col-md-6">
                                {{ Form::select('clues', $clues, [''], ['class' => 'form-control','id'=>'clues','placeholder'=>'Seleccione un CLUES','required'] )}} 
                            </div>
                        </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" onclick=" window.parent.closeModal();" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">
                                    Asignar
                                </button><br><br>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
  $("#clues").select2({theme: 'bootstrap4'});                       
});
</script>	
		

@endsection