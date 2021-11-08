<?php
  error_reporting(E_ALL);
  ini_set('display_errors', '1');
  session_start();
  $ruta="../../";
  include_once($ruta."class/invmovimiento.php");
  $invmovimiento=new invmovimiento;
  include_once($ruta."class/item_almacen.php");
  $item_almacen=new item_almacen;
  include_once($ruta."class/traspaso.php");
  $traspaso=new traspaso;
  include_once($ruta."class/traspasodet.php");
  $traspasodet=new traspasodet;
  include_once($ruta."funciones/funciones.php");
  extract($_POST);
  $idusuario=$_SESSION["codusuario"];
  /******************************************************************/
  /****************** MOVIMIENTO DE SALIDA **************************/
  //echo "DE DONDE: ".$idddonde;
  $idusuario=$_SESSION["codusuario"];

      


       $valoresTRA=array(
            "idalmacenorigen"=>"'$idalmacenO'",
            "idalmacendest"=>"'$idalmacenD'",
            "estado"=>"'1'"
          );
           if($traspaso->insertar($valoresTRA))
           {
            $tra=$traspaso->mostrarUltimo("idalmacenorigen=".$idalmacenO." and idalmacendest=".$idalmacenD." and usuariocreacion=".$idusuario);
              $idtraspaso=$tra['idtraspaso'];
                $lblcode=ecUrl($idtraspaso);
           }

    foreach ($_SESSION["carritoSesta"] as $data) //obtenemos los datos guardados en la variable de session (iditem, cantidad)
    {
          $iditem=$data['iditem'];
          $cantidad=$data['cantidad'];//cantidad enviado
        $valoresMdet=array(
            "tipomov"=>"'3'",
            "iditem"=>"'$iditem'",
            "cantidad"=>"'$cantidad'",
            "idtransaccion"=>"'$idtraspaso'",
            "descripcion"=>"'TRASPASO'"
          );
           if($invmovimiento->insertar($valoresMdet))
           {
                //ORIGEN -  Restar cantidad traspasado
                   $italO=$item_almacen->mostrarUltimo("idalmacen=".$idalmacenO." and iditem=".$iditem);
                   $iditem_almacenO=$italO['iditem_almacen'];
                   $cantidadexis= intval($italO['existencias']) - intval($cantidad);
                   $valoresALM=array(
                      "existencias"=>"'$cantidadexis'"
                    );
                    if($item_almacen->actualizar($valoresALM,$iditem_almacenO))
                    {
                        //DESTINO - se suma la cantidad traspaso
                         $existe=$item_almacen->mostrarUltimo("idalmacen=".$idalmacenD." and iditem=".$iditem);
                         if (count($existe)>0) 
                         {
                           $italD=$item_almacen->mostrarUltimo("idalmacen=".$idalmacenD." and iditem=".$iditem);
                           $iditem_almacenD=$italD['iditem_almacen'];
                           $cantidadexis=intval($italD['existencias'])+intval($cantidad);
                           $valoresALM=array(
                              "existencias"=>"'$cantidadexis'"
                            );
                            $item_almacen->actualizar($valoresALM,$iditem_almacenD);
                         }else{
                              $valoresALMD=array(
                                "idalmacen"=>"'$idalmacenD'",
                                "iditem"=>"'$iditem'",                        
                                "existencias"=>"'$cantidad'"
                              );
                              $item_almacen->insertar($valoresALMD);              
                         }
                    }
           }

            $valoresTRAD=array(
            "idtraspaso"=>"'$idtraspaso'",
            "iditem"=>"'$iditem'",
            "cantidad"=>"'$cantidad'",
            "estado"=>"'1'"
          );
           $traspasodet->insertar($valoresTRAD);
    }
?>
  <script type="text/javascript">

 swal({
      title: "EXITO",
      text: "Traspaso realizado correctamente",
      type: "success",
      showCancelButton: false,
      confirmButtonColor: "#16c103",
      confirmButtonText: "OK",
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm){
      if (isConfirm) {
        window.open("../imprimir/traspaso.php?lblcode=<?php echo $lblcode ?>","_blank");
        location.reload();
      }else{
        location.reload();
      }
    });
  </script>
