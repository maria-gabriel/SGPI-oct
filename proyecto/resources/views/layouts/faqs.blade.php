@extends('layouts.plantilla')
@section('title','Faqs')
@section ('content')

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Preguntas frecuentes</h4>
                    </div>

                    <div class="accordion custom-accordion accordion-secondary">
                        <div class="accordion-row open"> <a href="#" class="accordion-header"> <span>Accordion 1</span>
                                <i class="accordion-status-icon close fa fa-chevron-up text-md"></i> <i
                                    class="accordion-status-icon open fa fa-chevron-down text-md"></i> </a>
                            <div class="accordion-body">...</div>
                        </div>
                        <div class="accordion-row"> <a href="#" class="accordion-header"> <span>Accordion 2</span> <i
                                    class="accordion-status-icon close fa fa-chevron-up text-md"></i> <i
                                    class="accordion-status-icon open fa fa-chevron-down text-md"></i> </a>
                            <div class="accordion-body">...</div>
                        </div>
                        <div class="accordion-row"> <a href="#" class="accordion-header"> <span>Accordion 3</span> <i
                                    class="accordion-status-icon close fa fa-chevron-up text-md"></i> <i
                                    class="accordion-status-icon open fa fa-chevron-down text-md"></i> </a>
                            <div class="accordion-body">...</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

@endsection