<?php
  error_reporting(E_ALL);
  ini_set('display_errors', '1');
  session_start();

  $ruta="../../web-admin/";
  $rutaRaiz="../../";
  include_once($rutaRaiz."class/item_almacen.php");
  $item_almacen=new item_almacen;
  include_once($rutaRaiz."class/vitem.php");
  $vitem=new vitem;  
  include_once($rutaRaiz."class/vusuario2.php");
  $vusuario2 =new vusuario2;
  include_once($rutaRaiz."class/cierrecaja.php");
  $cierrecaja =new cierrecaja;
  include_once($rutaRaiz."class/almacen.php");
  $almacen =new almacen;
  include_once($rutaRaiz."class/vusuario2.php");
  $vusuario2 =new vusuario2;
  include_once($rutaRaiz."class/invventadet.php");
  $invventadet=new invventadet;
  //include_once($rutaRaiz."class/invitem.php");
  //$invitem=new invitem;
  //include_once($rutaRaiz."class/almacen.php");
  //$almacen=new almacen;
  include_once($rutaRaiz."class/miempresa.php");
  $miempresa=new miempresa;
  include_once($rutaRaiz."class/admsucursal.php");
  $admsucursal=new admsucursal;
  include_once($rutaRaiz."class/files.php");
  $files=new files;


  include_once($rutaRaiz."funciones/funciones.php");


  require_once($rutaRaiz.'recursos/pdf/tcpdf/tcpdf.php');
  include($rutaRaiz."recursos/qr/qrlib.php"); 
  /******************    SEGURIDAD *************/
  //******* SEGURIDAD GET *************/
  extract($_GET);
    $idalmacen=dcUrl($lblcode);
    $fechaactual=date('Y-m-d');
    $horaactual=date('H:i:s');
   // $aml = $almacen->muestra($idalmacen);

  $datosalmacen = $almacen ->muestra($idalmacen);
  $lblcode2=ecUrl($datosalmacen['idalmacen']);


  $dsuc=$admsucursal->muestra(1);
  $demp=$miempresa->muestra(1);

  $nombreG=$demp['nombre'];

  $nsuc=$dsuc['nombre'];
  $dirG=$dsuc['direccion'];
  $zonaG=$dsuc['zona'];
  $fonos="Telfs: ".$dsuc['telefonos'];
  $nsede="La Paz ";
  // **********  obtener organizacion  ***********************************************************/
  // logo e info de golden

  $dfoto=$files->mostrarUltimo("id_publicacion=1 and tipo_foto='LogoEmpresa'");
  $rutaImg=$rutaRaiz."factura/miempresa/server/php/1/".$dfoto['name'];



/***************************************************************************************************/

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf->SetPrintHeader(false);
$pdf->setHeaderData('',0,'','',array(0,0,0), array(255,255,255) );  
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Julio Vargas desarrollo.julio@gmail.com');
$pdf->SetTitle('RECIBO');
$pdf->SetSubject('SWCGB');
$pdf->SetKeywords('JULIO VARGAS');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
$pdf->AddPage('','A4');
// Add a page
// This method has several options, check the source code documentation for more information.
setlocale(LC_ALL, 'es_ES').': ';
// Set some content to print
$html=' <br><br>
<style>
.tituloFactura{
  font-size:12px;
  font-weight: bold;
}
.tituloCenda{
  color:red;
}
.letras{
  font-size:7px;
}
.letras1{
  font-size:8px;
}
.letras2{
  font-size:14px;
}
.letras3{
  font-size:8px;
}
</style>
<table width="100%"  align="center">
          <tr>
            <td width="40%" class="letras">
              <center>
                <img width="100px;" src="'.$rutaImg.'" ><br>
                <b>'.$nombreG.'</b><br>
                ';
                $html=$html.'

                <b>'.$nsuc.'</b><br>
                '.$dirG.'-'.$zonaG.'<br>
                '.$fonos.'<br>
                '.$nsede.'-BOLIVIA
              </center>
            </td>
            <td width="30%"><br><br>
              <div class="tituloFactura">Reporte de existencias de Almacen</div>
            </td>
            <td width="30%"><br><br>
              <table border="1">
                <tr>
                  <td>
                    <table class="letras1" cellpadding="1">
                      <tr>
                        <td align="right">
                          FECHA:
                        </td>
                        <td align="left">
                          <b>'.$fechaactual.'</b>
                        </td>
                      </tr>
                      <tr>
                        <td align="right">
                          HORA:
                        </td>
                        <td align="left">
                          <b>'.$horaactual.'</b>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>';
        $pdf->SetFont('helvetica', '', 10);
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$html='
<style>
.tituloCenda{
  text-align:center;
  font-weight: bold;
  font-size:10px;
}
.sMoneda{
  text-align: right;
}
.scenter{
  text-align: center;
}
.sfila{
  border-right: solid 1px #fff;
  border-bottom: solid 1px #606060;
  border-left: solid 1px #fff;
}
.letras{
  font-size:6px;
  text-align: center;
}
.letras3{
  font-size:7px;
}
.letras4{
  font-size:8px;
}
.letras5{
  font-size:9px;
}
.cabeceraCentro{
  padding: 1px;
  border-top: solid 1px white;
  border-bottom: solid 1px white;
}
.cabecera2{
  border-top: solid 1px #606060;
  border-bottom: solid 1px #606060;
  font-weight: bold;
}
.cabecera3{
  border-top: solid 1px #606060;
  border-bottom: solid 1px #606060;
  border-left: solid 1px #606060;
  border-right: solid 1px #606060;
}
.cabecera4{
  border-top: solid 1px #606060;
  border-bottom: solid 1px #606060;
  border-left: solid 1px #606060;
  border-right: solid 1px #606060;
  margin-top: 20px;
}
.tabla{
  border-top: solid 1px #606060;
  border-bottom: solid 1px #606060;
  border-left: solid 1px #606060;
  border-right: solid 1px #606060;
}
</style>';
$html=$html.'
<table width="100%">
  <tr style="text-align:center; font-size:15px;">
    <td width="100%"><b>ALMACEN: </b>'.$datosalmacen['nombre'].'</td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td width="100%"><b>EXISTENCIAS EN EL ALMACEN </b></td>
  </tr>
</table>
';

  $html=$html.'
  <br>
<table  width="100%" class="tabla">
  <tr style="background-color:#f2f2f2; border:none;">
    <td class="cabecera4 tituloCenda tituloCenda" width="10%"><b>Codigo</b></td>
    <td class="cabecera4 tituloCenda" width="40%"><b>Item</b></td>
    <td class="cabecera4 tituloCenda" width="15%"><b>Marca</b></td>
    <td class="cabecera4 tituloCenda" width="20%"><b>Tipo</b></td>
    <td class="cabecera4 tituloCenda" width="15%"><b>Existencia</b></td>
  </tr>
  <tr>
    <td class=""></td>
    <td class=""></td>
  </tr>';
          switch ($datosalmacen['tipo_almacen']) {
                
                
                 case '1':
                        $condicion="tipouso in(2)";
                  break;
                 case '2':
                      $condicion="tipouso in(1)";
                  break; 
                  case '3':
                      $condicion="tipouso in(1,2)";
                  break;
              } 
  foreach($vitem->mostrarTodo($condicion) as $f)
  {
   $datoIA=$item_almacen->mostrarUltimo("idalmacen=".$idalmacen." and iditem=".$f['idvitem']);
    $html=$html.'
    <tr style="font-size:8px;">
      <td class="scenter">'.$f['idvitem'].'</td>
      <td class="">'.$f['nombre'].'</td>
      <td class="scenter">'.$f['marca'].'</td>    
      <td class="">'.$f['tipo'].'</td>
      <td class="sMoneda">'.$datoIA['existencias'].'</td>
    </tr>';
  }  
  $html=$html.'
    <tr>
      <td class=""></td>
      <td class=""></td>
    </tr>
    <tr style="background-color:#f2f2f2; border:none;">
        <td class="cabecera4 sMoneda"></td>
        <td class="cabecera4 sMoneda"></td>
        <td class="cabecera4 sMoneda"></td>
        <td class="cabecera4 sMoneda"></td>
        <td class="cabecera4 sMoneda"></td>
      </tr>
  </table>
  <br>';

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// Close and output PDF document
// This method has several options, check the source code documentation for more information. "D"
$pdf->Output('Cierre de caja-'.$idalmacen.'.pdf', 'I');

 ?>
