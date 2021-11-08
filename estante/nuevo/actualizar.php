<?php
	$ruta="../../";
	include_once($ruta."class/estante.php");
	$estante=new estante;

	include_once($ruta."funciones/funciones.php");
	extract($_POST);
	session_start();
    /*********** actualiza contrato  ***********/
	
    $valores=array(
	     "nombre"=>"'$idnombreImp'",
	     "descripcion"=>"'$iddescripcionImp'"
	);
	if ($estante->actualizar($valores,$idestanteImp)) {		
		?>
			<script  type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Datos Actualizados correctamente",
					type: "success",
					//showCancelButton: false,
					confirmButtonColor: "#28e29e",
					confirmButtonText: "OK",
					closeOnConfirm: false
		        }, function () {  
		            location.reload();
		        });
			</script>
		<?php
	}else{
		?>
		<script type="text/javascript">
			swal("ERROR!", "No se actualizo, intente de nuevo", "error");
		</script>
		<?php		
	}
    
?>