<?php
  $ruta="../../";
  include_once($ruta."class/invitem.php");
  $invitem=new invitem;
  include_once($ruta."class/almacen.php");
  $almacen=new almacen;
  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);
  $idpedido=dcUrl(10);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Traspaso de Items ";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
      include_once($ruta."includes/head_tablax.php");
    ?>
    <style type="text/css">
      .estIn input{
        border:solid 1px #4286f4;
        width: 110px;
        height: 20px;
      }
      .disabled {
        pointer-events: none;
      }

      .cssdatos{
      padding: 0px;
      border: 0px;
      margin: 0px;
      margin-top: 10px;
      border: 1px solid white;
      font-size: 12px;
    }
    .cssdatos thead tr th{
  padding: 0px;
  border: 0px;
  margin: 0px;
  text-align: center;
  background-color: #03459E;
  font-size: 12px;
  color: white;
}
  .cssdatos tbody tr td{
    padding: 0px;
    border: 0px;
    margin: 0px;
    border: 1px solid white;
    text-align: center;
    font-size: 12px;
    color:#03459E;
    font-weight: bold;
  }
  .tituloblue{
  color: #03459E;
  font-weight: bold;
  font-size: 18px;
  margin: 5px;
  border-bottom: 1px solid #03459E;
}
 .buscador{
   border: 1px solid #03459E; 
  border-radius:5px;  
 /* background: #FCFCFC;*/
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
          $idmenu=1031;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                 <!--  <a href="../aprobado" class="btn waves-effect darken-4 red"><i class="mdi-content-reply-all"></i> Volver</a>
                 <a class="btn blue" href="../../proyectos"><i class="mdi-content-reply"></i></a>
                  <button id="btnSendProyect" class="btn purple"><i class="mdi-content-send"></i> Abastecer</button>
               <a href="#modal1" onclick="ListarDatos();" class="btn waves-effect blue darken-3 modal-trigger" id="btnpres" ><i class="fa fa-calculator"></i> Lista previa</a> -->
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="section">
              <div class="row"> 

                <div class="col s12 m12 l6">
                    <fieldset class="buscador" >
                        <legend><div class="tituloblue"><strong><i class="mdi-action-assignment"></i>ALMACEN PROCEDENCIA</strong> </div></legend> 
                            <div class="input-field col s12 m12 l12  bordeado">
                                  <label for="idalmacenO">Almacen Origen</label>
                                  <select id="idalmacenO" name="idalmacenO" onchange="obtener_items(this.value);">
                                   <option value="0">Seleccionar</option>
                                    <?php
                                          foreach($almacen->mostrarTodo("") as $t)
                                          {                                            
                                            ?> 
                                              <option value="<?php echo $t['idalmacen'] ?>"><?php echo $t['nombre']; ?></option>
                                            <?php
                                          }
                                        ?>
                                  </select>
                                </div>          
                    </fieldset>
                   </div>
                   <div class="col s12 m12 l6">
                    <fieldset class="buscador" style="background-color: #EAF4F8;" >
                        <legend><div class="tituloblue"><strong><i class="mdi-action-assignment"></i> ALMACEN DESTINO</strong> </div></legend> 
                          <div class="input-field col s12 m12 l12  bordeado">
                                  <label for="idalmacenD">Almacen destino</label>
                                  <select id="idalmacenD" name="idalmacenD" onchange="selectDestino();">
                                   <option value="0">Seleccionar</option>
                                    <?php
                                          foreach($almacen->mostrarTodo("") as $t)
                                          {                                            
                                            ?> 
                                              <option value="<?php echo $t['idalmacen'] ?>"><?php echo $t['nombre']; ?></option>
                                            <?php
                                          }
                                        ?>
                                  </select>
                                </div>             
                    </fieldset>
                        
                   </div>
              </div>
              
            </div>
          </div>
          <div class="container">
            <div class="section">
              <div class="row"> 

              <div class="col s12 m12 l6">
                <fieldset class="buscador" >
                    <legend><div class="tituloblue"><strong><i class="mdi-action-assignment"></i> ITEMS</strong> </div></legend> 
                       <div class="row">
                            <div class="col s12 m12 l12">
                               <div class="row table-responsive">                                          
                                      <div id="result2"></div>
                                </div>
                             </div>    
                         </div>
                      </fieldset>
                   </div>
                   <div class="col s12 m12 l6">
                    <fieldset class="buscador" style="background-color: #EAF4F8;" >
                        <legend><div class="tituloblue"><strong><i class="mdi-action-assignment"></i> Lista de Items seleccionados</strong> </div></legend> 
                         <div class="table-responsive">                                            
                          <div id="result"></div>
                          <table id="examples" class="display" cellspacing="0" width="100%">
                            <thead style="font-size:14px;">
                              <tr>
                                <th>Cod</th>
                                <th  style="width:300px;">Item</th>
                                <th>Cantidad</th>
                                <th>Opciones</th>
                              </tr>
                            </thead>
                            <tbody style="font-size:14px;">
                            </tbody>
                            <tfoot>
                              <tr>
                                <td colspan="1"></td>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                              </tr>
                            </tfoot>
                          </table>
                          <div class='modal-footer col-xs-12 col-sm-12' align="right"> 
                            
                             <button id="btnSendProyect" disabled class="btn purple"><i class="mdi-content-send"></i> Traspasar items</button>
                          </div>
                        </div>             
                    </fieldset>
                        
                   </div>
              </div>
              
            </div>
          </div>
          <?php
            //include_once("../footer.php");
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
           actualizar();
      function actualizar()
      {
          $.ajax({
          url: "vaciar.php",
          type: "POST",
          data: "valor=0",
          success: function(resp){
            console.clear();
            console.log(resp);
            $('#idresultado').html(resp);
          }
        });
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
              {"data":"cantidad"},
              {"defaultContent":"<a class='btn-jh red ideliminar'><i class='fa fa-trash'></i></a>"}
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
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
              // Total over this page
              pageTotal = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
              // Update footer
              $( api.column( 3 ).footer() ).html(
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
                    {"data":"cantidad"},
              {"defaultContent":"<a class='btn-jh red ideliminar'><i class='fa fa-trash'></i></a>"}
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
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
              // Total over this page
              pageTotal = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
              // Update footer
              $( api.column( 3 ).footer() ).html(
                pageTotal 
              );
            }
            
          });
          eliminaItemCarrito("#examples tbody",mytable);
          //AUMENTADO
                // $('#'+data.iditem+'btn').attr("disabled",false);
                // $('#'+data.iditem+'precio').attr("disabled",false);
               //  $('#'+data.iditem+'precio').css('background-color','white');
                      $('#'+data.iditem+'cantidad').attr("disabled",false);
                       $('#'+data.iditem+'cantidad').css('background-color','white');
                       $("#"+data.iditem+"cantidad").val(0);
        });
      }
      function fn_agregarPRO(idproducto,exis)
      {
        
       var canti= $("#"+idproducto+"cantidad").val(); 
       //alert(idproducto+' '+cantidad);       
        canti=parseInt(canti);
        //alert(precio);
          if (canti<=0) 
          {
            Materialize.toast('<span>No pueden ser 0 o negativo</span>', 1500);
          }else{
                 if (exis>=canti) 
                 {
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
                          {"data":"cantidad"},
                          {"defaultContent":"<a class='btn-jh red ideliminar'><i class='fa fa-trash'></i></a>"}
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
                                .column( 3 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                              // Total over this page
                              pageTotal = api
                                .column( 3, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                              // Update footer
                              $( api.column( 3 ).footer() ).html(
                                pageTotal 
                              );
                            }
                       
                      });
                      eliminaItemCarrito("#examples tbody",table);
                       //$("#"+idproducto+"cantidad").val(1);
                        //$('#'+idproducto+'btn').attr("disabled",true);
                       // $('#'+idproducto+'precio').attr("disabled",true);
                       // $('#'+idproducto+'precio').css('background-color','#73C6B6');
                       $('#btnSendProyect').attr("disabled",false);
                       $('#'+idproducto+'cantidad').attr("disabled",true);
                       $('#'+idproducto+'cantidad').css('background-color','#C5ECFC');
                 }else{
                      swal("Error","No existe "+canti+" en el almacen","error");
                 }
                
          }
        
        
      }
  

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
            var str = $( "#idFormVenta" ).serialize();
            $.ajax({
              url: "procesarVenta.php",
              type: "POST",
              data: str,
              success: function(resp){
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


    function validaCant(cantidad){
      flag=true;
      if (cantidad<=0) {
        flag=false;
      }
      return flag;
    }

      function msg(mensaje, titulo){
        Materialize.toast('<span>'+titulo+'. '+mensaje+'</span>', 3500);
      }

   $("#btnSendProyect").click(function(){
      
        var almO= $("#idalmacenO").val();
         var almD= $("#idalmacenD").val();  
         if (almO==0 || almD==0) 
         {
            swal("Error","Debe Seleccionar los almacenes Origen o destino ","error");
         }else if(almO==almD){
            swal("Error","No se puede traspasar al mismo almacen","error");
         }else{
                swal({   
                  title: "Estas Seguro?",   
                  text: "Traspasaras items al almacen seleccionado",   
                  type: "warning",   
                  showCancelButton: true,   
                  closeOnConfirm: false,   
                  showLoaderOnConfirm: true,
                }, 
                function(){                 
                            $.ajax({
                              url: "guardar.php",
                              type: "POST",
                              data: "idalmacenO="+almO+"&idalmacenD="+almD,
                              success: function(resp){
                               // alert(resp);
                                setTimeout(function(){
                                  console.log(resp);
                                  $('#idresultado').html(resp);  
                                }, 1000); 
                              }
                            });
                });
         }

        
      });


   ////--------------------------------
   function obtener_items(idalm)
    {    actualizar(); 
         ListarDatos(); 
         selectDestino();

          $.ajax({
          url: "mostrar_items.php",
          method: "POST",
          data: "idalmacenO="+idalm,
          success: function(data){
              $("#result2").html(data)
          }
        });
           
    }
    function selectDestino()
    {
         var almO= $("#idalmacenO").val();
         var almD= $("#idalmacenD").val();  
         if (almO==0) 
         {
            swal("Error","Seleccione primero el origen del almacen ","error");
            $("#idalmacenD").val('0');
            $("#idalmacenD").material_select(); 
         }else if(almO==almD){
            swal("Error","No se puede traspasar al mismo almacen seleccionado","error");
         }
    }
    </script>
</body>

</html>