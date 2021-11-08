<?php
      $ruta="../../";
	include_once($ruta."class/itemalmacenventa.php");
	$itemalmacenventa=new itemalmacenventa;
	session_start();
	extract($_POST);
	//extract($_GET);
	$ital = $itemalmacenventa->muestra($iditemalamcen);
    $existe=$ital['existencias'];   
   	    $cantidadCarrito=0;
     //	if(!isset($_SESSION["carritoSesta"])) //si existe el carrito inicializado
		//{
			//creamos el array solo con el nuevo array
		//	$_SESSION["carritoSesta"] = array();
		//}		 		
		//print_r($_SESSION["carritoSesta"]);

		if($_SESSION["carritoSesta"]=="") //si existe una session en vacio eliminamos la variable de session
		 {
		      $cantidadCarrito=0; 

		 }else{
			 	 foreach($_SESSION["carritoSesta"] as $f) //copiamos todos los items del array
			    {
					if($f["iditem"] == $iditem)
					{ 
						$cantidadCarrito=$cantidadCarrito+$f['cantidad'];
					}
				}
		 }
		$cantidadAdi=$cantidadCarrito + $cantidadMas;
		if ($existe>=$cantidadAdi) 
		{
			echo '1'; //adiciona al carrito
		}else{
			echo '0'; //cantidad no existente ene almacen
		}
   

?>