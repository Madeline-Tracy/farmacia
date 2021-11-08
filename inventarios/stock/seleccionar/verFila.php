<?php 
include_once("../../../class/fila.php");
$fila=new fila;
include_once("../../../class/estante.php");
$estante=new estante;
session_start();  
extract($_POST);
$data=array();
 
    foreach($fila->mostrarTodo("idestante=".$idestante) as $f)
	{
		 $data[] = array(
					"idfila" => $f['idfila'],
					"nombre" => $f['nombre']
				);                     
		
	}
	echo json_encode($data);
?>
