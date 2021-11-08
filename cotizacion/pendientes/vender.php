<?php
session_start();
$ruta="../../";
include_once($ruta."class/invitem.php");
$invitem=new invitem;
include_once($ruta."class/invpedido.php");
$invpedido=new invpedido;
include_once($ruta."class/invpedidodetalle.php");
$invpedidodetalle=new invpedidodetalle;
include_once($ruta."class/invmovimiento.php");
$invmovimiento=new invmovimiento;
include_once($ruta."class/invcliente.php");
$invcliente=new invcliente;


include_once($ruta."class/factura.php");
$factura=new factura;
include_once($ruta."class/facturadet.php");
$facturadet=new facturadet;
include_once($ruta."class/admsucursal.php");
$admsucursal=new admsucursal;
include_once($ruta."class/admdosificacion.php");
$admdosificacion=new admdosificacion;

require_once($ruta."funciones/codigo.php");
include_once($ruta."funciones/funciones.php");

extract($_POST);
$dped=$invpedido->muestra($ped);
$dcli=$invcliente->muestra($dped['idcliente']);

  $fecha=date("Y-m-d");


  $valores2 = array( 
    "estado" =>"'VENDIDO'" 
  );
  $invpedido->actualizar($valores2,$ped); 


    /*****************************************************************************************************************/
    /********************  OPREACION PARA INSERTAR A FACTURACION *****************************************************/
    

    $dsuc=$admsucursal->mostrarUltimo("idsede=1");
    $esprueba=$dsuc['esprueba']; 
    $idsucursal=$dsuc['idadmsucursal'];
    $ddos=$admdosificacion->mostrarUltimo("idadmsucursal=".$idsucursal." and estado=1");
    $iddosificacion=$ddos['idadmdosificacion'];
    echo $iddosificacion."---";
    $nro=$ddos['nro'];
    $idtabla=$ped;
    $tipotabla="CART";

    
    $matricula="";
    $total=$dped['costo'];
    /*************************************************************************************************/
    $numAut=$ddos['autorizacion'];
    $numFactura=$nro;
    $nitCli=$dcli['nit'];
    $razonCli=$dcli['razon'];
    $idmonto=$dped['costo'];
    $fTransaccion=$fecha;
    $date = date_create($fTransaccion);
    $fTransaccion=date_format($date, 'Y-m-d');
    $fTransaccion=str_replace("-", "", $fTransaccion);
    $llave=$ddos['llave'];
    // datos antes de ingresar a facturacion
    /*
    echo "\n"."numAut-> ".$numAut."\n";
    echo "numFactura-> ".$numFactura."\n";
    echo "nitCli-> ".$nitCli."\n";
    echo "fTransaccion-> ".$fTransaccion."\n";
    echo "monto-> ".round($idmonto)."\n";
    echo "llave-> ".$llave."\n";
    */
    /********************************* GENERANDO CODIGO DE CONTROL ***********************************/
    $clsControl = new CodigoControl($numAut,$numFactura,$nitCli,$fTransaccion,round($idmonto),$llave);
    $codigoControl = $clsControl->generar();
    /*************************************************************************************************/
    $val3=array(
      "idsucursal"=>"'$idsucursal'",
      "iddosificacion"=>"'$iddosificacion'",
      "idtabla"=>"'$idtabla'",
      "tipotabla"=>"'$tipotabla'",
      "nro"=>"'$numFactura'",
      "fecha"=>"'$fecha'",
      "matricula"=>"'$matricula'",
      "nit"=>"'$nitCli'",
      "razon"=>"'$razonCli'",
      "total"=>"'$idmonto'",
      "control"=>"'$codigoControl'",
      "impresion"=>"'0'",
      "esprueba"=>$esprueba,
      "estado"=>"'1'",
    );  
    if($factura->insertar($val3)){
      $fdet=$factura->mostrarUltimo("idtabla=$idtabla and tipotabla='".$tipotabla."'");
      $idfactura=$fdet['idfactura'];
      //actualiza numero de factura
      $valFactura=array(
        "nro"=>$numFactura+1
      );  
      $admdosificacion->actualizar($valFactura,$iddosificacion);


      foreach($invpedidodetalle->mostrarTodo("idpedido=".$ped) as $m)
      {
        $ditem=$invitem->muestra($m['idproducto']);

        $detalle=$ditem['nombre'];
        $cantidad=$m['cantidad'];
        $precio=$m["precio"];
        $estado=1;
        $val4=array(
          "idfactura"=>"'$idfactura'",
          "iditem"=>$m['idproducto'],
          "codigo"=>$ditem['codigo'], 
          "detalle"=>"'$detalle'",
          "cantidad"=>"'$cantidad'",
          "precio"=>"'$precio'",
          "estado"=>"'$estado'"
        );  
        $facturadet->insertar($val4);

        $cantidadtotal=$ditem['cantidad']-$m['cantidad'];
        $valores = array( 
          "tipo_movimiento" =>"'E'",
          "cantidad_movimiento" =>$m['cantidad'],  
          "saldoCantidad" =>"'$cantidadtotal'",
          "precio_venta" =>$m["precio"],  
          "idproveedor" =>"'0'",   
          "idproducto" =>$m['idproducto'],     
          "motivo"=>"'VENTA'"
        );
        if ($invmovimiento->insertar($valores)) 
        {
          $valores1 = array( 
            "cantidad" =>"'$cantidadtotal'" 
          );
          $invitem->actualizar($valores1,$m['idproducto']); 
        }
      }
      $lblcode=ecUrl($idfactura);
      ?>
        <script  type="text/javascript">
          swal({
            title: "Factura:  <?php echo $numFactura ?>",
            text: "Selecciona el modo de impresion de la factura",
            type: "warning",
            showCancelButton: false,
            confirmButtonColor: "#16c103",
            confirmButtonText: "Computarizada",
            cancelButtonText: "P.O.S.",
            confirmButtonClass: 'btn green',
            cancelButtonClass: 'btn red',
            closeOnConfirm: false,
            closeOnCancel: false
          },
          function(isConfirm){
            if (isConfirm) {
              location.reload();
              window.open("../../factura/impresion/computarizada/?lblcode=<?php echo $lblcode ?>","_blank");
            } else {
              location.reload();
            }
          });
        </script>
      <?php
    }


    

?>
