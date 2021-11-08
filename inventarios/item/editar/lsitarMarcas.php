<?php 
	$ruta="../../../../../web-admin/";
  	$rutaRaiz="../../../"; 
	include_once($rutaRaiz."class/marca.php");
	$marca=new marca;
	extract($_GET);
	$arrayName = array();

	foreach($marca->mostrarTodo("") as $f)
    {
    	$nombre=$f['nombre'];
    	$desc=$f['descripcion'];
    	$val4=array(
			"idmarca"=>$f['idmarca'],
			"nombre"=>"$nombre",
			"desc"=>"$desc"
		);
	    array_push($arrayName,$val4);
	}
	$arreglo['data']=$arrayName;
	echo json_encode($arreglo);
?>