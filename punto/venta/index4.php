<?php
  $rutaC="../../";
  $ruta="../../";
  include_once($ruta."class/almacen.php");
  $almacen=new almacen;
  include_once($ruta."class/item_almacen.php");
  $item_almacen=new item_almacen;
  include_once($ruta."class/invitem.php");
  $invitem=new invitem;
  include_once($ruta."class/configuracion.php");
  $configuracion=new configuracion;
  include_once($ruta."class/files.php");
  $files=new files;
  include_once($ruta."class/itemalmacenventa.php");
  $itemalmacenventa=new itemalmacenventa;
  include_once($ruta."funciones/funciones.php");
  extract($_GET);
  session_start();
  $idsucursal=dcUrl($lblcode);
  $_SESSION['sucursal']=$idsucursal;
  $dalm=$almacen->muestra($idsucursal);
  //echo $_SESSION['sucursal'];
  $_SESSION["idventatemp"]=0;

$conf=$configuracion->mostrarUltimo("short='VENTA'");
$cantidad=$conf['cantidad'];


?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo=$dalm['nombre'];
    include_once($ruta."includes/head_basico.php");
    include_once($ruta."includes/head_tabla.php");
    include_once($ruta."includes/head_tablax.php");
  ?>
  <style type="text/css">
    .border{
      border: solid 1px #dedede ;
    }
    .precio .preN {
      font-family: 'Arial Black', Arial, Helvetica, sans-serif;
      font-weight: bold;
      color: #2f7560; 
      font-size: 25px;
    }
    .total{
      font-family: 'Arial Black', Arial, Helvetica, sans-serif;
      font-weight: bold;
      color: #2f7560; 
       font-size: 25px;
    }
    .efecto{
      border: 1px solid #d8d8d8;
      margin-bottom: 4px;
    }
    .efecto:hover{
       opacity: 0.5;
       background: #ececec; 
       border:solid 1px #5f5f5f;
    }
    .imgefecto:hover{      
      cursor: pointer;
      transform:scale(1.2);
      -ms-transform:scale(1.2); // IE 9 
      -moz-transform:scale(1.2); // Firefox 
      -webkit-transform:scale(1.2); // Safari and Chrome 
      -o-transform:scale(1.2); // Opera
    } 
    .imgefecto{
      width:130px;
      height: 130px;
    }
    .bordMenu
    {
      border: 1px solid #09a7a9;
      border-radius: 5px;  
    }
    .barraMenu
    {
      border-right: 1px solid #09a7a9; 
      height: 
    }
    .textog
    {
      font-size: 28px; 
    }
    /*----------------------------------------
        VENTAS
    ------------------------------------------*/
    .billetes {
      width: 100%;
    }
    .billetes img {
      width: 30%;
      border: 1px solid #dedede;
      margin-top: 1px;
    }
    .monedas {
      width: 100%;
    }
    .monedas img {
      width: 15%;
      border: 1px solid #dedede;
      margin-top: 1px;
    }
    .estInEste input{
      border:solid 1px #6759ff;
      border-radius: 3px;
    }
  </style>
</head>
<body id="layouts-horizontal">
    <?php
      $tab=1;
      include_once("../head2.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=1028;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
       
          <div class="container">
            <div class="section">
             <div class="row">
                <div id="modal2" class="modal" style="width:80%; height:100%;">
                  <div class="modal-content">
                    <div align="right">
                      <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i></button>
                    </div>
                    <form class="col s12" id="idFormVenta" action="return false" onsubmit="return false" method="POST">
                      <div class="row">
                        <div class="col s12 m12 l12" style="background-color:#ffffff; border: 1px solid #D5D8DC; border-radius:5px;">
                          <div class="input-field col col s12 m6 estInEste"  style="font-weight:bold;">
                            <input id="idnit" name="idnit" type="text" class="validate"  style="font-size: 28px;" value="">
                            <label for="idnit">CI/NIT:</label>
                          </div>
                          <div class="input-field col col s12 m6 estInEste" style="font-weight:bold;">
                            <input id="idnombre" name="idnombre" type="text" class="validate"   style="font-size: 28px;"    value="">
                            <label for="idnombre"><i class="fa fa-user"></i>Nombre/Razon Social</label>
                          </div>
                          <div class="col s12 m12 l6"  style="font-weight:bold;">&nbsp;
                            <div id="iddinero">
                            <div class="billetes">                      
                              <img onclick="sumBillete(200);" alt="200" src="<?php echo $ruta;?>imagenes/dinero/200.jpg">  
                              <img onclick="sumBillete(100);" alt="100" src="<?php echo $ruta;?>imagenes/dinero/100.jpg">  
                              <img onclick="sumBillete(50);" alt="50" src="<?php echo $ruta;?>imagenes/dinero/50.jpg"> 
                              <img onclick="sumBillete(20);" alt="20" src="<?php echo $ruta;?>imagenes/dinero/20.jpg">   
                              <img onclick="sumBillete(10);" alt="10" src="<?php echo $ruta;?>imagenes/dinero/10.jpg">                 
                            </div>
                            <div class="monedas">
                              <img onclick="sumBillete(5);" alt="5" src="<?php echo $ruta;?>imagenes/dinero/5.jpg">  
                              <img onclick="sumBillete(2);" alt="2" src="<?php echo $ruta;?>imagenes/dinero/2.jpg"> 
                              <img onclick="sumBillete(1);" alt="1" src="<?php echo $ruta;?>imagenes/dinero/1.jpg">  
                              <img onclick="sumBillete(0.5);" alt="0.50" src="<?php echo $ruta;?>imagenes/dinero/050.jpg">  
                              <img onclick="sumBillete(0.20);" alt="0.20" src="<?php echo $ruta;?>imagenes/dinero/020.jpg">  
                              <img onclick="sumBillete(0.10);" alt="0.10" src="<?php echo $ruta;?>imagenes/dinero/010.jpg">    
                            </div>
                            </div>
                          </div>
                          <div class="campoForm col s12 m12 l6"  style="font-weight:bold;">
                            <div class="formAreaND"> 
                             <input id="idmontooriginal" name="idmontooriginal" type="hidden" readonly class="validate" style="font-size: 28px;"  value="0"> 
                              <div class="input-field col col s12 m6">
                                <input id="idmonto" name="idmonto" type="text" readonly class="validate"  style="font-size: 28px;"  value="0">
                                <label for="idmonto">IMPORTE A PAGAR BS.</label>
                              </div>
                              <div class="input-field col col s12 m6">
                               <input id="iddescuento" name="iddescuento" type="number" style="font-size: 28px;" class="validate" value="0">
                                <label for="iddescuento">Descuento (%)</label>
                              </div>
                              <div class="input-field col col s8 m8">
                                <input id="idimporte" name="idimporte" type="text" readonly class="validate" style="font-size: 28px;"  value="0">
                                <label for="idimporte">IMPORTE BS.</label>
                              </div>
                              
                              <div class="input-field col col s4 m4">
                                <input type="checkbox" class="filled-in" id="idefectivo" checked="checked" />
                                <label for="idefectivo">Efectivo</label>
                              </div>
                              <div class="col col s12 m12">
                              </div>
                              <div class="input-field col col s4 m4">
                                <input id="idimporteTar" name="idimporteTar" type="text" disabled class="validate" style="font-size: 28px;"  value="0">
                                <label for="idimporteTar">IMPORTE CON TARJETA BS.</label>
                              </div>
                              <div class="input-field col col s4 m4">
                                <input id="idnroreferencia" name="idnroreferencia" type="text" disabled class="validate" style="font-size: 28px;"  value="">
                                <label for="idnroreferencia">Nro DE REFERENCIA</label>
                              </div>
                              <div class="input-field col col s4 m4">
                                <input type="checkbox" class="filled-in" id="idtarjeta" />
                                <label for="idtarjeta">Tarjeta</label>
                              </div>

                              <div class="input-field col col s12 m12">
                                <input id="idsaldo" name="idsaldo" type="text" readonly class="validate" style="font-size: 28px;"  value="0">
                                <label for="idsaldo">CAMBIO BS.</label>
                              </div>

                            </div>
                            <button style="width: 100%" id="idreset" type="button"  class="btn red">RESET</button>
                          </div>
                        </div>&nbsp;
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button id="btnSave" target="_blank" disabled type="button" class="btn green"> GUARDAR  VENTA</button> 
                  </div>
                </div>
             </div>
            </div>  
          </div>   
          <div class="container">
            <div class="section">
            <!--  <a href="nuevo/" class="btn blue"><i class="fa fa-plus"></i> Nuevo Libro</a><br><br> -->
            <div class="row">            
              <div class="col s12 m12 l4">
                <div class="table-responsive">                                            
                  <div id="result"></div>
                  <table id="examples" class="display" cellspacing="0" width="100%" style="font-size: 13px;">
                    <thead>
                      <tr>
                        <th>COD</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Opciones</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="3"></td>
                        <th colspan="1">TOTAL BS: </th>
                        <th colspan="2"></th>
                      </tr>
                    </tfoot>
                  </table>
                  <div class='modal-footer col-xs-12 col-sm-12'> 
                    <button type='button' id='idCobrarVenta' href="#modal2" class='btn green modal-trigger'><i class="fa fa-money"></i> COBRAR VENTA</button>
                  </div>
                </div>
              </div> 
              <div class="col s12 m12 l8">
              <div class="col s12">
                <ul class="tabs tab-demo z-depth-1 cyan">
                 
                  <li class="tab col s3"><a class="white-text waves-effect waves-light active" href="#test2">BUSQUEDA DE MEDICAMENTOS</a>
                  </li>
                 <!-- <li class="tab col s3"><a class="white-text waves-effect waves-light" href="#test3">Por Mayor </a>
                  </li> -->
                </ul>
                </div>
                <div class="col s12">
                   
                  <div id="test2" class="col s12 cyan lighten-4">
                    <table id="tablaPedidos" class="display" cellspacing="0" width="100%" style="font-size: 13px; color:##060606;">
                        <thead>
                        <tr>
                          <th>nombre</th>
                          <th>precio</th>
                          <th style="width: 80px;">cantidad</th>
                          <th>medicamento</th>
                          <th>ATQ</th>
                          <th>Stock</th>
                          <th>Accion</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                  </div>
                              
                </div>
                <div class="col s12">
                 <div class="col s12" style="border: 1px solid cyan;"></div>
                </div>
                
              </div>
            </div>
            </div>
          </div>
          <?php
          //  include_once("../../footer.php");
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
    function Hola(id){
      console.error("Hola Este es el ID:"+id);
      alert(id);
    }
    function obtener_datos(){
        console.log("EstoFalla");
      }
      var table;
      ListarDatos();
      function ListarDatos(){
        $("#examples").dataTable().fnDestroy();
          var table=$("#examples").dataTable({
            "ajax":{
              "method":"POST",
              "url":"dataItem.php?acc=list"
            },
           
            "columns":[
              {"data":"iditem"},
              {"data":"nombre"},
              {"data":"precio"},
              {"data":"cantidad"},//<input type='number'>
              {"data":"subtotal"},
              {"defaultContent":"<a class='btn red ideliminar'><i class='fa fa-trash'></i></a>"}
            ],
            "paging":   false,
            "ordering": false,
            "info":     false,
            "footerCallback": function ( row, data, start, end, display ) {
              var api = this.api(), data;
              // Remove the formatting to get integer data for summation
              var intVal = function ( i ) {
                return typeof i === 'string' ?
                  i.replace(/[\$,]/g, '')*1 :
                  typeof i === 'number' ?
                    i : 0;
              };
            
              // Total over all pages
              total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
              // Total over this page
              pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
              // Update footer
              $( api.column( 4 ).footer() ).html(
                pageTotal 
              );
            }
          });
        eliminaItemCarrito("#examples tbody",table);
      }

      function eliminaItemCarrito(tbody,table){
        $(tbody).on("click","a.ideliminar",function(){
          var data=table.api().row( $(this).parents("tr") ).data();        
          console.log(data);
          var str="idproducto="+data.iditem;
          $("#examples").dataTable().fnDestroy();
          var mytable=$("#examples").dataTable({
            "ajax":{
              "method":"POST",
              "url":"dataItem.php?"+str+"&acc=del"
            },
            "columns":[
              {"data":"iditem"},
              {"data":"nombre"},
              {"data":"precio"},
              {"data":"cantidad"},//<input type='number'>
              {"data":"subtotal"},
              {"defaultContent":"<a class='btn red ideliminar'><i class='fa fa-trash'></i></a>"}
            ],
            "paging":   false,
            "ordering": false,
            "info":     false,
            "footerCallback": function ( row, data, start, end, display ) {
              var api = this.api(), data;
              // Remove the formatting to get integer data for summation
              var intVal = function ( i ) {
                return typeof i === 'string' ?
                  i.replace(/[\$,]/g, '')*1 :
                  typeof i === 'number' ?
                    i : 0;
              };
              // Total over all pages
              total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
              // Total over this page
              pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
              // Update footer
              $( api.column( 4 ).footer() ).html(
                pageTotal 
              );
            }
          });
          eliminaItemCarrito("#examples tbody",mytable);
        });
      }
      function fn_agregarPRO(idproducto)
      {
        var canti= $("#"+idproducto+"cantidad").val();  

        var str="idproducto="+idproducto+"&idcantidad="+canti;
        $("#examples").dataTable().fnDestroy();
        var table=$("#examples").dataTable({
          "ajax":{
            "method":"POST",
            "url":"dataItem.php?"+str+"&acc=add"
          },
          "columns":[
            {"data":"iditem"},
            {"data":"nombre"},
            {"data":"precio"},
            {"data":"cantidad"},
            {"data":"subtotal"},
            {"defaultContent":"<a class='btn red ideliminar'><i class='fa fa-trash'></i></a>"}
          ],
          "paging":   false,
          "ordering": false,
          "info":     false,
          "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
              return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                  i : 0;
            };
            // Total over all pages
            total = api
              .column( 4 )
              .data()
              .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
              }, 0 );
            // Total over this page
            pageTotal = api
              .column( 4, { page: 'current'} )
              .data()
              .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
              }, 0 );
            // Update footer
            $( api.column( 4 ).footer() ).html(
              pageTotal 
            );
          }
        });
        eliminaItemCarrito("#examples tbody",table);
         $("#"+idproducto+"cantidad").val(1);
      }
      $("#idnitBORRAR").blur(function(){
        var str = $( "#idFormVenta" ).serialize();
        $.ajax({
          url: "validaFactura.php",
          type: "POST",
          data: str,
          success: function(resp){
            console.log(resp);
            $('#idresultado').html(resp);
          }
        });
      });
      $(document).ready(function(){
        $("#idreset").click(function(){
          $("#idimporte").val("0");
          $("#idimporteTar").val("0");
          $("#idsaldo").val("0");
          $("#iddescuento").val("0");
          $("#idtarjeta").prop('checked', false);

          $("#idimporteTar").val("0");
          $("#idnroreferencia").val("0");
      
          $("#idnit").val("");
          $("#idnombre").val("");
          $('#idimporteTar').attr("disabled",true);
          $('#idnroreferencia').attr("disabled",true);  
          verificaCambio();
          $('#btnSave').attr("disabled",true);
        });
        $("#btnResta").click(function(){
          var cantidad = $("#idcantidad").val();
          if (cantidad<=1) {
            swal("ALERTA !", "No puede tener cantidad 0", "warning");
          }else{
            $("#idcantidad").val(parseFloat(cantidad)-1);
          }
        });
        $("#btnSuma").click(function(){
          var cantidad = $("#idcantidad").val();
          $("#idcantidad").val(parseFloat(cantidad)+1);
        });
      });
      $("#Send").click(function(){
        var cant=document.getElementById('idcantidad').value; 
        var cod=document.getElementById('idvproductoAlm').value; 
        $.ajax({
          url: "verCantidad.php",
          type: "POST",
          data: "cant="+cant+"&idPA="+cod,
          success: function(resp){
            console.log(resp);
            var res=resp;
            if (res==1) 
            {
              fn_agregar();
            }
            if (res==2) 
            {
              swal("ERROR","La cantidad no puede ser mayor a la existencias","warning");    
            }
          }    
        });    
      });
      $(document).ready(function() {
        $('#example').DataTable({
          dom: 'Bfrtip',
          buttons: [
               'csv', 'excel', 'pdf' 
          ]
        });
        $('#opcion1').DataTable({
          dom: 'Bfrtip',
          buttons: [
               'excel', 'pdf' 
          ]
        });
        $('#opcion2').DataTable({
          dom: 'Bfrtip',
          buttons: [
               'excel', 'pdf' 
          ]
        });
        $('#opcion3').DataTable({
          dom: 'Bfrtip',
          buttons: [
               'excel', 'pdf' 
          ]
        });
        $('#opcion4').DataTable({
          dom: 'Bfrtip',
          buttons: [
               'excel', 'pdf' 
          ]
        });
      });      
      
      $(document).on("click", "#sumarC", function(){
       var id = $(this).data("ids");
        //alert(id);
          $.ajax({
            url: "sumaC.php",
            type: "POST",
            data: "idventadetalletemp="+id,
            success: function(resp){
              if (resp==1) 
              {
                //obtener_datos();
              }
               if (resp==2) 
              {
                swal({
                  title: "ERROR",
                  text: 'no registro',
                  type: "warning",
                  showCancelButton: true,
                  // confirmButtonColor: "#2c2a6c",
                  // confirmButtonText: "OK",
                  //closeOnConfirm: false
                }, function () {
                });
              }
              if (resp==3) 
              {
                msg("La cantidad no existe en el almacen 2", "ERROR");
              }
            }   
          });
        })
      $(document).on("click", "#restaC", function(){
       var id = $(this).data("idr");
        //alert(id);
          $.ajax({
            url: "restaC.php",
            type: "POST",
            data: "idventadetalletemp="+id,
            success: function(resp){
              if (resp==1) 
              {
                obtener_datos();                
              }
               if (resp==2) 
              {
                swal({
                  title: "ERROR",
                  text: 'no registro',
                  type: "warning",
                  showCancelButton: true,
                 // confirmButtonColor: "#2c2a6c",
                 // confirmButtonText: "OK",
                  //closeOnConfirm: false
                }, function () {
                });
              }
              if (resp==3) 
              {
                 msg("NO se puede tener 0 productos", "ERROR");
              }
            }   
          });
        })
      $(document).on("click", "#eliminar", function(){
        var id = $(this).data("ide");       
        //alert(id);
        $.ajax({
          url: "delete.php",
          type: "POST",
          data: "idventadetalletemp="+id,
          success: function(resp){
            if (resp==1) 
            {
              obtener_datos();                
            }else{
              swal({
                title: "ERROR",
                text: 'no registro',
                type: "warning",
                showCancelButton: true,
               // confirmButtonColor: "#2c2a6c",
               // confirmButtonText: "OK",
                //closeOnConfirm: false
              }, function () {
              });
            }
          }   
        });
      })
      function validar(){
        retorno= true;
        var nombre=$("#idnombre").val();
        if (nombre=="") {
          retorno=false;
        }
        var nit=$("#idnitERror").val();
        if (nit=="") {
          retorno=false;
        }
        return retorno;
      }

      $(document).on("click", "#idCobrarVenta", function(){
        $.ajax({
          url: "devuelveTotal.php",
          type: "POST",
          success: function(resp){
            $('#idresultado').html(resp);
          }
        });

      });


      $("#btnSave").click(function(){
        if (validar()) {
          swal({   
            title: "Estas Seguro?",   
            text: "Se registrara la venta",   
            type: "warning",   
            showCancelButton: true,   
            closeOnConfirm: false,   
            showLoaderOnConfirm: true,
          }, 
          function(){
            var str = $("#idFormVenta").serialize();
            if($("#idtarjeta").is(':checked')) 
            {  
                //alert("Está activado");
                var contarjeta=1; 
            }else{  
                var contarjeta=0; 
            }

            $.ajax({
              url: "procesarVenta.php",
              type: "POST",
              data: str+"&contarjeta="+contarjeta,
              success: function(resp){
                //alert(resp);
                setTimeout(function(){     
                  console.log(resp);
                  $('#idresultado').html(resp);  
                }, 10); 
              }
            });
          });
        }else{
          swal("Error","Datos faltantes","error");
        }
      });

     $(document).on("blur", "#m_cantidad", function(){
          var id = $(this).data("idmc");
          var nuevacant = $(this).text();   
           
           if (parseInt(nuevacant)>0) 
           {
              //alert(id);
                $.ajax({
                    url: "cantidadlibre.php",
                    type: "POST",
                    data: "idventadetalletemp="+id+"&nuevacantidad="+nuevacant,
                    success: function(resp){
                      if (resp==1) 
                      {
                        obtener_datos();                
                      }
                      if(resp==2)
                      {
                         swal({
                                title: "ERROR",
                                text: 'no registro',
                                type: "warning",
                                showCancelButton: true,
                               // confirmButtonColor: "#2c2a6c",
                               // confirmButtonText: "OK",
                                //closeOnConfirm: false
                              }, function () {

                              });
                      }
                          if (resp==3) 
                      {
                          msg("La cantidad no existe en el almacen 3", "ERROR");
                           obtener_datos(); 
                      }
                      
                    }   
                  });
           }else{
            msg("ingrese numero valido ", "ERROR");
            obtener_datos();
           }
              
        })

    function validaCant(cantidad){
      flag=true;
      if (cantidad<=0) {
        flag=false;
      }
      return flag;
    }
    function sumBillete(num){
        num=parseFloat(num);
        num=num.toFixed(2);
        var importe = $("#idimporte").val();
        importe=parseFloat(importe)+parseFloat(num);
        importe=importe.toFixed(2);
        $("#idimporte").val(importe);
        verificaCambio();
      }
    function verificaCambio(){  
        var importe = $("#idimporte").val();
        var costoTotal = $("#idmonto").val();
        var importeTar = $("#idimporteTar").val();
        var ImporteTotal=parseFloat(importe)+parseFloat(importeTar)
        

        var calculo = parseFloat(importe)+parseFloat(importeTar);
         var saldo = parseFloat(calculo)-parseFloat(costoTotal);
        if (parseFloat(calculo)>=parseFloat(costoTotal)) {
          $('#btnSave').attr("disabled",false);
          $("#idCambio").css("color","#67c13d");
          $("#idsaldo").val(saldo.toFixed(2));
        }
        else{
          $('#btnSave').attr("disabled",true);
          $("#idCambio").css("color","#FF0000");    
        }
        if (parseFloat(ImporteTotal)>=parseFloat(costoTotal)) 
        {
            $('#btnSave').attr("disabled",false);
        }else{
            $('#btnSave').attr("disabled",true);
        }
      }
      function msg(mensaje, titulo){
        Materialize.toast('<span>'+titulo+'. '+mensaje+'</span>', 3500);
      }


      $(document).ready(function() {              
        obtener_datos();
      });


      $("#idefectivo").click(function(){

          if($("#idefectivo").is(':checked')) 
          {  
              //alert("Está activado");             
              $("#iddinero").css("display", "block");
          }else{  
               
               $("#iddinero").css("display", "none");
               $("#idimporte").val("0");
              // $("#idimporteTar").val("0");
               $("#idsaldo").val("0");
               verificaCambio();
          }
      });

      $("#idtarjeta").click(function(){

          if($("#idtarjeta").is(':checked')) 
          {  
              //alert("Está activado");
              var asistencia= 1;  
              $('#idimporteTar').attr("disabled",false);
              $('#idnroreferencia').attr("disabled",false);  
          }else{  
              $('#idimporteTar').attr("disabled",true); 
               $('#idnroreferencia').attr("disabled",true); 
               //$("#idimporte").val("0");
               $("#idimporteTar").val("0");
               $("#idsaldo").val("0");
               $("#idnroreferencia").val("");
               verificaCambio();
          }
          //alert(asistencia);
      });

      $("#idimporteTar").blur(function(){
         var importe = $("#idimporte").val();
        var importeTar = $("#idimporteTar").val();
        var costoTotal = $("#idmonto").val();
         var calculo = parseFloat(importe)+parseFloat(importeTar);
        if (parseFloat(calculo)> parseFloat(costoTotal)) 
        {
            swal("Error","No puede cobrar monto mayor al costo total","error");
            $("#idimporteTar").val(0);
            verificaCambio();
        }else{
          verificaCambio();
        }
        
      });
      $("#iddescuento").blur(function(){

          var importeoriginal = $("#idmontooriginal").val();
          var porcentaje = $("#iddescuento").val();
          var descuento=  porcentaje * parseFloat(importeoriginal) / 100;
          if (parseFloat(descuento) < parseFloat(importeoriginal)) 
          {
            if (parseFloat(descuento)>=0) 
            {
              importe=parseFloat(importeoriginal) - parseFloat(descuento);
              var importe = Math.round(importe * 100) / 100;
              $("#idmonto").val(importe);
              $("#idimporte").val("0");
              $("#idimporteTar").val("0");
              $("#idsaldo").val("0");
              $('#btnSave').attr("disabled",true);
            }else{
              swal("Error","No puede ser monto negativo","error");
               $("#iddescuento").val(0);
            }
              
          }else{
              swal("Error","No puede realizar descuento mayor a precio total","error");
               $("#iddescuento").val(0);
          }
         
      });                        
       mostrarPedidos();
      function mostrarPedidos(){
      $("#tablaPedidos").dataTable().fnDestroy();
        var idalmacen="<?php echo $idsucursal ?>";
        var str="idalmacen="+idalmacen;
        var table=$("#tablaPedidos").dataTable({
        "ajax":{
          "method":"POST",
          "url":"listarItemVenta.php?"+str
        },
        "columns":[
          {"data":"nombre"},
          {"data":"precio"},
          //{"defaultContent":"<input type='number' value='1'> "},
          {"data":"cantidad"},
          {"data":"medicamento"},
          {"data":"atq"},
          {"data":"existencia"},
        
          {"data":"bootones"}  
        ]
      });
      eliminaItemCarrito("#tablaPedidos tbody",table);
    };
    </script>
</body>

</html>