<?php
  $ruta="../";
  include_once($ruta."class/almacen.php");
  $almacen=new almacen;
  include_once($ruta."class/cierrecaja.php");
  $cierrecaja=new cierrecaja;
  include_once($ruta."funciones/funciones.php");

  session_start();
  $fechaactual=date('Y-m-d');
  $horaactual=date('H:i:s');
  $fechainicio=date('Y-m-01');

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="REPORTES";
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
          $idmenu=1033;
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
                      <th>Reporte</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>                  
                      <tr style="<?php echo $formato ?>">
                        <td>REPORTE DE VENTAS</td>
                        <td>
                        <a href="#modal2" class='btn green modal-trigger'><i class="fa fa-file-text-o"></i> Ver PDF</a>
                        </td>
                      </tr>
                  </tbody>
                </table>
              </div>
              <div class="col s12 m12 l2">&nbsp;</div>
              </div>
            </div>
          </div>

          <div class="container">
            <div class="section">
             <div class="row">
                <div id="modal2" class="modal" style="width:70%; height:100%;">
                  <div class="modal-content">
                    <div align="right">
                      <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i></button>
                    </div>
                    <form class="col s12" id="idForm" action="return false" onsubmit="return false" method="POST">
                      <div class="row">
                           <div class="input-field col s12 m12 l12" style="font-weight:bold;">
                             <label>TIPO PRODUCTO</label>
                                  <select id="idalmacen" name="idalmacen">
                               <!--    <option value="0">Seleccionar</option> -->
                                    <?php
                                          foreach($almacen->mostrarTodo("tipo_almacen=2") as $t)
                                          {                                            
                                            ?> 
                                              <option value="<?php echo $t['idalmacen'] ?>"><?php echo $t['nombre']; ?></option>
                                            <?php
                                          }
                                        ?>
                                  </select>
                          </div>
                          

                        <div class="col s12 m12 l12" style="background-color:#ffffff; border: 1px solid #D5D8DC; border-radius:5px; font-weight:bold;">                       
                         
                          <div class="input-field col s12 m12 l3">
                             <label>Tipo factura</label>
                              <select id="idesfactura2" name="idesfactura2">
                               <option value="10">Todos</option> 
                                <option value="1">Factura</option>
                                <option value="0">Sin factura</option>
                              </select>
                          </div>
                          <div class="input-field col col s12 m3">
                            <input id="idfechaini2" name="idfechaini2" type="date" class="validate" value="<?php echo $fechainicio ?>">
                            <label for="idfechaini2"><i class="fa fa-user"></i>Fecha inicio</label>
                          </div>
                          <div class="input-field col col s12 m3" style="font-weight:bold;">
                            <input id="idfechafin2" name="idfechafin2" type="date" class="validate" value="<?php echo $fechaactual ?>">
                            <label for="idfechafin2"><i class="fa fa-user"></i>Fecha Fin</label>
                          </div> 
                          <div class="col col s12 m3" style="font-weight:bold;">
                            <button id="btnventas" onclick="ventas('2');" type="button" class="btn green">GENERAR REPORTE</button> 
                          </div>                          
                        </div>
                        <div class="col col s12 m12">&nbsp;</div>

                        <div class="col s12 m12 l12" style="background-color:#ffffff; border: 1px solid #D5D8DC; border-radius:5px; font-weight:bold;">                       
                         
                            <div class="input-field col s12 m12 l3">
                               <label>Tipo factura</label>
                                <select id="idesfactura3" name="idesfactura3">
                                  <option value="10">Todos</option>
                                  <option value="1">Factura</option>
                                  <option value="0">Sin factura</option>
                                </select>
                            </div>
                            <div class="input-field col col s12 m3">
                              <input id="idfechaini3" name="idfechaini3" type="date" class="validate" value="<?php echo $fechainicio ?>">
                              <label for="idfechaini3"><i class="fa fa-user"></i>Fecha</label>
                            </div>
                            <div class="input-field col col s12 m3" style="font-weight:bold;">
                              &nbsp;
                            </div>
                            <div class="col col s12 m3" style="font-weight:bold;">
                            <button id="btnventas" onclick="ventas('3');" type="button" class="btn green">GENERAR REPORTE</button> 
                          </div>                           
                        </div>
                         <div class="col col s12 m12">&nbsp;</div>

                         <div class="col s12 m12 l12" style="background-color:#ffffff; border: 1px solid #D5D8DC; border-radius:5px; font-weight:bold;"> 
                            <div class="input-field col s12 m12 l3">
                               <label>Tipo factura</label>
                                <select id="idesfactura4" name="idesfactura4">
                                  <option value="10">Todos</option>
                                  <option value="1">Factura</option>
                                  <option value="0">Sin factura</option>
                                </select>
                            </div>
                            <div class="input-field col col s12 m3">
                              &nbsp;
                            </div>
                            <div class="input-field col col s12 m3" style="font-weight:bold;">
                              &nbsp;
                            </div>
                            <div class="col col s12 m3" style="font-weight:bold;">
                            <button id="btnventas" onclick="ventas('4');" type="button" class="btn green">GENERAR REPORTE</button> 
                          </div>                           
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    
                  </div>
                </div>
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
    function ventas(opc)
    {
      //var str = $("#idForm").serialize();
      var idalmacen = $("#idalmacen").val();
     activo=0;
       if (opc==2) 
       {
           var esfactura = $("#idesfactura2").val();
           var fechaini = $("#idfechaini2").val();
           var fechafin = $("#idfechafin2").val();
            if (fechaini=="" || fechafin=="") 
            {
              activo=0;
            }else{
              activo=1;
            }      
       }
       if (opc==3) 
       {
           var esfactura = $("#idesfactura3").val();
           var fechaini = $("#idfechaini3").val();
           var fechafin = "";
           if (fechaini=="") 
            {
              activo=0;
            }else{
              activo=1;
            }      
       }
       if (opc==4) 
       {
           var esfactura = $("#idesfactura4").val();
           var fechaini = "";
           var fechafin = "";
           activo=1;
       }

       if (activo==1) 
       {
           popup=window.open("pdf/ventas.php?idalmacen="+idalmacen+"&idesfactura="+esfactura+"&idfechaini="+fechaini+"&idfechafin="+fechafin+"&opcion="+opc);
       }else{
          swal("Error","Verifique las fechas","error");
       }
     
    }
    </script>
</body>

</html>