<?php
session_start();
$ruta="../../";
include_once($ruta."class/invpedidodetalle.php");
$invpedidodetalle=new invpedidodetalle;

include_once($ruta."class/invpedido.php");
$invpedido=new invpedido;

include_once($ruta."class/invitem.php");
$invitem=new invitem;
include_once($ruta."class/files.php");
$files=new files;

include_once($ruta."class/invcliente.php");
$invcliente=new invcliente;

include_once($ruta."class/persona.php");
$persona=new persona;

require_once($ruta.'recursos/pdf/tcpdf/tcpdf.php');

extract($_GET);

$ped=$invpedido->mostrarTodo("idcliente=".$idcliente);
$ped=array_shift($ped);
$cotizacion=$ped['idinvpedido'];

$dVenta=$invpedido->mostrar($cotizacion);
$dVenta=array_shift($dVenta);

$cli=$invcliente->mostrar($idcliente);
$cli=array_shift($cli);
$per=$persona->mostrar($cli['idpersona']);
$per=array_shift($per);


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf->SetPrintHeader(false);
$pdf->setHeaderData('',0,'','',array(0,0,0), array(255,255,255) );  
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Julio Vargas');
$pdf->SetTitle('SOLICITUD DE PEDIDO');
$pdf->SetSubject('SFV');
$pdf->SetKeywords('SOLICITUD DE PEDIDO');


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
$pdf->AddPage('L','A4');
// Add a page
// This method has several options, check the source code documentation for more information.


// Set some content to print
$html=' 
<style>
.tituloFactura{
  font-size:12px;
}
.tituloCenda{
  color:red;
}
</style>
<table width="100%" align="center">
                  <tr>
                    <td>
                      <center>
                        <img src="../../imagenes/logo.png"  width="110" height="40">
                        
                        <div>DIRECCION</div>
                        <b>Telefono: </b>2222548 - 70654115 <br>
                        <b>Mail: </b>librosgye@gmail.com
                      </center>
                    </td>
                    <td><br><br><br>
                    <div class="tituloFactura">FORMULARIO DE COTIZACION</div><br>
                    <div class="tituloFactura">Cliente: '.$per['nombre'].' '.$per['paterno'].' '.$per['materno'].'</div>

                    </td>
                    <td>
                      <table>
                        <tr>
                          <td align="right">
                            Nº Cotización :
                          </td>
                          <td align="left">
                            <b>'.$cotizacion.'</b>
                          </td>
                        </tr>
                      </table><br>
                      <br>
                    </td>
                  </tr>
                </table';
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
  padding:50px;
}
</style>

        <table border="1" width="704">
  <tr>
    <td class="tituloCenda" width="150">
      Imagen
    </td>
    <td class="tituloCenda" width="300">
      Concepto
    </td>
    <td class="tituloCenda" width="88">Costo Un.</td>
    <td class="tituloCenda" width="88">Cantidad</td>
    <td class="tituloCenda" width="88">Subtotal</td>
  </tr>';
  $costototal=0;
  foreach($invpedidodetalle->mostrarTodo("idpedido=".$cotizacion) as $m)
  { 
    $dProducto=$invitem->mostrar($m['idproducto']);
    $dProducto=array_shift($dProducto);
    $subtotal=$m['cantidad']*$m["precio"];
    $costototal=$costototal+$subtotal;


    $df=$files->mostrarUltimo("id_publicacion=".$m['idproducto']." and tipo_foto='fotoItemInventarios'");
    $rutaFoto="../../inventarios/item/editar/server/php/".$m['idproducto']."/".$df['name'];
    

   $html=$html.'
     <tr class="sfila">
       <td>
       	<img src="'.$rutaFoto.'"  width="100px">
       </td>
       <td>'.$dProducto['nombre'].'</td>
       <td class="scenter">'.$dProducto['precio'].'</td>
       <td class="scenter">'.$m["cantidad"].'</td>
       <td class="scenter">'.number_format($subtotal, 2, '.', '').'</td>
     </tr>';
  }
  $html=$html.'
<tr>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
  <td class="scenter">TOTAL</td>
  <td class="sMoneda">'.number_format($costototal, 2, '.', '').'</td>
</tr>
 </table>
';
  $html=$html."
<br><br>Nota: Todas nuestras cotizaciones incluyen factura. <br>
Esta Cotizacion queda vigente por los proximos 15 dias.
";


// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information. "D"
$pdf->Output('Factura'.$dVenta['idpedido'].'.pdf', 'I');
//echo "hola";
echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";

 ?>
