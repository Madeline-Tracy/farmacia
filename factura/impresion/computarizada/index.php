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
    include($ruta."recursos/qr/qrlib.php");
    require_once '../../../recursos/pdf/mpdf/vendor/autoload.php';

        /******************    SEGURIDAD *************/
        extract($_GET);
        //********* SEGURIDAD GET *************/
        $valor=dcUrl($lblcode);
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

/*************   DEFINE TAMAÑO DE LA PAGINA    */
$dfdet=$facturadet->mostrarTodo("idfactura=$valor");
$alto=(count($dfdet)*9)+220;
        /******************** MPDF ******************* */

    $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

    $ancho=75;//mm
    $mpdf = new \Mpdf\Mpdf(
        [  
        'fontDir' => array_merge($fontDirs, [
                $ruta.'recursos/font/helvetica',
            ]),
            'fontdata' => $fontData + [
                'frutiger' => [
                    'R' => 'Helvetica.ttf',
                    'I' => 'Helvetica-Oblique.ttf',
                    'B' => 'Helvetica-Bold.ttf',
                ]
            ],
            'default_font' => 'frutiger',
            'mode' => 'utf-8', 
            'format' => [$ancho, $alto],
            'margin_top'=>2,
            'margin_left'=>4,
            'margin_right'=>4
        ]
    );
    $html = '
    <div class="tituloh" style="text-align:center">
        '.$nombreG.'
    </div>
    <div class="titulo">
    <b>'.$nsuc.'</b><br>
    '.$dirG.'-'.$zonaG.'<br>
    '.$fonos.'<br>
    '.$nsede.'-BOLIVIA
  </div>
  <div class="tituloh btm">
    FACTURA
  </div>
    <div class="btm">
        <table class="detalle" align="center">
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
        </table>
    </div>
  <div class="titulo btm">
  '.$actividad.'
  </div>
  <div class="detalle btm">
    <b>Fecha : </b>'.$lugarFecha.'<br>
    <b>Hora : </b>'.$dfactura['horacreacion'].'<br>
    <b>Señor(es) : </b>'.$razonT.'<br>
    <b>NIT/CI : </b>'.$nitT.'
  </div>
    <div class="btm">
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
    <div class="btm">
        <table class="detalle" align="center">
            <tr>
                <td width="50%" align="right">SUB TOTAL: </td>
                <td width="50%" align="left"><b>'.number_format($dfactura['totaloriginal'], 2, '.', '').'</b></td>
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
    </div>
    <div class="titulol">
        SON:<b>'.strtoupper(num2letras(number_format($dfactura['total'], 2, '.', '')))." BOLIVIANOS ".'</b><br>
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
  <div class="tituloh">
    <img width="150px" src="'.$urlRelativeFilePath.'" />
  </div>
  <div class="tituloh">
    "ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS. EL USO ILÍCITO DE ÉSTA SERÁ SANCIONADO DE ACUERDO A LEY"</b><br>
    '.$leyenda.'
    
  </div>
  

';
    //==============================================================
    //==============================================================
    //==============================================================

    //$mpdf->SetDisplayMode('fullpage');

    $stylesheet = file_get_contents($ruta.'recursos/css/elisyam-1.5.css');
    $mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no
    $mpdf->SetHTMLFooter('');
    $mpdf->WriteHTML($html);
    $mpdf->Output();

?>