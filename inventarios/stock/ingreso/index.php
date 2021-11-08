<?php
  $ruta="../../../";
 include_once($ruta."class/invcategoria.php");
  $invcategoria=new invcategoria;
  include_once($ruta."class/vitem.php");
  $vitem=new vitem;
  include_once($ruta."class/modulo.php");
  $modulo=new modulo;
  include_once($ruta."class/almacen.php");
  $almacen=new almacen;
  include_once($ruta."class/proveedor.php");
  $proveedor=new proveedor;
  include_once($ruta."class/tipoproducto.php");
  $tipoproducto=new tipoproducto;
  include_once($ruta."funciones/funciones.php");
  session_start(); 
  extract($_GET);


  $valor=dcUrl($lblcode);
  $ditem=$vitem->muestra($valor);
  $tipr=$tipoproducto->muestra($ditem['idtipoproducto']);  


  $valor2=dcUrl($lblcode2);
  $dalmacen=$almacen->muestra($valor2);


  $idusuario=$_SESSION["codusuario"];
  $adress=$_SERVER['REQUEST_URI'] ;
  $_SESSION["codempresa"]=$valor;


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="INGRESO";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php"); 
    ?>  
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
                 <!-- <h4 class="header">Actualizar Curso</h4> -->
                  <div class="titulo">Datos del Item</div>
                  
                  <form class="col s12" id="idform" name="idform" action="return false" onsubmit="return false" method="POST">
                    <input type="hidden" name="iditem" id="iditem" value="<?php echo $valor; ?>">
                    <div class="row">


    <!--Basic Card-->
          <div id="basic-card" class="section"> 
            <div class="row">
              
                <div class="col s10 offset-s1 ">
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
          </div>
          <!--Image Card-->
                   


                    </div> 

 
                 
                  <div class="titulo">Datos del INGRESO</div>
                  <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo"> <i class="fa fa-save"></i> Guardar INGRESO </button>
                    
                    
                <div class="col s10 offset-s1 ">
                          <div class="input-field col s12 m12 l12">
                          <label>Laboratorio</label>
                          <select id="idprovee" name="idprovee">
                            <?php
                            foreach($proveedor->mostrarTodo("") as $f)
                            {
                              ?>
                                <option value="<?php echo $f['idproveedor']; ?>" ><?php echo $f['encargado']; ?></option> 
                              <?php
                            }
                            ?>
                          </select>
                        </div>
                         <div class="input-field col col s12 m12">
                          <input id="idcantingreso"  name="idcantingreso" type="number"  class="validate">
                          <input id="idalmacen"  name="idalmacen" type="hidden"   value="<?php echo $valor2 ?>">
                           <input id="iditem"  name="iditem" type="hidden"   value="<?php echo $ditem['idvitem'] ?>">
                          <label for="idcantingreso">Cantidad de Ingreso</label>
                        </div>
                        <div class="input-field col col s12 m12">
                          <input id="preciocompra"  name="preciocompra" type="text" onblur="validaFloat(this.value);" class="validate">
                          <label for="preciocompra">Precio de Compra Total</label>
                        </div>


                          <?php
                    if ($ditem['tipoitem']=="1") {
                  ?>
                       
                      <div class="input-field col col s12 m12">
                          <input id="idfechavence"  name="idfechavence" type="date" value="<?php echo date('Y-m-d') ?>"  class="validate">
                          <label for="idfechavence">Fecha vencimiento</label>
                        </div>
                  <?php
                    }else{
                      ?>
                      <input type="hidden" name="idfechavence" id="idfechavence" value="0000-00-00" class="form-control"> 
                      <?php
                    }
                  ?>   
               
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
   
    <div id="idresultado"></div>
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php"); 
    ?>
    <script type="text/javascript">
      $("#btnSave").click(function(){
           if (validarr()) {
          swal({   
            title: "Estas Seguro?",   
            text: "Se registrara el Ingreso",   
            type: "warning",   
            showCancelButton: true,   
            closeOnConfirm: false,   
            showLoaderOnConfirm: true,
          }, 
          function(){
             var str = $( "#idform" ).serialize();
            prove = $('#idprovee').val();
            $.ajax({
              url: "guardar.php",
              type: "POST",
              data: str +'&idproveer='+prove,
              success: function(resp){
                setTimeout(function(){     
                  console.log(resp);
                  $('#idresultado').html(resp);
                }, 1000); 
              }
            });
          });
        }else{
           Materialize.toast('<span>Datos Invalidos Revise Por Favor</span>', 1500);
        }
      });



      function validarr(){
        retorno=true;
        cantidad=$('#idcantingreso').val();
        precio=$('#preciocompra').val();
        precio0=$('#preciocompra').val();
        if(cantidad=="" || precio=="0" || precio0==""){
          retorno=false;
        }
        return retorno;
      }
      function validaFloat(numero)
      {
        if (!/^([0-9])*[.]?[0-9]*$/.test(numero))
        {
          swal("ERROR!", "Ingrese precio valido", "error");
          $('#preciocompra').val("");
        }
         
      }
    </script>
</body>

</html>