@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mt-5">
            <div class="card">
                <div class="card-header bg-gradient-primary">{{ __('Register') }}</div>

                <div class="p-3">
                    @if(!empty($errorlog))
                    <div class="alert alert-danger" role="alert"> {{ $errorlog }}</div>
                @else
                    <div class="alert alert-secondary" role="alert">
                  *Ingrese nombre de usuario y contraseña igual que el asignado por el área de informática.
                </div>
                @endif
                </div>
                
                <div class="card-body justify-content-center">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group row justify-content-center">
                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="Nombre de usuario">
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Usuario necesario</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" placeholder="Contraseña">                     
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            
                            <div class="col-md-6 mt-4">
                                <button type="submit" class="btn btn-platzi btn-block text-white bg-gradient-primary text-capitalize">
                                   {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
    $("#cat_clues_id").select2();
});
</script>
@endsection
