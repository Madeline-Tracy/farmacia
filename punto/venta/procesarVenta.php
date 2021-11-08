<?php 
	error_reporting(E_ALL);
  	ini_set('display_errors', '1');
	$ruta="../../";
  	$rutaRaiz="../../";
  	include_once($rutaRaiz."class/ventadetalletemp.php");
	$ventadetalletemp=new ventadetalletemp;
  	include_once($rutaRaiz."class/almacen.php");
	$almacen=new almacen;
  	include_once($rutaRaiz."class/invcliente.php");
	$invcliente=new invcliente;
	include_once($rutaRaiz."class/invventa.php");
	$invventa=new invventa;
	include_once($rutaRaiz."class/invventadet.php");
	$invventadet=new invventadet;
	include_once($rutaRaiz."class/factura.php");
	$factura=new factura;
	include_once($rutaRaiz."class/facturadet.php");
	$facturadet=new facturadet;
	include_once($rutaRaiz."class/invitem.php");
	$invitem=new invitem;
	include_once($rutaRaiz."class/invmovimiento.php");
	$invmovimiento=new invmovimiento;
	include_once($rutaRaiz."class/admsucursal.php");
	$admsucursal=new admsucursal;
	include_once($rutaRaiz."class/admdosificacion.php");
	$admdosificacion=new admdosificacion;
	include_once($rutaRaiz."class/item_almacen.php");
	$item_almacen=new item_almacen;
	include_once($rutaRaiz."class/miempresa.php");
	$miempresa=new miempresa;

	require_once($rutaRaiz."funciones/codigo.php");
	include_once($rutaRaiz."funciones/funciones.php");
	extract($_POST);
	session_start();


	$fecha=date("Y-m-d");
	$hora=date("H:i:s");
	if (isset($_SESSION["idventatemp"] )) {

		//if ($idnit=="NIT-SN") {
		//	$esfactura=0;
		//}else{
		//	$esfactura=1;
		//}
		$esfactura=0;
		$idsucursal=$_SESSION["sucursal"];
		$dsuc=$almacen->muestra($idsucursal);
		$nroventa=$dsuc['nroventa']+1;

		/***************  OBTENEMOS EL TOTAL DEL CARRITO GENERADO  ********************/
		//$total=0;
		//foreach ($_SESSION["carritoSesta"] as $f) {
		//	$subtotal=$f['precio']*$f['cantidad'];
		//	$total=$total+$subtotal;
		//}


		$efectivo=floatval($idmonto) - floatval($idimporteTar); 
		/********************************************************************************/
		// valida montos
		$saldo=0;
		if ($saldo<0) {
			?>
				<script type="text/javascript">
					 swal("Error","Cobro supera lo agregado","error");
				</script>
			<?php	
		}else{
			//guardacliente
		    $valcliente=array(
				"razon"=>"'$idnombre'",
				"nit"=>"'$idnit'"
			);
			if ($invcliente->insertar($valcliente)) {
				/******** Se debera insertar contrato detalle *********/
				$dcli=$invcliente->mostrarUltimo("nit='$idnit'");
				$idcliente=$dcli['idinvcliente'];
				//guarda venta
			    $valores=array(
					"idcliente"=>"'$idcliente'",
					"idsucursal"=>"'$idsucursal'",
					"nit"=>"'$idnit'",
					"razon"=>"'$idnombre'",
					"nro"=>"'$nroventa'",
					"fechault"=>"'$fecha'",
					"fecha"=>"'$fecha'",
					"efectivo"=>"'$efectivo'",
					"tarjeta"=>"'$idimporteTar'",
					"total"=>"'$idmonto'",
					"totaloriginal"=>"'$idmontooriginal'",
					"importeBs"=>"'$idimporte'",
					"cambio"=>"'$idsaldo'",
					"importe"=>"'$idmonto'",
					"descuento"=>"'$iddescuento'",
					"saldo"=>"'0'",
					"idmovimiento"=>"1",
					"esfactura"=>"'$esfactura'",
					"contarjeta"=>"'$contarjeta'",
					"nroreferencia"=>"'$idnroreferencia'",
					"estado"=>"'1'"
				);
				if ($invventa->insertar($valores)) {
					/******** Se debera insertar contrato detalle *********/
					$dven=$invventa->mostrarUltimo("nro='$nroventa' and idsucursal=$idsucursal");
					$idventa=$dven['idinvventa'];
					//guarda venta detalle
					foreach ($_SESSION["carritoSesta"] as $f) //copiamos todos los items del array
					{
						$nombre=$f['nombre'];
						$valores=array(
							"idventa"=>"'$idventa'",
							"iditem"=>$f['iditem'],
							"detalle"=>"'$nombre'",
							"cantidad"=>$f['cantidad'],
							"precio"=>$f["precio"],
							"estado"=>"'1'"
						);
						$invventadet->insertar($valores);
					}
					//GENERA MOVIMIENTO DE SALIDA DE INVENTARIOS
					
					foreach ($_SESSION["carritoSesta"] as $f)
					{
						$valMov=array(
							"iditem"=>$f['iditem'],
							"idalmacen"=>"'$idsucursal'",
							"tipomov"=>"'2'",// Egreso
							"cantidad"=>$f['cantidad'],
							//"precio_compra"=>$f["precio"],
							//"precio_venta"=>$f['precio'],
							"idtransaccion"=>"$idventa",
							"idlote"=>"'1'",
							"idproveedor"=>"0",							
							"descripcion"=>"'VENTA'"
						);
						$invmovimiento->insertar($valMov);

						$cantidadIt=$f['cantidad'];
						$precio=$f['precio'];

					    $dAlmItem=$item_almacen->mostrarUltimo("idalmacen='".$idsucursal."' and iditem='".$f['iditem']."'");
					    $idalmitem=$dAlmItem['iditem_almacen'];
					    $cantidadAlm=$dAlmItem['existencias'];

					    $nuevacant=$cantidadAlm-$cantidadIt;
					    $valorSucursal=array(
					      "existencias"=>"'$nuevacant'"
					    );
					    $item_almacen->actualizar($valorSucursal,$idalmitem);/********************/
					  	/***************************************************************************/
					}
					//preguntamos si lo hacemos con factura o con venta
					//imprimimos la venta
					$valores=array(
					    "nroventa"=>"'$nroventa'",
					);
					$almacen->actualizar($valores,$idsucursal);
					//if ($esfactura==0) {
						
						$lblcode=ecUrl($idventa);
						unset($_SESSION["carritoSesta"]);
						?>
							<script  type="text/javascript">
						        swal({
					              title: "Exito,  Venta: NRO. "+"<?php echo $nroventa ?>",
					              text: "Venta generada correctamente",
					              type: "success",
					              showCancelButton: false,
					              confirmButtonColor: "#16c103",
					              confirmButtonText: "OK",
					              closeOnConfirm: false,
					              closeOnCancel: false
					            },
					            function(isConfirm){
					              if (isConfirm) {
					                location.reload();
					               // window.open("imprimir/?lblcode=<?php echo $lblcode ?>","_blank");
					              }
					            });
							</script>
						<?php
					//}
				}else{
					?>
					<script type="text/javascript">
						Materialize.toast('<span>No se pudo generar venta</span>', 1500);
					</script>
					<?php		
				}

			}else{
				?>
				<script type="text/javascript">
					Materialize.toast('<span>No se pudo guardar cliente</span>', 1500);
				</script>
				<?php		
			}
		}
	}else{
		?>
			<script type="text/javascript">
				swal({
					title: "Error",
					text: "Session caducada",
					type: "warning",
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
	
?>