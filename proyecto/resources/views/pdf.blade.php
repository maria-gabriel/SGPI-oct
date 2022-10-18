<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Formato - Solicitud de Servicio</title>
<style>
/* Estilos de etiqueta*/
@import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";

*{
  font-family: "Poppins", sans-serif;
}

body {
  color: rgba(70,70,72,255);
  border-radius: 10px;
  padding: .5rem;
}

table {
  /*background: white;*/
  width: 100%;
  margin: 0 auto;
  border-collapse: collapse;
  font-size: 9pt;
}

th {
  height: 35px;
  /*border-bottom: 1px solid rgb(210, 220, 250);
  color: rgb(120, 120, 120);*/
}

td {
  width: 25%;
  padding: 0px 10px 0px 10px;
  height: 30px;
  /*border: 0.1px solid rgba(240, 240, 240, 10);*/
}

tfoot {
  font-weight: bold;
}

.cabecera {
  width: 94%;
  height: auto;
  padding: 1em;
  padding-bottom: 0px;
  font-size: 13pt;
  font-weight: bold;
}

.titulo{
    padding-left: 10px;
    float: right;
}

a{
  text-decoration: none;
  color: white;
  font-size: 13pt;
}

hr.hr-1 {
  border: 0;
  height: 7px;
  border-top: 2px solid lavender;
}

.bg-white{
    background-color: ghostwhite;
    border-radius: 5px;
}

.h-50{
    height: 120px;
    color: lavender;
}

.center{
    text-align: center;
}

.small{
    font-size: 9pt;
    font-weight: normal;
    text-align: right;
    color: #5B5B5F;
}

.name{
    color: #5B5B5F;
    font-weight: normal;
}

.justify{
    text-align: justify;
    background-color: ghostwhite;
    border-radius: 5px;
}

.td-title{
    background-color: #6A3E8C;
    color: white;
    font-weight: bold;
    font-size: 10pt;
    border-radius: 5px;
}

.border-top{
    border: 0;
    height: 5px;
    border-top: 1px solid lavender;
}
</style>
</head>
<body>
<header class="cabecera">
  <img src="{{URL::asset('/image/logos/ssm_logo.png')}}" width="200">
  <span class="titulo">Formato de solicitud de orden de servicio <br><p class="small">SSM-DPE-STIS-DI-FO-
</p></span>
</header>
<hr class="hr-1">
<table>
  <tbody>
    <tr class="center">
      <td class="bg-white"><b>Folio:</b> OS/</td>
      <td></td>
      <td></td>
      <td class="bg-white"><b></b></td>
    </tr>
    <td colspan="4"></td>
    <tr>
      <td class="td-title">Datos del solicitante</td>
      <td colspan="3"></td>
    </tr><br>
    <tr class="bg-white">
      <td colspan="2"><b>Nombre: </b></td>
      <td></td>
      <td class="center"><b> </b> </td>
    </tr>
    <tr class="bg-white">
      <td colspan="3"><b>Area: </b> <b>&nbsp;ext. </b> </td>
      <td class="center"></td>
    </tr>
    <td colspan="4"><hr class="hr-1"></td>
    <tr>
      <td class="td-title">Datos del servicio</td>
      <td colspan="3"></td>
    </tr><br>
    <tr class="bg-white">
      <td colspan="2"><b>Supervisor: </b></td>
      <td></td>
      <td class="center"><b> </b> </td>
    </tr>
    <tr class="bg-white">
      <td colspan="3"><b>Tipo de servicio: </b>  </td>
      <td class="center"></td>
    </tr>
    <!-- <tr class="bg-white">
      <td colspan="4"><b>Tipo de equipo: </b> </td>
    </tr> -->
    <tr class="bg-white">
      <td colspan="4" class="justify"><b>Descripción inicial: </b> </td>
    </tr>
    <tr class="bg-white">
      <td colspan="4" class="justify"><b>Comentarios técnico: </b> </td>
      <!-- <td class="center"><b></b></td> -->
    </tr>
    <td colspan="4"><hr class="hr-1"></td>
    <tr>
      <td class="td-title" colspan="2">Terminos y condiciones</td>
      <td colspan="2"></td>
    </tr><br>
    <tr>
      <td colspan="4" class="justify">
        <span>
            <br>Al firmar este documento usted acepta de conformidad lo siguiente:
            <ul>
            <li> Acepta los Términos y Condiciones de los Lineamientos de Uso de las Tecnologías de la Información y Comunicaciones de los Servicios de Salud de Morelos. </li><br>
            <li> En caso de que se haya requerido realizar un respaldo de Información, usted acepta haber autorizado la intervención del Técnico Autorizado Asignado a su equipo a cargo para realizar el respaldo de su información, asi mismo acepta que la cantidad de información que se respaldo, concuerda con los datos antes mencionados en este documento (Apartado de Datos del Respaldo) y es
            la que se le ha entregado.</li>
            </ul><br>
        </span>
        </td>
    </tr>
    <tr class="bg-white center">
      <td colspan="2"><b>Firma del solicitante </b></td>
      <td colspan="2"><b>Firma del supervisor </b></td>
    </tr>
    <tr class="bg-white center">
      <td colspan="2" class="h-50"><b>___________________________<br><span class="name"></span></b></td>
      <td colspan="2" class="h-50"><b>___________________________<br><span class="name"></span> </b></td>
    </tr>
    <td colspan="4"><hr class="hr-1"></td>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="2"></td>
      <td></td>
      <td></td>
    </tr>
  </tfoot>
</table>
</body>
</html>