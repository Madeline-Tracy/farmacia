<?php
	$ruta="../../../";
	include_once($ruta."class/item_almacen.php");
	$item_almacen=new item_almacen;

	include_once($ruta."class/invmovimiento.php");
	$invmovimiento=new invmovimiento;
	include_once($ruta."class/lote.php");
	$lote=new lote;

	include_once($ruta."funciones/funciones.php");
	
	extract($_POST);
	session_start();
	$fecha=date("Y-m-d");
	$hora=date("H:i:s");
$lblcode=ecUrl($idalmacenImp);
 //$precio = $preciocompra/$idcantingreso;
$ital = $item_almacen->mostrarUltimo("idalmacen=".$idalmacenImp." and iditem=".$iditemImp);
$precio=$ital['precio_compraU'];
$iditem_almacen=$ital['iditem_almacen'];

    $valores=array(
		"tipomov"=>"'2'",
		"iditem"=>"'$iditemImp'",
		"cantidad"=>"'$idcantegreso'",
		"idalmacen"=>"'$idalmacenImp'",
		"preciocompra"=>"'$precio'",
		"iddonacion"=>"'$idmotivo'",
		"idlote"=>"'$idloteImp'",
		"descripcion"=>"'Egreso de item'"
	);
	if ($invmovimiento->insertar($valores)) 
	{
		$cantidadnueva = $ital['existencias'] - $idcantegreso;	
					  $valores2=array(
							"existencias"=>"'$cantidadnueva'" 
						);
					if ($item_almacen->actualizar($valores2,$iditem_almacen)) 
					{
						$lot = $lote->muestra($idloteImp);
						$cantidadnuevaLOTE = $lot['cantidad'] - $idcantegreso;
						$valores3=array(
							"cantidad"=>"'$cantidadnuevaLOTE'" 
						);
					   if ($lote->actualizar($valores3,$idloteImp))
					   {} 
					?>
						<script  type="text/javascript">
							swal({
								title: "Exito !!!",
								text: "Egreso ejecutado correctamente",
								type: "success",
								showCancelButton: false,
								confirmButtonColor: "#28e29e",
								confirmButtonText: "OK",
								closeOnConfirm: true
					        }, function () {  
					           $("#<?php echo $iditemImp.'existen' ?>").text('<?php echo $cantidadnueva ?>');
								$("#idcantegreso").val("");
								$("#idexistenciaImp").text('<?php echo $cantidadnueva ?>');
					        });
						</script>
					<?php
					}else{
							?>
							<script type="text/javascript">
								Materialize.toast('<span>No se pudo afectar el item</span>', 1500);
							</script>
							<?php		
						}
	}else{
		?>
		<script type="text/javascript">
			Materialize.toast('<span>No se pudo guardar el registro</span>', 1500);
		</script>
		<?php		
	}
    
?>