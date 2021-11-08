<?php
  $ruta="../../../";
  include_once($ruta."class/invitem.php");
  $invitem=new invitem;
  include_once($ruta."class/marca.php");
  $marca=new marca;
  include_once($ruta."class/tipoproducto.php");
  $tipoproducto=new tipoproducto;
  include_once($ruta."funciones/funciones.php");
  session_start(); 
  extract($_GET);


  $valor=dcUrl($lblcode);
  $ditem=$invitem->muestra($valor);
  $dmarca=$marca->muestra($ditem['idmarca']);

  $idusuario=$_SESSION["codusuario"];
  $adress=$_SERVER['REQUEST_URI'] ;
  $_SESSION["codempresa"]=$valor;


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="EDITAR LIBRO";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
      include_once($ruta."includes/head_foto.php");
    ?>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">  
 <style type="text/css">   

.bordeado{
  border: 1px solid #d8d8d8; 
  border-radius:5px;
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
          $idmenu=91;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i><?php echo $ditem['nombre'] ?>
                  </h5>
                  <a class="btn blue" href="../"><i class="fa fa-reply"></i> Atrás</a>
                  <a href="../nuevo" class="btn waves-effect waves-light purple"><i class="fa fa-plus"></i> Nuevo</a> 
                  <ol class="breadcrumbs">
                  </ol>    
                </div>
              </div>   
            </div>
          </div>
          <div class="container">
              <div class="row">
                <div class="col s6 m8 l8">
                  <fieldset class="formulario">
                    <legend>Ingrese los datos</legend>
                    <form class="col s12" id="idform" name="idform" action="return false" onsubmit="return false" method="POST">
                      <input type="hidden" name="iditem" id="iditem" value="<?php echo $valor; ?>">
                      <div class="row">
                        <div class="row">
                          <div class="input-field col col s12 m12">
                            <input id="idnombre" name="idnombre" type="text" class="validate" value="<?php echo $ditem['nombre'] ?>">
                            <label for="idnombre">Nombre Item</label>
                          </div>
                          

                          <div class="input-field col col s12 m12">
                            <input id="idprecio" name="idprecio" type="text" onblur="validaFloat(this.value);" class="validate" value="<?php echo $ditem['precio'] ?>">
                            <label for="idprecio">Precio</label>
                          </div>
                          <div class="input-field col col s12 m6">
                            <input type="hidden" name="idmarca" id="idmarca" value="<?php echo $ditem['idmarca'] ?>">
                            <input id="idmarcaNombre" name="idmarcaNombre" value="<?php echo $dmarca['nombre'] ?>" readonly="" type="text" class="validate" placeholder="Preciona el botón seleccionar Marca">
                            <label for="idmarcaNombre">Marca</label>
                          </div>
                          <div class="input-field col col s12 m6">
                            <a id="btnMarcaSel" class="waves-effect waves-light btn modal-trigger  purple" href="#modal1">Seleccionar Marca</a>
                          </div>
                          
                           <div >&nbsp;</div>
                            <div class="col col s12 m12 bordeado">
                            <div>Tipo Item</div>
                               <input class="with-gap" name="tipoitem" type="radio" id="idtipo1" value="1" <?php if ($ditem['tipoitem']=='1') echo 'checked';?>>
                               <label for="idtipo1">Perecedero</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                               <input class="with-gap" name="tipoitem" type="radio" id="idtipo2" value="2" <?php if ($ditem['tipoitem']=='2') echo 'checked';?>>
                               <label for="idtipo2">Comprementario</label>
                            </div>
                            <div >&nbsp;</div>
                            
                                  <div class="col col s12 m12 bordeado">
                                    <div>Tipo uso</div>
                                     <input class="with-gap" name="tipouso" type="radio" id="idtipouso1" value="1" <?php if ($ditem['tipouso']=='1') echo 'checked';?>>
                                     <label for="idtipouso1">Venta</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                     <input class="with-gap" name="tipouso" type="radio" id="idtipouso2" value="2" <?php if ($ditem['tipouso']=='2') echo 'checked';?>>
                                     <label for="idtipouso2">Producción</label>
                                  </div> 
                              <div class="input-field col s12 m12 l12  bordeado">
                                  <label>TIPO PRODUCTO</label>
                                  <select id="idtipoproducto" name="idtipoproducto">
                                    <?php
                                          foreach($tipoproducto->mostrarTodo("") as $t)
                                          {                                            
                                            ?> 
                                              <option value="<?php echo $t['idtipoproducto']; ?>"<?php if ($ditem['idtipoproducto']==$t['idtipoproducto']) echo "selected"; ?>><?php echo $t['nombre']; ?></option>
                                            <?php
                                          }
                                        ?>
                                  </select>
                                </div> 
                          <div class="input-field col s12">
                            <textarea id="iddesc" name="iddesc" class="materialize-textarea"><?php echo $ditem['descripcion'] ?></textarea>
                            <label for="iddesc">Descripcion</label>
                          </div>
                        </div>
                      </div>
                    </form>
                    <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo"> <i class="fa fa-save"></i>Guardar Cambios </button>
                  </fieldset>
                </div>
                <div class="col s12 m12 l4">
                  <div class="titulo">Imagen del producto</div>
                  <div class="container">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="editarfotoperfil">
                            <div class="ibox">
                                <div class="ibox-content">
                                    <div class="clients-list">
                                      <!-- The file upload form used as target for the file upload widget -->
                                      <form id="fileupload"  method="POST" enctype="multipart/form-data">
                                          <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
                                          <div class="row fileupload-buttonbar">
                                              <div class="col s12 m12 l12">
                                                <span class="btn green fileinput-button">
                                                  <i class="fa fa-folder-open-o"></i>
                                                  <span>Seleccionar Imagen</span>
                                                  <input type="file" name="files[]" multiple>
                                                </span>
                                                <button type="submit" class="btn blue start">
                                                  <i class="fa fa-save"></i>
                                                  <span>Confirmar Todo</span>
                                                </button>
                                              </div>
                                          </div>
                                          <!-- The table listing the files available for upload/download -->
                                          <div id="scroll">
                                            <div id="scrollin">
                                                <table role="presentation" class="table table-striped table-hover">
                                                <tbody class="files"></tbody>
                                                </table>
                                            </div>
                                          </div>
                                      </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>    
            </div>
          </div>
          <?php
            //include_once("../../footer.php");
          ?>
        </section>
      </div>
    </div>
    <script id="template-upload" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade">
            <td>
              <fieldset class="formulario">
                <legend>Campos de foto</legend>
                <center>
                  <span class="preview"></span>
                </center>
                <strong class="error text-danger"></strong>
                <div class="row">
                  <div class="input-field col s12">
                    <input name="titulo[]" type="text" placeholder="Título..." class="validate">
                    <label for="idnombre">Título</label>
                  </div>
                  <div class="input-field col s12">
                    <input name="description[]" type="text" placeholder="Descripción..." class="validate">
                    <label for="idnombre">Descripción</label>
                  </div>
                </div>
              <input type="hidden" name="url_proc[]" value="<?php echo $adress;?>" style="visibility: hidden;" >
              <input type="hidden" name="id_usuario[]" value="<?php echo $idusuario;?>" style="visibility: hidden;" >
              <input type="hidden" name="tipo_foto[]" value="fotoItemInventarios" style="visibility: hidden;" >
              <input type="hidden" name="tipo_usuario[]" value="1" style="visibility: hidden;" >
              <input type="hidden" name="id_publicacion[]" value="<?php echo $valor;?>" style="visibility: hidden;">
              <input type="hidden" name="principal[]" value="1" style="visibility: hidden;">
              {% if (!i && !o.options.autoUpload) { %}
                <button class="btn blue start" disabled>
                    <i class="fa fa-save"></i>
                    <span>Confirmar</span>
                </button>
              {% } %}

              {% if (!i) { %}
                <button class="btn red cancel">
                    <i class="fa fa-trash"></i>
                    <span>Descartar</span>
                </button>
              {% } %}
              </fieldset>
            </td>

        </tr>

        {% } %}
    </script>
    <!-- The template to display files available for download -->
    <script id="template-download" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-download fade" >
                <td>
                  <fieldset class="formulario">
                        <legend>Foto</legend>
                    {% if (file.url) { %}
                        <center>
                          <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery>
                            <img style="height: 210px;" src="{%=file.url%}">
                          </a>
                        </center>
              
                        <div class="row">
                          <div class="input-field col s12">
                            <input id="idFileTitle" value="{%=file.title%}" placeholder="Sin título..." readonly="" type="text" class="validate">
                          </div>
                          <div class="input-field col s12">
                            <input id="idFileDes" name="{%=file.description%}" placeholder="Sin descripción..." readonly="" type="text" class="validate">
                          </div>
                        </div>
                    {% } %}
                    {% if (file.error) { %}
                        <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                    {% } %}
                    {% if (file.deleteUrl) { %}
                        <button class="btn red delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                            <i class="fa fa-trash"></i>
                            <span>Eliminar</span>
                        </button>
                        <input type="checkbox" style="visibility: hidden;" name="delete" value="1" class="toggle">
                    {% } else { %}
                        <button class="btn btn-warning cancel">
                            <i class="fa fa-trash"></i>
                            <span>Cancelar</span>
                        </button>
                    {% } %}
                  </fieldset>
                </td>
            </tr>
        {% } %}
    </script>


    <div id="modal1" class="modal">
      <div class="modal-content">
        <fieldset class="formulario">
          <legend> Seleccionar Marca</legend>
          <form  class="col s12" id="idformMarca" name="idform" action="return false" onsubmit="return false" method="POST">
            <div class="row">
              <div class="input-field col col s12 m4">
                <input id="idNmarca" name="idNmarca" type="text" class="validate">
                <label for="idNmarca">Nombre de la Nueva Marca</label>
              </div>
              <div class="input-field col col s12 m4">
                <input id="idNdesc" name="idNdesc" type="text" class="validate">
                <label for="idNdesc">Descripcion nueva Marca</label>
              </div>
              <div class="input-field col col s12 m4">
                <button id="BtnSaveMarca" class="btn waves-effect green"><i class="fa fa-save"></i> Guaradar</button>
              </div>
            </div>
          </form>
          <table id="tablajson" class="display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>COD</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Sel.</th>
              </tr>
            </thead>
            <tbody>                         
            </tbody>
          </table>
        </fieldset>
      </div>
    </div>
    <div id="idresultado"></div>
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
      include_once($ruta."includes/script_foto.php");
    ?>
    <script type="text/javascript">
      $("#BtnSaveMarca").click(function(){
        var str = $( "#idformMarca" ).serialize();
        $.ajax({
          url: "nuevaMarca.php",
          type: "POST",
          data: str,
          success: function(resp){
            setTimeout(function(){     
              console.log(resp);
              $('#idresultado').html(resp);
            }, 1000); 
          }
        });
      });
      $("#btnMarcaSel").click(function(){
        listarMarcas();
      });
      function listarMarcas(){
        $("#tablajson").dataTable().fnDestroy();
        var table=$("#tablajson").dataTable({
          "ajax":{
            "method":"POST",
            "url":"lsitarMarcas.php"
          },
          "columns":[
            {"data":"idmarca"},
            {"data":"nombre"},
            {"data":"desc"},
            {"defaultContent":"<a class='btn-jh purple ideditar'><i class='mdi-navigation-check'></i> Seleccionar</a>"}
          ],
        });
        GetData("#tablajson tbody",table);
      }
      function GetData(tbody,table){
        $(tbody).on("click","a.ideditar",function(){
          var data=table.api().row( $(this).parents("tr") ).data();        
          console.log(data);
          $("#idmarcaNombre").val(data.nombre);
          $("#idmarca").val(data.idmarca);
          $('#modal1').closeModal();
        });
      }
      $("#btnSave").click(function(){
        swal({   
          title: "Estas Seguro?",   
          text: "Esta seguro de guardar cambios?",   
          type: "warning",   
          showCancelButton: true,   
          closeOnConfirm: false,   
          showLoaderOnConfirm: true,
        }, 
        function(){
          if (validarr()) {
                $('#btnSave').attr("disabled",true);
                var tipoitem=$("input[name='tipoitem']:checked").val();
                var tipouso=$("input[name='tipouso']:checked").val();
            var str = $( "#idform" ).serialize();
            $.ajax({
              url: "guardar.php",
              type: "POST",
              data: str+"&idtipoitem="+tipoitem+"&idtipouso="+tipouso,
              success: function(resp){
                setTimeout(function(){     
                  console.log(resp);
                  $('#idresultado').html(resp);
                }, 1000); 
              }
            });
          }
          else{
            Materialize.toast('<span>Datos Invalidos Revise Por Favor</span>', 1500);
          }
        });
      });
      function validarr(){
        retorno=true;
        nom=$('#idnombre').val();
        pre=$('#idprecio').val();
        pre0=$('#idprecio').val();
        mar=$('#idmarca').val();
        if(nom=="" || pre=="" || mar=="" || pre0=="0"){
          retorno=false;
        }
        return retorno;
      }
      function validaFloat(numero)
      {
        if (!/^([0-9])*[.]?[0-9]*$/.test(numero))
        {
          swal("ERROR!", "Ingrese precio valido", "error");
          $('#idprecio').val("");
        }
         
      }
    </script>
</body>

</html>