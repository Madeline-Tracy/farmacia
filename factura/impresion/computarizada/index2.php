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
include_once($ruta."class/factura.php");
$factura=new factura;
include_once($ruta."class/facturadet.php");
$facturadet=new facturadet;
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
$dfactura=$factura->muestra($valor);

$dsuc=$admsucursal->muestra($dfactura['idsucursal']);

$imgSinV="";
if ($dfactura['esprueba']==1) {
  $imgSinV='<img width="200px" src="'.$ruta.'imagenes/SinValor.png" />';
}

$demp=$miempresa->muestra($dsuc['idmiempresa']);
$dsede=$sede->muestra($dsuc['idsede']);
$dfoto=$files->mostrarUltimo("id_publicacion=".$dsuc['idmiempresa']." and tipo_foto='LogoEmpresa'");

$ddos=$admdosificacion->mostrarUltimo("idadmdosificacion=".$dfactura['iddosificacion']);
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
$nitgolden=$demp['nit'];
$autorizacion=$ddos['autorizacion'];
$nrofactura=$dfactura['nro'];
$actividad=$dsuc['actividad'];

if ($dfactura['impresion']==0) {
	$dtipo="ORIGINAL";
}else{
	$dtipo="COPIA";
}
// Actualiza cantidad de impresiones
$valFactura=array(
  "impresion"=>$dfactura['impresion']+1
);  
$factura->actualizar($valFactura,$valor);

// cabecera factura
$lugarFecha=$dfactura['fecha'];
$matricula=$dfactura['matricula'];

$razonT="ERROR";
$nitT="ERROR";
$razonT=$dfactura['razon'];
$nitT=$dfactura['nit'];


//pie
$fechca = date_create($ddos['fechalimite']);
$fechaQr=date_format($fechca, 'd/m/Y');

$control=$dfactura['control'];
$fechalimite=$fechaQr;
$leyenda=$ddos['leyenda'];



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
  <div class="tituloFactura btm">
    FACTURA
  </div>
    <table class="texto btm">
      <tr>
        <td align="right">NIT :</td>
        <td align="left"><b>'.$nitgolden.'</b></td>
      </tr>
      <tr>
        <td align="right">FACTURA Nº :</td>
        <td align="left"><b>'.$nrofactura.'</b></td>
      </tr>
      <tr>
        <td align="right">AUTORIZACIÓN:</td>
        <td align="left"><b>'.$autorizacion.'</b></td>
      </tr>
    </table><br>
  <div class="texto btm">
  '.$actividad.'
  </div>
  <div class="texto btm">
    <b>Fecha : </b>'.$lugarFecha.'<br>
    <b>Hora : </b>'.$dfactura['horacreacion'].'<br>
    <b>Señor(es) : </b>'.$razonT.'<br>
    <b>NIT/CI : </b>'.$nitT.'
  </div>
  <div class="texto btm">
    <table>
      <tr>
        <td width="15%"><b>COD. </b></td>
        <td width="25%"><b>DETALLE</b></td>
        <td width="20%"><b>CANT.</b></td>
        <td width="20%"><b>UNIT.</b></td>
        <td width="20%"><b>IMPORTE</b></td>
      </tr>
      ';
      foreach($facturadet->mostrarTodo("idfactura=$valor") as $f)
      {
        $subtotal=$f['precio']*$f['cantidad'];
        $html=$html.'
        <tr>
          <td class="">'.$f['codigo'].'</td>
          <td colspan="4" class="textoDET">'.$f['detalle'].'</td>
        </tr>
        <tr>
          <td class=""></td>
          <td class=""></td>
          <td class="">'.$f['cantidad'].'</td>
          <td class="">'.number_format($f['precio'], 2, '.', '').'</td>
          <td class="">'.number_format($subtotal, 2, '.', '').'</td>
        </tr>
        ';
      }
      $html=$html.'
    </table>
  </div>
  
  <table class="texto btm">
    <tr>
      <td align="right">SUB TOTAL: </td>
      <td align="left"><b>'.number_format($dfactura['totaloriginal'], 2, '.', '').'</b></td>
    </tr>
    <tr>
      <td align="right">DESCUENTO: </td>
      <td align="left"><b>'.$dfactura['descuento'].' %</b></td>
    </tr>
    <tr>
      <td align="right">TOTAL FACTURA: </td>
      <td align="left"><b>'.number_format($dfactura['efectivo'], 2, '.', '').'</b></td>
    </tr>
    <tr>
      <td align="right">TOTAL TARJETA: </td>
      <td align="left"><b>'.number_format($dfactura['tarjeta'], 2, '.', '').'</b></td>
    </tr>
    <tr>
      <td align="right">CAMBIO:</td>
      <td align="left"><b>'.number_format($dfactura['cambio'], 2, '.', '').'</b></td>
    </tr>
  </table>
  <div class="textoC">
    SON:<b>'.strtoupper(num2letras(number_format($dfactura['total'], 2, '.', '')))." BOLIVIANOS ".'<br>
    Código de Control: <b>'.$control.'</b><br>
	  Fecha Límite de Emisión: <b>'.$fechalimite.'</b>
  </div>


  ';
  $fechca = date_create($dfactura['fecha']);
    $fechaQr=date_format($fechca, 'd/m/Y');
    $costototal=$dfactura['total'];
    $codeContents = $nitgolden.'|'.$nrofactura.'|'.$autorizacion.'|'.$fechaQr.'|'.number_format($dfactura['total'], 2, '.', '').'|'.number_format($dfactura['total'], 2, '.', '').'|'.$control.'|'.$nitT.'|0|0|0|0'; 
     
    // we need to generate filename somehow,  
    // with md5 or with database ID used to obtains $codeContents... 
    $fileName = 'qr/'.$valor.'.png'; 
     
    $pngAbsoluteFilePath = $fileName; 
    $urlRelativeFilePath = $fileName; 
    if (!file_exists($pngAbsoluteFilePath)) { 
        QRcode::png($codeContents, $pngAbsoluteFilePath, QR_ECLEVEL_L, 3);
    }
$html.='
  <div class="texto">
    <img width="90px" src="'.$urlRelativeFilePath.'" />
  </div>
  <div class="textopie">
    "ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS. EL USO ILÍCITO DE ÉSTA SERÁ SANCIONADO DE ACUERDO A LEY"</b><br>
    '.$leyenda.'
    
  </div>
  

';


// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information. "D"
$pdf->Output('FacturaCod'.$valor.'.pdf', 'I');

 ?>
