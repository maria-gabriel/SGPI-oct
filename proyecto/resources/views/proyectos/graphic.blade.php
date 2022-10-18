@extends('layouts.modal')
@section('content')
    <style>
        #chartdiv {
            width: 100%;
            height: 750px;
        }
    </style>
    <script src="https://www.amcharts.com/lib/4/themes/dataviz.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <div class="row p-10 m-10 bg-white rounded">
        <div class="card-body py-2">
            <div class="d-flex justify-content-between">
                <h6 class="text-uppercase mb-4 uppercase">{{ $proyecto->nombre }}</h6>
                <div class="text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button class="btn btn-warning text-white btn-sm btn-tar" type="button">Tareas</button>
                        <button class="btn btn-success btn-sm btn-sub" type="button">Subtareas en tareas</button>
                        <button class="btn btn-info btn-sm btn-sub2 " type="button">Subtareas</button>
                        <button class="btn btn-secondary btn-sm btn-all" type="button">Subtareas y tareas</button>
                        <button class="btn btn-outline-secondary btn-sm" type="button" onclick="savePDF();">Descargar</button>

                    </div>
                </div>
            </div>
            <div id="charttxt" class="mt-4 text-center" style="display: none">
                <img class="logo opacity-7" src="{{ URL::asset('/image/animations/nograph.gif') }}" alt="logo" width="250" style="filter: hue-rotate(70deg);">
                <h5>Aún no se han agregado tareas/subtareas</h5>
            </div>
            <div id="chartdiv" class="pl-0" style="display: none"></div>
        </div>
    </div>
    <script type="text/javascript">
        var array_proyecto = @json($proyecto, JSON_PRETTY_PRINT);
        var array_task = @json($subtar, JSON_PRETTY_PRINT);
        var array_just_tar = @json($tar, JSON_PRETTY_PRINT);
        var array_just_sub = @json($sub, JSON_PRETTY_PRINT);
        var array_task_all = @json($all, JSON_PRETTY_PRINT);
        var array_pdf = array_task_all;
        array_task_all.length > 0 ? $('#chartdiv').show() : $('#charttxt').show();
        if (array_task_all.length > 0 && array_just_tar.length == 0) {
            array_just_tar = array_task_all;
        }
        array_task_all.sort((a, b) => {
            return new Date(a.fromDate) - new Date(b.fromDate);
        });
        var cuerpo = [[{ text: "", bold: true },
              { text: "Nombre", bold: true },
              { text: "Descripción", bold: true },
              { text: "Fecha inicio", bold: true },
              { text: "Fecha final", bold: true }]
          ];

          for (var i in array_pdf){
            cuerpo.push([array_pdf[i].tipo, array_pdf[i].client, array_pdf[i].descrip, array_pdf[i].fromDate, array_pdf[i].toDate]);
          }

        console.log(array_pdf);
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create("chartdiv", am4charts.XYChart);
        chart.hiddenState.properties.opacity = 0.8;
        chart.paddingRight = 30;
        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";
        var colorSet = new am4core.ColorSet();
        colorSet.saturation = 0.4;
        let colores = [];
        let xnum = [0, 0, 0, 1, 1, 2, 2, 2, 3, 3, 4, 4, 4, 4, 5, 5, 6, 6, 6, 7, 7, 8, 8, 9, 9, 10, 10, 10, 11, 11, 12, 12, 13, 13];
        let ynum = [0, 0.4, 0.8, 0.2, 0.6, 0, 0.4, 0.8, 0.2, 0.6, 0, 0.4, 0.6, 0.8, 0.2, 0.6, 0, 0.4, 0.8, 0.2, 0.6, 0.4, 0.8, 0.2, 0.6, 0, 0.4, 0.8, 0.2, 0.6, 0, 0.4, 0.8, 0.2];

        if(array_just_tar.length > xnum.length || array_just_sub.length > xnum.length){
            for (var i = 0; i < array_task_all.length; i++) {
                for (var j = 0; j < 1; j = j + 0.4) {
                    colores[i] = colorSet.getIndex(i).brighten(j);
                }
            }
        }else{
            for (var i = 0; i < xnum.length; i++) {
                colores[i] = colorSet.getIndex(xnum[i]).brighten(ynum[i]);
            }
        }
        //colores.sort(function() { return Math.random() - 0.5 });
        function truncate(str, n) {
            return (str.length > n) ? str.slice(0, n - 1).trim() + '...' : str;
        };

        for (var i = 0; i < array_pdf.length; i++) {
            array_pdf[i]['color'] = colores[i];
        }

        for (var i = 0; i < array_task.length; i++) {
            array_task[i]['color'] = colores[i];
            array_task[i]['name'] = truncate(array_task[i]['name'], 70);
            array_task[i]['client'] = truncate(array_task[i]['client'], 55);
        }

        for (var i = 0; i < array_just_sub.length; i++) {
            array_just_sub[i]['color'] = colores[i];
            array_just_sub[i]['name'] = truncate(array_just_sub[i]['name'], 65);
            array_just_sub[i]['client'] = truncate(array_just_sub[i]['client'], 55);
        }

        for (var i = 0; i < array_task_all.length; i++) {
            array_task_all[i]['color'] = colores[i];
            array_task_all[i]['name'] = truncate(array_task_all[i]['name'], 65);
            array_task_all[i]['client'] = truncate(array_task_all[i]['client'], 55);
        }

        for (var i = 0; i < array_just_tar.length; i++) {
            //colores[i]._value.a = 0.5;
            array_just_tar[i]['color'] = colores[i];
            array_just_tar[i]['name'] = truncate(array_just_tar[i]['name'], 70);
            array_just_tar[i]['client'] = truncate(array_just_tar[i]['client'], 55);
        }
        chart.data = array_just_tar;
        
        var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "name";
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.grid.template.strokeOpacity = 0.08;
        categoryAxis.renderer.inversed = true;

        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.dateFormatter.dateFormat = "yyyy-MM-dd";
        dateAxis.renderer.minGridDistance = 60;
        dateAxis.renderer.grid.template.location = 0;
        dateAxis.renderer.grid.template.strokeOpacity = 0.1;
        dateAxis.baseInterval = {
            count: 15,
            timeUnit: "minute"
        };
        var today = new Date();
        var year = today.getFullYear() + 1;
        dateAxis.max = new Date(year, 0, 1, 1, 0, 0, 0).getTime();
        dateAxis.strictMinMax = true;
        dateAxis.renderer.tooltipLocation = 0;

        var series1 = chart.series.push(new am4charts.ColumnSeries());
        series1.columns.template.width = am4core.percent(99);
        series1.columns.template.tooltipText = "{client} \n {fromDate} a {toDate} \n";
        series1.dataFields.openDateX = "fromDate";
        series1.dataFields.dateX = "toDate";
        series1.dataFields.categoryY = "name";
        series1.columns.template.fillOpacity = 0.5;
        series1.columns.template.propertyFields.fill = "color";
        series1.columns.template.strokeOpacity = 0.95;
        series1.columns.template.propertyFields.stroke = "color";
        chart.scrollbarX = new am4core.Scrollbar();
        chart.scrollbarX.parent = chart.bottomAxesContainer;
        chart.scrollbarX.fill = am4core.color("#bbb");
        chart.scrollbarX.minHeight = 10;

        var label = categoryAxis.renderer.labels.template;
        label.wrap = true;
        label.width = 300;
        label.minHeight = 20;
        label.fontFamily = "Sans-serif";
        label.fontSize = "12";
        label.align = "right";
        categoryAxis.dataFields.category.fontSize = "11";
        categoryAxis.renderer.minGridDistance = 20;
        categoryAxis.renderer.labels.template.fill = "#333";

        chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.menu.items = [{
            "label": "...",
            "menu": [
              { "type": "png", "label": "PNG" },
              { "type": "xlsx", "label": "XLSX" },
              { "label": "Print", "type": "print" }
            ]
          }];
        
        $(".btn-tar").click(function() {
            chart.data = array_just_tar;
        });

        $(".btn-sub").click(function() {
            chart.data = array_task;
        });

        $(".btn-sub2").click(function() {
            chart.data = array_just_sub;
        });
        $(".btn-all").click(function() {
            chart.data = array_task_all;
        });

        function savePDF() {
            chart.data = array_task_all;
            Promise.all([
              chart.exporting.pdfmake,
              chart.exporting.getImage("png")
            ]).then(function(res) { 
              
              var pdfMake = res[0];
              var doc = {
                pageSize: "A4",
                pageOrientation: "portrait",
                pageMargins: [30, 30, 30, 30],
                content: []
              };
              
              doc.content.push({
                text: array_proyecto.nombre,
                fontSize: 20,
                bold: true,
                margin: [0, 20, 0, 15]
              });
          
              doc.content.push({
                text: array_proyecto.descripcion,
                fontSize: 15,
                margin: [0, 0, 0, 15]
              });
              
              doc.content.push({
                image: res[1],
                width: 530
              });
              
              doc.content.push({
                text: "Desgloce de tareas y subtareas",
                fontSize: 12,
                bold: true,
                margin: [0, 20, 0, 15]
              });
              
              doc.content.push({
                fontSize: 9,
                color: '#333',
                table: {
                  headerRows: 1,
                  widths: [ "*", "*", "*", "*", "*" ],
                  body: cuerpo,
                  border:'1px solid #aaa',
                }
              });
              
              pdfMake.createPdf(doc).download("diagrama_gantt.pdf");
              
            });
          }

    </script>
@endsection
