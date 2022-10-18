 
 @if (auth::user())
     @if (auth::user()->iactivo !=1 )    
    @php
        header("Location: " . URL::to('/'), true, 302);
        exit();
    @endphp  
     @endif            
@else
    @php
        header("Location: " . URL::to('/'), true, 302);
        exit();
    @endphp 
@endif

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <style type="text/css">
    .select2{
        min-width: 100%;
    }
</style>

    <!-- Scripts -->
<!--  <script src="https://code.jquery.com/jquery-3.2.1.js"   integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
 -->
 <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <script src="{{ URL::asset('editor/sandbox/js/jquery.dataTables.js') }}"></script>
  <link href="{{ URL::asset('editor/sandbox/css/editor.dataTables.css') }}" rel="stylesheet" type="text/css" />

  <link rel="stylesheet" type="text/css" href="{{ URL::asset('editor/jquery/jquery.dataTables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('editor/css/select.dataTables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('editor/buttons/buttons.dataTables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('editor/css/dataTables.dateTime.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('editor/css/editor.dataTables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('js/vendors/select2/css/select2.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('js/vendors/bundle.css') }}" />

  <style>
    :root {
    --bs-primary: <?php echo $bg->custom; ?>;
    --bs-primary-fade: <?php echo $bg->customfade; ?>;
    }
    </style>
  <link rel="stylesheet" type="text/css" href="{{ url('/css/app.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ url('/css/plantilla.css') }}" />

 <!-- Select2 -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('js/vendors/select2/css/select2.min.css') }}">
<script src="{{ URL::asset('js/vendors/select2/js/select2.min.js') }}"></script>
    <title>@yield('title')</title>
<body class="bg-white">
    @yield('content')
</body>

</html>
<script type="text/javascript">
    $(document).ready(function(){
      $("#cat_sed").select2({}); 
      $("#cat_dir").select2({}); 
      $("#cat_sub").select2({});   
      $("#cat_dep").select2({});
      $("#cat_res").select2({});
      $(".select2-selection[aria-labelledby='select2-cat_sed-container']").addClass('bg-ghost');
      $(".select2-selection[aria-labelledby='select2-cat_dir-container']").addClass('bg-ghost');
      $(".select2-selection[aria-labelledby='select2-cat_sub-container']").addClass('disabled');
      $(".select2-selection[aria-labelledby='select2-cat_dep-container']").addClass('disabled');
    });
</script>

<script src="{{ URL::asset('editor/jquery/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('editor/js/dataTables.select.min.js') }}"></script>
<script src="{{ URL::asset('editor/js/dataTables.datetime.min.js') }}"></script>
<script src="{{ URL::asset('editor/js/dataTables.editor.min.js') }}"></script>
<script src="{{ URL::asset('js/vendors/dataTable/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('js/vendors/dataTable/dataTables.bootstrap.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ URL::asset('js/vendors/select2/js/select2.min.js') }}"></script>

<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/app2.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/app_datatable.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/plantilla.js') }}"></script>
