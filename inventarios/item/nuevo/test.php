<?php
  $ruta="../../../";
  include_once($ruta."class/admsucursal.php");
  $admsucursal=new admsucursal;
  include_once($ruta."class/producto_almacen.php");
  $producto_almacen=new producto_almacen;
  include_once($ruta."class/producto.php");
  $producto=new producto;
  include_once($ruta."class/files.php");
  $files=new files;
  include_once($ruta."funciones/funciones.php");
extract($_GET);
  session_start();
 // $_SESSION['sucursal']=dcUrl($lblcode);//sucursal
  //echo $_SESSION['sucursal'];
   $_SESSION["idventatemp"]=0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
<!--
<link href="<?php// echo $ruta ?>recursos/css/layouts/style-horizontal.css" type="text/css" rel="stylesheet" media="screen,projection">
-->
  <?php
    $hd_titulo="PUNTO DE VENTA";
    include_once($ruta."includes/head_basico.php");
    include_once($ruta."includes/head_tabla.php");
    include_once($ruta."includes/head_tablax.php");

  ?>
  <style type="text/css">

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
</style>
</head>
<body id="layouts-horizontal">
    <?php
    $tab=1;
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
           
          <div class="container">
            <div class="section">
             <div class="row">
                <div id="modal2" class="modal" style="width:65%; height:100%;">
                  <div class="modal-content">
                   <div align="right">
                      <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i></button>  
                    </div>
                    <form class="col s12" id="idFormVenta" action="return false" onsubmit="return false" method="POST">
                    <div class="row">
                      <div class="col s12 m12 l12" style="background-color:#ffffff; border: 1px solid #D5D8DC; border-radius:5px;">
                          <div class="col s12 m12 l8">
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
                          <div class="campoForm col s12 m12 l4">
                                                  
                              <div class="formAreaND">  
                                <div class="laberlform">Pagado: </div>
                                <div class="campoForm"><input type="text" name="importe" value="0" id="idimporte" class="form-control"></div> 
                                <div class="laberlform">Costo: </div>
                                <div class="campoForm"><input type="text" readonly name="monto" id="idmonto" class="form-control"></div>
                                <div id="idCambio" class="laberlform">Cambio: </div>
                                <div class="campoForm"><input type="text" readonly name="saldo" id="idsaldo" class="form-control"></div>
                              </div>
                            <button id="idreset" type="button"  class="btn red">RESET</button>
                          </div>
                        </div>&nbsp;
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                       <!-- <button type="button" class="btn red" data-dismiss="modal">Cerrar</button> -->
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
              <div class="col s12 m12 l6"><div id="result"></div>
                    <div class="table-responsive">                                            
                        
                        <div class='modal-footer col-xs-12 col-sm-12'> 
                          <button type='button' id='idCobrarVenta' href="#modal2" disabled class='btn green modal-trigger'><i class="fa fa-money"></i> COBRAR VENTA</button>
                        </div>
                  </div>
              </div> 
              <div class="col s12 m12 l6">
              <div class="col s12">
                    <ul class="tabs tab-demo z-depth-1 cyan">
                      <li class="tab col s3"><a class="white-text waves-effect waves-light active" href="#test1">Mas Vendidos</a>
                      </li>
                      <li class="tab col s3"><a class="white-text waves-effect waves-light" href="#test2">General</a>
                      </li>
                      <li class="tab col s3"><a class="white-text waves-effect waves-light" href="#test3">Opción </a>
                      </li>
                      <li class="tab col s3"><a class="white-text waves-effect waves-light" href="#test4">Opción 4</a>
                      </li>
                    </ul>
                  </div>
                  <div class="col s12">
                    <div id="test1" class="col s12">
                        <?php
                                foreach($producto_almacen->mostrarTodo("idalmacen=8") as $f)//$idalm
                                {
                                  $pro=$producto->mostrar($f['idproducto']);
                                   $pro=array_shift($pro);   
                                  ?> 
                                        <div class="col s12 m12 l3 efecto" >
                                            <div class="col s12 m12 l12">
                                                    <?php   
                                                      $datofoto = $files->mostrarTodo("url_procedencia = ".$f['idproducto']." and tipo_foto = 'productos'");

                                                      if (count($datofoto)==0){

                                                          $pic= $ruta."imagenes/sinminiimagen.jpg";
                                                         
                                                          //echo "NO SE CARGO LA FOTO";
                                                      }
                                                      else{
                                                          $pic= $ruta."administracion/inventarios/productos/items/".$f['foto'];
                                                          //echo("cargo la foto");
                                                      }

                                                      ?>
                                                      <img class="imgefecto" onclick="fn_agregarPRO('<?php echo $f["idproducto_almacen"] ;?>','<?php echo $f["idproducto"] ;?>','<?php echo $pro['nombre'] ;?>','<?php echo $pro['precio_1'] ;?>','<?php echo $f['idlote'] ;?>');" src="<?php echo $pic ?>">
                                                    </div>   
                                                        <div class="col s12 m6 l8 precio">
                                                            <label style=" ">Bs</label><label class="preN"><?php echo $pro['precio_1']; ?></label>                                                       
                                                        </div>
                                                          <div class="col s12 m6 l4" style=" text-align:center; border-radius:20px; background:#d64100; color:white;">
                                                          
                                                               <?php echo $f['existencias']; ?>
                                                              
                                                          </div>
                                                        <div class="col s12 m12 l12" style="font-size:10px;">
                                                        <strong><?php echo $pro['nombre']; ?></strong>  
                                                        </div>  
                                            </div>
                                           
                                  <?php
                                }
                                                                  
                                ?> 
                    </div>
                    <div id="test2" class="col s12 cyan lighten-4">
                      <table id="opcion2" class="display" cellspacing="0" width="100%">
                                  <thead>
                                              <tr>                                       
                                                <th>nombre</th>
                                                <th style="width: 35px;">precio</th>
                                                <th style="width: 35px;">Lote</th>
                                                <th style="width: 43px;">Stock</th>
                                                <th>Accion</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <?php
                                                foreach($producto_almacen->mostrarTodo("idalmacen=8") as $f)//$idalm
                                                {
                                                   $pro=$producto->mostrar($f['idproducto']);
                                                  $pro=array_shift($pro);                                 
                                                ?>                              
                                                  <tr>
                                                    
                                                    <td>
                                                    <?php
                                                      echo $pro['nombre'];
                                                    ?>
                                                    </td>
                                                     <td style="width: 35px;">
                                                    <?php
                                                      echo $pro['precio_1'];
                                                    ?>
                                                    </td> 
                                                     <td style="width: 35px;">
                                                    <?php
                                                      echo $f['idlote'];
                                                    ?>
                                                    </td>                           
                                                    <td style="width: 43px;">
                                                    <?php
                                                      echo $f['existencias'];
                                                    ?>
                                                    </td>                          

                                                    <td width="90px;">
                                                    <button class="btn-jh green" onclick="fn_agregarPRO('<?php echo $f["idproducto_almacen"] ;?>','<?php echo $f["idproducto"] ;?>','<?php echo $pro['nombre'] ;?>','<?php echo $pro['precio_1'] ;?>','<?php echo $f['idlote'] ;?>');"><i class="fa fa-plus"></i>Adicionar</button> 

                                                     </td>
                                                  </tr>
                                                <?php
                                                }
                                                ?>                          
                                            </tbody>
                                            <tfoot>
                                              <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                              </tr>
                                            </tfoot>
                                </table>
                    </div>
                    <div id="test3" class="col s12 cyan lighten-4">
                     <table id="opcion3" class="display" cellspacing="0" width="100%">
                                    <thead>
                                              <tr>                                       
                                                <th>nombre</th>
                                                <th style="width: 35px;">precio</th>
                                                <th style="width: 35px;">Lote</th>
                                                <th style="width: 43px;">Stock</th>
                                                <th>Accion</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <?php
                                                foreach($producto_almacen->mostrarTodo("idalmacen=8") as $f)//$idalm
                                                {
                                                     $pro=$producto->mostrar($f['idproducto']);
                                                  $pro=array_shift($pro);                                 
                                                ?>                              
                                                  <tr>
                                                    
                                                    <td>
                                                    <?php
                                                      echo $pro['nombre'];
                                                    ?>
                                                    </td>
                                                     <td style="width: 35px;">
                                                    <?php
                                                      echo $pro['precio_1'];
                                                    ?>
                                                    </td> 
                                                     <td style="width: 35px;">
                                                    <?php
                                                      echo $f['idlote'];
                                                    ?>
                                                    </td>                           
                                                    <td style="width: 43px;">
                                                    <?php
                                                      echo $f['existencias'];
                                                    ?>
                                                    </td>                          

                                                    <td width="15px">
                                                    <button class="btn-jh green" onclick="fn_agregarPRO('<?php echo $f["idproducto_almacen"] ;?>','<?php echo $f["idproducto"] ;?>','<?php echo $pro['nombre'] ;?>','<?php echo $pro['precio_1'] ;?>','<?php echo $f['idlote'] ;?>');"><i class="fa fa-plus"></i> Adicionar</button> 

                                                     </td>
                                                  </tr>
                                                <?php
                                                }
                                                ?>                          
                                            </tbody>
                                            <tfoot>
                                              <tr>
                                                
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                              </tr>
                                            </tfoot>
                                </table>
                    </div>
                    <div id="test4" class="col s12 cyan lighten-4">
                      <table id="opcion4" class="display" cellspacing="0" width="100%">
                                    <thead>
                                              <tr>                                       
                                                <th>nombre</th>
                                                <th style="width: 35px;">precio</th>
                                                <th style="width: 35px;">Lote</th>
                                                <th style="width: 43px;">Stock</th>
                                                <th>Accion</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <?php
                                                foreach($producto_almacen->mostrarTodo("idalmacen=8") as $f)//$idalm
                                                {
                                                   $pro=$producto->mostrar($f['idproducto']);
                                                  $pro=array_shift($pro);                                 
                                                ?>                              
                                                  <tr>
                                                    
                                                    <td>
                                                    <?php
                                                      echo $pro['nombre'];
                                                    ?>
                                                    </td>
                                                     <td style="width: 35px;">
                                                    <?php
                                                      echo $pro['precio_1'];
                                                    ?>
                                                    </td>  
                                                     <td style="width: 35px;">
                                                    <?php
                                                      echo $f['idlote'];
                                                    ?>
                                                    </td>                           
                                                    <td style="width: 43px;">
                                                    <?php
                                                      echo $f['existencias'];
                                                    ?>
                                                    </td>                          

                                                    <td width="15px">
                                                    <button class="btn-jh green" onclick="fn_agregarPRO('<?php echo $f["idproducto_almacen"] ;?>','<?php echo $f["idproducto"] ;?>','<?php echo $pro['nombre'] ;?>','<?php echo $pro['precio_1'] ;?>','<?php echo $f['idlote'] ;?>');"><i class="fa fa-plus"></i> Adicionar</button> 

                                                     </td>
                                                  </tr>
                                                <?php
                                                }
                                                ?>                          
                                            </tbody>
                                            <tfoot>
                                              <tr>
                                                
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                              </tr>
                                            </tfoot>
                                </table>
                    </div>
                  </div>
                        
                  <div class="col s12">
                   <div class="col s12" style="border: 1px solid cyan;"></div>
                  </div>
                             <!--BORRAR   <div class="col s12 m12 l12">
                                <a href="#modal1" id="btnlistaP" class="btn btn-block btn-outline btn-primary modal-trigger" onclick="cargar('<?php echo $f['idestudiante'] ?>');"><i class="fa fa-plus-circle"></i> Productos...</a>
                                  </div> --> 
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
  $(document).ready(function(){
    $("#idreset").click(function(){
      $("#idimporte").val("0");
      $("#idsaldo").val("0");
      verificaCambio();
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
     $("#wizard").steps();
            $("#form").steps({
                bodyTag: "fieldset"
            });

    $("#Send").click(function(){
  var cant=document.getElementById('idcantidad').value; 
   var cod=document.getElementById('idvproductoAlm').value; 

            $.ajax({
              url: "verCantidad.php",
              type: "POST",
              data: "cant="+cant+"&idPA="+cod,
              success: function(resp){
                var res=resp;
                //alert(res);
                if (res==1) 
                {
                  fn_agregar();
                }
                 if (res==2) 
                {
                    //MENSAJE

                     swal({
                          title: "ERROR",
                          text: 'La cantidad no puede ser mayor a la existencias',
                          type: "warning",
                          showCancelButton: true,
                         // confirmButtonColor: "#2c2a6c",
                         // confirmButtonText: "OK",
                          //closeOnConfirm: false
                        }, function () {

                        });
                    //FIN MENSAJE
                }
                      
              }   
            });    
    });
</script>
    <script type="text/javascript">
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


       function obtener_datos()
       {
        $.ajax({
          url: "mostrar_marca.php",
          method: "POST",
          success: function(data){
              $("#result").value(data)
          }
        });
       }
       $(document).ready(function() {              

               obtener_datos();

        });

       function fn_agregarPRO(idproducto_almacen,idproducto,producto,precio,idlote)
      {
        //alert(idproducto_almacen+" "+idproducto+" "+precio+" "+producto);
         $.ajax({
                    url: "guardardetalletemp.php",
                    type: "POST",
                    data: "idproducto_almacen="+idproducto_almacen+"&idproducto="+idproducto+"&precio="+precio+"&producto="+producto+"&idlote="+idlote,
                    success: function(resp){
                      if (resp==1) 
                      {
                        obtener_datos();
                         $('#idCobrarVenta').attr("disabled",false);
                      
                      }
                       if (resp==2) 
                      {
                          //MENSAJE

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
                          //FIN MENSAJE
                      }
                        if (resp==3) 
                      {
                          msg("La cantidad no existe en el almacen", "ERROR");
                      }
                            
                    }   
                  }); 
      }


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
                          msg("La cantidad no existe en el almacen", "ERROR");
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

    $(document).on("click", "#idCobrarVenta", function(){

         var costoTotal= $("#idpreciototales").text();

          //$("#idpreciototales").html(costoTotal);
          $("#idmonto").val(costoTotal);
          $("#idsaldo").val("0");
        })

     $(document).on("click", "#btnSave", function(){
        $('#btnSave').attr("disabled",false);
         var str = $("#idFormVenta").serialize();
          //alert(str);
          $.ajax({
            url: "guardaVenta.php",
            type: "POST",
            data: str,
            success: function(resp){
                if (resp==1) 
                {
                         swal({
                              title: "CORRECTO",
                              text: 'Venta realizado correctamente, ¿Desea imprimir recibo?',
                              type: "success",
                              showCancelButton: true,
                              confirmButtonColor: "#7b4d87",
                              confirmButtonText: "SI, Imprimir recibo",
                              cancelButtonText: "No",
                              closeOnConfirm: false
                            }, function (isConfirm) {
                                      if (isConfirm) {
                                           location.reload();
                                          window.open("../impresion/impresionventa.php");
                                      }else {
                                          location.reload();
                                      }                              
                            });
                        //FIN MENSAJE
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
                   
              
            }
          });
        })

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
                          msg("La cantidad no existe en el almacen", "ERROR");
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
    var saldo = parseFloat(importe)-parseFloat(costoTotal);
    if (parseFloat(importe)>=parseFloat(costoTotal)) {
      $('#btnSave').attr("disabled",false);
      $("#idCambio").css("color","#67c13d");
      $("#idsaldo").val(saldo.toFixed(2));
    }
    else{
      $('#btnSave').attr("disabled",true);
      $("#idCambio").css("color","#FF0000");    
    }
  }
    </script>
</body>

</html>