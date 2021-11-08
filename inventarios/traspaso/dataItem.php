<?php
include_once("../../class/vitem.php");
$vitem=new vitem;
	extract($_GET);
	session_start();
	//unset($_SESSION["carritoSesta"]);
$datoIA=$vitem->muestra($idproducto);
$idnombreProd=$datoIA['nombre'];

	if ($acc=='add') {
		//echo $subtotal;
	    $nuevoItem = array(array(
	    	"iditem"=>"$idproducto",
			"nombre"=>"$idnombreProd",
			"cantidad"=>"$idcantidad"
	    ));
	    if(isset($_SESSION["carritoSesta"])) //si existe el carrito inicializado
		{
			$found = false; //set found item to false
			$total=0;
			foreach ($_SESSION["carritoSesta"] as $f) //loop through session array
			{
				$nombre=$f['nombre'];
				$nuevaCant=0;
				if($f["iditem"] == $idproducto){ //si el item ya existe en el array debera aumentar la cantidad
					$nuevaCant=$idcantidad+$f['cantidad'];
					$producto[] = array('iditem'=>$f['iditem'],
										'nombre'=>"$nombre", 
										'cantidad'=>$nuevaCant
									);
					//Sabemos que registra un mismo producto
					$found = true;
				}else{
					//$nuevoSubtotal=$f["cantidad"]*$f["precio"];
					//trasladamos los datos
					$producto[] = array('iditem'=>$f['iditem'],
										'nombre'=>"$nombre", 
										'cantidad'=>$f["cantidad"]
									);
				}
				$total=100000;
			}

			if($found == false) //sabemos que existe un nuevo item y agregamos el nuevo item
			{
				//agregamos un nuevo item al array
				$_SESSION["carritoSesta"] = array_merge($producto, $nuevoItem);
			}else{
				//Solo cambio la cantidad
				$_SESSION["carritoSesta"] = $producto;
			}
			$_SESSION['carritoDatos']['total']=$total;
		}else{
			//creamos el array solo con el nuevo array
			$_SESSION["carritoSesta"] = $nuevoItem;
			$_SESSION['carritoDatos']['total']=$subtotal;
		}
	}
	if ($acc=='del') {
		foreach ($_SESSION["carritoSesta"] as $f) //copiamos todos los items del array
		{
			$nombre=$f['nombre'];
			if($f["iditem"]!=$idproducto){ //No copiamos el item que selleccionamos
				$producto[] = array(
					'iditem'=>$f['iditem'],
					'nombre'=>"$nombre", 
					'cantidad'=>$f["cantidad"]
				);
			}
		
			$_SESSION["carritoSesta"] = $producto;
		}
	}
	if ($acc=='list') {
		$acc=='list';//Solo Lista
	}
	$arreglo['data']=$_SESSION["carritoSesta"];
	//echo $_SESSION['carritoDatos']['total'];
	echo json_encode($arreglo);	
	
?>