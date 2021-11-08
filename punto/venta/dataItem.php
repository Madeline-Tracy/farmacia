<?php
    $ruta="../../";
    include_once($ruta."class/invitem.php");
    $invitem=new invitem;
	extract($_GET);
	session_start();
	//unset($_SESSION["carritoSesta"]);

  $invi=$invitem->muestra($idproducto);
  $idnombreProd=$invi['nombre'];
  $idprecio=$invi['precio'];
	if ($acc=='add') {
		if($_SESSION["carritoSesta"]=="") //si existe una session en vacio eliminamos la variable de session
		{
			unset($_SESSION["carritoSesta"]);
		}
		$subtotal=$idprecio*$idcantidad;
		//echo $subtotal;
	    $nuevoItem = array(array(
	    	"iditem"=>"$idproducto",
			"nombre"=>"$idnombreProd",
			"precio"=>"$idprecio",
			"cantidad"=>"$idcantidad",
			"subtotal"=>"$subtotal"
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
					$nuevoSubtotal=$nuevaCant*$f["precio"];
					$producto[] = array('iditem'=>$f['iditem'],
										'nombre'=>"$nombre", 
										'precio'=>$f["precio"], 
										'cantidad'=>$nuevaCant, 
										'subtotal'=>$nuevoSubtotal
									);
					//Sabemos que registra un mismo producto
					$found = true;
				}else{
					$nuevoSubtotal=$f["cantidad"]*$f["precio"];
					//trasladamos los datos
					$producto[] = array('iditem'=>$f['iditem'],
										'nombre'=>"$nombre", 
										'precio'=>$f["precio"], 
										'cantidad'=>$f["cantidad"],
										'subtotal'=>$f["subtotal"]
									);
				}
				$total=$total+$nuevoSubtotal;
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
					'precio'=>$f["precio"], 
					'cantidad'=>$f["cantidad"],
					'subtotal'=>$f["subtotal"]
				);
			}
		
			$_SESSION["carritoSesta"] = $producto;
		}
	}
	if ($acc=='list') {
		$acc=='list';//Solo Lista
		if(!isset($_SESSION["carritoSesta"])) //si existe el carrito inicializado
		{
			//creamos el array solo con el nuevo array
			$_SESSION["carritoSesta"] = "";
		}
	}
	$arreglo['data']=$_SESSION["carritoSesta"];
	echo json_encode($arreglo);	
	
?>