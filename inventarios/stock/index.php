<?php
  $ruta="../../";
  include_once($ruta."class/vliname.php");
  $vliname=new vliname;
  include_once($ruta."class/almacen.php");
  $almacen=new almacen;
  include_once($ruta."class/estante.php");
  $estante=new estante;
  include_once($ruta."class/proveedor.php");
  $proveedor=new proveedor;
  include_once($ruta."funciones/funciones.php");

  session_start();

  extract($_GET);


  $idalmacen=dcUrl($lblcode);

  $datosalmacen = $almacen ->muestra($idalmacen);
  $lblcode2=ecUrl($datosalmacen['idalmacen']);
 // echo $idalmacen;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Stock del almacen ";
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
          $idmenu=42;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                        
                  <h5 class="breadcrumbs-title">  <a class="btn-jh red" href="../../almacen/admin"><i class="fa fa-reply"> </i> Atrás</a><i class="fa fa-tag"></i> <?php echo $hd_titulo." ".$datosalmacen['nombre']?></h5>
                </div> 
              </div>
            </div>
          </div>
          <div class="container">
            <div class="section"> 
              <div class="col s12 m12 l6">
                <table id="tablaItem" class="display" cellspacing="0" width="100%" style="font-size: 13px; color:##060606;">
                        <thead>
                        <tr>
                          <th style="width: 80px;">iditem</th>
                          <th>nombre</th>
                          <th>marca</th>
                          <th style="width: 80px;">uso</th>
                          <th>tipo</th>
                          <th style="width: 80px;">Precio Und</th>
                          <th style="width: 80px;">Existencias</th>
                          <th>Accion</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
              </div>
            </div>
          </div>
      
        </section>
      </div>
    </div>
           <div class="row">
                <div id="modal2" class="modal">
                  <div class="modal-content">
                  <h1 align="center">INGRESO ITEMS</h1>
                    <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <input id="iditem" name="iditem" type="hidden">
                    <input id="idalmacen" name="idalmacen" type="hidden" value="<?php echo $idalmacen ?>">
                      
                            <div class="col s12 m12 l12" >
                            <label class="light center-align blue-text" style="font-size:25px;"><i class="mdi-hardware-gamepad"></i>ITEM</label>
                            </div>
                            <div class="col s6 m6 l6">
                               <div class="col s12 m12 l12">
                                <p> <strong>MEDICAMENTO: </strong>
                                <label id="idnombreitem" style="color:#252525; font-size:15px;"></label></p>                          
                               </div>
                               <div class="col s12 m12 l12">
                                <p> <strong>MARCA: </strong><label id="idmarca" style="color:#252525; font-size:15px;"></label></p>
                                </div>
                            </div>
                            <div class="col s6 m6 l6">
                               <div class="input-field col s12 m12 l12">
                                     <label>PRECIO</label>
                                     <input id="idprecio" name="idprecio" onblur="validaFloat(this.value);" type="text" >  
                                </div>
                                
                                <div class="input-field col s12 m12 l12">                             
                                <label>CODIGO LINAME</label>
                                  <input id="idli" name="idli" type="hidden"  > 
                                  <input id="idcodigo" name="idcodigo" type="text" readonly  >   
                                 <a href="#modal3" class="btn-jh waves-effect waves-light blue modal-trigger " onclick="mostrarLiname();">VINCULAR con LINAME</a> 
                                 <button class="btn-jh green" onclick="actualizarDatos();">ACTUALIZAR</button>
                                </div>
                            </div>
                            <div class="col s12 m12 l12" >
                            <label class="light center-align blue-text" style="font-size:25px;">
                            <i class="mdi-file-file-upload"></i>DATOS INGRESO</label>
                            </div>
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
                            <div class="input-field col s6 m6 l3">
                            <label>Cantidad</label>
                            <input id="idcantidad" name="idcantidad" type="text">
                            </div>
                           
                            <div class="input-field col s6 m6 l3">
                            <label>Precio TOTAL</label>
                            <input id="idpreciototal" name="idpreciototal" type="text">
                            </div>
                            
                            <div class="input-field col s6 m6 l6">
                            <label>Fecha Vencimiento</label>
                            <input id="idfechavence" name="idfechavence" type="date"  value="<?php echo date('Y-m-d') ?>" >
                            </div>

                            <div class="input-field col s6 m6 l6">
                              <label>Ubicación</label>
                              <select id="idestante" name="idestante">
                                <option value="0" >Seleccionar</option> 
                                <?php
                                foreach($estante->mostrarTodo("idalmacen=".$idalmacen." and estado=1") as $f)
                                {
                                  ?>
                                    <option value="<?php echo $f['idestante']; ?>" ><?php echo 'Estante '.$f['nombre']; ?></option> 
                                  <?php
                                }
                                ?>
                              </select>
                            </div>
                            <div class="input-field col s6 m6 l6"> 
                              <label>Fila</label>
                              <select id="idfila" name="idfila"  >
                                  <option value="0"> Seleccionar</option>
                              </select>
                            </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                  <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo" onclick="guardar();"><i class="fa fa-save"></i> GUARDAR</button>
                  <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i> CERRAR</button>                  
                  </div>
                  <div class="col s12 m12 l12">
                    <fieldset class="buscador" >
                        <legend><div class="tituloblue"><strong><i class="mdi-action-assignment"></i> Historial de lotes de item</strong> </div></legend> 
                           <div class="row">
                                <div class="col s12 m12 l12">
                                   <div class="row table-responsive">                                          
                                          <div id="result2"></div>
                                    </div>
                                 </div>    
                             </div>
                          </fieldset>
                       </div>
                </div>
             </div>

             <div class="row">
                <div id="modal5" class="modal" style="width: 80%;">
                  <div class="modal-content">
                  <h1 align="center">EGRESO DE  ITEMS</h1>
                    <form class="col s12" id="idform5" action="return false" onsubmit="return false" method="POST">
                    <input id="iditemImp" name="iditemImp" type="hidden">
                    <input id="idalmacenImp" name="idalmacenImp" type="hidden" value="<?php echo $idalmacen ?>">
                      
                            <div class="col s12 m12 l12" >
                            <label class="light center-align blue-text" style="font-size:25px;"><i class="mdi-hardware-gamepad"></i>ITEM</label>
                            </div>
                            <div class="col s6 m6 l6">
                               <div class="col s12 m12 l12">
                                <p> <strong>MEDICAMENTO: </strong>
                                <label id="idnombreitemImp" style="color:#252525; font-size:15px;"></label></p>                          
                               </div>
                               <div class="col s12 m12 l12">
                                <p> <strong>MARCA: </strong><label id="idmarcaImp" style="color:#252525; font-size:15px;"></label></p>
                                </div>
                            </div>
                            <div class="col s6 m6 l6">
                               <div class="input-field col s12 m12 l12">
                                     <label>PRECIO</label>
                                     <input id="idprecioImp" name="idprecioImp" readonly onblur="validaFloat(this.value);" type="text" >  
                                </div>
                                
                                <div class="input-field col s6 m6 l6">                             
                                <label>CODIGO LINAME</label>
                                  <input id="idliImp" name="idliImp" type="hidden"  > 
                                  <input id="idcodigoImp" name="idcodigoImp" type="text" readonly  >   
                                </div>
                            </div>
                            <div class="col s12 m12 l12" >
                            <label class="light center-align blue-text" style="font-size:25px;">
                            <i class="mdi-file-file-upload"></i>DATOS EGRESO</label>
                            </div>

                              <div class="col s6 m6 l6">
                                <fieldset class="buscador" >
                                <legend><div class="tituloblue"><strong><i class="mdi-action-assignment"></i> Lotes de item</strong> </div></legend> 
                                   <div class="row">
                                           <div class="row table-responsive">                                          
                                                  <div id="result3"></div>
                                            </div>  
                                     </div>
                                 </fieldset>
                              </div>
                              <div class="col col s6 m6 l6">
                                 <div class="col col s12 m12 l12">
                                <p> <strong>Existencia: </strong><label id="idexistenciaImp" style="color:#252525; font-size:15px;"></label></p>
                                </div>
                                <div class="input-field col s12 m12 l12">
                                    <label>Cantidad Egreso</label>
                                    <input id="idcantegreso" name="idcantegreso" type="text">
                                </div>
                                <div class="input-field col s12 m12 l12">
                                    <label>Motivo Egreso</label>
                                    <select id="idmotivo" name="idmotivo">
                                          <option value="1" >Producto Roto</option>
                                          <option value="2" >Producto Perdido</option>
                                          <option value="3" >Correcion Inventario</option>
                                    </select>
                                </div>
                                <div class="input-field col s12 m12 l12">
                                  <label>Ubicación</label>
                                  <input id="idloteImp" name="idloteImp" type="hidden">
                                  <input id="idubicacionImp" name="idubicacionImp" type="text">
                                </div>
                                <div class="modal-footer">
                                <button id="btnSaveEgreso" class="btn waves-effect light-blue darken-4 indigo" onclick="guardarEGRE();"><i class="fa fa-save"></i> GUARDAR EGRESO</button>
                                <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i> CERRAR</button>                  
                                </div>
                              </div>
                           
                           
                    </form>
                  </div>
                  
                  
                    </div>
                 </div>

             <div class="row">
                <div id="modal3" class="modal">
                   <input id="idcontrol" name="idcontrol" type="text" value="0">
                  <div class="modal-content"> 
                    <form class="col s12" id="idform2" action="return false" onsubmit="return false" method="POST">
                    <table id="tablaLiname" class="display" cellspacing="0" width="100%" style="font-size: 13px; color:##060606;">
                        <thead>
                        <tr>
                          <th>Medicamento</th>
                          <th>Forma</th>
                          <th>Concentracion</th>
                          <th>ATQ GRUPO</th>
                          <th>ATQ</th>
                          <th>ASIGNAR</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                     <div class="modal-footer">
                  <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</button>                  
                  </div>
                    </form>
               
                   </div>
              
                  </div>
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
    
  
    function cargar(ide)
     {
        $('#iditem').val(ide);
        $.ajax({
            async: true,
            url: "cargaritem.php?ide="+ide,
            type: "get",
            dataType: "html",
            success: function(data){
              //console.log(data);
              var json = eval("("+data+")");
                $("#idnombreitem").text(json.nombre);
                $("#idmarca").text(json.marca);
                $("#idprecio").val(json.precio);
                $("#idli").val(json.liname);
                $("#idcodigo").val(json.codigo);               
            }
          });
        $('#modal2').openModal();
        obtener_lotes(ide);
     }
     function asigna(id)
     {  //alert(id);
      $('#modal3').closeModal();
          $.ajax({
              url: "cargaLi.php",
              type: "POST",
              data: "idliname="+id,
              success: function(resp){
                console.log(resp);
                $('#idresultado').html(resp);

              }
            });
       // $("#idli").val(id); 
        //$("#idcodigo").val(codigo);      
                
     }   
     function validaFloat(numero)
      {
        if (!/^([0-9])*[.]?[0-9]*$/.test(numero))
        {
          swal("ERROR!", "Ingrese precio valido", "error");
          $('#idprecio').val("");
        }
         
      } 
      function actualizarDatos()
      {
        if (validarr()) {
          swal({   
            title: "Estas Seguro?",   
            text: "Actualizar los datos",   
            type: "warning",   
            showCancelButton: true,   
            closeOnConfirm: false,   
            showLoaderOnConfirm: true,
          }, 
          function(){
             var str = $("#idform").serialize();
            $.ajax({
              url: "actualizar.php",
              type: "POST",
              data: str,
              success: function(resp){
                //alert(resp);
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
      }
      function validarr(){
        retorno=true;
        cod=$('#idcodigo').val();
        precio=$('#idprecio').val();
        precio0=$('#idprecio').val();
        if(cod=="" || precio=="0" || precio0==""){
          retorno=false;
        }
        return retorno;
      }

       $("#btnSave").click(function(){
           if (validar2()) {
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
              url: "ingreso/guardar.php",
              type: "POST",
              data: str +'&idproveer='+prove,
              success: function(resp){
                setTimeout(function(){     
                  console.log(resp);
                  $('#idresultado').html(resp);
                }, 1000); 
                ide=$('#iditem').val();
                obtener_lotes(ide);
              }
            });
          });
          //VOLVER A CARGAR LA LISTA DE LOTES          
        }else{
           Materialize.toast('<span>Datos Invalidos Revise Por Favor</span>', 1500);
        }
      });
       function validar2(){
        retorno=true;
        cantidad=$('#idcantidad').val();
        precio=$('#idpreciototal').val();
        precio0=$('#idpreciototal').val();
        fecha=$('#idfechavence').val();
        estante=$('#idestante').val();
        fil=$('#idfila').val();
        if(cantidad=="" || precio=="0" || precio0=="" || fecha=="" || estante=="0" || fil=="0"){
          retorno=false;
        }
        return retorno;
      }

      $("#btnSaveEgreso").click(function(){
           if (validarE()) {
          swal({   
            title: "Estas Seguro?",   
            text: "Se registrara el Egreso",   
            type: "warning",   
            showCancelButton: true,   
            closeOnConfirm: false,   
            showLoaderOnConfirm: true,
          }, 
          function(){
             var str = $( "#idform5" ).serialize();
            prove = $('#idprovee').val();
            $.ajax({
              url: "egreso/guardar.php",
              type: "POST",
              data: str +'&idproveer='+prove,
              success: function(resp){
                setTimeout(function(){     
                  console.log(resp);
                  $('#idresultado').html(resp);
                }, 1000); 
                ide=$('#iditemImp').val();
                obtener_lotesEgre(ide);
              }
            });
          });
        }else{
           Materialize.toast('<span>Datos Invalidos Revise Por Favor</span>', 1500);
        }
      });
       function validarE(){
        retorno=true;
        cantidad=$('#idcantegreso').val();
        lote=$('#idloteImp').val();
        if(cantidad=="" || lote==""){
          retorno=false;
        }
        return retorno;
      }

      function cargarEgre(ide)
     {
        $('#iditemImp').val(ide);
        idalmacen='<?php echo $idalmacen ?>';
        $.ajax({
            async: true,
            url: "cargaritemEgre.php?ide="+ide+"&idalmacen="+idalmacen,
            type: "get",
            dataType: "html",
            success: function(data){
              //console.log(data);
              var json = eval("("+data+")");
                $("#idnombreitemImp").text(json.nombre);
                $("#idmarcaImp").text(json.marca);
                $("#idprecioImp").val(json.precio);
                $("#idliImp").val(json.liname);
                $("#idcodigoImp").val(json.codigo);
                $("#idexistenciaImp").text(json.existencias);               
            }
          });
        $('#modal5').openModal();
         obtener_lotesEgre(ide);
         $('#idloteImp').val("");
         $('#idubicacionImp').val("");
     }

     function obtener_lotes(ide)
    {  //alert('entra');
      idalm='<?php echo $idalmacen ?>';
          $.ajax({
          url: "mostrar_lotes.php",
          method: "POST",
          data: "idalmacen="+idalm+"&iditem="+ide,
          success: function(data){
              $("#result2").html(data)
          }
        });
           
    }

    function obtener_lotesEgre(ide)
    {  //alert('entra');
      idalm='<?php echo $idalmacen ?>';
          $.ajax({
          url: "mostrar_lotesEgre.php",
          method: "POST",
          data: "idalmacen="+idalm+"&iditem="+ide,
          success: function(data){
              $("#result3").html(data)
          }
        });
           
    }

    $("select[name=idestante]").change(scripestante);
    $('#idfila').prop('disabled', true);
    function scripestante(){
      $('#idfila').prop('disabled', false);      
      var idestante= $("select[name=idestante]").val();
      $("#idfila").empty().html(' ');
      //$("#idequipotorneo").empty().html(' ');
      $.post("seleccionar/verFila.php",{"idestante":idestante,},function(ejecutivos){  
        console.log(ejecutivos);   
        var cmdejec=$("#idfila");
          cmdejec.empty(); 
         //var cmdejec2=$("#idequipotorneo");
       //cmdejec2.empty(); 

        // $("#idequipotorneo").append( $("<option></option>").attr("value","0").text("TODOS")); 
          $("#idfila").append( $("<option></option>").attr("value","0").text("Seleccionar"));
          $.each(ejecutivos,function(idfila,ejec){

            $("#idfila").append( $("<option></option>").attr("value",ejec.idfila).text(ejec.nombre));
          });
          $("#idfila").material_select('update');

          $("#idfila").material_select('update');
          $("#idfila").closest('.input-field').children('span.caret').remove();
         
         // $("#idequipotorneo").material_select('update');
         // $("#idequipotorneo").closest('.input-field').children('span.caret').remove();
      },'json');

      /*************************************************************************************/ 
      //$('#idserie').val('');
    }


    mostrarPedidos();
      function mostrarPedidos(){
      $("#tablaItem").dataTable().fnDestroy();
        var idalmacen="<?php echo $idalmacen ?>";
        var str="idalmacen="+idalmacen;
        var table=$("#tablaItem").dataTable({
        "ajax":{
          "method":"POST",
          "url":"listarItem.php?"+str
        },
        "columns":[
          {"data":"iditem"},
          {"data":"nombre"},
          {"data":"marca"},
          //{"defaultContent":"<input type='number' value='1'> "},
          {"data":"uso"},
          {"data":"tipo"},
          {"data":"precio"},
          {"data":"existencia"},        
          {"data":"bootones"}  
        ]
      });
      eliminaItemCarrito("#tablaItem tbody",table);
    };


     function mostrarLiname(){
      control=$('#idcontrol').val();
      if (control==0)//para no volver a cargar cada vez 
      {
        $('#idcontrol').val(1);
        $("#tablaLiname").dataTable().fnDestroy();
        var str="estado=1";
        var table=$("#tablaLiname").dataTable({
        "ajax":{
          "method":"POST",
          "url":"listarLiname.php?"+str
        },
        "columns":[
          {"data":"medicamento"},
          {"data":"forma"},
          {"data":"concentracion"},
          {"data":"grupo"},
          {"data":"accion"},      
          {"data":"bootones"}  
        ]
      });
      eliminaItemCarrito("#tablaLiname tbody",table);
      
    }
      
    };
    </script>
</body>

</html>