<?php
  $ruta="../../../";
 include_once($ruta."class/invcategoria.php");
  $invcategoria=new invcategoria;
  include_once($ruta."class/invitem.php");
  $invitem=new invitem;
  include_once($ruta."class/modulo.php");
  $modulo=new modulo;
  include_once($ruta."class/marca.php");
  $marca=new marca;
  include_once($ruta."class/vitem.php");
  $vitem=new vitem;
  include_once($ruta."class/almacen.php");
  $almacen=new almacen;
  include_once($ruta."class/item_almacen.php");
  $item_almacen=new item_almacen;
  include_once($ruta."class/tipoproducto.php");
  $tipoproducto=new tipoproducto;
  include_once($ruta."funciones/funciones.php");
  session_start(); 
  extract($_GET);


  $valor=dcUrl($lblcode);
  $idalmacen=dcUrl($lblcode2);
  $ditem=$invitem->muestra($valor);
  $dmarca=$marca->muestra($ditem['idmarca']);
  $ditem=$vitem->muestra($valor);
  $tipr=$tipoproducto->muestra($ditem['idtipoproducto']); 

  $valor2=dcUrl($lblcode2);
  $dalmacen=$almacen->muestra($valor2); 

  $idusuario=$_SESSION["codusuario"];
  $adress=$_SERVER['REQUEST_URI'] ;
  $_SESSION["codempresa"]=$valor;

  $datoIA=$item_almacen->mostrarTodo("idalmacen=".$idalmacen." and iditem=".$valor);
    $datoIA=array_shift($datoIA);
//echo $idalmacen;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="EGRESO";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php"); 
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
                  <a href="../?lblcode=<?php echo $lblcode2 ?>" class="btn waves-effect waves-light red"><i class="fa fa-reply"></i> Atras</a>    
                </div>
              </div>   
            </div>
          </div>
          <div class="container">
              <div class="row">
                <div class="col s12 m12">
                 <!-- <h4 class="header">Actualizar Curso</h4> -->
                  <div class="titulo">Datos del Item</div>
                  
                  <form class="col s12" id="idform" name="idform" action="return false" onsubmit="return false" method="POST">
                    <input type="hidden" name="iditem" id="iditem" value="<?php echo $valor; ?>">
                    <input type="hidden" name="idalmacen" id="idalmacen" value="<?php echo $idalmacen; ?>">
                     <div class="row">
                        <div class="row">
                           <div class="card ">
                      <div class="card-content "> 
                        <div class="col s2 m2 l2 orange-text">NOMBRE: </div>
                        <div class="col s4 m4 l4"><?php echo $ditem['nombre'] ?> </div>

                        <div class="col s2 m2 l2 orange-text">MARCA: </div>
                        <div class="col s4 m4 l4"><?php echo $ditem['marca'] ?> </div>

                          <div class="col s2 m2 l2 orange-text">TIPO : </div>
                        <div class="col s4 m4 l4"><?php echo $ditem['tipo'] ?> </div>

                        <div class="col s2 m2 l2 orange-text">USO: </div>
                        <div class="col s4 m4 l4"><?php echo $ditem['uso'] ?> </div>

                          <div class="col s2 m2 l2 orange-text">PRECIO: </div>
                        <div class="col s4 m4 l4"><?php echo $ditem['precio'] ?> </div>

                        <div class="col s2 m2 l2 orange-text">Tipo producto: </div>
                        <div class="col s4 m4 l4"><?php echo $tipr['nombre'] ?> </div>

                        <div class="col s2 m2 l2 orange-text">ALMACEN: </div>
                        <div class="col s4 m4 l4"><?php echo $dalmacen['nombre'] ?> </div>
                      
                      </div>
                       
                    </div>
                        </div>
                      </div>
                </div>
                <div class="col s12 m12">
                 
                  <div class="titulo">Datos del Egreso</div>
                  <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo"> <i class="fa fa-save"></i> Guardar Egreso </button>
                    <div class="input-field col col s12 m12">
                          <input id="idexistencias" readonly  name="idexistencias" type="text" value="<?php echo $datoIA['existencias'] ?>" class="validate">
                          <label for="idexistencias">Existencias</label>
                        </div>
        <div class="input-field col col s12 m12">
                          <input id="idcantegreso"  name="idcantegreso" type="number"  class="validate">
                          <label for="idcantidade">Cantidad Egreso</label>
                        </div>
 <div class="input-field col s12 m12 l12">
                          <label>Motivo Egreso</label>
                          <select id="idmotivo" name="idmotivo">
                             
                                <option value="1" >Producto Roto</option>
 
                                <option value="2" >Producto Perdido</option>
 
                                <option value="3" >Correcion Inventario</option>
 
                              
                          </select>
                        </div>
                </div>

                  </form>
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
                <span class="preview"></span>
                    <strong class="error text-danger"></strong>
                    <input name="description[]" value="foto de item" style="visibility: hidden;">
                    <input name="url_proc[]" value="<?php echo $adress;?>" style="visibility: hidden;" >
                    <input name="id_usuario[]" value="<?php echo $idusuario;?>" style="visibility: hidden;" >
                    <input name="tipo_foto[]" value="fotoItemInventarios" style="visibility: hidden;" >
                    <input name="tipo_usuario[]" value="1" style="visibility: hidden;" >
                    <input name="id_publicacion[]" value="<?php echo $valor;?>" style="visibility: hidden;">
                    <input name="principal[]" value="1" style="visibility: hidden;">
                <br>
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
            </td>

        </tr>

        {% } %}
    </script>
    <!-- The template to display files available for download -->
    <script id="template-download" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-download fade" >
                <td>
                    <p>
                    <span>
                        {% if (file.url) { %}
                            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.url%}"></a>
                        {% } %}
                    </span>
                    </p>
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
                </td>
            </tr>
        {% } %}
    </script>
    <div id="idresultado"></div>
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php"); 
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
       $("#btnSave").click(function(){
        swal({   
          title: "Estas Seguro?",   
          text: "Se registrara el Egreso",   
          type: "warning",   
          showCancelButton: true,   
          closeOnConfirm: false,   
          showLoaderOnConfirm: true,
        }, 
        function(){
          if (validarr()) {
            var str = $( "#idform" ).serialize();
            motivo = $('#idmotivo').val();
      // alert (str);
            $.ajax({
              url: "guardar.php",
              type: "POST",
              data: str + '&idmotivo='+ motivo,
              success: function(resp){
                //alert(resp);
                setTimeout(function(){     
                  console.log(resp);
                  $('#idresultado').html(resp);
                }, 1000); 
              }
            });
          } else{
            Materialize.toast('<span>Datos Invalidos Revise Por Favor</span>', 1500);
          }
        });
      });
      function validarr(){
        retorno=true;
        cantidad=$('#idcantegreso').val();
        Existen =$('#idexistencias').val();
        if(cantidad==""){
                  retorno=false;     
        }else{
                if(parseInt(cantidad)>parseInt(Existen))
                {
                  retorno=false;     
                }
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