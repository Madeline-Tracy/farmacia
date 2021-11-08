<?php
	$ruta="../../";
	include_once($ruta."class/invitem.php");
	$invitem=new invitem;

	include_once($ruta."funciones/funciones.php");
	
	extract($_POST);
	session_start();
    /*********** actualiza contrato  ***********/
	$fecha=date("Y-m-d");
	$hora=date("H:i:s");
	$precio=number_format($idprecio, 2, '.', '').' Bs.-';
$valores=array(
		"precio"=>"'$idprecio'",
		"idliname"=>"'$idli'"
	);

	if ($invitem->actualizar($valores,$iditem))
	{
			?>
			<script type="text/javascript">
			swal({
				title: "Exito !!!",
				text: "Actualizado Correctamente",
				type: "success",
				showCancelButton: false,
				confirmButtonColor: "#28e29e",
				confirmButtonText: "OK",
				closeOnConfirm: true
	          }, function () {
				 $("#<?php echo $iditem.'precio' ?>").text('<?php echo $precio ?>');
	          });
			</script>
		<?php
	}else{
		?>
		<script type="text/javascript">
			Materialize.toast('<span>No se pudo actualizar el registro</span>', 1500);
		</script>
		<?php
	}
?>