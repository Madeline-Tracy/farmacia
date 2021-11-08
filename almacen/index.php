<?php

  $ruta="../";
  include_once($ruta."class/almacen.php");
  $almacen=new almacen;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio; 
  include_once($ruta."funciones/funciones.php");

  session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Items ";
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
          $idmenu=40;
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
              <a href="nuevo/" class="btn blue"><i class="fa fa-plus"></i> Nuevo almacen</a><br><br>
              <div class="col s12 m12 l6">
                <table id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Almacen</th>
                      <th>Zona</th>
                      <th>Dirección</th>
                      <th>Telefono</th>
                      <th>Tipo Almacen</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sw=true;
                    foreach($almacen->mostrarTodo("") as $f)
                    {
                      $lblcode=ecUrl($f['idalmacen']);
                      $tal=$dominio->mostrarTodo("codigo=".$f['tipo_almacen']." and tipo='inventario'");
                      $tal = array_shift($tal);
                      ?>
                      <tr>
                        <td><?php echo $f['idalamcen'] ?></td>
                        <td><?php echo $f['nombre'] ?></td>
                        <td><?php echo $f['zona'] ?></td>
                        <td><?php echo $f['direccion'] ?></td>
                        <td><?php echo $f['telefono'] ?></td>
                        <td><?php echo $tal['nombre'] ?></td>
                        <td>
                           
                          <a href="editar/?lblcode=<?php echo $lblcode ?>" class="btn-jh green"><i class="fa fa-edit"></i> EDITAR</a>
                          <button class="btn-jh red"><i class="fa fa-times"></i></button>
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
    <div class="row">
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
    $(document).ready(function() {
      $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
             'csv', 'excel', 'pdf' 
        ]
      });
    });
    function recomendar(id,estado){
      //alert(estado);
      swal({
        title: "Recomendar ?",
        text: "El producto se mostrará en el slide de recomendados",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#e20a0b",
        confirmButtonText: "Si, Estoy Seguro!",
        closeOnConfirm: false
      }, function () {
        $.ajax({
          url: "recomendar.php",
          type: "POST",
          data:"id="+id+"&estado="+estado,
          success: function(resp){
            console.log(resp);
            $("#idresultado").html(resp);
          }
        });
      });
    }
    function destacar(id,estado){
      //alert(estado);
      swal({
        title: "Destacar ?",
        text: "El producto se mostrará en el slide principal",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#e20a0b",
        confirmButtonText: "Si, Estoy Seguro!",
        closeOnConfirm: false
      }, function () {
        $.ajax({
          url: "destacar.php",
          type: "POST",
          data:"id="+id+"&estado="+estado,
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