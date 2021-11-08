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
  $idusuario=$_SESSION['codusuario'];
  $idusuario=ecUrl($idusuario);
  
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="PUNTOS DE VENTA";
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
          $idmenu=1028;
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
                <div id="modal2" class="modal" > 

                  <div class="modal-content"> 
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                       <input type="hidden" id="idalmacen" name="idalmacen">
                       <div align="right">
                         <button class="btn-jh waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i></button>                         
                       </div>
                        
                      <div class="row">
                      <div id="card-alert" class="col s12 m12 l6 card green lighten-5">
                        <div class="card-content">
                           <div align="center" >Usuario(a):<label id="idusuariocaja" style="color:#00BBC7; text-decoration:none; font-size:25px;"> <?php echo $dusuario['nombre'].' '.$dusuario['paterno'] ?> </label></div>
                          <div style="text-align:center;"> 
                          <div align="center" >Fecha:<label style="color:#00BBC7; text-decoration:none; font-size:17px;"> <?php echo $fechaactual ?></label></div>
                          <div align="center" >Hora:<label style="color:#00BBC7; text-decoration:none; font-size:17px;"> <?php echo $horaactual ?></label></div>
                          </div>
                         
                        </div>
                      
                      </div>
                      <div class="col s12 m12 l6">
                        <div class="card-content col s12 m12 l12" style="background-color:#ffffff; border: 1px solid #D5D8DC; border-radius:5px;">                         
                          <div class="input-field col col s12 m4">Monto Inicial Caja
                          </div>
                          <div class="input-field col col s12 m8">                          
                            <input id="idmontoinicial" name="idmontoinicial" type="number" class="validate" value="0">
                            <label for="idmontoinicial"><i class="fa fa-money"></i> Monto Inicial</label>
                          </div>
                           
                        </div>
                        <div> 
                              <button id="btnSave" type="button" style="width:100%;" onclick="abrecaja();" class="btn green"> Iniciar caja</button> 
                        </div>
                         </div>                      
                        
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    &nbsp;
                  </div>
                </div>
             </div>
            </div>  
          </div> 
          <div class="container">
            <div class="section">
            <!--  <a href="nuevo/" class="btn blue"><i class="fa fa-plus"></i> Nuevo Libro</a><br><br> -->
              <div class="col s12 m12 l6">
                <table id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Sucursal</th>
                      <th>Dirección</th>
                      <th>Zona</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sw=true;
                    foreach($almacen->mostrarTodo("tipo_almacen=2") as $f)
                    {
                      $lblcode=ecUrl($f['idalmacen']);
                      $cc = $cierrecaja->mostrarTodo("idalmacen=".$f['idalmacen']." and estado=1"); 
                     // $cc = array_shift($cc);
                      ?>
                      <tr>
                        <td><?php echo $f['nombre'] ?></td>
                        <td><?php echo $f['direccion'] ?></td>
                        <td><?php echo $f['zona'] ?></td>
                        <td>
                        <?php 
                            if (count($cc)>0) 
                            {
                               ?>
                               <button class="btn green" onclick="ingresar('<?php echo $lblcode ?>','<?php echo $f['nombre'] ?>','<?php echo $idusuario ?>')"><i class="mdi-action-exit-to-app"></i>INGRESAR A VENTAS </button>
                               <button class="btn red" onclick="cierre('<?php echo $lblcode ?>')"><i class="mdi-action-exit-to-app"></i>INICIAR CIERRE DE CAJA</button>
                              <?php
                            }else{
                                ?>
                                 <button type='button' id='btniniciacaja' href="#modal2" class='btn blue modal-trigger' onclick="enviavalor('<?php echo $f['idalmacen'] ?>');"><i class="fa fa-money"></i> Iniciar caja</button>
                              <?php
                            }
                         ?>
                          
                         
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

    function ingresar(id,name,idusuario)
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
            location.href='venta/index.php?lblcode='+id+'&idusuario='+idusuario;         
      });
    }
    function enviavalor(idalm)
    {
      $("#idalmacen").val(idalm);
    }
    function abrecaja()
    {
       if (validar()) {
            //$('#btnSaveTotal').attr("disabled",true);
            var str = $( "#idform" ).serialize();
            $.ajax({
              url: "abrircaja.php",
              type: "POST",
              data: str,
              success: function(resp){
                setTimeout(function(){     
                  console.log(resp);
                  $('#idresultado').html(resp);  
                }, 10); 
              }
            });
          }else{
            swal("ERROR!", "Valor no valido", "error")
          }
    }
  function validar(retorno){
        var retorno=true;
        var monto=$("#idmontoinicial").val();
        if (monto=="") {
          retorno=false;
        }
        return retorno;
      }

      function cierre(idalm)
    {
      swal({
        title: "¿Estas Seguro?",
        text: "Iniciar Cierre de caja",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#E74C3C",
        confirmButtonText: "Si, estoy seguro",
        closeOnConfirm: false
      }, function () {      
                   location.href='cierre/?lblcode='+idalm;     
                
      });
    }
    </script>
</body>

</html>