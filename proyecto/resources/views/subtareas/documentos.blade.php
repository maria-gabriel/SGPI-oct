@extends('layouts.modal')
@section('content')

    <div class="row bg-white p-10 m-10 rounded">
        <div class="card app-content-body">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h6 class="font-size-11 text-uppercase mb-4 uppercase">{{$subtarea->nombre}} documentos</h6>
                    <div>
                        <button class="btn btn-success btn-sm mr-1" onclick="$('.formulario').show('fast');">Nuevo</button> <button class="btn btn-{{$bg->customcolor}} btn-sm more">Más detalles</button>
                    </div>
                </div>
                <p class="my-2">Presiona <span class="text-success text-bold">nuevo</span> para agregar un documento. Para abrir el archivo slecciona <i class="fa fa-file-o text-md text-info"></i> En caso de editar o eliminar presiona <span
                        class="text-secondary text-bold">más detalles</span> para ver la tabla de documentos completa.</p>
                <div class="row formulario bg-ghost rounded mb-3" style="display: none;">
                    {!! Form::open(['route' => ['subtareas.store', $subtarea], 'method' => 'post', 'class' => 'container', 'enctype' => 'multipart/form-data']) !!}
                    <div class="container">
                        <div class="row justify-content-center">
                            @csrf
                            <div class="col-10 mt-3">
                                {!! Form::label('', 'Nombre') !!}
                                {!! Form::text('nombre', '', ['class' => 'form-control form-gray px-2','placeholder' => 'Nombre','required',]) !!}
                            </div>
                            <div class="col-10 mt-2">
                                {!! Form::label('', 'Descripción') !!}
                                {!! Form::text('descripcion', '', ['class' => 'form-control form-gray px-2','placeholder' => 'Descripción','required',]) !!}
                            </div>
                            <div class="col-10 mt-2">
                                {!! Form::label('', 'Tipo documento') !!}
                                {{ Form::select('tipo', $cat_doc, '', ['class' => 'custom-select form-control form-gray', 'id' => 'cat_doc', 'placeholder' => 'Seleccione un tipo', 'required']) }}
                            </div>
                            <div class="col-10 input-group mt-2">
                                {!! Form::label('', 'Documento') !!}
                                <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="archivo" name="archivo" value="" required accept="image/*,.doc,.docx,.pds,.csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,text/plain,.pdf">
                                    <label class="custom-file-label border-0 h-auto" id="label-dictamen" for="dictamen">Seleccione un archivo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer text-center mt-2">
                            <button type="button" onclick="$('.formulario').hide('fast');" class="btn btn-outline-dark btn-rounded"
                                data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-{{ $bg->customcolor }} btn-rounded">Guardar </button>
                        </div>
                    </div>
                </div>
                <div class="row listado mt-3">
                @foreach($documentos as $key => $documento)
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="card app-file-list">
                            <a href="../../documents/subtareas/{{$documento->nombre_doc}}" target="_blank">
                            <div class="app-file-icon">
                                <i class="fa {{$documento->tipo}} pointer"></i>
                                <div class="dropdown position-absolute top-0 right-0 mr-3">
                                <div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item">View Details</a></div>
                                </div>
                            </div></a>
                            <a href="../../documents/subtareas/{{$documento->nombre_doc}}" target="_blank">
                            <div class="p-2 small pointer">
                                <div>{{$documento->nombre}}.{{$documento->extension}}</div>
                                <div class="text-muted">{{$documento->descripcion}} ({{$documento->categorias->nombre}})</div>
                            </div></a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/4.9.1/d3.js"></script>
    <script>
        $('#archivo').on('change',function(){
            var fileName = $(this).val();
            $(this).next('#label-dictamen').html('Archivo seleccionado');
        });

        $(".more").click(function() {
            localStorage.setItem('modal-response', 'documentos');
            window.parent.closeModal();
        });
    </script>

@endsection