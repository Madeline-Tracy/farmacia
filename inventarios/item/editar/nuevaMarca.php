<?php
	$ruta="../../../";
	include_once($ruta."class/marca.php");
	$marca=new marca;

	include_once($ruta."funciones/funciones.php");
	extract($_POST);
	session_start();
    /*********** actualiza contrato  ***********/
    $idNmarca=strtoupper($idNmarca);
    $idNdesc=strtoupper($idNdesc);
    $valores=array(
		"nombre"=>"'$idNmarca'",
		"descripcion"=>"'$idNdesc'"
	);
	if ($marca->insertar($valores)) {
		$dmar=$marca->mostrarUltimo("nombre='".$idNmarca."'");
	    $idmarca=$dmar['idmarca'];
		?>
			<script  type="text/javascript">
				Materialize.toast('<span>Agregado. Se agrego la marca a la base de datos</span>', 3500);
				$("#idmarcaNombre").val("<?php echo $idNmarca; ?>");
	            $("#idmarca").val("<?php echo $idmarca; ?>");
	            $('#modal1').closeModal();
			</script>
		<?php
	}else{
		?>
		<script type="text/javascript">
			swal("ERROR","No se pudo guardar","error");
		</script>
		<?php		
	}
    
?>