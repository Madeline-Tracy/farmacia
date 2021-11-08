<?php 
	$ruta="../../";
	include_once($ruta."class/proveedor.php");
	$proveedor=new proveedor; 
	include_once($ruta."funciones/funciones.php");
	extract($_POST);
	$id=dcUrl($id);
	session_start();
	$valores=array(
	     "estado"=>"'$estado'"
	);	
	if($proveedor->actualizar($valores,$id))
	{
   
				?>
			<script  type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Operacion Realizada Correctamente",
					type: "success",
					showCancelButton: false,
					confirmButtonColor: "#28e29e",
					confirmButtonText: "OK",
					closeOnConfirm: false
		        }, function () {      
		            location.reload();
		        });				
			</script>
		<?php
					 
		 	
	}
	else
	{
		?>
		<script type="text/javascript">
			Materialize.toast('<span>No se pudo cambiar</span>', 150);
		</script>
		<?php
	}
?>	