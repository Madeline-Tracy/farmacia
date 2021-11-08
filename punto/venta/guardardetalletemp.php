<?php
session_start();
include_once("../../class/ventatemp.php");
$ventatemp=new ventatemp;
include_once("../../class/ventadetalletemp.php");
$ventadetalletemp=new ventadetalletemp;
include_once("../../class/item_almacen.php");
$item_almacen=new item_almacen;
extract($_POST);

$idsucursal=$_SESSION['sucursal'];
$localIP = getHostByName(getHostName());

$fechaactual=date('Y-m-d');
 $idventatemp = $_SESSION['idventatemp'];

 
    $datos=$item_almacen->muestra($idproducto_almacen);
    $cantExistente=$datos['existencias'];
//consulta si la cantidad ultrapasa la cantiad existente
if (intval($cantExistente)>0) 
{
     if ($idventatemp==0)
     {
         $valores=array("tipo"=>"'TEMPORAL'",
                        "estacion"=>"'$idsucursal'",
                        "ip"=>"'$localIP'"
              );
               if($ventatemp->insertar($valores))
                {               
                  foreach($ventatemp->mostrarTodo("tipo='TEMPORAL' and ip='$localIP'") as $f)
                  {
                    $idventatemp=$f['idventatemp'];
                    //echo $idventa;
                  }
                     $valores2=array( "idproducto_almacen"=>"'$idproducto_almacen'",
                                      "idventatemp"=>"'$idventatemp'",
                                      "tipoventa"=>"'ARMADO'",
                                      "idproducto"=>"'$idproducto'",
                                      "producto"=>"'$producto'",
                                      "idlote"=>"'$idlote'",
                                      "precio"=>"'$precio'",
                                      "cantidad"=>"'1'",
                                      "total"=>"'$precio'",
                                      "costototal"=>"'$precio'",
                                      "estacion"=>"'$idsucursal'",
                                      "ip"=>"'$localIP'"
                    );
                     if($ventadetalletemp->insertar($valores2))
                     {
                        echo '1';
                     }else{
                        echo '2';
                     } 
                      $_SESSION["idventatemp"] =$idventatemp;
                }
                else{
                  echo '<span>No se guardo</span>';
                }
     }else{
                $existe=$ventadetalletemp->mostrarTodo("idventatemp=".$idventatemp." and idproducto=".$idproducto);
                if (count($existe)>0) 
                {
                   $vdt=$ventadetalletemp->mostrarUltimo("idventatemp=".$idventatemp." and idproducto=".$idproducto);
                   
                   $cantidad=$vdt['cantidad']+1;
                   $total=$precio+$vdt['total'];


                    if (intval($cantExistente)>=$cantidad) 
                    {
                          $valores=array( //"idproducto_almacen"=>"'idproducto_almacen'",
                                          //"idventatemp"=>"'$idventatemp'",
                                          //"tipoventa"=>"'ARMADO'",
                                          //"idproducto"=>"'$idproducto'",
                                          //"precio"=>"'$precio'",
                                          "cantidad"=>"'$cantidad'",
                                          "total"=>"'$total'",
                                          "costototal"=>"'$total'"
                        );
                         if($ventadetalletemp->actualizar($valores,$vdt['idventadetalletemp']))
                         {
                            echo '1';
                         }else{
                            echo '2';
                         }
                    }else{
                            echo '3';
                    }
                          

                }else{

                      $valores=array( "idproducto_almacen"=>"'$idproducto_almacen'",
                                      "idventatemp"=>"'$idventatemp'",
                                      "tipoventa"=>"'ARMADO'",
                                      "idproducto"=>"'$idproducto'",
                                      "producto"=>"'$producto'",
                                      "idlote"=>"'$idlote'",
                                      "precio"=>"'$precio'",
                                      "cantidad"=>"'1'",
                                      "total"=>"'$precio'",
                                      "costototal"=>"'$precio'",
                                      "estacion"=>"'$idsucursal'",
                                      "ip"=>"'$localIP'"
                    );
                     if($ventadetalletemp->insertar($valores))
                     {
                        echo '1';
                     }else{
                        echo '2';
                     }
                }
     }
}else{
  echo '3';
}


 

      

 ?>