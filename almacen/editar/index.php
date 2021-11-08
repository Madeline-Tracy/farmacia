<?php
  $ruta="../../";
  include_once($ruta."class/almacen.php");
  $almacen=new almacen; 
  include_once($ruta."class/dominio.php");
  $dominio=new dominio; 
  include_once($ruta."funciones/funciones.php");
  session_start();  

   extract($_GET);
 
  $valor=dcUrl($lblcode);
  $datop = $almacen->muestra($valor); 
  //$datop = array_shift($datop);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Modificar Laboratorio";
      include_once($ruta."includes/head_basico.php");
    ?>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=1025;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
           
           <div class="row section">
     
                   

                    <div class="col s12 m12 l1">
                      <p></p>
                    </div>
                    <div class="col s10">
                    <ul class="tabs tab-demo-active z-depth-1 green">
                      <li class="tab col s3"><a class="white-text waves-effect waves-light active" href="#persona">MOdificar datos de Almacen</a>
                      </li>
                     
                    </ul>
                  </div>
               
           <div class="col s12">
 <div class="col s12 m12 l1">
                      <p></p>
                    </div>

            <div id="persona" class="col s10  green lighten-4">
                 <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                 <input id="idalmacen" name="idalmacen" type="text" readonly value="<?php echo $valor; ?>">
                <div class="col s12 m12 l12">
                  
                    <div class="formcontent">  
                      <div class="row">  
                        <div id="valCarnet" class="col s12"></div>
                         
                         
                        <div class="input-field col s6">
                          <input id="idnombre" name="idnombre" type="text" class="validate" value="<?php echo $datop['nombre'] ?>">
                          <label for="idnombre">NOMBRE</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idzona" name="idzona" type="text" class="validate" value="<?php echo $datop['zona'] ?>">
                          <label for="idzona">ZONA</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="iddireccion" name="iddireccion" type="text" class="validate active"  value="<?php echo $datop['direccion'] ?>">
                          <label for="iddireccion">DIRECCION</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idtelefono" name="idtelefono" type="number" class="validate"  value="<?php echo $datop['telefono'] ?>">
                          <label for="idtelefono">TELEFONO</label>
                        </div>  
                        <div class="input-field col s6">
                          <input id="iddescripcion" name="iddescripcion" type="text" class="validate"  value="<?php echo $datop['descripcion'] ?>">
                          <label for="iddescripcion">DESCRIPCION</label>
                        </div>
                          <div class="input-field col s12 m6 l6">
                            <label>TIPO</label>
                            <select id="idtipo" name="idtipo">
                              <?php
                                    foreach($dominio->mostrarTodo("tipo='inventario'") as $m)
                                    {
                                      $sw="";
                                      if ($datop['tipo_almacen']==$m['codigo']) 
                                      {
                                         $sw="selected";
                                      }
                                      ?>
                                        <option <?php echo $sw ?> value="<?php echo $m['codigo']; ?>"><?php echo $m['nombre']; ?></option>
                                      <?php
                                    }
                                  ?>
                            </select>
                          </div>
                         
                          <div class="input-field col s6">
                          <a class="btn red" href="../"><i class="fa fa-reply"></i> Atrás</a>
                          <a id="btnSave" class="btn waves-effect waves-light blue"><i class="fa fa-save"></i> Guardar</a>
                        </div> 


                                               
                      </div>
  
                         
                     
                    </div>
                </div>
              </form>

            </div>
           
          </div>
                  
             


            </div> 
          <?php
           // include_once("../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <?php
      include_once($ruta."includes/script_basico.php");
    ?>
    <script type="text/javascript">
      
      $("#btnSave").click(function(){
        $('#btnSave').attr("disabled",true);
        if (validar()) {          
          swal({
            title: "CONFIRMACION",
            text: "Se Actualizará los datos",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2c2a6c",
            confirmButtonText: "Actualizar",
            closeOnConfirm: false
          }, function () {
            var str = $( "#idform" ).serialize();
            $.ajax({
              url: "actualizar.php",
              type: "POST",
              data: str,
              success: function(resp){
                console.log(resp);
                $("#idresultado").html(resp);
              }
            }); 
          });
        }
        else{
           swal("DATOS FALTANTES");
        }
      });
      function validar(){
        retorno=true;
          alm=$('#idnombre').val();
        zon=$('#idzona').val();
        direccion=$('#iddireccion').val();
        if(alm=="" || zon=="" || direccion==""){
          retorno=false;
        }
        return retorno;
      }
      
    </script>
</body>

</html>