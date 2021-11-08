<?php 
include_once("../../class/estante.php");
$estante=new estante;

extract($_GET);
$est=$estante->muestra($idestante);

        $arrayJSON['idestante']=$idestante;
		$arrayJSON['nombre']=$est['nombre'];
		$arrayJSON['cantidad']=$est['cantidadfila'];
		$arrayJSON['descripcion']=$est['descripcion'];

		echo json_encode($arrayJSON);


?>