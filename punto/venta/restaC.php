<?php
session_start();
include_once("../../class/ventadetalletemp.php");
$ventadetalletemp=new ventadetalletemp;
extract($_POST);

          $vdt=$ventadetalletemp->mostrar($idventadetalletemp);
          $vdt=array_shift($vdt);
          if ($vdt['cantidad']==1) 
          {
            echo '3';            
          }else{
            
             $cantidad=$vdt['cantidad']-1;
              $sumaTotal=$vdt['total'] - $vdt['precio'];

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
          }

            



 ?>