<?php
	$ruta="../../../";
	include_once($ruta."class/invitem.php");
	$invitem=new invitem;
	include_once($ruta."funciones/funciones.php");
	
	extract($_POST);
	session_start();
    /*********** actualiza contrato  ***********/
	$fecha=date("Y-m-d");
	$hora=date("H:i:s");
    $valores=array(
		"nombre"=>"'$idnombre'",
		"codigo"=>"'0'",
		"precio"=>"'$idprecio'",
		"idmarca"=>"'$idmarca'",
		"tipoitem"=>"'$idtipoitem'",
		"tipouso"=>"'$idtipouso'",
		"idtipoproducto"=>"'$idtipoproducto'",
		"cantidad"=>"'0'",
		"descripcion"=>"'$iddesc'"
	);
	if ($invitem->insertar($valores)) {
		/******** Se debera insertar contrato detalle *********/
		$ditem=$invitem->mostrarUltimo("nombre='$idnombre' and precio='$idprecio'");
		$iditem=$ditem['idinvitem'];
		$lblcode=ecUrl($iditem);
			?>
			<script  type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Datos guardados correctamente",
					type: "success",
					showCancelButton: false,
					confirmButtonColor: "#28e29e",
					confirmButtonText: "OK",
					closeOnConfirm: false
		        }, function () {  
		            location.href="../editar/?lblcode=<?php echo $lblcode ?>";
		        });
			</script>
		<?php
	}else{
		?>
		<script type="text/javascript">
			swal("ERROR!", "No se guardo", "error")
		</script>
		<?php		
	}
    
?>