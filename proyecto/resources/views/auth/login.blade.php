@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="form-wrapper p-4 mt-4">
         <!-- logo -->
         <div id="logo">
            <img class="logo w-60" src="{{URL::asset('/image/logos/ssm_logo.png')}}" alt="image">
         </div>
             @if(!empty($errorlog))
                <div class="alert alert-danger" role="alert"> {{ $errorlog }}</div>
            @endif
         <!-- ./ logo -->
         <h5>Bienvenido</h5>
         <!-- form -->
         <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group"><input id="username" type="text" class="form-control bg-gray" name="username" value="{{ old('username') }}" required autocomplete="username" placeholder="Nombre de usuario"  autofocus></div>
            <div class="form-group"><input id="password" type="password" class="form-control bg-gray @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña"></div>
            <div class="form-group d-flex justify-content-between">
               <div class="custom-control custom-checkbox"></div>
               <a href="recover-password.html"></a>
            </div>
                @if(!empty($request))
                    <div class="alert alert-secondary" role="alert"> Registro realizado.</div>
                @endif
            <button type="submit" class="btn btn-secondary btn-block">Ingresar</button>
            <hr>
            <!-- <p class="text-muted"></p>
            <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">Registro </a> -->
         </form>
         <p class="mt-4 mb-3 text-muted text-center text-white text-sm">&copy;Servicios de Salud Morelos <?php echo date("Y");?></p>
         <!-- ./ form -->
      </div>
        
    </div>
    <div class="position-fixed bottom-4 end-1 z-index-2">
        <div class="toast fade hide p-2 bg-white" role="alert" aria-live="assertive" id="successToast" aria-atomic="true">
          <div class="toast-header border-0">
            <i class="material-icons text-success me-2">
        check
      </i>
            <span class="me-auto font-weight-bold">Registro exitoso </span>
            <i class="fas fa-times text-md ms-3 cursor-pointer" data-bs-dismiss="toast" aria-label="Close"></i>
          </div>
          <hr class="horizontal dark m-0">
          <div class="toast-body">
            El registro fue procesado correctamente.
          </div>
        </div>
        <div class="toast fade hide p-2 mt-2 bg-white" role="alert" aria-live="assertive" id="dangerToast" aria-atomic="true">
          <div class="toast-header border-0">
            <i class="material-icons text-danger me-2">
        campaign
      </i>
            <span class="me-auto text-gradient text-danger font-weight-bold">Registro fallido </span>
            <i class="fas fa-times text-md ms-3 cursor-pointer" data-bs-dismiss="toast" aria-label="Close"></i>
          </div>
          <hr class="horizontal dark m-0">
          <div class="toast-body">
             El registro no fue procesado correctamente.
          </div>
        </div>
    </div>
</div>

@endsection
