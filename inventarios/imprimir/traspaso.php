<?php
  error_reporting(E_ALL);
  ini_set('display_errors', '1');
  session_start();

  $ruta="../../web-admin/";
  $rutaRaiz="../../";
  include_once($rutaRaiz."class/traspaso.php");
  $traspaso=new traspaso;
  include_once($rutaRaiz."class/traspasodet.php");
  $traspasodet=new traspasodet; 
  include_once($rutaRaiz."class/vitem.php");
  $vitem=new vitem;

  include_once($rutaRaiz."class/invventa.php");
  $invventa=new invventa;
  include_once($rutaRaiz."class/invgasto.php");
  $invgasto=new invgasto;  
  include_once($rutaRaiz."class/vusuario2.php");
  $vusuario2 =new vusuario2;
  include_once($rutaRaiz."class/cierrecaja.php");
  $cierrecaja =new cierrecaja;
  include_once($rutaRaiz."class/almacen.php");
  $almacen =new almacen;
  include_once($rutaRaiz."class/vusuario2.php");
  $vusuario2 =new vusuario2;
  //include_once($rutaRaiz."class/invventadet.php");
  //$invventadet=new invventadet;
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
   $idtraspaso=dcUrl($lblcode);
    $fechaactual=date('Y-m-d');
    $horaactual=date('H:i:s');
    $tra = $traspaso->muestra($idtraspaso);
    $almO = $almacen->muestra($tra['idalmacenorigen']);
    $almD = $almacen->muestra($tra['idalmacendest']);
    $vu2 = $vusuario2->muestra($tra['usuariocreacion']);
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

 // $lugarFecha=" La Paz,". obtenerFechaLetra($caci['diacierra']).' Hrs.'.$caci['horacierra'];



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
                <img width="100px" src="'.$rutaImg.'" ><br>
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
              <div class="tituloFactura"></div>
            </td>
            <td width="30%"><br><br>
              <table border="1">
                <tr>
                  <td>
                    <table class="letras1" cellpadding="1">
                      <tr>
                        <td align="right">
                          Fecha Impresión:
                        </td>
                        <td align="left">
                          <b>'.$fechaactual.'</b>
                        </td>
                      </tr>
                      <tr>
                        <td align="right">
                          Hora impresión:
                        </td>
                        <td align="left">
                          <b>'.$horaactual.'</b>
                        </td>
                      </tr>
                      <tr>
                        <td align="right">
                          Fecha traspaso:
                        </td>
                        <td align="left">
                          <b>'.$tra['fechacreacion'].'</b>
                        </td>
                      </tr>
                      <tr>
                        <td align="right">
                          Hora traspaso:
                        </td>
                        <td align="left">
                          <b>'.$tra['horacreacion'].'</b>
                        </td>
                      </tr>
                      <tr>
                        <td align="right">
                          Usuario Traspaso:
                        </td>
                        <td align="left">
                          <b>'.$vu2['usuario'].'</b>
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
  <tr style="text-align:center; font-size:13px;">
    <td width="100%"><b>TRASPASO DE ITEMS DE ALMACEN </b></td>
  </tr>
</table>
<table width="100%">
  <tr style="text-align:center; font-size:13px;">
    <td width="100%"><b>'.$almO['nombre'].' A '.$almD['nombre'].'</b></td>
  </tr>
</table>
<br><br>
  <table  width="100%" class="tabla">
  <tr style="background-color:#f2f2f2; border:none;">
    <td class="cabecera4 " width="50%"><b>Item</b></td>
    <td class="cabecera4 " width="30%"><b>Marca</b></td>
    <td class="cabecera4 tituloCenda" width="20%"><b>Cantidad Trapaso</b></td>
  </tr>';
 foreach($traspasodet->mostrarTodo("idtraspaso=".$idtraspaso) as $f)
  {
    $vit = $vitem->muestra($f['iditem']);
    $html=$html.'
    <tr>
      <td class="">'.$vit['nombre'].'</td>
      <td class="">'.$vit['marca'].'</td>
      <td class="scenter">'.$f['cantidad'].'</td>
    </tr>';
  }

  $html=$html.'
      <tr style="background-color:#f2f2f2; border:none;">
        <td class="cabecera4 " width="50%"><b></b></td>
        <td class="cabecera4 " width="30%"><b></b></td>
        <td class="cabecera4 tituloCenda" width="20%"><b></b></td>
      </tr>
  </table>';

  //piede pagina

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// Close and output PDF document
// This method has several options, check the source code documentation for more information. "D"
$pdf->Output('TRASPASO-'.$idtraspaso.'.pdf', 'I');

 ?>
