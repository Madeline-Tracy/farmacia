<?php
session_start();
include_once("../../class/ventadetalletemp.php");
$ventadetalletemp=new ventadetalletemp;
include_once("../../class/venta.php");
$venta=new venta;
include_once("../../class/ventadetalle.php");
$ventadetalle=new ventadetalle;
include_once("../../class/producto_almacen.php");
$producto_almacen=new producto_almacen;
include_once("../../class/movimientos.php");
$movimientos=new movimientos;

extract($_POST);

$idsucursal=$_SESSION['sucursal'];
$localIP = getHostByName(getHostName());
$idventatemp=$_SESSION["idventatemp"];
$fechaactual=date('Y-m-d');

        $valores=array( "tipoventa"=>"'EFECTIVO'",
                        "importe"=>"'$importe'",
                        "saldo"=>"'$saldo'",
                        "costototal"=>"'$monto'",
                        "fechaentrega"=>"'$fechaactual'",
                        "estacion"=>"'$idsucursal'",
                        "ip"=>"'$localIP'"
          );
           if($venta->insertar($valores))
            { 
              $idventa=0;
              foreach($venta->mostrarTodo("tipoventa='EFECTIVO' and ip='$localIP'") as $ve)
              {
                $idventa=$ve['idventa'];
                //echo $idventa;
              }
              $_SESSION["idventa"] =$idventa;

                  foreach($ventadetalletemp->mostrarTodo("idventatemp=".$idventatemp) as $f)
                  {
                    $tipo='ARMADO';
                    $idproducto=$f['idproducto'];
                    $precio=$f['precio'];
                    $cantidad=$f['cantidad'];
                    $total=$f['total'];


                      $valores=array("idventa"=>"'$idventa'",
                                      "tipoventa"=>"'$tipo'",
                                      "idproducto"=>"'$idproducto'",
                                      "precio"=>"'$precio'",
                                      "cantidad"=>"'$cantidad'",
                                      "total"=>"'$total'",
                                      "costototal"=>"'$total'"
                                  );
                                  if($ventadetalle->insertar($valores))
                                  {
                                              $datp=$producto_almacen->mostrarTodo("idproducto_almacen=".$f['idproducto_almacen']." and idlote=".$f['idlote']);
                                              $datp=array_shift($datp);

                                                     $idproalm=$datp['idproducto_almacen'];

                                                     $calculado=$datp['existencias'] - $cantidad;

                                                     $valores2=array("existencias"=>"'$calculado'"
                                                      );
                                          if($producto_almacen->actualizar($valores2,$idproalm))
                                          {

                                                 $idalm=$datp['idalmacen'];
                                               //  $idlot=$datp['idlote'];
                                                 $idlot=$f['idlote'];

                                                          $valores3=array("idalmacen"=>"'$idalm'",
                                                                          "tipo_movimiento"=>"'E'",
                                                                          "cantidad_movimiento"=>"'$cantidad'",
                                                                          "precio_venta"=>"'$total'",
                                                                          "idlote"=>"'$idlot'",
                                                                          "idproducto"=>"'$idproducto'"
                                                          );
                                                          if($movimientos->insertar($valores3))
                                                          {
                                                               $exito=1;
                                                          }else{
                                                            $exito=2;
                                                          }

                                              
                                          }else{
                                            $exito=2;
                                          }
                                   
                                  }else{
                                    $exito=2;
                                  }

                  }
                  if ($exito==1) 
                  {
                    echo '1';
                  }else{
                     echo '2';
                  }
                  
            }
            else{
              echo '<span>No se guardo</span>';
            }

        

       

 ?>