<?php	
  $ruta="../../";
  include_once($ruta."class/cierrecaja.php");
  $cierrecaja=new cierrecaja;
  include_once($ruta."class/invventa.php");
  $invventa=new invventa;
  extract($_POST);
  session_start();
  $fechaactual=date('Y-m-d');
  $horaactual=date('H:i:s');
  $IDUSER=$_SESSION["codusuario"];
    $verificaCV=0;
   foreach($invventa->mostrarTodo("idsucursal=".$idalmacen."  and cierrecaja=0 and estado=1") as $v)
   {
      $verificaCV=$verificaCV+1;
   }
   if ($controlventa==$verificaCV) 
   {
      $existe = $cierrecaja->mostrarTodo("idalmacen=".$idalmacen." and estado=1"); 
      if (count($existe)>0) 
      {
        $cc = $cierrecaja->mostrarTodo("idalmacen=".$idalmacen." and estado=1"); 
        $cc = array_shift($cc);
        $idcierrecaja=$cc['idcierrecaja'];
        $_SESSION["CODcierrecaja"]=$idcierrecaja;
         $valores=array(
          "diacierra"=>"'$fechaactual'",
          "horacierra"=>"'$horaactual'",
          "aentregar"=>"'$idaentregar'",
          "entregado"=>"'$idaentregar'",//monto modificado, tiene que cuasdrar si o si
          "totaldescuento"=>"'$idtotalDescuento'",
          "idusuariocierre"=>"'$IDUSER'",
          "observacion"=>"'$idobservacion'",
          "estado"=>"'0'"//caja cerrado

        );
          if($cierrecaja->actualizar($valores,$idcierrecaja))
          {
           echo '1';
          }else{
            echo '2';
          }
      }else{
          echo '3';
      }
   }else{
    echo '4';
   }

 
   
?>