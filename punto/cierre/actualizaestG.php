<?php	
  $ruta="../../";
  include_once($ruta."class/invgasto.php");
  $invgasto=new invgasto;
  extract($_POST);
  session_start();
$idcierrecaja=$_SESSION["CODcierrecaja"];
   $valores=array(
    "cierrecaja"=>"'1'",
    "idcierrecaja"=>"'$idcierrecaja'"
  );
  if($invgasto->actualizar($valores,$idinvgasto))
  {} 
?>