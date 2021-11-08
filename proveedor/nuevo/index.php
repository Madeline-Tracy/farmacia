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
      $hd_titulo="Registrar Laboratorio";
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
                    <ul class="tabs tab-demo-active z-depth-1 cyan">
                      <li class="tab col s3"><a class="white-text waves-effect waves-light active" href="#persona">REGISTRO Laboratorio</a>
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
                          <input id="idempresa" name="idempresa" type="text" class="validate">
                          <label for="idempresa">Empresa</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idnit" name="idnit" type="number" class="validate">
                          <label for="idnit">NIT</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="iddireccion" name="iddireccion" type="text" class="validate active">
                          <label for="iddireccion">Direccion</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idtelefono" name="idtelefono" type="number" class="validate">
                          <label for="idtelefono">Telefono</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idencargado" name="idencargado" type="text" class="validate">
                          <label for="idencargado">Encargado</label>
                        </div>  
                         
                          <div class="input-field col s6">
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
            text: "Se registrara Nuevo proveedor",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2c2a6c",
            confirmButtonText: "Registrar",
            closeOnConfirm: false
          }, function () {
            var str = $( "#idform" ).serialize();
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
           swal("DATOS FALTANTES");
        }
      });
      function validar(){
        retorno=true;
        empresa=$('#idempresa').val();
        nit=$('#idnit').val();
        direccion=$('#iddireccion').val();
        encargado=$('#idencargado').val();
        telefono=$('#idtelefono').val();
        if(empresa=="" || nit=="" || direccion=="" || encargado=="" || encargado =="" ){
          retorno=false;
        }
        return retorno;
      }
      
    </script>
</body>

</html>