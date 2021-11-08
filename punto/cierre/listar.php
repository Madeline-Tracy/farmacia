<?php
  $ruta="../../";
  include_once($ruta."class/almacen.php");
  $almacen=new almacen;
  include_once($ruta."class/cierrecaja.php");
  $cierrecaja=new cierrecaja;
  include_once($ruta."funciones/funciones.php");

  session_start();
  $fechaactual=date('Y-m-d');
  $horaactual=date('H:i:s');

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Lista de cierres de caja";
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
          $idmenu=1029;
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
            <div class="row">
            <!--  <a href="nuevo/" class="btn blue"><i class="fa fa-plus"></i> Nuevo Libro</a><br><br> -->
             <div class="col s12 m12 l2">&nbsp;</div>
              <div class="col s12 m12 l8">
                <table id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Punto de venta</th>
                      <th>fecha de cierre de caja</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                     $ultimo=1;
                    $ultimo2=1;
                     $consulta="SELECT *
                                  FROM cierrecaja
                                  where estado=0 order by idcierrecaja DESC";
                    foreach($cierrecaja->sql($consulta) as $f)  
                    {
                      
                      $lblcode=ecUrl($f['idcierrecaja']);
                      $aml = $almacen->muestra($f['idalmacen']);
                      if($ultimo==$ultimo2) {
                        $formato='background:#D5F5E3;';
                         $ultimo2=$ultimo2+1;
                      }else{
                        $formato='';
                      }
                      ?>
                      <tr style="<?php echo $formato ?>">
                        <td><?php echo $aml['nombre'] ?></td>
                        <td><?php echo $f['diacierra'].' '.$f['horacierra'] ?></td>
                        <td>
                        <a href="imprimir/?lblcode=<?php echo $lblcode ?>" class="btn-jh green" target="_blank"><i class="fa fa-file-text-o"></i> Ver PDF</a>
                        <a href="imprimir/impresion.php?lblcode=<?php echo $lblcode ?>" class="btn-jh blue" target="_blank"><i class="fa fa-file-text-o"></i> Ver Impresion</a>
                        </td>
                      </tr>
                      <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <div class="col s12 m12 l2">&nbsp;</div>
              </div>
            </div>
          </div>
          <?php
            include_once("../../footer.php");
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
    </script>
</body>

</html>