<?php
  session_start();
  include_once("../../class/ventadetalletemp.php");
  $ventadetalletemp=new ventadetalletemp;
  include_once("../../class/item_almacen.php");
  $item_almacen=new item_almacen;
  extract($_POST);

  $vdt=$ventadetalletemp->mostrar($idventadetalletemp);
  $vdt=array_shift($vdt);
  $cantidad=$vdt['cantidad']+1;
  $sumaTotal=$vdt['precio'] + $vdt['total'];

  $datos=$item_almacen->mostrarTodo("iditem_almacen=".$vdt['idproducto_almacen']);
  $datos=array_shift($datos);
  $cantExistente=$datos['existencias'];
  //consulta si la cantidad ultrapasa la cantiad existente
  if (intval($cantExistente)>=$cantidad)
  {
    $valores=array(
      "cantidad"=>"'$cantidad'",
      "total"=>"'$sumaTotal'",
      "costototal"=>"'$sumaTotal'"
    );
    if($ventadetalletemp->actualizar($valores,$idventadetalletemp))
    { 
      echo '1';
    }else{
      echo '2';
    }
  }else{
    echo '3';
  }

           




 ?>