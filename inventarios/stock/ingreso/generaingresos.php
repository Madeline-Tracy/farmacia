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
 $precio = $idpreciototal/1;

 foreach($invitem->mostrarTodo("") as $f)
{
    $idi=$f['idinvitem'];
    $valoreslote=array( 
		"cantidad"=>"'100'",
		"iditem"=>"'$idi'", 
		"idestante"=>"'1'", 
		"idfila"=>"'1'", 
		"idalmacen"=>"'2'", 
		"fecha_vencimiento"=>"'2020-12-31'"
     );
     
     $lote->insertar($valoreslote);
     $datoslote=$lote->mostrarUltimo();
		$idlote=$datoslote['idlote'];
		//Paso 3 Extraccion de la ultima transaccion
		$ultimatransaccion=$invmovimiento->mostrarUltimo();
		$idtransaccion=$ultimatransaccion['idtransaccion'];
		$idtransaccion++;
		//valores movimineto
			$valoresmovimiento=array(        	  
					"idalmacen"=>"'2'",
					"iditem"=>"'$idi'",
					"tipomov"=>"'1'",
					"cantidad"=>"'100'",
					"preciocompra"=>"'0'", 
					"idtransaccion"=>"'1'",
					"idlote"=>"'$idlote'",
					"idproveedor"=>"'1'",	
					"descripcion"=>"'Ingreso de item'"				
                     );
                     
                     $invmovimiento->insertar($valoresmovimiento);

                     $datoIA=$item_almacen->mostrarTodo("iditem=".$iditem." and idalmacen=".$idalmacen);
							if (count($datoIA)==0){

								//no esiste regsitro del item en el almacen
								$datoitem = $invitem->muestra($iditem);
									$precioventa =$datoitem['precio'];

										$valoresIA=array(        	  
										"idalmacen"=>"'2'",
										"iditem"=>"'$idi'",
										 
										"cantidad_maxima"=>"'100000000'",
										"cantidad_minima"=>"'100'",
										"existencias"=>"'$idcantidad'",

										"precio_compraU"=>"'$precio'", 
										"precio_ventaU"=>"'$precioventa'", 	
										 );
									 $item_almacen->insertar($valoresIA);

           					 
                                        }
                                    }


 