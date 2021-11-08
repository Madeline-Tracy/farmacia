<?php 
	error_reporting(E_ALL);
  	ini_set('display_errors', '1');
	$ruta="../../";
  	$rutaRaiz="../../";
  	include_once($rutaRaiz."class/invgasto.php");
	$invgasto=new invgasto;
	include_once($rutaRaiz."class/admsucursal.php");
	$admsucursal=new admsucursal;
	extract($_POST);
	session_start();
	$dsuc=$admsucursal->muestra($idsucursal);
	$nrogasto=$dsuc['nrogasto']+1;
	if (!isset($idinterno)) {
		$idinterno=0;
	}
	$montototal=floatval($idcantidad) * intval($idmonto);
	$fecha=date("Y-m-d");
	$hora=date("H:i:s");
	/********************************************************************************/
	//guardacliente
    $valcliente=array(
		"idsucursal"=>"'$idsucursal'",
		"fecha"=>"'$fecha'",
		"nro"=>"'$nrogasto'",
		"recibo"=>"'$idrecibo'",
		"detalle"=>"'$iddetalle'",
		"cantidad"=>"'$idcantidad'",
		"montounid"=>"'$idmonto'",
		"monto"=>"'$montototal'",
		"interno"=>"'$idinterno'",
		"obs"=>"'$iddesc'",
		"estado"=>"'1'"
	);
	if ($invgasto->insertar($valcliente)) {
		$valores=array(
		    "nrogasto"=>"'$nrogasto'",
		);
		$admsucursal->actualizar($valores,$idsucursal);
		?>
			<script  type="text/javascript">
		        swal({
	              title: "Exito",
	              text: "Gasto registrado correctamente",
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
				Materialize.toast('<span>No se pudo guardar el cliente</span>', 1500);
			</script>
		<?php		
	}
	
?>