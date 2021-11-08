<?php 
$ruta="../../";
include_once($ruta."class/vitem.php");
$vitem=new vitem; 
include_once($ruta."class/vliname.php");
$vliname=new vliname; 
include_once($ruta."class/item_almacen.php");
$item_almacen=new item_almacen; 
extract($_GET);

$es=$vitem->muestra($ide);
$vli=$vliname->muestra($es['idliname']);
$datoIA=$item_almacen->mostrarUltimo("idalmacen=".$idalmacen." and iditem=".$ide);
$codigo="";
$liname="";
if (count($vli)>0) 
{
	$codigo=$vli['codigo'];
	$liname=$vli['idliname'];
}

	$arrayJSON['nombre']=$es['nombre'] ;
	$arrayJSON['marca']=$es['marca'] ;
	$arrayJSON['precio']=$es['precio'];
	$arrayJSON['liname']=$liname;
	$arrayJSON['codigo']=$codigo;
	$arrayJSON['existencias']=$datoIA['existencias'];

	echo json_encode($arrayJSON); 
?>