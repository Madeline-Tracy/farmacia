<?php
session_start();
$ruta="../../../";
$folder="";
include_once($ruta."class/dominio.php");
$dominio=new dominio;
include_once($ruta."class/vejecutivo.php");
$vejecutivo=new vejecutivo;
include_once($ruta."class/sede.php");
$sede=new sede;

include_once($ruta."class/invventa.php");
  $invventa=new invventa;
  include_once($ruta."class/invgasto.php");
  $invgasto=new invgasto;  
  include_once($ruta."class/vusuario2.php");
  $vusuario2 =new vusuario2;
  include_once($ruta."class/cierrecaja.php");
  $cierrecaja =new cierrecaja;
  include_once($ruta."class/almacen.php");
  $almacen =new almacen;
  include_once($ruta."class/vusuario2.php");
  $vusuario2 =new vusuario2;

include_once($ruta."class/admsucursal.php");
$admsucursal=new admsucursal;
include_once($ruta."class/miempresa.php");
$miempresa=new miempresa;
include_once($ruta."class/files.php");
$files=new files;
include_once($ruta."class/admdosificacion.php");
$admdosificacion=new admdosificacion;
include_once($ruta."funciones/funciones.php");
require_once($ruta.'recursos/pdf/tcpdf/tcpdf.php');
include($ruta."recursos/qr/qrlib.php"); 
/******************    SEGURIDAD *************/
//******* SEGURIDAD GET *************/
extract($_GET);
$valor=dcUrl($lblcode);
if (!ctype_digit(strval($valor))) {
  if (!isset($_SESSION["faltaSistema"]))
  {  $_SESSION['faltaSistema']="0"; }
  $_SESSION['faltaSistema']=$_SESSION['faltaSistema']+1;
  header('Location: '.$ruta.'login/salir.php');
}
//$dfactura=$factura->muestra($valor);

    $idcierrecaja=dcUrl($lblcode);
    $caci = $cierrecaja->muestra($idcierrecaja);


    $aml = $almacen->muestra($caci['idalmacen']);
    $vu2 = $vusuario2->muestra($caci['idusuariocierre']);
    $usuarioC=$vu2['nombre'].' '.$vu2['paterno'];
$dsuc=$admsucursal->muestra(1);
  $demp=$miempresa->muestra(1);

$dsede=$sede->muestra($dsuc['idsede']);
$dfoto=$files->mostrarUltimo("id_publicacion=".$dsuc['idmiempresa']." and tipo_foto='LogoEmpresa'");

  $lugarFecha=" La Paz,". obtenerFechaLetra($caci['diacierra']);
// **********  obtener organizacion      ***********************************************************/
// logo e info de golden

$rutaImg=$ruta."factura/miempresa/server/php/".$dsuc['idmiempresa']."/".$dfoto['name'];
$nombreG=$demp['nombre'];

$nsuc=$dsuc['nombre'];
$dirG=$dsuc['direccion'];
$zonaG=$dsuc['zona'];
$fonos="Telfs: ".$dsuc['telefonos'];
$nsede=$dsede['nombre'];


// SUCURSAL CASA MATRIZ
$sucMt=$admsucursal->muestra(1);
$nsucM=$sucMt['nombre'];
$dirGM=$sucMt['direccion'];
$zonaGM=$sucMt['zona'];
$fonosM="Telfs: ".$sucMt['telefonos'];
$ds=$sede->muestra(1);
$nsedeM=$ds['nombre'];


//datos de facturacion

// Actualiza cantidad de impresiones



//pie

/***************************************************************************************************/

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf->SetPrintHeader(false);
$pdf->setHeaderData('',0,'','',array(0,0,0), array(255,255,255) );  
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Alvaro Pacheco');
$pdf->SetTitle('FACTURA');
$pdf->SetSubject('SWCGB');
$pdf->SetKeywords('FACTURA');

$pdf->SetMargins(2, 2,2,2);// MARGENES

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/es.php')) {
    require_once(dirname(__FILE__).'/lang/es.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
//$pdf->SetFont('dejavusans', '', 14, '', true);
$pdf->SetFont('helvetica', '', 8);
$pdf->AddPage('','tfactura');
// Add a page
// This method has several options, check the source code documentation for more information.
setlocale(LC_ALL, 'es_ES').': ';
// Set some content to print
$html='
<style>
  .tituloFactura{
    font-size:8px;
    font-weight: bold;
    text-align:center;
  }
  .textoB{
    font-weight: bold;
    font-size:8px;
    text-align:center;
  }

  .textoC{
    font-weight: bold;
    font-size:9px;
    text-align:center;
  }
  .texto{
    font-size:8px;
    text-align:center;
  }

  .textopie{
    font-size:6px;
    text-align:center;
  }
  .textoDET{
    font-size:7px;
    text-align:letf;
  }
  .btm{
    border-bottom: solid 1px black;
  }

  .btmfin{
    border-top: 0;
    height: 2px; text-align: center; background-image: linear-gradient(left, #fff, #000, #fff);
  }
</style>
  <span class="textoB">
    '.$nombreG.'
  </span>
  <div class="texto">
    <b>'.$nsuc.'</b><br>
    '.$dirG.'-'.$zonaG.'<br>
    '.$fonos.'<br>
    '.$nsede.'-BOLIVIA
  </div>
 
  <div class="texto btm">
    <b>Fecha : </b>'.$lugarFecha.'<br>
    <b>Hora : </b>'.$caci['horacreacion'].'<br>

    <b>Punto de venta : </b>'.$aml['nombre'].'<br>
    <b>Cierre caja : </b>'.$vu2['nombre'].' '.$vu2['paterno'].'
  </div>

  <div class="texto btm">
<b> VENTAS </b>
  </div>
  <div class="texto btm">
    <table>
      <tr>
        <td width="10%"><b>COD</b></td>
        <td width="35%"><b>HORA VENTA</b></td>
        <td width="25%"><b>DESC.</b></td>
        <td width="25%"><b>TOTAL</b></td>
      </tr>
      ';
        $totalVenta=0;
        $totalEfectivo=0;
        $totalTarjeta=0;
      foreach($invventa->mostrarTodo("idcierrecaja=".$idcierrecaja) as $f)
      {
        $vu2 = $vusuario2->muestra($f['usuariocreacion']);
        $html=$html.'
        <tr>
          <td class="">'.$f['idinvventa'].'</td>
       
       
          <td class="">'.$f['horacreacion'].'</td>
          <td class="">'.$f['descuento'].' %</td>
          <td class="">'.number_format($f['total'], 2, '.', '').'</td>
        </tr>
        ';
        $totalVenta= $totalVenta+$f['total'];
          $totalEfectivo= $totalEfectivo+$f['efectivo'];
          $totalTarjeta= $totalTarjeta+$f['tarjeta'];
      }
          
      $html=$html.'
      
    </table>
  </div>
  
  <table class="texto btm">
    <tr>
      <td align="right">SUB TOTAL: </td>
      <td align="left"><b>'.number_format($totalVenta, 2, '.', '').'</b></td>
    </tr>
  </table>

  <br>

  <div class="texto btm">
<b> GASTOS </b>
  </div>
<br>
  <div class="texto btm">
    <table>
      <tr>
        <td width="15%"><b>COD. </b></td>
        <td width="25%"><b>USUARIO</b></td>
        <td width="20%"><b>FECHA VENTA</b></td>
        <td width="20%"><b>DESCUENTO</b></td>
        <td width="20%"><b>TOTAL</b></td>
      </tr>
      ';
        $totalGasto=0;
      foreach($invgasto->mostrarTodo("idcierrecaja=".$idcierrecaja) as $f)
      {
       $vu2 = $vusuario2->muestra($f['usuariocreacion']);
        $html=$html.'
        <tr>
          <td class="">'.$f['idinvgasto'].'</td>
          <td colspan="4">'.$vu2['nombre'].'</td>
        </tr>

        <tr>
        <td class=""></td>
          <td class=""></td>
          <td class="">'.$f['fechacreacion'].' '.$f['horacreacion'].'</td>
      <td class="">'.$f['detalle'].'</td>      
      <td class="">'.number_format($f['monto'], 2, '.', '').'</td>
        </tr>
        ';  
        $totalGasto= $totalGasto+$f['monto'];
      }
         

            $montoinicial=floatval($caci['montoinicial']);
            $MontoFinal=$totalEfectivo+$montoinicial - $totalGasto;
            $literal='('.strtoupper(num2letras(number_format($MontoFinal, 2, '.', ''))).' Bolivianos)';
      $html=$html.'
     
    </table>
  </div>
 <table class="texto btm">
    <tr>
      <td align="right">Total Gasto Bs. </td>
      <td align="left"><b>'.number_format($totalGasto, 2, '.', '').'</b></td>
    </tr>
  </table>
 <br>
  <div class="texto btm">
  <b>RESUMEN</b>
  </div>
  <div class="texto btm">
    <table>
      <tr>
        <td width="20%"><b>Monto Incial. </b></td>
        <td width="30%"><b>Total Venta</b></td>
        <td width="25%"><b>Total Efectivo</b></td>
        <td width="25%"><b>Total Tarjeta</b></td>
      </tr>
      <tr>
        <td class="scenter" >'.number_format($montoinicial, 2, '.', '').'</td>
        <td class="scenter" >'.number_format($totalVenta, 2, '.', '').'</td>
        <td class="scenter" >'.number_format($totalEfectivo, 2, '.', '').'</td>
        <td class="scenter" >'.number_format($totalTarjeta, 2, '.', '').'</td>
      </tr>
    </table>
  </div>
  <table class="texto btm">
    <tr>
      <td class="scenter">SON: <b>'.strtoupper(num2letras(number_format($MontoFinal, 2, '.', '')))." BOLIVIANOS ".'</b></td>
    </tr>
  </table>


  ';


// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information. "D"
$pdf->Output('FacturaCod'.$valor.'.pdf', 'I');

 ?>
