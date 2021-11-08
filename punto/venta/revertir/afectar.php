<?php 
	error_reporting(E_ALL);
  	ini_set('display_errors', '1');
	$ruta="../../";
  	$rutaRaiz="../../../";
  	include_once($rutaRaiz."class/invventa.php");
	$invventa=new invventa;
	include_once($rutaRaiz."class/invventadet.php");
	$invventadet=new invventadet;
	include_once($rutaRaiz."class/factura.php");
	$factura=new factura;
	include_once($rutaRaiz."class/facturadet.php");
	$facturadet=new facturadet;
	include_once($rutaRaiz."class/item_almacen.php");
	$item_almacen=new item_almacen;
	include_once($rutaRaiz."class/admsucursal.php");
	$admsucursal=new admsucursal;
	extract($_POST);
	session_start();	
	$ven=$invventa->muestra($idventa);
	$idsucursal=$ven['idsucursal'];
	$fecha=date("Y-m-d");
	$hora=date("H:i:s");

		//cambio de ventas anuladas y reponer la cantidad descontado
		foreach($invventadet->mostrarTodo("idventa=".$idventa." and estado=1") as $vede)
		{
		   $ital=$item_almacen->mostrarUltimo("idalmacen=".$idsucursal." and iditem=".$vede['iditem']);
		   $existenciaNuevo=$ital['existencias']+$vede['cantidad'];
           $valor2=array(
				"existencias"=>"'$existenciaNuevo'"
			);
           if ($item_almacen->actualizar($valor2,$ital['iditem_almacen']))
           {
           		   $valor3=array(
				     "estado"=>"'2'"
					);
		           $invventadet->actualizar($valor3,$vede['idinvventadet']);
           }
          
		}		

	/********************************************************************************/
	$valor5=array(
					"fechanul"=>"'$fecha'",
					"estado"=>"'2'"
				);
	if ($invventa->actualizar($valor5,$idventa)) 
	{		    
		?>
			<script  type="text/javascript">
		        swal({
	              title: "Exito",
	              text: "Venta anulada corectamente",
	              type: "success",
	              showCancelButton: false,
	              confirmButtonColor: "#16c103",
	              confirmButtonText: "OK",
	              closeOnConfirm: false,
	              closeOnCancel: false
	            },
	            function(isConfirm){
	              if (isConfirm) {
	                location.reload();
	              }
	            });
			</script>
		<?php

	}else{
		?>
			<script type="text/javascript">
				Materialize.toast('<span>No se pudo anular intente de nuevo</span>', 1500);
			</script>
		<?php		
	}

if ($ven['esfactura']==1) 
{
	//cambio de estado de facruras anuladas
	$fac=$factura->mostrarUltimo("idtabla=".$idventa." and tipotabla='VENTA' and estado=1");

		foreach($facturadet->mostrarTodo("idfactura=".$fac['idfactura']." and estado=1") as $vede)
		{
		   	   $valor4=array(
				     "estado"=>"'2'"
					);
		        $facturadet->actualizar($valor4,$vede['idfacturadet']);		          
		    
		}
       $valor6=array(
			"fechanul"=>"'$fecha'",
			"estado"=>"'2'"
		);
       $factura->actualizar($valor6,$fac['idfactura']);
}
	 
	
?>