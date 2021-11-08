<?php
  $ruta="../../";
  $rutaRaiz="../../";
  include_once($ruta."class/almacen.php");
  $almacen=new almacen;
  include_once($rutaRaiz."class/invgasto.php");
  $invgasto=new invgasto;
  include_once($rutaRaiz."class/admsucursal.php");
  $admsucursal=new admsucursal;
  include_once($rutaRaiz."funciones/funciones.php");
  session_start();
  extract($_GET);
  $idsucursal=dcUrl($lblcode);
  $_SESSION['sucursal']=$idsucursal;
  $dalm=$almacen->muestra($idsucursal);

  //$idsucursal=$_SESSION["idsede"];
  //echo $idsede;
  //$idsucursal=dcUrl($lblcode);
  $dse=$admsucursal->muestra($idsucursal);

  //echo "CANTIDAD ".count($_SESSION["carritoSesta"]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo=$dse['nombre'];
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
      include_once($ruta."includes/head_tablax.php");
    ?>
    <style type="text/css">
      .estIn input{
        border:solid 1px #4286f4;
        width: 110px;
      }
      .estInEste input{
        border:solid 1px #b7b7b7;
        border-radius: 3px;
      }
      .disabled {
        pointer-events: none;
      }

    </style>
</head>
<body id="layouts-horizontal">
    <?php
      $tab=2;
      include_once("../head2.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=1;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m6 l6">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?> - GASTOS 
                </h5></div>
                <div class="col s12 m6 l6">
                  
                  <table class="table">
                    <tr style="font-size: 25px;">
                      <td>Nro. Gasto: <b><strong><?php echo $dse['nrogasto']+1; ?></strong></b></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="section">
              <div class="row">
                <div class="col s12 m6 l12">
                  <fieldset class="formulario">
                    <legend>DATOS DEL GASTO</legend>
                    <form id="idform" action="return false" onsubmit="return false" method="POST">
                      <input type="hidden" name="idsucursal" id="idsucursal" value="<?php echo $idsucursal ?>">
                      <div class="input-field col col s12 m12">
                        <input id="iddetalle" name="iddetalle" type="text" class="validate">
                        <label for="iddetalle"><i class="fa fa-user"></i>Detalle</label>
                      </div>
                      <div class="input-field col col s12 m6">
                        <input id="idrecibo" name="idrecibo" type="text" value="0" class="validate">
                        <label for="idrecibo">NRO. RECIBO (Si es sin recibo, ingrese 0)</label>
                      </div>
                      <div class="input-field col col s12 m6">
                        <input id="idcantidad" name="idcantidad" type="text" value="1" class="validate">
                        <label for="idcantidad">CANTIDAD</label>
                      </div>
                      <div class="input-field col col s12 m5">
                        <input id="idmonto" name="idmonto" type="text" value="0" class="validate">
                        <label for="idmonto">MONTO</label>
                      </div>
                      <div class="input-field col col s12 m5">
                        <input id="idinterno" name="idinterno" value="1" type="checkbox" checked="" />
                        <label for="idinterno"><i class="fa fa-thumbs-up"></i>GASTO INTERNO</label>
                      </div>
                      <div class="input-field col s12">
                        <textarea id="iddesc" name="iddesc" class="materialize-textarea"></textarea>
                        <label for="iddesc">Descripción</label>
                      </div>
                      <div class="input-field col col s12 m12">
                        <button id="btnAgregar" style="width: 100%" class="btn purple"><i class="mdi-action-shopping-basket"></i> Registrar Gasto</button>
                      </div>
                    </form>
                  </fieldset>
                </div>
                <div class="col s12 m6 l12">
                  <fieldset class="formulario">
                    <legend><i class="mdi-action-shopping-cart"></i> GASTOS</legend>
                      <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>FECHA</th>
                            <th>NRO</th>
                            <th>RECIBO</th>
                            <th>DETALLE</th>
                            <th>CANTIDAD</th>
                            <th>MONTO UNID</th>
                            <th>MONTO TOTAL</th>
                            <th>GASTO INTERNO</th>
                            <th>OBSERVACIONES</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            foreach($invgasto->mostrarTodo("idsucursal=$idsucursal and cierrecaja=0") as $f)
                            {
                              ?>
                                <tr>
                                  <td><?php echo $f['fecha'].$f['horacreacion']; ?></td>
                                  <td><?php echo $f['nro']; ?></td>
                                  <td><?php echo $f['recibo']; ?></td>
                                  <td><?php echo $f['detalle']; ?></td>
                                  <td><?php echo $f['cantidad']; ?></td>
                                   <td><?php echo $f['montounid']; ?></td>
                                  <td><?php echo $f['monto']; ?></td>
                                  <td>
                                    <?php 
                                      if ($f['interno']==1) {
                                        echo "SI";
                                      }else{
                                        echo "NO";
                                      }
                                    ?>
                                  </td>
                                  <td><?php echo $f['obs']; ?></td>
                                </tr>
                              <?php
                            }
                          ?>
                        </tbody>
                  </fieldset>
                </div>
              </div>
            </div>
          </div>
          <?php
            include_once("../../footer.php");
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
      $('#example').DataTable({
        "order": [[ 1, "desc" ]],
      });
      function validar(retorno){
        var retorno=true;
        var detalle=$("#iddetalle").val();
        var monto=$("#idmonto").val();
        if (detalle=="" || monto=="0"|| monto=="" ) {
          retorno=false;
        }
        return retorno;
      }
      $("#btnAgregar").click(function(){
        if (validar()) {
        swal({   
          title: "Estas Seguro?",   
          text: "Se registrara el gasto",   
          type: "warning",   
          showCancelButton: true,   
          closeOnConfirm: false,   
          showLoaderOnConfirm: true,
        }, 
        function(){
          //alert(str);
          
            $('#btnAgregar').attr("disabled",true);
            var str = $( "#idform" ).serialize();
            $.ajax({
              url: "guardar.php",
              type: "POST",
              data: str,
              success: function(resp){
                setTimeout(function(){     
                  console.log(resp);
                  $('#idresultado').html(resp);  
                }, 10); 
              }
            });
          
        });
        }else{
            swal("Error","El campo detalle o monto tienen algun error. Revice e intente de nuevo","error");
          }
      });
    </script>
</body>

</html>