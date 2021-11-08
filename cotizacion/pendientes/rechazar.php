<?php
session_start();
$ruta="../../";
include_once($ruta."class/invpedido.php");
$invpedido=new invpedido;
extract($_POST);

        $valores2 = array( 
          "estado" =>"'RECHAZADO'" 
        );
        ; 
        if ($invpedido->actualizar($valores2,$ped)){
          ?>
            <script type="text/javascript">
              swal("Exito. Rechazado correctamente");
            </script>
          <?php
        }
        else
        {
          ?>
            <script type="text/javascript">
              swal("Error. Realice la accion nuevamente");
            </script>
          <?php
        }
?>
