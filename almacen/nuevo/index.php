<?php
  $ruta="../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio; 
  include_once($ruta."funciones/funciones.php");
  session_start();  

   extract($_GET);
 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Registrar Almacen";
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
          $idmenu=40;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
           
           <div class="row section">
                    <div class="col s12 m12 l1">
                      <p></p>
                    </div>
                    <div class="col s10">
                    <ul class="tabs tab-demo-active z-depth-1 cyan">
                      <li class="tab col s3"><a class="white-text waves-effect waves-light active" href="#persona">REGISTRO ALMACEN</a>
                      </li>
                     
                    </ul>
                  </div>
               
           <div class="col s12">
 <div class="col s12 m12 l1">
                      <p></p>
                    </div>
            <div id="persona" class="col s10  cyan lighten-4">
                 <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                <div class="col s12 m12 l12">
                
                    <div class="formcontent">  
                      <div class="row">  
                        <div id="valCarnet" class="col s12"></div>
                         
                         
                        <div class="input-field col s6">
                          <input id="idnombre" name="idnombre" type="text" class="validate">
                          <label for="idnombre">NOMBRE</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idzona" name="idzona" type="text" class="validate">
                          <label for="idzona">ZONA</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="iddireccion" name="iddireccion" type="text" class="validate active">
                          <label for="iddireccion">DIRECCION</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idtelefono" name="idtelefono" type="number" class="validate">
                          <label for="idtelefono">TELEFONO</label>
                        </div>  
                        <div class="input-field col s6">
                          <input id="iddescripcion" name="iddescripcion" type="text" class="validate">
                          <label for="iddescripcion">DESCRIPCION</label>
                        </div>
                          <div class="input-field col s12 m6 l6">
                            <label>TIPO</label>
                            <select id="idtipo" name="idtipo">
                              <?php
                                    foreach($dominio->mostrarTodo("tipo='inventario' ") as $m)
                                    {
                                      
                                      ?> 
                                        <option value="<?php echo $m['codigo'] ?>"><?php echo $m['nombre']; ?></option>
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
            text: "Se registrara Nuevo Almacen",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2c2a6c",
            confirmButtonText: "Registrar",
            closeOnConfirm: false
          }, function () {
            var str = $( "#idform" ).serialize();
          //  alert(str);
            $.ajax({
              url: "guardar.php",
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
           swal("ERROR!", "Faltan datos", "error")
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