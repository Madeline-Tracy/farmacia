<?php
session_start();
include_once("../../class/invventa.php");
$invventa=new invventa;
include_once("../../class/invgasto.php");
$invgasto=new invgasto;
include_once("../../class/cierrecaja.php");
$cierrecaja=new cierrecaja;
include_once("../../funciones/funciones.php");
extract($_POST);
extract($_GET);
ecUrl($idalmacen);
$totalVenta=0;
$totalEfectivo=0;
$totalTarjeta=0;
//cierre caja 0 no se encuentra cerrado la caja // estado=1 valido 0 anulado
foreach($invventa->mostrarTodo("idsucursal=".$idalmacen." and cierrecaja=0 and estado=1") as $f)
{
   $totalVenta= $totalVenta+$f['total'];
   $totalEfectivo= $totalEfectivo+$f['efectivo'];
   $totalTarjeta= $totalTarjeta+$f['tarjeta'];
}
$totalGasto=0;               
foreach($invgasto->mostrarTodo("idsucursal=".$idalmacen."  and cierrecaja=0 and estado=1") as $g)
{
 $totalGasto= $totalGasto+$g['monto'];
}
$caci = $cierrecaja->mostrarTodo("idalmacen=".$idalmacen." and estado=1"); 
$caci = array_shift($caci);
$montoinicial=floatval($caci['montoinicial']);
$MontoFinal=$totalEfectivo+$montoinicial-$totalGasto;
  echo "
  <ul class='collection'>
    <li class='collection-item avatar'>
      <img src='../iconos/money.png' alt='' class='circle'>
      <p><span class='title'>TOTAL VENTAS EFECTIVO:</span> <b style='color:green; font-size:20px;'>".number_format($totalEfectivo, 2, '.', '')."</b></p>
      <p><span class='title'>TOTAL VENTAS TARJETA:</span> <b style='color:green; font-size:20px;'>".number_format($totalTarjeta, 2, '.', '')."</b></p>         
      <p><span class='title'>TOTAL VENTAS:</span> <b style='color:green; font-size:20px;'>".number_format($totalVenta, 2, '.', '')."</b></p>
      <p><span class='title'>TOTAL GASTOS:</span> <b style='color:red; font-size:20px;'>".number_format($totalGasto, 2, '.', '')."</b></p>
       <p><span class='title'>MONTO INICIAL:</span> <b style='color:blue; font-size:20px;'>".number_format($montoinicial, 2, '.', '')."</b></p>
       <p><span class='title'>TOTAL EN EFECTIVO:</span> <b style='color:green; font-size:20px;'>".number_format($MontoFinal, 2, '.', '')."</b></p>
      <a href='imprimir/detalleventa.php?lblcode=".ecUrl($idalmacen)."' class='secondary-content' target='_blank'><i class='mdi-action-grade'></i>Ver Detalles completo</a>
    </li>
  </ul>
  ";  
?> 
   
     

