@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Nueva contraseña</div>
                 @if(!empty($actualiza))
					<div class="alert alert-success" role="alert"> {{ $actualiza }}</div>
				@elseif(!empty($errorcontra))
					<div class="alert alert-danger" role="alert"> {{ $errorcontra }}</div>
				@elseif(!empty($erroract))
					<div class="alert alert-danger" role="alert"> {{ $erroract }}</div>
				@else
					<div class="alert alert-primary" role="alert">
                  *Las actualizaciones de contraseña se realizan en el área de informática
                </div>

				@endif
                
                <div class="card-body">
                    <form method="POST" action="{{route('actua')}}">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">Usuario</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Nueva contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password2" class="col-md-4 col-form-label text-md-right">Confirmar contraseña</label>

                            <div class="col-md-6">
                                <input id="password2" type="password" class="form-control @error('password2') is-invalid @enderror" name="password2" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Actualizar contraseña
                                </button>
                               
                                

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">

         	
        </div> 	
    </div>
</div>
@endsection
