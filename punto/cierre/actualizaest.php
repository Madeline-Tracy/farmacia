<?php	
  $ruta="../../";
  include_once($ruta."class/invventa.php");
  $invventa=new invventa;
  extract($_POST);
  session_start();
$idcierrecaja=$_SESSION["CODcierrecaja"];
   $valores=array(
    "cierrecaja"=>"'1'",
    "idcierrecaja"=>"'$idcierrecaja'"
  );
  if($invventa->actualizar($valores,$idinvventa))
  {} 
?>