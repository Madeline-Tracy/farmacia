<?php
include_once("../../class/invitem.php");
$invitem=new invitem;
extract($_POST);
	$valores=array(
		"destacado"=>"'$estado'"
	 );
	if ($invitem->actualizar($valores,$id)) 
	{
		?>
			<script type="text/javascript">		
				swal({
		            title: "Exito",
		            text: "Cambios Guardados Correctamente",
		            type: "warning",
		            showCancelButton: false,
		            confirmButtonColor: "#e20a0b",
		            confirmButtonText: "OK",
		            closeOnConfirm: false
		        }, function () {
		            location.reload();
		        });
			</script>
		<?php
		    
	}
	else{
			?>
				<script type="text/javascript">		
					toastr.success('Error no se registro Correctamente', 'PRODUCTO');
				</script>
			<?php
			
	}
?>