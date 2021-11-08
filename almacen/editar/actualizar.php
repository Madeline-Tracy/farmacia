<?php
session_start();
$ruta="../../";
include_once($ruta."class/almacen.php");
$almacen=new almacen; 
extract($_POST);

$nombre=strtoupper($idnombre); 
$zona=strtoupper($idzona);
$direccion=strtoupper($iddireccion); 
$descripcion=strtoupper($iddescripcion); 
 
	$valores=array(
		"nombre"=>"'$nombre'",
		"tipo_almacen"=>"'$idtipo'",
		"zona"=>"'$zona'",
		"direccion"=>"'$direccion'",
		"telefono"=>"'$idtelefono'", 
		"descripcion"=>"'$descripcion'", 
		"estado"=>"'1'"		 
	 );	
	if($almacen->actualizar($valores,$idalmacen))
	{
		 
		  	?>
				<script type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Actualizo Correctamente",
					type: "success",
					showCancelButton: false,
					confirmButtonColor: "#28e29e",
					confirmButtonText: "OK",
					closeOnConfirm: false
		          }, function () {
					//location.href="../listar";
					location.reload();
		          });
				</script>
			<?php
	}
	else{
		?>
			<script type="text/javascript">
				setTimeout(function() {
		            Materialize.toast('<span>2 No se pudo realizar la Operacion. Consulte con su proveedor</span>', 1500);
		        }, 1500);
			</script>
		<?php
	 }
 
?>