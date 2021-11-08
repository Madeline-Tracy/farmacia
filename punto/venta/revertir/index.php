<?php
  $ruta="../../../";
  include_once($ruta."class/almacen.php");
  $almacen=new almacen;
  include_once($ruta."class/invventa.php");
  $invventa=new invventa;
  include_once($ruta."class/factura.php");
  $factura=new factura;
  include_once($ruta."funciones/funciones.php");
  session_start();
   $fechaactual=date('Y-m-d');
  $horaactual=date('H:i:s');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="REVERTIR UNA VENTA";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
    ?>
    <style type="text/css">
      .estIn input{
        border:solid 1px #4286f4;
        width: 110px;
      }
      .disabled {
        pointer-events: none;
      }
   
    </style>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=1030;
          include_once($ruta."aside.php");
          $idUSE=$_SESSION["codusuario"];
          $vus=$vusuario->muestra($idUSE);
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12" style="color: #03459E; font-weight: bold;">
                  <h5 class="breadcrumbs-title"><i class="mdi-action-account-balance"></i> <?php echo $hd_titulo; ?></h5>
                </div>
                <div class="col s12 m12 l12"><a href="../../../inicio" class="btn waves-effect darken-4 red"><i class="mdi-content-reply-all"></i> Salir</a></div>
                
              </div>
            </div>
          </div>
            <div class="container">
              <div class="section" >
               <div class="row">
                  <div id="modal2" class="modal" style="width:80%;">
                    <div class="modal-content">
                     <div align="right">
                        <button class="btn-jh waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i></button>  
                      </div>
                      
                      <div class="row">
                           <div class="row table-responsive">                                          
                                  <div id="result"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                         <!-- <button type="button" class="btn red" data-dismiss="modal">Cerrar</button>
                        <button id="btnSave" target="_blank" disabled type="button" class="btn green"> GUARDAR  VENTA</button> --> 
                    </div>
                  </div>
               </div>
              </div>  
          </div>
          <div class="container">
            <div class="section">
               <div class="col s12 m12 l2">&nbsp;</div>
               <div class="col s12 m12 l10">
               <fieldset class="formulario">
                  <legend>VENTAS</legend>
                 <table id="example"  class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>FECHA VENTA</th>
                      <th>NIT</th>
                      <th>RAZON SOCIAL</th>
                      <th>TOTAL(bs.)</th>
                       <th>TIPO</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                     $ultimo=1;
                    $ultimo2=1;
                     $consulta="SELECT *
                                  FROM invventa
                                  where cierrecaja=0 order by idinvventa DESC"; //estado=1 : no esta anulado
                    foreach($invventa->sql($consulta) as $f)  
                    {
                      
                      //$lblcode=ecUrl($f['idcierrecaja']);
                      switch ($f['esfactura']) {
                        case '1':
                          $tipofac='FACTURA';
                          break;
                        
                        case '0':
                           $tipofac='RECIBO';
                          break;
                      }
                      if($f['estado']==2) {
                        $formato='background:#FBA7A7;';
                      }else{
                        $formato='';
                      }                     
                      ?>
                      <tr style="<?php echo $formato ?>">
                        <td><?php echo $f['fecha'] ?></td>
                        <td><?php echo $f['nit'] ?></td>
                        <td><?php echo $f['razon'] ?></td>
                        <td><?php echo number_format($f['total'], 2, '.', '') ?></td>
                         <td><?php echo $tipofac ?></td>
                        <td>
                        <a href="#modal2" onclick="obtener_ventas('<?php echo $f['idinvventa'] ?>','<?php echo $f['esfactura'] ?>');" class="btn-jh purple darken-2 modal-trigger"><i class="mdi-action-receipt"></i> Ver venta</a>
                        </td>
                      </tr>
                      <?php
                    }
                    ?>
                  </tbody>
                  <thead>
                    <tr>
                      <th>FECHA VENTA</th>
                      <th>NIT</th>
                      <th>RAZON SOCIAL</th>
                      <th>TOTAL(bs.)</th>
                      <th>TIPO</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                </table>
                </fieldset>
              </div>
               <div class="col s12 m12 l2">&nbsp;</div>
            </div>
          </div>
          <?php
            include_once($ruta."footer.php");
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
    ?>
    <script type="text/javascript">
    $(document).ready(function(){
      $('#example3').DataTable({
        dom: 'Bfrtip',
        "order": [[ 0, "DESC" ]],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
      
    });

    $(document).ready(function() {
      $('#example').DataTable({
        dom: 'Bfrtip',
        "order": [[ 0, "DESC" ]],
        buttons: [
             'csv', 'excel', 'pdf' 
        ]
      });
    });
  
       function obtener_ventas(idventa,fac)
       {        
              $.ajax({
              url: "mostrar_venta.php",
              method: "POST",
              data: "idventa="+idventa+"&fac="+fac,
              success: function(data){
                  $("#result").html(data)
              }
            });
            
       }
      function revertirV(idv)
       {
       // alert(idv);
         // var str = $( "#idFormVenta" ).serialize();
          $.ajax({
            url: "afectar.php",
            type: "POST",
            data: "idventa="+idv,
            success: function(resp){
              //alert(resp);
              console.log(resp);
              $('#idresultado').html(resp);
            }
          });
       }
    </script>
</body>

</html>