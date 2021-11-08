<?php
  $ruta="../../../";
  include_once($ruta."class/marca.php");
  $marca=new marca;
  include_once($ruta."class/tipoproducto.php");
  $tipoproducto=new tipoproducto;
extract($_GET);
  session_start(); 
  //if (!isset($lblcode)) {
   // $query="";
   // $tituloSede="Contratos en todas las Sedes";
 // }
 // else{
  //  $query=" and idsede=".dcUrl($lblcode);
  //  $dSelSede=$admmodulo->mostrar(dcUrl($lblcode));
  //  $dSelSede=array_shift($dSelSede);
  //  $tituloSede="Contratos en Sede ".$dSelSede['nombre'];
 // }


?>
<!DOCTYPE html>
<html lang="es">
<head>

    <?php
      $hd_titulo="NUEVO ITEM";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
    ?>
 <style type="text/css">   
.btn, .btn-large {
  background-color: #2196F3;
}

button:focus {
   outline: none;
   background-color: #2196F3;
}

.btn:hover, .btn-large:hover {
   background-color: #64b5f6;
}
.bordeado{
  border: 1px solid #d8d8d8; 
  border-radius:5px;
}
.bordeado input[type=radio] {
    width: 50px;
    height: 50px;
}
</style>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">  
 
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
                <a href="../" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a>
                
                </div>
              </div>   
            </div>
          </div>
         
           <div class="divider"></div>
          <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                 
                 <form class="col s12" id="idform" name="idform" action="return false" onsubmit="return false" method="POST">
                    <div class="row">
                    
                     <div class="col s12 m12 l8 " style="background-color:white;">
                     <fieldset class="formulario">
                   <legend><div class="titulo waves-effect waves-dark"><i class="fa fa-plus"></i> <strong>Datos del Item</strong> </div></legend>
                            
                          <div class="input-field col col s12 m12">
                            <input id="idnombre" name="idnombre" type="text" class="validate">
                            <label for="idnombre">Nombre Item</label>
                          </div>
                          <div class="input-field col col s12 m12">
                            <input id="idprecio" name="idprecio" type="text" onblur="validaFloat(this.value);" class="validate">
                            <label for="idprecio">Precio</label>
                          </div>
                          <div class="input-field col s12 m12 l12  bordeado">
                                  <label>TIPO PRODUCTO</label>
                                  <select id="idtipoproducto" name="idtipoproducto">
                                   <option disabled value="0">Seleccionar</option>
                                    <?php
                                          foreach($tipoproducto->mostrarTodo("") as $t)
                                          {                                            
                                            ?> 
                                              <option value="<?php echo $t['idtipoproducto'] ?>"><?php echo $t['nombre']; ?></option>
                                            <?php
                                          }
                                        ?>
                                  </select>
                                </div>
                          <div id="seccionRecargar" class="input-field col col s12 m12">
                          </div>
                          <div class="input-field col col s12 m6">
                            <input type="hidden" name="idmarca" id="idmarca">
                            <input id="idmarcaNombre" name="idmarcaNombre" readonly="" type="text" class="validate" placeholder="Preciona el botón seleccionar Marca">
                            <label for="idmarcaNombre">Laboratorio/Marca</label>
                          </div>
                          <div class="input-field col col s12 m6">
                            <a id="btnMarcaSel" class="waves-effect waves-light btn modal-trigger  purple" href="#modal1">Seleccionar Marca</a>
                          </div>
                           <div >&nbsp;</div>   
                          <div class="input-field col col s12 m6">
                            <input type="hidden" name="idmarca" id="idmarca">
                            <input id="idpresentacion" name="idpresentacion" readonly="" type="text" class="validate" placeholder="Preciona el botón seleccionar presentación">
                            <label for="idpresentacion">Presentación</label>
                          </div>
                          <div class="input-field col col s12 m6">
                            <a id="btnMarcaSel" class="waves-effect waves-light btn modal-trigger  purple" href="#modal1">Seleccionar pressentación</a>
                          </div>
                                            
                                   
                                                           
                              
                              <div class="input-field col col s12 m12">
                               <textarea id="iddesc" name="iddesc" class="materialize-textarea"></textarea>
                                <label for="iddesc">Descripcion</label>
                              </div>
 
                          <div class="step-actions" align="right">
                            <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo" onclick="guardar();"> <i class="fa fa-save"></i> Guardar Item </button><!--  -->
                          </div>
                           </fieldset>
                        </div>
                       
                    </div>
                  </form>
                  
               </div>

              </div>
          </div>

          </div>
          <?php
            include_once("../../footer.php");
          ?>
        </section>
      </div>
    </div>
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
    ?>

    <script type="text/javascript">
      $("#BtnSaveMarca").click(function(){
        var str = $( "#idformMarca" ).serialize();
        $.ajax({
          url: "../editar/nuevaMarca.php",
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
            "url":"../editar/lsitarMarcas.php"
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
    $(document).ready(function() {
      $('#example').DataTable({
        responsive: true
      });
     
     
    //selecciones de comboDSA
    
  });

     function guardar()
       {   
          if (validar()) {
             if ($("input[name='tipoitem']").is(':checked') &&  $("input[name='tipouso']").is(':checked')) 
             {
                 $('#btnSave').attr("disabled",true);
                var tipoitem=$("input[name='tipoitem']:checked").val();
                var tipouso=$("input[name='tipouso']:checked").val();
                var str = $( "#idform" ).serialize();
                $.ajax({
                  url: "guardar.php",
                  type: "POST",
                  data: str+"&idtipoitem="+tipoitem+"&idtipouso="+tipouso,
                  success: function(resp){     
                      console.log(resp);
                      $('#idresultado').html(resp);
                    }
                  });
             }else{
                swal("ERROR!", "Completar datos", "error")
             }
               
          }else{
           swal("ADVERTENCIA!", "El medicamento es contraindicado con otros medicamentos de la lista", "error")
          }
       }
  
      function validar(){

        retorno=true;
        nom=$('#idnombre').val();
        pre=$('#idprecio').val();
        pre0=$('#idprecio').val();
        mar=$('#idmarca').val();
        tp=$('#idtipoproducto').val();
        if(nom=="" || pre=="" || mar=="" || tp=="0" || pre0=="0"){
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