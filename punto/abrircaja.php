<?php
session_start();
$ruta="../";
include_once($ruta."class/cierrecaja.php");
$cierrecaja=new cierrecaja; 
include_once($ruta."funciones/funciones.php");
extract($_POST);
$lblcode=ecUrl($idalmacen);

$fechaactual=date('Y-m-d');
$horaactual=date('H:i:s');
$IDUSER=$_SESSION["codusuario"];
 
	$valores=array(
		"idalmacen"=>"'$idalmacen'",
		"montoinicial"=>"'$idmontoinicial'",
		"dia"=>"'$fechaactual'",
		"horaabre"=>"'$horaactual'",
		"idusuarioabrio"=>"'$IDUSER'",
		"estado"=>"'1'"		 
	 );	
	if($cierrecaja->insertar($valores))
	{ 
		  	?>
				<script type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Caja abierto con exito",
					type: "success",
					showCancelButton: false,
					confirmButtonColor: "#28e29e",
					confirmButtonText: "OK",
					closeOnConfirm: false
		          }, function () {
		          	location.reload();
					location.href="venta/?lblcode=<?php echo $lblcode ?>";
					
		          });
				</script>
			<?php
	}else{
		?>
			<script type="text/javascript">
				swal("ERROR!", "No se realizo la operacion, consulte con de sistemas", "error");
			</script>
		<?php
	 }
 
?>