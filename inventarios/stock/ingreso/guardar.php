<?php
	$ruta="../../../";
	include_once($ruta."class/invitem.php");
	$invitem=new invitem;
	include_once($ruta."class/lote.php");
	$lote=new lote;

	include_once($ruta."class/invmovimiento.php");
	$invmovimiento=new invmovimiento;
	include_once($ruta."class/item_almacen.php");
	$item_almacen=new item_almacen;

	include_once($ruta."funciones/funciones.php");
	
	extract($_POST);
	session_start();
    /*********** actualiza contrato  ***********/
	$fecha=date("Y-m-d");
	$hora=date("H:i:s");
$lblcode=ecUrl($idalmacen);
 $precio = $idpreciototal/$idcantidad;


$valoreslote=array( 
		"cantidad"=>"'$idcantidad'",
		"iditem"=>"'$iditem'", 
		"idestante"=>"'$idestante'", 
		"idfila"=>"'$idfila'", 
		"idalmacen"=>"'$idalmacen'", 
		"fecha_vencimiento"=>"'$idfechavence'"
	 );

//paso 1 se regsitra el lote

	if ($lote->insertar($valoreslote)) {
		 	
		//Paso 2 Extraccion del idlote
		$datoslote=$lote->mostrarUltimo();
		$idlote=$datoslote['idlote'];
		//Paso 3 Extraccion de la ultima transaccion
		$ultimatransaccion=$invmovimiento->mostrarUltimo();
		$idtransaccion=$ultimatransaccion['idtransaccion'];
		$idtransaccion++;
		//valores movimineto
			$valoresmovimiento=array(        	  
					"idalmacen"=>"'$idalmacen'",
					"iditem"=>"'$iditem'",
					"tipomov"=>"'1'",
					"cantidad"=>"'$idcantidad'",
					"preciocompra"=>"'$precio'", 
					"idtransaccion"=>"'$idtransaccion'",
					"idlote"=>"'$idlote'",
					"idproveedor"=>"'$idprovee'",	
					"descripcion"=>"'Ingreso de item'"				
					 );

				if ($invmovimiento->insertar($valoresmovimiento)){	


							$datoIA=$item_almacen->mostrarTodo("iditem=".$iditem." and idalmacen=".$idalmacen);
							if (count($datoIA)==0){

								//no esiste regsitro del item en el almacen
								$datoitem = $invitem->muestra($iditem);
									$precioventa =$datoitem['precio'];

										$valoresIA=array(        	  
										"idalmacen"=>"'$idalmacen'",
										"iditem"=>"'$iditem'",
										 
										"cantidad_maxima"=>"'100000000'",
										"cantidad_minima"=>"'100'",
										"existencias"=>"'$idcantidad'",

										"precio_compraU"=>"'$precio'", 
										"precio_ventaU"=>"'$precioventa'", 	
										 );
										if ($item_almacen->insertar($valoresIA)){

           					
													?>
														<script type="text/javascript">
														swal({
															title: "Exito !!!",
															text: "Ingreso Registrado Correctamente",
															type: "success",
															showCancelButton: false,
															confirmButtonColor: "#28e29e",
															confirmButtonText: "OK",
															closeOnConfirm: true
												          }, function () {
															$("#<?php echo $iditem.'existen' ?>").text('<?php echo $idcantidad ?>');
															$("#idcantidad").val("");
															$("#idpreciototal").val("");
												          });
														</script>
													<?php
										}
										else
										{
											?>
											<script type="text/javascript">
												Materialize.toast('<span>No se pudo guardar el Item en Almacen</span>', 1500);
											</script>
											<?php	

										}


							}
							else
							{// Existen regsitros en el almacen
								//$precioventa = $precio+ (($precio/100)*10);
						$datoitemalmacen=$item_almacen->mostrarTodo("iditem=".$iditem." and idalmacen=".$idalmacen);
						$datoitemalmacen=array_shift($datoitemalmacen);

						$iditemA= $datoitemalmacen['iditem_almacen'];

						$nuevacantidad = $datoitemalmacen['existencias'] + $idcantidad;


//						$nuevoprecioC = ($datoitemalmacen['precio_compraU']+$precio)/2;
//calculo costo preomedio
// (Existencias x Costo Promedio actual) + (Cantidad que entra o sale x Costo Unitario)
//_____________________________________________________________________
//  Existencias +/- Cantidad que entra o sale 
	 

$a=($datoitemalmacen['existencias']*$datoitemalmacen['precio_compraU']);
$b =($idcantidad*$precio);
$c=($datoitemalmacen['existencias']+$idcantidad);


//D=A*B
$d=$a+$b;

//X= D/C
$nuevoprecioC= $d/$c;
						$nuevoprecioV = $nuevoprecioC+(($nuevoprecioC/100)*10);
										$valoresIA=array(        	  
										
										"existencias"=>"'$nuevacantidad'",

										"precio_compraU"=>"'$nuevoprecioC'", 
										//"precio_ventaU"=>"'$nuevoprecioV'", 	
										 );	

									if ($item_almacen->actualizar($valoresIA,$iditemA)){

										//$lblcode=ecUrl($f['idalmacen']);
													?>
														<script type="text/javascript">
														swal({
															title: "Exito !!!",
															text: "Ingreso Registrado Correctamente",
															type: "success",
															showCancelButton: false,
															confirmButtonColor: "#28e29e",
															confirmButtonText: "OK",
															closeOnConfirm: true
												          }, function () {
															$("#<?php echo $iditem.'existen' ?>").text('<?php echo $nuevacantidad ?>');
															$("#idcantidad").val("");
															$("#idpreciototal").val("");
												          });
														</script>
													<?php

										}else{
											?>
											<script type="text/javascript">
												Materialize.toast('<span>No se pudo actualizar el Item en Almacen</span>', 1500);
											</script>
											<?php	

										}
							}

				}
				else
				{
					?>
					<script type="text/javascript">
						Materialize.toast('<span>No se pudo guardar el movimiento</span>', 1500);
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