<?php
  $ruta="../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/files.php");
  $files=new files;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/admjerarquia.php");
  $admjerarquia=new admjerarquia;
  include_once($ruta."class/domicilio.php");
  $domicilio=new domicilio;
  include_once($ruta."funciones/funciones.php");
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/rol.php");
  $rol=new rol;

  session_start();
   extract($_GET);
  $valor=dcUrl($lblcode);
  
  $dus=$usuario->mostrarUltimo("idpersona=$valor");
  $dper=$persona->muestra($valor);
  $ddom = $domicilio->mostrarTodo("idpersona = $valor"); 
  $ddom = array_shift($ddom);
  /******** foto ***********/
$dfoto=$files->mostrarTodo("id_publicacion=".$valor." and tipo_foto='foto'");
$dfoto=array_shift($dfoto);
if (count($dfoto)>0) {
    $rutaFoto=$ruta."persona/editar/server/php/".$valor."/".$dfoto['name'];
}
else{
    $rutaFoto=$ruta."imagenes/user.png";
}
    /******** foto ***********/
     
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Registrar usuario";
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
          $idmenu=11;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
           
           <div class="row section">
                   
                   
 


                <div class="col s12">
                   <div class="col s12 m12 l1">
                      <p></p>
                    </div>
                  <div id="primera" class="col s10  ">
         <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                <input id="idpersona" name="idpersona" value="<?php echo $valor ?>" type="hidden" class="validate">
                <div class="col s12 m12 l12">
                     
                    <div class="" style="background: white">
                       


 

   

 <ul class="tabs   z-depth-0 green lighten-2">
        <li class="tab col s3">
           <a class="label white-text     offset-s4 l2 offset-l1" data-position="button" data-delay="50" data-tooltip="Editar Datos Persona" href="../../../persona/editar/?lblcode=<?php echo $lblcode; ?>", target="_blank"> DATOS PERSONA <i class="mdi-editor-border-color"></i></a>
        </li>
      </ul>

<div class="col s12 red-text green lighten-4" > 
    <div class="col s10"> 
          <div id="valCarnet" class="col s12"></div>
          <div class="input-field col s2">
            <input id="CC" name="CC" type="text" readonly="" value="<?php echo $dper['carnet'] ?>" >
            <label for="idcarnet">CARNET</label>
          </div>
          <div class="input-field col s1">
            <label>Exp.</label>
            <select id="idexp" name="idexp" disabled="">
              <option disabled value="">Seleccionar Departamento</option>
              <?php
                foreach($dominio->mostrarTodo("tipo='DEP'") as $f)
                {
                  $sw="";
                  if ($dper['expedido']==$f['short']) {
                     $sw="selected";
                  }
                  ?>
                    <option <?php echo $sw ?> value="<?php echo $f['short']; ?>"><?php echo $f['nombre']; ?></option>
                  <?php
                }
              ?>
            </select>
          </div>
          <div class="input-field col s3">
            <input id="idnombre" name="idnombre" readonly="" value="<?php echo $dper['nombre'] ?>" type="text" >
            <label for="idnombre">Nombre(s)</label>
          </div>
          <div class="input-field col s3">
           <input id="idpaterno" name="idpaterno" readonly=""  value="<?php echo $dper['paterno'] ?>" type="text" >
            <label for="idpaterno">Paterno</label>
          </div>
          <div class="input-field col s3">
            <input id="idmaterno" name="idmaterno" readonly="" value="<?php echo $dper['materno'] ?>" type="text"  >
            <label for="idmaterno">Materno</label>
          </div>
      
          <div class="input-field col s3"> 
            <input id="idemail" name="idemail" readonly=""  value="<?php echo $dper['email'] ?>" type="email" >
            <label for="idemail">Email</label>
          </div>  
          <div class="input-field col s3">
            <input id="idcelular" name="idcelular" readonly=""  value="<?php echo $dper['celular'] ?>" type="text" >
            <label for="idcelular">Celular(es)</label>
          </div>
        
          <div class="input-field col s3">
            <input id="idocupacion" name="idocupacion"  readonly="" value="<?php echo $dper['ocupacion'] ?>" type="text" >
            <label for="idocupacion">Ocupacion</label>
          </div> 
          <div class="input-field col s3">
            <a class="btn btn-info" href="../../../persona/editar/?lblcode=<?php echo $lblcode; ?>", target="_blank"> <i class="mdi-editor-border-color"></i>MODIFICAR </a>
          </div> 
      </div> 

       <div class="col s2"> 
           <a class="modal-trigger" style="height: 100px" href="#modal4"><img src="<?php echo $rutaFoto ?>"  width="100" > </a>
      </div> 
  </div> 

<ul class="tabs tab-demo-active  green lighten-2">
        <li class="tab col s3">
           <a class="label white-text     offset-s4 l2 offset-l1" data-position="top" data-delay="50" data-tooltip="Editar Datos Persona" href="#" > DATOS USUARIO <i class="mdi-action-assignment-ind"></i></a>
        </li>
      </ul>

                      
<div class="col s12 red-text green lighten-5" > 
                         
       
                            <div class="input-field col s12">
                    <?php
                      if (count($dus)>0) {
                        ?> 
                            <input type="hidden" name="idus" id="idus" value="<?php echo $dus['idusuario'] ?>">
                            <div class="input-field col s6">
                              <input id="idusmod" name="idusmod" type="text" readonly="" value="<?php echo $dus['usuario'] ?>" class="validate">
                              <label for="idusmod">USUARIO</label>
                            </div>
                            <div class="input-field col s6">
                              <input id="idusante" name="idusante" type="password" class="validate">
                              <label for="idusante">CONTRASEÑA ANTERIOR</label>
                            </div>                            
                            <div class="input-field col s6">
                              <input id="idpass1" name="idpass1" type="password" class="validate">
                              <label for="idpass1">NUEVA CONTRASEÑA</label>
                            </div>
                            <div class="input-field col s6">
                              <input id="idpass2" name="idpass2" type="password" class="validate">
                              <label for="idpass2">REPITA CONTRASEÑA</label>
                            </div>
                            <div class="input-field col s6">
                                <label>ASIGNAR ROL</label>
                                <select id="idrol" name="idrol">
                                  <?php
                                    foreach($rol->mostrarTodo("") as $f)
                                    {
                                      ?>
                                        <option value="<?php echo $f['idrol']; ?>"><?php echo $f['Nombre']; ?></option>
                                      <?php
                                    }
                                  ?>
                                </select>
                              </div>
                            <div class="input-field col s6">
                              <button style="width: 100%" id="btnEdit" class="btn green"><i class="fa fa-save"></i> GUARDAR CAMBIOS</button>
                            </div> 
                        <?php
                      }
                      else{
                        ?>
                          
                            <div class="input-field col s6">
                              <input id="idusuario" name="idusuario" type="text" class="validate">
                              <label for="idusuario">USUARIO</label>
                            </div>
                            <div class="input-field col s6">
                              <input id="idpass1" name="idpass1" type="password" class="validate">
                              <label for="idpass1">CONTRASEÑA</label>
                            </div>
                            <div class="input-field col s6">
                              <input id="idpass2" name="idpass2" type="password" class="validate">
                              <label for="idpass2">REPITA CONTRASEÑA</label>
                            </div>
                            <div class="input-field col s6">
                                <label>ASIGNAR ROL</label>
                                <select id="idrol" name="idrol">
                                  <?php
                                    foreach($rol->mostrarTodo("") as $f)
                                    {
                                      ?>
                                        <option value="<?php echo $f['idrol']; ?>"><?php echo $f['Nombre']; ?></option>
                                      <?php
                                    }
                                  ?>
                                </select>
                              </div>
                            <div class="input-field col s6">
                              <button style="width: 100%" id="btnSave" class="btn green"><i class="fa fa-save"></i> GUARDAR</button>
                            </div> 
                        <?php
                      }
                    ?>
                    


                  </div>
                        
                       
                       
                    
                     
                  
                        
                                   
                      </div>
                    </div>
                </div>
              </form> 
                  </div> 
                        <div id="modal4" class="modal modal-fixed-footer green lighten-2 white-text">
                         <div class="modal-content"> 
                                      <center>                  
                                            <img src="<?php echo $rutaFoto ?>"  width="350" >
                                   </center> 
     
                          </div> 
                     <div class="modal-footer"> 
                       <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close">Cerrar</a>
                      </div>
                ` </div> 

            </div>
            </div> 
          <?php
            include_once("../../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <?php
      include_once($ruta."includes/script_basico.php");
    ?>
    <script type="text/javascript">
      $("#idusante").blur(function(){
        nusuario=$("#idusmod").val();
        pass=$("#idusante").val();
        $.ajax({
            url: "valpass.php",
            type: "POST",
            data: 'idusmod='+nusuario+'&idusante='+pass,
            success: function(resp){
              console.log(resp);
              $("#idresultado").html(resp);
            }
          });
      });
      $("#idusuario").blur(function(){
        nusuario=$("#idusuario").val();
        $.ajax({
            url: "validaUsuario.php",
            type: "POST",
            data: 'idusuario='+nusuario,
            success: function(resp){
              console.log(resp);
              $("#idresultado").html(resp);
            }
          });
      });
     

$("#btnEdit").click(function(){

if (validarU()) {   
         if (validarC()) {   
                if (validar()) {   
                          $('#btnEdit').attr("disabled",true);
                        swal({
                          title: "CONFIRMACION",
                          text: "Esta seguro de modificar la contraseña?",
                          type: "warning",
                          showCancelButton: true,
                          confirmButtonColor: "#2c2a6c",
                          confirmButtonText: "Registrar",
                          closeOnConfirm: false
                        }, function () {
                          var str = $( "#idform" ).serialize();
                         // alert(str);
                          $.ajax({
                            url: "modificar.php",
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
                    Materialize.toast('<span>Las contraseñas no coinciden.</span>', 1500);
                    $("#idpass1").focus();
                  } 
          }
          else{
            Materialize.toast('<span>Inserte Una contraseña.</span>', 1500);
            $("#idpass1").focus();
          } 
       }
    else{
      Materialize.toast('<span>Inserte usuario </span>', 1500);
      $("#idusuario").focus();
    }
 });
 $("#btnSave").click(function(){

if (validarU()) {   
         if (validarC()) {   
                if (validar()) {   
                    $('#btnSave').attr("disabled",true);
                    swal({
                      title: "CONFIRMACION",
                      text: "Se registrara el usuario",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonColor: "#2c2a6c",
                      confirmButtonText: "Registrar",
                      closeOnConfirm: false
                    }, function () {
                      var str = $( "#idform" ).serialize();
                      //alert(str);
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
                    Materialize.toast('<span>Las contraseñas no coinciden.</span>', 1500);
                    $("#idpass1").focus();
                  } 
          }
          else{
            Materialize.toast('<span>Inserte Una contraseña.</span>', 1500);
            $("#idpass1").focus();
          } 
       }
    else{
      Materialize.toast('<span>Inserte usuario </span>', 1500);
      $("#idusuario").focus();
    }
 });

    function validar(){
        retorno=false;
        pass1=$("#idpass1").val();
        pass2=$("#idpass2").val();
        passX=$("#idusante").val();
        if (pass1==pass2) { 
            if (passX!='') {
                 
                    retorno=true;
                 
              } 
        }
  
        return retorno;
      }
      function validarC(){
        retorno=false;
        pass1=$("#idpass1").val();
        pass2=$("#idpass2").val(); 
         
             if (pass1!='') {
                 if (pass2!='') {
                      retorno=true;
                  } 
            } 
                
        return retorno;
      } 
      function validarU(){
        retorno=false;
        u=$("#idusuario").val(); 
         
             if (u!='') {
                  
                      retorno=true;
                   
            } 
                
        return retorno;
      }

      
    </script>
</body>

</html>
