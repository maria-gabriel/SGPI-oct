@extends('layouts.plantilla')
@section('title','Mi perfil')
@section ('content')
<div class="container-fluid p-4">
    <div class="row app-block">
        <div class="col-md-5 app-sidebar">
           <div class="card">
               <div class="card-body text-center">
                 <figure class="avatar avatar-lg mb-3">
                   <span class="avatar-title bg-{{$bg->customcolor}} text-white rounded-circle">{{substr(Auth::user()->username,0,1)}}</span>
                 </figure>
                  <h5 class="mb-1">{{Auth::user()->username}}</h5>
                  <p class="text-muted">{{$tipo}}</p>
                  <a class="btn btn-outline-{{$bg->customcolor}}" onclick="show_form();"><i data-feather="edit-2" class="mr-2"></i>Editar</a>
               </div>
               <hr class="m-0">
               <div class="card-body">
                 {!! Form::open(['route' => ['usuarios.update', Auth::user()->id], 'method' => 'post', 'class' => 'container']) !!}
                  <div class="row mb-2">
                     <div class="col-4 text-muted">Nombre(s):</div>
                     <div class="col-8">
                         {!! Form::text('nombre', Auth::user()->nombre, ['class' => 'form-control bg-ghost px-2', 'required', 'readonly']) !!}
                     </div>
                  </div>
                  <div class="row mb-2">
                     <div class="col-4 text-muted">Apellido paterno:</div>
                     <div class="col-8">
                         {!! Form::text('apepa', Auth::user()->apepa, ['class' => 'form-control bg-ghost px-2', 'required', 'readonly']) !!}
                     </div>
                  </div>
                  <div class="row mb-2">
                     <div class="col-4 text-muted">Apellido materno:</div>
                     <div class="col-8">
                         {!! Form::text('apema', Auth::user()->apema, ['class' => 'form-control bg-ghost px-2', 'required', 'readonly']) !!}
                     </div>
                  </div>
                  <div class="row mb-2">
                     <div class="col-4 text-muted">Género:</div>
                     <div class="col-8">
                         <select class="custom-select form-control bg-ghost pointer" id="sexo" name="sexo" disabled required>
                             <option value="0">Seleccionar</option>
                             <option value="1" {{ Auth::user()->sexo == '1' ? 'selected' : '' }}>Hombre</option>
                             <option value="2" {{ Auth::user()->sexo == '2' ? 'selected' : '' }}>Mujer</option>
                         </select>
                     </div>
                  </div>
                  <div class="row mb-2">
                     <div class="col-4 text-muted">Teléfono:</div>
                     <div class="col-8">
                         {!! Form::text('telefono', Auth::user()->telefono, ['class' => 'form-control bg-ghost px-2',
                             'required','pattern' => '[0-9]{4,10}','title' => 'Ingresa minimo una extensión a cuatro dígitos', 'readonly']) !!}
                     </div>
                  </div>
                  <div class="row mb-2">
                     <div class="col-4 text-muted">Email:</div>
                     <div class="col-8">
                         {!! Form::email('email', Auth::user()->email, ['class' => 'form-control bg-ghost px-2','required', 'readonly']) !!}
                     </div>
                  </div>
               </div>
                 <div class="oformulario text-center mb-4" style="display: none">
                     <button type="submit"class="btn btn-{{ $bg->customcolor }} btn-rounded">Guardar </button>
                 </div>
                 {!! Form::close() !!}
               <hr class="m-0">
               <div class="card-body">
                  <div class="row mb-2">
                     <div class="col-4 text-muted">Area de trabajo:</div>
                     <div class="col-8">{{$area->nombre ?? 'No asignado'}}</div>
                  </div>
                  <a onclick="openiframe2('Mi area de trabajo','{{ route('usuarios.area')}}')" class="btn btn-outline-light btn-sm float-right mt-2"><i data-feather="edit-2" class="mr-2"></i>Cambiar</a>
                </div>
            </div>
        </div>
        <div class="col-md-7 app-content">
           <div class="app-action">
                  <ul class="list-group list-group-flush w-100">
                    <li> <h5><i data-feather="settings" class="mr-2"></i>Configuración</h5></li>
                         <li class="list-group-item pl-5">
                            <div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input"
                                  id="customSwitch1" checked><label class="custom-control-label config-title"
                                  for="customSwitch1">Mostrar título de cabecera.</label></div>
                         </li>
                         <li class="list-group-item pl-5">
                            <div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input"
                                  id="customSwitch2" checked><label class="custom-control-label config-date"
                                  for="customSwitch2">Mostrar fecha en cabecera</label></div>
                         </li>
                         <li class="list-group-item pl-5">
                            <div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input"
                                  id="customSwitch3" checked><label class="custom-control-label config-icons"
                                  for="customSwitch3">Mostrar iconos de cabecera</label></div>
                         </li>
                         <li class="list-group-item pl-5">
                            <div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input"
                                  id="customSwitch4"><label class="custom-control-label config-text"
                                  for="customSwitch4">Mostrar letra más grande</label></div>
                         </li>
                         <li class="list-group-item">
                            <span class="text-muted small">Los cambios se borrarán al cerrar sesión</span>
                         </li>
                      </ul>
                      <img class="logo opacity-9 mx-3" src="{{ URL::asset('/image/animations/content-moderation.gif') }}" alt="logo" width="260" style="filter: hue-rotate(220deg) drop-shadow(2px 4px 6px #666);">

                 </div>
                 <div class="card card-body">
                    <div class="app-lists" tabindex="1" style="overflow: hidden; outline: none;">
                       <ul class="list-group list-group-flush">
                        <li> <h5><i data-feather="users" class="mr-2"></i>Usuarios en mi área</h5></li>
                          @foreach($usuarios as $key => $user)  
                              <li class="list-group-item d-flex align-items-center p-l-r-0">
                                  <div>
                                      <figure class="avatar avatar-md mb-3 mr-2">
                                          <span class="avatar-title bg-{{$bg->customcolor}} text-white rounded-circle">{{substr($user->username,0,1)}}</span>
                                      </figure>                        </div>
                                  <div>
                                      <h6 class="m-b-0">{{$user->nombreCompleto}}</h6><small class="text-muted">{{$user->username}}</small>
                                  </div>
                                  <div class="ml-auto">
                                      <span class="badge border border-success rounded mr-2 d-sm-inline d-none">{{$user->tipo_usuario == 1 ? 'Usuario de dominio' : 'Administrador'}}</span>
                                  </div>
                              </li>
                          @endforeach  
                      </ul>
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </div>
<!-- 
<script type="text/javascript" src="{{ URL::asset('js/table.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script> -->
<script>

    function show_form(){
        var nombre = $('[name="nombre"]');
        var apepa = $('[name="apepa"]');
        var apema = $('[name="apema"]');
        var sexo = $('[name="sexo"]');
        var email = $('[name="email"]');
        var telefono = $('[name="telefono"]');
        if($('.oformulario').css("display") != "none"){
            nombre.prop('readonly', true);  
            apepa.prop('readonly', true);  
            apema.prop('readonly', true);  
            sexo.prop('disabled', true); 
            email.prop('readonly', true);  
            telefono.prop('readonly', true);  
        }else{
            nombre.prop('readonly', false);  
            apepa.prop('readonly', false);  
            apema.prop('readonly', false);  
            sexo.prop('disabled', false); 
            email.prop('readonly', false);  
            telefono.prop('readonly', false);  
        }
        $('.oformulario').toggle('fast');
    }

</script>

<!-- <span class="text-xs text-muted float-right opacity-1">Icons by Icons8</span> -->
 @endsection