<?php
  $ruta="../../";
  include_once($ruta."class/invpedido.php");
  $invpedido=new invpedido;
  include_once($ruta."class/invcliente.php");
  $invcliente=new invcliente;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."funciones/funciones.php");
  session_start();

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Cotizaciones Pendientes";
    include_once($ruta."includes/head_basico.php");
    include_once($ruta."includes/head_tabla.php");
    include_once($ruta."includes/head_tablax.php");
  ?>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=101;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="section">
              <div class="col s12 m12 l6">
                <table id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Fecha</th>
                      <th>Cliente</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sw=true;
                    foreach($invpedido->mostrarTodo("idcliente>0 and estado='COTIZADO'") as $f)
                    {
                      $cli=$invcliente->muestra($f['idcliente']);
                      $per=$persona->muestra($cli['idpersona']);
                    ?>
                    <tr>
                      <td><?php echo $f['fechacreacion']." ".$f['horacreacion'] ?></td>
                      <td>
                      <?php
                        echo $per['nombre'].' '.$per['paterno'].' '.$per['materno'];
                      ?>
                      </td>
                      <td><?php echo $f['estado']; ?></td>
                      <td>
                          <button onclick="aprobarVenta(<?php echo $f['idinvpedido']; ?>);" class="btn-jh green"><i class="fa fa-check-square"></i> Aprobar / Vender</button>
                          <button onclick="rechazarVenta(<?php echo $f['idinvpedido']; ?>);"  class="btn-jh red"><i class="fa fa-trash"></i> Rechazar</button>
                          <a href="../reportes/cotizacionCli.php?idcliente=<?php echo $f['idcliente']?>" target="_blank" class="btn-jh blue"><i class="fa fa-file-pdf-o"></i> VER COTIZACION</a>
                      </td>         
                    </tr>
                    <?php
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <?php
            include_once("../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
      include_once($ruta."includes/script_tablax.php");
    ?>
    <script type="text/javascript">
    $( "#idsede" ).change(function() {
      location.href="?lblcode="+$('select[name=idsede]').val();
    });
    $(document).ready(function() {
      $('#example').DataTable({
        dom: 'Bfrtip',
        "order": [[ 1, "desc" ]],
        buttons: [
            'csv', 'excel', 'pdf'
        ]
      });
    });
    function rechazarVenta(idpedido){
        swal({
            title: "¿ESTAS SEGURO?",
            text: 'ya no podras aprobar la cotizacion',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2c2a6c",
            confirmButtonText: "SI, ESTOY SEGURO",
            cancelButtonText:"NO",
            closeOnConfirm: true
        }, function () {  
             $.ajax({
                url: "rechazar.php",
                type: "POST",
                data: "ped="+idpedido,
                success: function(resp){
                  console.log(resp);
                  $("#idresultado").html(resp);
                  location.reload();
                }
            });           
        });
    }
    function aprobarVenta(idpedido){
        swal({
          title: "¿ESTAS SEGURO?",
          text: 'Al aprobar la cotizacion se descontará las cantidades de inventario',
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#2c2a6c",
          confirmButtonText: "ESTOY SEGURO",
          cancelButtonText:"NO",
          closeOnConfirm: true
        }, function () {  
        $.ajax({
          url: "vender.php",
          type: "POST",
          data: "ped="+idpedido,
          success: function(resp){
            console.log(resp);
            $("#idresultado").html(resp);
          }
        });           
        });
    }
    </script>
</body>

</html>