<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>{{ config('app.name', 'Laravel') }}</title>
   <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
      crossorigin="anonymous"></script>

   <!-- Fonts -->
   <link rel="dns-prefetch" href="//fonts.gstatic.com">
   <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
   <script src="{{ url('/css/fonts/kit.fontawesome-42d5adcbca.js') }}" crossorigin="anonymous"></script>
   <script src="{{ URL::asset('editor/sandbox/js/jquery.dataTables.js') }}"></script>
   <link href="{{ URL::asset('editor/sandbox/css/editor.dataTables.css') }}" rel="stylesheet" type="text/css" />  

   <!-- Style -->
   <link rel="stylesheet" type="text/css" href="{{ URL::asset('editor/jquery/jquery.dataTables.min.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ URL::asset('editor/css/select.dataTables.min.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ URL::asset('editor/css/select2.dataTables.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ URL::asset('editor/buttons/buttons.dataTables.min.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ URL::asset('editor/css/dataTables.dateTime.min.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ URL::asset('editor/css/editor.dataTables.min.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ URL::asset('js/vendors/select2/css/select2.min.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ URL::asset('js/vendors/bundle.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ URL::asset('js/vendors/enjoyhint/enjoyhint.css') }}">

   <!-- Css -->
   <style>
      :root {
         --bs-primary: <?php echo $bg->custom;
         ?>;
         --bs-primary-fade: <?php echo $bg->customfade;
         ?>;
      }
   </style>
   <link rel="stylesheet" type="text/css" href="{{ url('/css/app.css') }}" />
   <link rel="stylesheet" type="text/css" href="{{ url('/css/plantilla.css') }}" />
   <link rel="icon" class="rounded-circle" href="{{URL::asset('/image/logos/ssm_logo_32.png')}}">

<body>
   <div class="preloader">
      <div class="preloader-icon"></div>
   </div>
   <!-- begin::header -->
   <div class="header">
      <div>
         <ul class="navbar-nav">
            <!-- begin::navigation-toggler -->
            <li class="nav-item navigation-toggler"><a href="#" class="nav-link" title="Ocultar panel lateral"><i
                     data-feather="arrow-left"></i></a></li>
            <li class="nav-item navigation-toggler mobile-toggler"><a href="#" class="nav-link"
                  title="Mostrar panel lateral"><i data-feather="menu"></i></a></li>
            <!-- end::navigation-toggler -->
            <li class="nav-item dropdown">
               <a href="#" class="nav-link dropdown-toggle btn btn-outline-dark btn-sm" data-toggle="dropdown">Acessos rápidos</a>
               <div class="dropdown-menu dropdown-menu-big">
                  <div class="p-3 svghover">
                     <div class="row row-xs">
                        <div class="col-4">
                           <a href="https://www.ssm.gob.mx/portal" target="_blank" title="Servicios de Salud de Morelos">
                              <div class="p-3 border-radius-1 border text-center mb-3">
                                 <i class="width-25 height-25" data-feather="layout"></i>
                                 <div class="mt-2">SSM</div>
                              </div>
                           </a>
                        </div>
                        <div class="col-4">
                           <a href="{{route('ordenes.home')}}" title="Solicitar una órden">
                              <div class="p-3 border-radius-1 border text-center mb-3">
                                 <i class="width-25 height-25" data-feather="clipboard"></i>
                                 <div class="mt-2">SOS</div>
                              </div>
                           </a>
                        </div>
                        <div class="col-4">
                            <a href="{{route('conferencias.calendario')}}" title="Solicitar una conferencia">
                               <div class="p-3 border-radius-1 border text-center mb-3">
                                  <i class="width-25 height-25" data-feather="video"></i>
                                  <div class="mt-2">VC</div>
                               </div>
                            </a>
                         </div>
                     </div>
                     <div class="row row-xs">
                        <div class="col-4">
                            <a href="{{route('home')}}" title="Mis proyectos">
                               <div class="p-3 border-radius-1 border text-center mb-3">
                                  <i class="width-25 height-25" data-feather="folder"></i>
                                  <div class="mt-2">SGPI</div>
                               </div>
                            </a>
                         </div>
                        <div class="col-4">
                           <a href="https://siempre.ssm.gob.mx/sirem/Login.php#no-back-buttom" target="_blank" title="Login SIEMPRE">
                              <div class="p-3 border-radius-1 border text-center mb-3">
                                 <i class="width-25 height-25" data-feather="airplay"></i>
                                 <div class="mt-2">SIEMPRE</div>
                              </div>
                           </a>
                        </div>
                        <div class="col-4">
                           <a href="https://lesp.ssm.gob.mx/lesp/dashboard.php#no-back-buttom" target="_blank" title="Login LESP">
                              <div class="p-3 border-radius-1 border text-center mb-3">
                                 <i class="width-25 height-25" data-feather="thermometer"></i>
                                 <div class="mt-2">LESP</div>
                              </div>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
            </li>
            {{--  <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Proyectos Direcciones</a>
                <div class="dropdown-menu">
                   <a href="" class="dropdown-item">Dirección general</a>
                   <a href="" class="dropdown-item">Dirección de Atención Médica</a>
                   <a href="" class="dropdown-item">Dirección de Planeación y Evaluación </a>
                   <a href="" class="dropdown-item">Dirección de Administración</a>
                   <a href="" class="dropdown-item">Comisión para la Protección Contra Riesgos Sanitarios del Estado de Morelos</a>
                </div>
             </li>  --}}
             <li class="nav-item"><a href="{{ route('proyectos.index')}}" class="nav-link ml-3 btn btn-outline-secondary btn-sm">
                <i class="fa fa-download fa-md mr-2 text-secondary" aria-hidden="true"></i>Exportar proyectos</a></li>
            <li class="nav-item dropdown">
                <a href="#" onclick="taskmenubtn();"
                    class="nav-link ml-3 btn btn-outline-info btn-sm nav-link-nota" title="Notas"
                    data-toggle="dropdown"><i class="fa fa-sticky-note fa-md mr-2 text-info" aria-hidden="true"></i>Mis notas</a>
                <div id="taskmenu" class="dropdown-menu dropdown-menu-left dropdown-menu-big">
                    <div class="p-4 text-center d-flex justify-content-between"
                        data-backround-image="{{URL::asset('/image/avatar/image1.jpg')}}">
                        <h6 class="mb-0">Notas</h6>
                        <small class="font-size-11 opacity-7"></small>
                    </div>
                    <div>
                        <div class="input-group px-2 pt-2 pb-0">
                            <input id="new-task" type="text" class="form-control bg-gray" maxlength="50"
                            placeholder="Crear nueva nota" required>
                            <div class="input-group-append"><button class="btn btn-{{$bg->customcolor}}" type="button"
                                id="add-task"><i class="fa fa-plus"></i></button></div>
                        </div>
                        <span class="text-muted small px-3">Máximo 50 carateres</span>
    
                        <ul class="list-group list-group-flush">
                            <div class="task">
                            <span class="text-divider small pb-2 pl-3 pt-3"><span>Notas pendientes</span></span>
                            <ul id="incomplete-tasks">
                                @foreach($notas_pen as $nota)
                                <li id="{{$nota->id}}"><input type="checkbox"><label>{{$nota->nombre}}</label><input
                                        type="text" class="form-control bg-gray" value=""><button
                                        class="check-edit btn btn-link text-{{$bg->customcolor}} btn-sm m-1"><i
                                        class="fa fa-pencil"></i></button><button
                                        class="check-delete btn btn-link text-danger btn-sm m-1"><i
                                        class="fa fa-times"></i></button></li>
                                    @endforeach
                            </ul>
                            <li id="non-pen"
                                class="text-muted small px-4 {{$notas_pen->isEmpty() ? 'd-block' : 'd-none'}}">No hay
                                notas</li>
    
                            <span class="text-divider small pb-2 pl-3 pt-3"><span>Notas finalizadas</span></span>
                            <ul id="completed-tasks">
                                @foreach($notas_fin as $nota)
                                <li id="{{$nota->id}}"><input type="checkbox"
                                        checked><label>{{$nota->nombre}}</label><input type="text"
                                        class="form-control bg-gray" value="Go Shopping"><button
                                        class="check-edit btn btn-link text-{{$bg->customcolor}} btn-sm m-1 disabled"
                                        disabled><i class="fa fa-pencil"></i></button><button
                                        class="check-delete btn btn-link text-danger btn-sm m-1"><i
                                        class="fa fa-times"></i></button></li>
                                @endforeach
                            </ul>
                            <li id="non-fin"
                                class="text-muted small px-4 {{$notas_fin->isEmpty() ? 'd-block' : 'd-none'}}">No hay
                                notas</li>
                            </div>
                        </ul>
                    </div>
                    <div class="p-2 text-right">
                        <ul class="list-inline small">
                            <li class="list-inline-item"><a href="#" onclick="finalizeTasks();">Finalizar todas</a></li>
                            <li class="list-inline-item"><a href="#" onclick="removeTasks();">Eliminar finalizadas</a></li>
                        </ul>
                    </div>
                </div>
                </li>
         </ul>
      </div>
      <div>
         <ul class="navbar-nav">
            <!-- begin::header search -->
            <li class="nav-item icon-header">
               <a href="#" class="nav-link tour" title="Tutorial"><i class="ti-help-alt text-md icon-bold"></i></a>
            </li>
            <li class="nav-item dropdown icon-header"><a href="#" class="nav-link" title="Pantalla completa"
                  data-toggle="fullscreen"><i class="maximize" data-feather="maximize"></i><i class="minimize"
                     data-feather="minimize"></i></a></li>
            {{--  <li class="nav-item dropdown icon-header">
               <a href="#" class="nav-link nav-link-notify" title="Notifications" data-toggle="dropdown"><i
                     data-feather="bell"></i></a>
               <div class="dropdown-menu dropdown-menu-right dropdown-menu-big">
                  <div class="p-4 text-center d-flex justify-content-between"
                     data-backround-image="{{URL::asset('/image/avatar/image1.jpg')}}">
                     <h6 class="mb-0">Notifications</h6>
                     <small class="font-size-11 opacity-7">1 unread notifications</small>
                  </div>
                  <div>
                     <ul class="list-group list-group-flush">
                        <li>
                           <a href="#" class="list-group-item d-flex hide-show-toggler">
                              <div>
                                 <figure class="avatar avatar-sm m-r-15"><span
                                       class="avatar-title bg-success-bright text-success rounded-circle"><i
                                          class="ti-user"></i></span></figure>
                              </div>
                              <div class="flex-grow-1">
                                 <p class="mb-0 line-height-20 d-flex justify-content-between">New customer registered
                                    <i title="Mark as read" data-toggle="tooltip"
                                       class="hide-show-toggler-item fa fa-circle-o font-size-11"></i></p>
                                 <span class="text-muted small">20 min ago</span>
                              </div>
                           </a>
                        </li>
                        <li class="text-divider small pb-2 pl-3 pt-3"><span>Old notifications</span></li>
                        <li>
                           <a href="#" class="list-group-item d-flex hide-show-toggler">
                              <div>
                                 <figure class="avatar avatar-sm m-r-15"><span
                                       class="avatar-title bg-warning-bright text-warning rounded-circle"><i
                                          class="ti-package"></i></span></figure>
                              </div>
                              <div class="flex-grow-1">
                                 <p class="mb-0 line-height-20 d-flex justify-content-between">New Order Recieved <i
                                       title="Mark as unread" data-toggle="tooltip"
                                       class="hide-show-toggler-item fa fa-check font-size-11"></i></p>
                                 <span class="text-muted small">45 sec ago</span>
                              </div>
                           </a>
                        </li>
                        <li>
                           <a href="#" class="list-group-item d-flex align-items-center hide-show-toggler">
                              <div>
                                 <figure class="avatar avatar-sm m-r-15"><span
                                       class="avatar-title bg-danger-bright text-danger rounded-circle"><i
                                          class="ti-server"></i></span></figure>
                              </div>
                              <div class="flex-grow-1">
                                 <p class="mb-0 line-height-20 d-flex justify-content-between">Server Limit Reached! <i
                                       title="Mark as unread" data-toggle="tooltip"
                                       class="hide-show-toggler-item fa fa-check font-size-11"></i></p>
                                 <span class="text-muted small">55 sec ago</span>
                              </div>
                           </a>
                        </li>
                        <li>
                           <a href="#" class="list-group-item d-flex align-items-center hide-show-toggler">
                              <div>
                                 <figure class="avatar avatar-sm m-r-15"><span
                                       class="avatar-title bg-info-bright text-info rounded-circle"><i
                                          class="ti-layers"></i></span></figure>
                              </div>
                              <div class="flex-grow-1">
                                 <p class="mb-0 line-height-20 d-flex justify-content-between">Apps are ready for update
                                    <i title="Mark as unread" data-toggle="tooltip"
                                       class="hide-show-toggler-item fa fa-check font-size-11"></i></p>
                                 <span class="text-muted small">Yesterday</span>
                              </div>
                           </a>
                        </li>
                     </ul>
                  </div>
                  <div class="p-2 text-right">
                     <ul class="list-inline small">
                        <li class="list-inline-item"><a href="#">Mark All Read</a></li>
                     </ul>
                  </div>
               </div>
            </li>  --}}
            <!-- end::header notification dropdown -->
            <!-- begin::user menu -->
            <li class="nav-item dropdown">
               <a href="#" class="nav-link" title="Configuración" data-toggle="dropdown"><i
                     data-feather="settings"></i></a>
               <div class="dropdown-menu dropdown-menu-right dropdown-menu-big">
                  <div class="p-4 text-center d-flex justify-content-between"
                     data-backround-image="{{URL::asset('/image/avatar/image1.jpg')}}">
                     <h6 class="mb-0">Configuración</h6>
                  </div>
                  <div>
                     <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                           <div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input"
                                 id="customSwitch1" checked><label class="custom-control-label config-title"
                                 for="customSwitch1">Mostrar título de cabecera.</label></div>
                        </li>
                        <li class="list-group-item">
                           <div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input"
                                 id="customSwitch2" checked><label class="custom-control-label config-date"
                                 for="customSwitch2">Mostrar fecha en cabecera</label></div>
                        </li>
                        <li class="list-group-item">
                           <div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input"
                                 id="customSwitch3" checked><label class="custom-control-label config-icons"
                                 for="customSwitch3">Mostrar iconos de cabecera</label></div>
                        </li>
                        <li class="list-group-item">
                           <div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input"
                                 id="customSwitch4"><label class="custom-control-label config-text"
                                 for="customSwitch4">Mostrar letra más grande</label></div>
                        </li>
                        <li class="list-group-item">
                           <span class="text-muted small">Los cambios se borrarán al cerrar sesión</span>
                        </li>
                     </ul>
                  </div>
               </div>
            </li>
            <!-- end::user menu -->
         </ul>
         <!-- begin::mobile header toggler -->
         <ul class="navbar-nav d-flex align-items-center">
            <li class="nav-item header-toggler"><a href="#" class="nav-link"><i data-feather="arrow-down"></i></a></li>
         </ul>
         <!-- end::mobile header toggler -->
      </div>
   </div>
   <!-- end::header -->
   <div id="main">
      <!-- begin::navigation -->
      <div class="navigation">
         <div class="navigation-menu-tab bg-{{$bg->customcolor}}">
            <div>
               <div class="navigation-menu-tab-header" data-toggle="tooltip" title="{{Auth::user()->username}}"
                  data-placement="right">
                  {{-- <figure class="avatar avatar-sm"><img src="{{URL::asset('/image/logos/ssm_logo_60.png')}}"
                        class="rounded-circle" alt="avatar"></figure> --}}
                  <figure class="avatar avatar-sm">
                     <span
                        class="avatar-title bg-white text-{{$bg->customcolor}} rounded-circle">{{substr(Auth::user()->username,0,1)}}</span>
                  </figure>
               </div>
            </div>
            <div class="flex-grow-1">
               <ul>
                  <li><a title="Proyectos" class="{{ (request()->is('home')) ? 'active' : '' }} {{ (request()->is('proyectos/home')) ? 'active' : '' }} {{ (request()->is('tareas')) ? 'active' : '' }} {{ (request()->is('subtareas')) ? 'active' : '' }} {{ (request()->is('archivos')) ? 'active' : '' }}" href="#" data-toggle="tooltip" data-placement="right"
                        data-nav-target="#dashboard"><i data-feather="home"></i></a></li>
                  <li><a title="SOS y Conferencias" class="{{ (request()->is('home/orden')) ? 'active' : '' }} {{ (request()->is('ordenes')) ? 'active' : '' }} {{ (request()->is('calendario')) ? 'active' : '' }}" data-nav-target="#ordenes" href="#" data-toggle="tooltip" data-placement="right"><i
                           data-feather="clipboard"></i></a></li>
                  <li><a title="Soporte Técnico" class="{{ (request()->is('faqs')) ? 'active' : '' }}" href="#" data-toggle="tooltip" data-placement="right"
                        data-nav-target="#soporte"><i data-feather="headphones"></i></a></li>
                  <li class="{{Auth::user()->tipo_usuario == 1 ? 'd-none' : ''}}"><a title="Bug Fixer" href="#" data-toggle="tooltip" data-placement="right" 
                        data-nav-target="#panel"><i data-feather="coffee"></i></a></li>
                  <li class="{{Auth::user()->tipo_usuario == 1 ? 'd-none' : ''}}"><a title="DataBase Manager" class="{{ (request()->is('usuarios')) ? 'active' : '' }} {{ (request()->is('admins')) ? 'active' : '' }} {{ (request()->is('accesos')) ? 'active' : '' }} {{ (request()->is('documentos')) ? 'active' : '' }} {{ (request()->is('servicios')) ? 'active' : '' }} {{ (request()->is('equipos')) ? 'active' : '' }} {{ (request()->is('perfiles')) ? 'active' : '' }} {{ (request()->is('direcciones')) ? 'active' : '' }} {{ (request()->is('subdirecciones')) ? 'active' : '' }} {{ (request()->is('departamentos')) ? 'active' : '' }} {{ (request()->is('sedes')) ? 'active' : '' }}" href="#" data-toggle="tooltip" data-placement="right"
                        data-nav-target="#datos"><i data-feather="database"></i></a></li>
               </ul>
            </div>
            <div class="navi-user">
               <ul>
                  <li><a href="{{ url('usuarios/perfil') }}" class="{{ (request()->is('usuarios/perfil')) ? 'active' : '' }}" data-toggle="tooltip" data-placement="right"
                        title="Mi perfil"><i data-feather="user"></i></a></li>
                  <li><a href="{{ route('logout') }}" data-toggle="tooltip" data-placement="right" title="Cerrar sesión"
                        onclick="event.preventDefault(); localStorage.clear(); document.getElementById('logout-form').submit();"><i
                           data-feather="log-out"></i></a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                     </form>
                  </li>
               </ul>
            </div>
         </div>
         <!-- begin::navigation menu -->
         <div class="navigation-menu-body">
            <!-- begin::navigation-logo -->
            <div>
               <div id="navigation-logo"><a href="https://www.ssm.gob.mx" target="_blank">
                     <img class="logo" src="{{URL::asset('/image/logos/ssm_logo.png')}}" alt="logo" width="170">
                     <img class="logo-light" src="{{URL::asset('/image/logos/ssm_logo_white.png')}}" alt="logo-w"
                        width="170"></a>
               </div>
            </div>
            <!-- end::navigation-logo -->
            <div class="navigation-menu-group">
               <div id="dashboard" class="{{ (request()->is('home')) ? 'open' : '' }} {{ (request()->is('proyectos/home')) ? 'open' : '' }} {{ (request()->is('usuarios/perfil')) ? 'open' : '' }} {{ (request()->is('tareas')) ? 'open' : '' }} {{ (request()->is('subtareas')) ? 'open' : '' }} {{ (request()->is('archivos')) ? 'open' : '' }} {{ (request()->is('proyectos/proyecto')) ? 'open' : '' }}">
                  <ul>
                     <li class="navigation-divider mt-2">
                        <h5 class="text-{{$bg->customcolor}} m-0">SGPI</h5>
                     </li>
                     <li class="navigation-divider my-0 text-xxs text-muted">
                        MI SECTOR
                     </li>
                     <li><a class="{{ (request()->is('home')) ? 'active' : '' }}"
                         href="{{route('home')}}">Mis proyectos</a></li>
                     <li><a class="{{ (request()->is('tareas')) ? 'active' : '' }}"
                           href="{{route('tareas.index')}}">Mis tareas</a></li>
                     <li><a class="{{ (request()->is('subtareas')) ? 'active' : '' }}"
                           href="{{route('subtareas.index')}}">Mis subtareas</a></li>
                     <li><a class="{{ (request()->is('archivos')) ? 'active' : '' }}"
                           href="{{route('archivos.index')}}">Documentos</a></li>
                    <li class="navigation-divider my-0 text-xxs text-muted">
                        OTROS SECTORES
                    </li>
                    <li><a class="{{ (request()->is('proyectos/home')) ? 'active' : '' }}"
                        href="{{route('proyectos.home')}}">Proyectos</a></li>
                  </ul>
               </div>
               <div id="ordenes" class="{{ (request()->is('home/orden')) ? 'open' : '' }} {{ (request()->is('ordenes')) ? 'open' : '' }} {{ (request()->is('calendario')) ? 'open' : '' }}">
                  <ul>
                     <li class="navigation-divider mt-2">
                        <h5 class="text-{{$bg->customcolor}} m-0">SOS-VC</h5>
                     </li>
                     <li><a class="{{ (request()->is('home/orden')) ? 'active' : '' }}" 
                        href="{{route('ordenes.home')}}">Solicitud de orden</a></li>
                     <li><a class="{{ (request()->is('ordenes')) ? 'active' : '' }}" 
                        href="{{route('ordenes.index')}}">Mis ordenes</a></li>

                     <li class="navigation-divider my-0">
                        Conferencias
                     </li>
                     <li><a class="{{ (request()->is('calendario')) ? 'active' : '' }}" 
                        href="{{route('conferencias.calendario')}}">Calendario</a></li>
                     <li><a class="{{ (request()->is('conferencias')) ? 'active' : '' }}" 
                        href="{{route('ordenes.home')}}">Mis conferencias</a></li>
                  </ul>
               </div>
               <div id="soporte" class="{{ (request()->is('faqs')) ? 'open' : '' }}">
                  <ul>
                     <li class="navigation-divider mt-2">
                        <h5 class="text-{{$bg->customcolor}} m-0">SSM</h5>
                     </li>
                     <li><a class="{{ (request()->is('faqs')) ? 'active' : '' }}" 
                        href="{{route('faqs')}}">Preguntas frecuentes SGPI</a></li>
                     <li><a class="{{ (request()->is('faqsos')) ? 'active' : '' }}" 
                        href="{{route('faqs')}}">Preguntas frecuentes SOS</a></li>
                     <li><a class="{{ (request()->is('faqsvc')) ? 'active' : '' }}" 
                        href="{{route('faqs')}}">Preguntas frecuentes Videoconferencias</a></li>
                        <hr>
                     <li><a class="{{ (request()->is('faqsn')) ? 'active' : '' }}" 
                        href="{{route('faqs')}}">Levantar una duda</a></li>
                  </ul>
               </div>
               <div id="panel">

               </div>
               <div id="datos" class="{{ (request()->is('usuarios')) ? 'open' : '' }} {{ (request()->is('admins')) ? 'open' : '' }} {{ (request()->is('accesos')) ? 'open' : '' }} {{ (request()->is('documentos')) ? 'open' : '' }} {{ (request()->is('servicios')) ? 'open' : '' }}{{ (request()->is('equipos')) ? 'open' : '' }} {{ (request()->is('perfiles')) ? 'open' : '' }} {{ (request()->is('direcciones')) ? 'open' : '' }} {{ (request()->is('subdirecciones')) ? 'open' : '' }} {{ (request()->is('departamentos')) ? 'open' : '' }} {{ (request()->is('sedes')) ? 'open' : '' }}">
                <ul class="mt-3">
                    @env('usuarios.index')
                    <li class="navigation-divider mt-2">
                        <h5 class="text-{{$bg->customcolor}} m-0">DataBase</h5>
                     </li>
                     <li class="navigation-divider my-0">
                        Usuarios y permisos
                     </li>
                    <li>
                    <li><a class="{{ (request()->is('usuarios')) ? 'active' : '' }}"
                        href="{{ route('usuarios.index') }}">Usuarios</a></li>
                    <li><a class="{{ (request()->is('admins')) ? 'active' : '' }}"
                        href="{{ route('admins.index') }}">Administradores</a></li>
                    </li>
                    <li><a class="{{ (request()->is('perfiles')) ? 'active' : '' }}"
                        href="{{ route('perfiles.index') }}">Perfiles</a></li>
                    <li><a class="{{ (request()->is('accesos')) ? 'active' : '' }}"
                        href="{{ route('accesos.index') }}">Permisos</a></li>
                    @endenv
                    @env('direcciones.index')
                    <li class="navigation-divider my-0">
                        Catálogos
                     </li>
                    <li>
                       <a class="{{ (request()->is('direcciones')) ? 'active' : '' }} {{ (request()->is('subdirecciones')) ? 'active' : '' }} {{ (request()->is('departamentos')) ? 'active' : '' }} {{ (request()->is('sedes')) ? 'active' : '' }}"
                          href="#">Sectores</a>
                       <ul>
                          <li><a class="{{ (request()->is('direcciones')) ? 'active' : '' }}"
                                href="{{ route('direcciones.index') }}">Direcciones</a></li>
                          <li><a class="{{ (request()->is('subdirecciones')) ? 'active' : '' }}"
                                href="{{ route('subdirecciones.index') }}">Subdirecciones</a></li>
                          <li><a class="{{ (request()->is('departamentos')) ? 'active' : '' }}"
                                href="{{ route('departamentos.index') }}">Departamentos</a></li>
                           <li><a class="{{ (request()->is('sedes')) ? 'active' : '' }}"
                               href="{{ route('sedes.index') }}">Sedes</a></li>
                       </ul>
                    </li>
                    @endenv
                    @env('servicios.index')
                    <li><a class="{{ (request()->is('documentos')) ? 'active' : '' }}"
                        href="{{ route('documentos.index') }}">Documentos</a></li>
                     <li>
                        <a class="{{ (request()->is('servicios')) ? 'active' : '' }} {{ (request()->is('equipos')) ? 'active' : '' }}"
                           href="#">SOS</a>
                        <ul>
                           <li><a class="{{ (request()->is('servicios')) ? 'active' : '' }}"
                              href="{{ route('servicios.index') }}">Servicios</a></li>
                          <li><a class="{{ (request()->is('equipos')) ? 'active' : '' }}"
                                 href="{{ route('equipos.index') }}">Equipos</a></li>
                        </ul>
                     </li>
                    
                    @endenv
                    
                    <li>
                       <a href="#">Menu Level</a>
                       <ul>
                          <li>
                             <a href="#">Menu Level</a>
                             <ul>
                                <li><a href="#">Menu Level</a></li>
                             </ul>
                          </li>
                       </ul>
                    </li>
                 </ul>
               </div>
            </div>
         </div>
         <!-- end::navigation menu -->
      </div>
      <!-- end::navigation -->
      <!-- begin::main content -->
      <main class="main-content pb-1">
         <div class="page-header">
            <div class="container-fluid d-sm-flex justify-content-between">
               <h5 class="title-changer">Servicios de Salud de Morelos</h5>
               <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item today-header text-muted">{{ $today }}</li>
                     {{-- <li class="breadcrumb-item active" aria-current="page"></li> --}}
                  </ol>
               </nav>
            </div>
         </div>
         <div class="container-fluid">
            @yield('content')
         </div>
         <!-- begin::footer -->
         <footer>
            <div class="container-fluid">
               <div><a href="https://www.ssm.gob.mx">© Servicios de Salud de Morelos 2022</a></div>
               <!-- <div>
                        <nav class="nav"><a href="" class="nav-link">Licenses</a><a href="#" class="nav-link">Change Log</a><a href="#" class="nav-link">Get Help</a></nav>
                     </div> -->
            </div>
         </footer>
         <!-- end::footer -->
      </main>
      <!-- end::main content -->
   </div>

   <div class="modal fade modalframe" id="modaliframe" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true" role="dialog" style="overflow-y: scroll;">
      <div class="modal-dialog modal-lg" id="dialog">
         <div class="modal-content">
            <div class="modal-header bg-{{$bg->customcolor}}">
               <h5 class="modal-title text-md text-white" id="modaltitulo"></h5>
               <span id="close" onclick="$('#modaliframe').modal('hide')" class="close text-{{$bg->customcolor}}"
                  data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </span>
            </div>
            <div class="embed-responsive embed-responsive-16by9 z-depth-1-half rounded-bottom">
               <iframe class="embed-responsive-item" id="iframemarca" src="" frameborder="0" allowfullscreen></iframe>
            </div>
            <!-- <div class="modal-footer">
           </div> -->
         </div>
      </div>
   </div>

   <div class="modal fade modalframe" id="modaliframe2" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog" style="overflow-y: scroll;">
      <div class="modal-dialog" id="dialog">
         <div class="modal-content">
            <div class="modal-header bg-{{$bg->customcolor}}">
               <h5 class="modal-title text-md text-white w-100 text-center" id="modaltitulo2"></h5>
            </div>
            <div class="rounded-bottom bg-lavender">
               <iframe class="" style="height: 420px; width: 100%;" id="iframemarca2" src="" frameborder="0"
                  allowfullscreen></iframe>
            </div>
         </div>
      </div>
   </div>

   <div class="modal fade modalframe" id="modaliframe3" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true" role="dialog" style="overflow-y: scroll;">
      <div class="modal-dialog modal-xl" id="dialog">
         <div class="modal-content">
            <div class="modal-header bg-{{$bg->customcolor}}">
               <h5 class="modal-title text-md text-white" id="modaltitulo3"></h5>
               <span id="close" onclick="$('#modaliframe3').modal('hide')" class="close text-{{$bg->customcolor}}"
                  data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </span>
            </div>
            <div class="embed-responsive embed-responsive-16by9 z-depth-1-half rounded-bottom">
               <iframe class="embed-responsive-item" id="iframemarca3" src="" frameborder="0" allowfullscreen></iframe>
            </div>
            <!-- <div class="modal-footer">
           </div> -->
         </div>
      </div>
   </div>

   <!-- Plugins -->
   <script src="{{ URL::asset('js/vendors/bundle.js') }}"></script>
   <script src="{{ URL::asset('js/vendors/charts/apex/apexcharts.min.js') }}"></script>
   <script src="{{ URL::asset('js/vendors/charts/chartjs/chart.min.js') }}"></script>
   <script src="{{ URL::asset('js/vendors/circle-progress/circle-progress.min.js') }}"></script>
   <script src="{{ URL::asset('js/vendors/prism/prism.js') }}"></script>
   <script src="{{ URL::asset('js/vendors/datepicker/daterangepicker.js') }}"></script>
   <script src="{{ URL::asset('js/vendors/charts/peity/jquery.peity.min.js') }}"></script>
   <script src="{{ URL::asset('js/vendors/enjoyhint/enjoyhint.min.js') }}"></script>
   <script src="{{ URL::asset('js/examples/dashboard.js') }}"></script>
   <script src="{{ URL::asset('js/plugins/bootstrap.min.js') }}"></script>
   <script src="{{ URL::asset('js/examples/datatable.js') }}"></script>
   <!-- <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> -->

   <!-- Javascript -->
   <script src="{{ URL::asset('editor/jquery/jquery.dataTables.min.js') }}"></script>
   <script src="{{ URL::asset('editor/js/dataTables.select.min.js') }}"></script>
   <script src="{{ URL::asset('editor/js/dataTables.select2.js') }}"></script>
   <script src="{{ URL::asset('editor/js/dataTables.datetime.min.js') }}"></script>
   <script src="{{ URL::asset('editor/js/dataTables.editor.min.js') }}"></script>
   <script src="{{ URL::asset('js/vendors/dataTable/dataTables.responsive.min.js') }}"></script>
   <script src="{{ URL::asset('js/vendors/dataTable/dataTables.bootstrap.min.js') }}"></script>
   <script src="{{ URL::asset('js/vendors/dataTable/dataTables.buttons.min.js') }}"></script>
   <script src="{{ URL::asset('js/vendors/dataTable/dataTables.bootstrap4.min.js') }}"></script>
   <script src="{{ URL::asset('js/vendors/select2/js/select2.min.js') }}"></script>

   <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
   <script type="text/javascript" src="{{ URL::asset('js/app2.js') }}"></script>
   <script type="text/javascript" src="{{ URL::asset('js/plantilla.js') }}"></script>
   <script type="text/javascript" src="{{ URL::asset('js/app_datatable.js') }}"></script>

   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/select/1.4.0/js/dataTables.select.min.js"></script>
   <script type="text/javascript">
      var mytitle = window.location.href.split('SGPI/')[1];
         switch (mytitle) {
            case 'home':case 'proyectos':case 'tareas':case 'subtareas':case 'archivos':case 'proyectos/home':case 'proyectos/proyecto':
            $('.title-changer').text('Sistema de Gestión de Proyectos Internos');
            break;
            case 'home/orden':case 'ordenes':case 'calendario':case 'conferencias':
            $('.title-changer').text('Solicitud de Ordenes de Servicio y Videoconferencias');
            break;
            case 'faqs':case 'faqsos':case 'faqsvc':
            $('.title-changer').text('Soporte Técnico');
            break;
            case 'usuarios':case 'admins':case 'perfiles':case 'accesos':case 'direcciones':case 'subdirecciones':case 'departamentos':case 'sedes':case 'documentos':case 'servicios':case 'equipos':
            $('.title-changer').text('Administrador de Base de datos');
            break;
         }

      var clase = '{{ $bg->customcolor }}';
       const boxes = document.querySelectorAll('thead');
         for (const box of boxes) {
            clase == 'secondary' ? box.classList.add('bg-'+clase+'-fade') : box.classList.add('bg-'+clase);
         }
   </script>

   <script type="text/javascript">
    
      $(document).ready(function(){
         $("#cat_area").select2({});
         $("#cat_tarea").select2({});
         $("#cat_equipo").select2({});
         $(".select2-selection").addClass('bg-ghost');

         @if(Auth::user()->area==null)
         $('#modaliframe2').modal({backdrop:'static', keyboard:false});
         var url = '{{ route("usuarios.area") }}';
         openiframe2('Mi area de trabajo',url);
         @endif
         $(".preloader").fadeOut(400,function(){setTimeout(function(){},500)});
         if ($(window).width() < 700) {
          $('.tabla-responsiva').addClass('table-responsive');
       }
       
    });
      
      localStorage.setItem('modal-response','');
      $('.modalframe').on('hidden.bs.modal', function () {
       var val = localStorage.getItem('modal-response');
       if(val != ''){
          if (val == 'ok'){
           $(".preloader").fadeOut(400,function(){setTimeout(function(){toastr.options={timeOut:2000,progressBar:true,showMethod:"slideDown",hideMethod:"slideUp",showDuration:200,hideDuration:300,positionClass:"toast-bottom-center",};toastr.success("Operación exitosa");a(".theme-switcher").removeClass("open")},500)});
           localStorage.getItem('modal-response', '');
           setTimeout(function(){history.go(0);}, 2000);
        }else if(val == 'okok'){
         $(".preloader").fadeOut(400,function(){setTimeout(function(){toastr.options={timeOut:2000,progressBar:true,showMethod:"slideDown",hideMethod:"slideUp",showDuration:200,hideDuration:300,positionClass:"toast-bottom-center",};toastr.success("Operación exitosa");a(".theme-switcher").removeClass("open")},500)});
           localStorage.getItem('modal-response', '');
      }else if(val == 'nook'){
           var mensaje = '';
           @if(Auth::user()->tipo_usuario==2)
           mensaje = "Operación no exitosa:" + val;
           @else
           mensaje = "Operación no exitosa";
           @endif
           $(".preloader").fadeOut(400,function(){setTimeout(function(){toastr.options={timeOut:5000,progressBar:true,showMethod:"slideDown",hideMethod:"slideUp",showDuration:200,hideDuration:300,positionClass:"toast-bottom-center",};toastr.error(mensaje);a(".theme-switcher").removeClass("open")},500)});
           localStorage.getItem('modal-response', '');
        }else if(val == 'tareas'){
           window.location.href="{{route('tareas.index')}}";
           localStorage.getItem('modal-response', '');
        }else if(val == 'subtareas'){
           window.location.href="{{route('subtareas.index')}}";
           localStorage.getItem('modal-response', '');
        }else if(val == 'documentos'){
         window.location.href="{{route('archivos.index')}}";
         localStorage.getItem('modal-response', '');
        }else if(val == 'exportar'){
            window.location.href="{{route('proyectos.index')}}";
            localStorage.getItem('modal-response', '');
        }
     }
   });
      
   </script>
</body>

</html>