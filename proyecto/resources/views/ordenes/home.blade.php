@extends('layouts.plantilla')
@section('title','Ordenes')
@section ('content')

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Formulario de solicitud</h4>
                        <div>
                            <a class="mr-3 pointer d-none d-sm-none d-md-inline-flex"
                                href="{{route('faqs')}}"><i class="fa fa-question-circle"></i></a>
                        </div>
                    </div>

                    {!! Form::open(array('route' => array('home'),'method'=>'post')) !!}
                    <div class="row ">
                    <div class="col-lg-6 col-md-6 col-sm-12 mt-3 mr-2">
                    {!! Form::label('','Nombre') !!}
                    {!! Form::text('nombre',$user->nombreCompleto,array('class' => 'form-control bg-ghost px-2', 'placeholder'=>'Nombre completo', 'required'))!!}
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                    {!! Form::label('','Area') !!}
                    {{ Form::select('area', $cat_area, Auth::user()->area, ['class' => 'form-control bg-ghost','id'=>'cat_area','placeholder'=>'Seleccione un departamento','required'])}}
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 mt-3">
                    {!! Form::label('','Teléfono') !!}
                    {!! Form::text('telefono',Auth::user()->telefono,array('class' => 'form-control bg-ghost px-2', 'placeholder'=>'Teléfono ó extensión', 'required', 'pattern' => '[0-9]{4,10}', 'title'=> 'Ingresa minimo una extensión a cuatro dígitos'))!!}
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                    {!! Form::label('','Tarea') !!}
                    {{ Form::select('tarea', $cat_tarea, '', ['class' => 'form-control bg-ghost','id'=>'cat_tarea','placeholder'=>'Seleccione servicio solicitado','required'])}}
                    <a id="soli18" href="http://192.168.10.79/portal/descargables/servicios_internos/Formato%20solicitud%20de%20cuenta%20de%20usuario%20.pdf" class="d-none" target="_blank"><label class="pointer m-0 mt-1 text-info">&nbsp;<u>Formato de solicitud a entregar</u></label></a> 
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 mt-3">
                    {!! Form::label('','Equipo') !!}
                    {{ Form::select('equipo', $cat_equipo, '', ['class' => 'form-control bg-ghost','id'=>'cat_equipo','placeholder'=>'Seleccione tipo de equipo','required'])}}
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                    {!! Form::label('','Descripción') !!}
                    {!! Form::textarea('descripcion','',array('class' => 'form-control bg-ghost px-2', 'placeholder'=>'Favor de ingresar una descripción sólida.', 'rows' => 1, 'required'))!!}
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 text-white d-flex align-self-end mt-3">
                    <button class="btn btn-secondary btn-block m-0 pt-sm-2" type="submit">Solicitar</button>
                    </div>            
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

@endsection
