<?php
session_start();
$ruta="../../";
include_once($ruta."class/proveedor.php");
$proveedor=new proveedor; 
extract($_POST);
$empresa_=strtoupper($idempresa); 
$direccion_=strtoupper($iddireccion);
$encargado_=strtoupper($idencargado); 
 
	$valores=array(
		"empresa"=>"'$empresa_'",
		"nit"=>"'$idnit'",
		"direccion"=>"'$direccion_'",
		"telefono"=>"'$idtelefono'",
		"encargado"=>"'$encargado_'",
		"estado"=>"'1'"		 
	 );	
	if($proveedor->insertar($valores))
	{
		 
		  	?>
				<script type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Laboratorio Registrado Correctamente",
					type: "success",
					showCancelButton: false,
					confirmButtonColor: "#28e29e",
					confirmButtonText: "OK",
					closeOnConfirm: false
		          }, function () {
					location.href="../listar";
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