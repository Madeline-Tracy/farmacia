<?php
  $ruta="../../";
  include_once($ruta."class/almacen.php");
  $almacen=new almacen;
  include_once($ruta."class/cierrecaja.php");
  $cierrecaja=new cierrecaja;
  include_once($ruta."class/venta.php");
  $venta=new venta;
  include_once($ruta."class/invgasto.php");
  $invgasto=new invgasto;
  include_once($ruta."class/invventa.php");
  $invventa=new invventa;
  include_once($ruta."funciones/funciones.php");

  session_start();
  extract($_GET);
  //$fechaactual=date('Y-m-d');
  $idalmacen=dcUrl($lblcode);

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="CIERRE DE CAJA";
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
          $idmenu=1;
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
            <!--  <a href="nuevo/" class="btn blue"><i class="fa fa-plus"></i> Nuevo Libro</a><br><br> -->
              <div class="row">
                    <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                        <input type="hidden" id="idalmacen" name="idalmacen" value="<?php echo $idalmacen ?>">
                      <div class="row">
                      <div class="col s12 m12 l2">&nbsp;</div>
                        <div class="col s12 m12 l8">
                         <ul class="collapsible collapsible-accordion" data-collapsible="expandable">                              
                               <li>
                                <div class="collapsible-header teal white-text active"><i class="mdi-device-dvr"></i> VENTAS REALIZADOS</div>
                                <div class="collapsible-body teal lighten-5">
                                   <div class="col s12 m12 l12" style="background-color:#D1F2EB; border: 1px solid #D5D8DC; border-radius:5px;">
                                     <table id="exampleventas" class="display" cellspacing="0" width="100%">
                                          <thead>
                                            <tr>
                                            <th>Cod</th>
                                             <th>Usuario(a)</th>
                                              <th>hora venta</th>
                                              <th>Descuento</th>
                                              <th style="text-align:right;">Monto Bs.</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <?php
                                          /*  SELECT *
                                                        FROM (SELECT *
                                                            FROM venta 
                                                            WHERE fechacreacion='2018-06-22' Order by usuariocreacion asc) A,(SELECT 
                                                                                COUNT(DISTINCT(usuariocreacion)) CANT 
                                                                              FROM venta 
                                                                              WHERE fechacreacion='$fechaactual') B */

                                            $consulta="SELECT *
                                                            FROM invventa 
                                                            WHERE idsucursal=$idalmacen and estado=1 and cierrecaja=0 Order by usuariocreacion asc";
                                             $totalVenta=0;
                                             $totalEfectivo=0;
                                             $totalTarjeta=0;   
                                             $totalDescuento=0;   
                                          $controlventa=0;             
                                            foreach($invventa->sql($consulta) as $f)
                                            {
                                               $vu2 = $vusuario2->muestra($f['usuariocreacion']);
                                              ?>
                                              <tr>
                                              <td><?php echo $f['idinvventa'] ?></td>
                                                <td><?php echo $vu2['nombre'] ?></td>
                                                <td ><?php echo $f['horacreacion'] ?></td>
                                                <td style="text-align:right;"><?php echo $f['descuento'].' %' ?></td>
                                                <td style="text-align:right;"><?php echo number_format($f['total'], 2, '.', '') ?></td>                                                
                                              </tr>
                                              <?php
                                              $totalVenta= $totalVenta+$f['total'];         
                                              $totalEfectivo= $totalEfectivo+$f['efectivo'];
                                              $totalTarjeta= $totalTarjeta+$f['tarjeta'];

                                              $totalDescuento= $totalDescuento+$f['descuento'];
                                              $controlventa =$controlventa+1; 
                                            }
                                            ?>
                                          </tbody>
                                          <thead>
                                            <tr>
                                              <th style="text-align:right;" colspan="5"><?php echo 'TOTAL BS.'.number_format($totalVenta, 2, '.', '') ?></th>
                                            </tr>
                                          </thead>
                                        </table>
                                   </div>
                                </div>
                              </li>
                               <li>
                               <!-- GASTOS-->
                                <div class="collapsible-header red white-text active"><i class="fa fa-money"></i> Gastos</div>
                                <div class="collapsible-body red lighten-5 lighten-5">
                                  <div class="col s12 m12 l12" style="background-color:#FDEDEC; border: 1px solid #D5D8DC; border-radius:5px;">
                                     <table id="examplegastos" class="display" cellspacing="0" width="100%">
                                          <thead>
                                            <tr>
                                            <th>Cod</th>
                                             <th>Usuario(a)</th>
                                              <th>hora registro</th>
                                              <th>Detalle</th>
                                              <th style="text-align:right;">Monto Bs.</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <?php                                         

                                             $totalGasto=0;                   
                                    foreach($invgasto->mostrarTodo("idsucursal=".$idalmacen."  and cierrecaja=0 and estado=1") as $g)
                                    {
                                               $vu2 = $vusuario2->muestra($g['usuariocreacion']);
                                              ?>
                                              <tr>
                                              <td><?php echo $g['idinvgasto'] ?></td>
                                                <td><?php echo $vu2['nombre'] ?></td>
                                                <td ><?php echo $g['horacreacion'] ?></td>
                                                <td ><?php echo $g['detalle'] ?></td>
                                                <td style="text-align:right;"><?php echo number_format($g['monto'], 2, '.', '') ?></td>                                                
                                              </tr>
                                              <?php
                                              $totalGasto= $totalGasto+$g['monto'];                                              
                                    }                                            
                                            ?>
                                          </tbody>
                                          <thead>
                                            <tr>
                                            <th></th>
                                             <th></th>
                                              <th></th>
                                              <th></th>
                                              <th style="text-align:right;"><?php echo 'TOTAL BS.'.number_format($totalGasto, 2, '.', '') ?></th>
                                            </tr>
                                          </thead>
                                        </table>
                                   </div>
                                </div>
                              </li>
                                <!-- SUMATORIO-->
                               <li>
                                <div class="collapsible-header blue white-text active"><i class="fa fa-money"></i> CUENTA FINAL</div>
                                <div class="collapsible-body blue lighten-5 lighten-5">
                                  <div class="card-content col s12 m12 l12" style="background-color:#D6EAF8; border: 1px solid #D5D8DC; border-radius:5px;">                         
                                      <?php
                                      $caci = $cierrecaja->mostrarTodo("idalmacen=".$idalmacen." and estado=1"); 
                                      $caci = array_shift($caci);
                                      $montoinicial=floatval($caci['montoinicial']);
                                      $MontoFinal=$totalEfectivo + $montoinicial - $totalGasto;
                                     ?>
                                     <div class="input-field col col s4 m4"> Monto Inicial en caja:</div>
                                      <div class="input-field col col s8 m8" style="font-size:18px; font-weight:bold;"> <?php echo 'Bs. '.$montoinicial ?><label> Monto inicial refleja en el monto final</label> </div>
                                      <div class="input-field col col s4 m4"> Total Venta:</div>
                                      <div class="input-field col col s8 m8" style="font-size:18px; font-weight:bold;"> <?php echo 'Bs. '.$totalVenta ?> </div>
                                      <div class="input-field col col s4 m4"> Total Efectivo:</div>
                                      <div class="input-field col col s8 m8" style="font-size:18px; font-weight:bold;"> <?php echo 'Bs. '.$totalEfectivo ?> </div>
                                       <div class="input-field col col s4 m4"> Total Tarjeta:</div>
                                      <div class="input-field col col s8 m8" style="font-size:18px; font-weight:bold;"> <?php echo 'Bs. '.$totalTarjeta ?> </div>
                                      <div class="input-field col col s4 m4"> Monto En efectivo a entregar:</div>
                                      <div class="input-field col col s8 m8" style="font-size:18px; font-weight:bold;"> <?php echo 'Bs. '.number_format($MontoFinal, 2, '.', '') ?></div>
                                      <input type="hidden" id="idaentregar" name="idaentregar" value="<?php echo $MontoFinal  ?>">
                                                          
                                         <input style="background:white; font-weight:bold; color:#403F3F" disabled id="idmontofinal" name="idmontofinal" type="hidden" class="validate" value="<?php echo $MontoFinal ?>">
                                           <input style="background:white; font-weight:bold; color:#403F3F" id="idtotalDescuento" name="idtotalDescuento" type="hidden" class="validate" value="<?php echo $totalDescuento ?>">
                                      <div class="input-field col col s4 m4"> Observación:</div>
                                      <div class="input-field col col s8 m8">
                                        <textarea style="background:white;" id="idobservacion" name="idobservacion"></textarea>
                                      </div>
                                      
                                       <div class="input-field col col s12 m12" align="right"> 
                                            <button id="btnSave" type="button" style="" onclick="guardarcierrecaja();" class="btn green"> Ejecutar Cierre de Caja</button> 
                                      </div>
                                       
                                    </div>
                                </div>
                              </li>
                         </ul>
                        </div>
                         <div class="col s12 m12 l2">&nbsp;</div>                     
                        
                      </div>
                    </form>
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

    function ingresar(id,name)
    {
      swal({
        title: "BIENVENIDO",
        text: "MODULO DE VENTAS "+ name,
        type: "success",
        showCancelButton: true,
        confirmButtonColor: "#58D68D",
        confirmButtonText: "ENTRAR",
        closeOnConfirm: false
      }, function () {
            location.href='venta/index.php?lblcode='+id;         
      });
    }
    function enviavalor(idalm)
    {
      $("#idalmacen").val(idalm);
    }
    function guardarcierrecaja()
    {
      var controlV='<?php echo $controlventa ?>';
       if (validar()) {
                //$('#btnSaveTotal').attr("disabled",true);
        swal({
              title: "¿Estas seguro?",
              text: "Proceguir con cierre de Caja",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#E74C3C",
              confirmButtonText: "SI",
              closeOnConfirm: false
            }, function () {
                        //GUARDAR CIERRE
                          var str = $( "#idform" ).serialize();
                            $.ajax({
                              url: "guardar.php",
                              type: "POST",
                              data: str+"&controlventa="+controlV,
                              success: function(resp){                  
                                  console.log(resp);
                                  //alert(resp);
                                  $('#idresultado').html(resp); 
                                    if (resp==1) 
                                    {
                                       //ACTUALIZABANDO TABLA invventa
                                      var codigo;
                                        $("#exampleventas tbody tr").each(function (index)
                                        {
                                          $(this).children("td").each(function (index2)
                                          {
                                            switch (index2)
                                            {
                                              case 0: codigo = $(this).text();
                                              break;
                                            }
                                          });
                                          //alert(codigo);
                                          actualizarventas(codigo);
                                        });
                                     //ACTUALIZANDO TABLA invgasto
                                      var codigo2;
                                        $("#examplegastos tbody tr").each(function (index)
                                        {
                                          $(this).children("td").each(function (index2)
                                          {
                                            switch (index2)
                                            {
                                              case 0: codigo2 = $(this).text();
                                              break;
                                            }
                                          });
                                          //alert(codigo2);
                                          actualizargastos(codigo2);
                                        });  

                                        swal({
                                              title: "EXITO!!!",
                                              text: "Cierre de caja ejecutado correctamente",
                                              type: "success",
                                             // showCancelButton: true,
                                              confirmButtonColor: "#58D68D",
                                              confirmButtonText: "OK",
                                              closeOnConfirm: false
                                            }, function () { 
                                                      location.href = "../";
                                                       
                                          });
                                             
                                    }
                                    if (resp==2) 
                                    {
                                      swal("ERROR!", "No se guardo, consulte con de sistemas", "error");
                                    }
                                    if (resp==3) 
                                    {
                                      swal("ERROR!", "Verificar, ya se ejecuto el cierre de caja", "error");
                                    }
                                    if (resp==4) 
                                    {
                                        swal({
                                              title: "Alerta",
                                              text: "Se actualizara la pagina porque existe ventas pendientes, ajecute el cierre nuevamente",
                                              type: "warning",
                                             // showCancelButton: true,
                                              confirmButtonColor: "#CB0202",
                                              confirmButtonText: "OK",
                                              closeOnConfirm: false
                                            }, function () { 
                                                     location.reload();
                                                       
                                          });

                                    }
                              }
                            });          
            });
              
          }else{
            swal("ERROR!", "Valor no valido", "error")
          }

    }
    function actualizarventas(codigo)
    {
         //var str = $( "#idform" ).serialize();
            $.ajax({
              url: "actualizaest.php",
              type: "POST",
              data: "idinvventa="+codigo,
              success: function(resp){                  
                  console.log(resp);
                  $('#idresultado').html(resp);  
               
              }
            }); 
    }
    function actualizargastos(codigo2)
    {
         //var str = $( "#idform" ).serialize();
            $.ajax({
              url: "actualizaestG.php",
              type: "POST",
              data: "idinvgasto="+codigo2,
              success: function(resp){                  
                  console.log(resp);
                  $('#idresultado').html(resp);  
               
              }
            }); 
    }
   
  function validar(retorno){
        var retorno=true;
        var monto=$("#idmontofinal").val();
        var vacio=$("#idmontofinal").val();
        if (monto=="0" || vacio=="") {
          retorno=false;
        }
        return retorno;
      }
    </script>
</body>

</html>