<?php 
  $ruta="../../";
  include_once($ruta."class/estante.php");
  $estante=new estante;
  include_once($ruta."funciones/funciones.php");

  session_start();
  $fechaactual=date('Y-m-d');
  $horaactual=date('H:i:s');
   $idusersis=$_SESSION["codusuario"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Lista de materia prima";
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

    .estInEste input{
      border:solid 1px #6759ff;
      border-radius: 3px;
    }
    .estilocliente{
      font-size:15px; 
      color:#004971;
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
          $idmenu=1028;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
           <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                
              </div>   
            </div>
          </div>
   <div class="container">
    <div class="section">
      <!--Basic Form <div class="divider"></div> -->
        <div class="row">

          <div class="col s12 m12 l2">&nbsp;</div>
      <div class="col s12 m12 l8">
              <div class="col s12 m4 l4">
                <a href="../../inicio" class="btn waves-effect waves-light red"><i class="fa fa-reply"></i> Atras</a>
                <a class="btn blue modal-trigger"  href="#modal5"><i class="fa fa-plus-square-o"></i> NUEVO</a>
                </div>
                <div class="col s12 m8 l8" style="color: white; border: 1px solid #006B99; background-color: #0088C2; border-radius: 5px; text-align: center; font-size: 18px;">
                <b>  LISTADO DE ESTANTES </b>
                </div>
        <div class="col s12 m12 l12">
          <div class="card-panel">
            <div class="row">
              <fieldset>
                    <legend class="titulo"></legend>
                    <table id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Cod</th>
                      <th>estante</th>
                      <th>Cantidad Fila</th>
                      <th>Descripción</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sw=true;
                    $contar=0;
                    foreach($estante->mostrarTodo("estado=1") as $f)
                    {
                       $lblcode=ecUrl($f['idestante']);
                       $contar++;
                      ?>
                      <tr>
                        <td><?php echo $f['idestante'] ?></td>
                        <td><?php echo $f['nombre'] ?></td>
                        <td><?php echo $f['cantidadfila'] ?></td>
                        <td><?php echo $f['descripcion'] ?></td>
                        <td>
                        <a class="btn-jh waves-effect darken-4 blue modal-trigger"  href="#modal2" onclick="cargar('<?php echo $f['idestante'] ?>');" ><i class="fa fa-pencil-square-o"></i> Editar</a>
                        <a class="btn-jh waves-effect darken-4 green modal-trigger"  href="#modal3" onclick="cargar2('<?php echo $f['idestante'] ?>');" ><i class="fa fa-plus-square-o"></i> filas</a>
                        </td>
                      </tr>
                      <?php
                      }
                    ?>
                  </tbody>
                </table>
                  </fieldset>
              </div>
            </div>
          </div>

      </div>
       <div class="col s12 m12 l2">&nbsp;</div>
    </div>
    </div>
   </div>
  <div class="container">
            <div class="section">
             <div class="row">
                <div id="modal5" class="modal" style="height: 100%" >
                  <div class="modal-content"> 
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    
                       <div align="right">
                         <button class="btn-jh waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i></button>                         
                       </div>
                        
                 <div class="row">
                   <div class="col s12 m12 l12" align="center" ><label style="color:#00BBC7; text-decoration:none; font-size:25px;"> NUEVO ESTANTE </label>
                       </div>
                
                  <div id="" class="col s12 m12 l12 " style="border: 1px solid #00818C; border-radius: 5px; background-color: white"><!--green lighten-5-->
                      <div class="card-content">
                      <div class="col s12 m12 l12">
                        <div class="input-field col s12 m6 l6"> 
                        <input id="idnombre" name="idnombre" type="text" class="validate" value=""  placeholder="">
                          <label for="idnombre"> Estante</label>
                        </div>
                        <div class="input-field col s12 m6 l6"> 
                        <input id="idcantidad" name="idcantidad" type="number" class="validate" value="" placeholder="">
                          <label for="idcantidad" > Cantidad de Filas</label>
                        </div>
                        <div class="input-field col s12 m12 l12"> 
                          <input id="iddescripcion" name="iddescripcion" type="text" class="validate" value="" placeholder="Descripción">
                          <label for="iddescripcion" > Descripcion</label>
                        </div>
                        
                      </div>
                      
                      </div>
                      <br><br><br><br><br><br>
                      </div>
                     
                 </div>

                    </form>
                  </div>
                  <div class="modal-footer">
                   <div class="col s12 m12 l12" style="text-align: right;"> 
                         <button id="btnSave" onclick="registrar();" style="font-size: 18px;" class="btn green"><i class="fa fa-save (alias)"></i> Guardar</button> 
                        </div>
                  </div>
                </div>
             </div>
            </div>  
          </div>
          <div class="container">
            <div class="section">
             <div class="row">
                <div id="modal2" class="modal" style="height: 100%" >
                  <div class="modal-content"> 
                  <form class="col s12" id="idform2" action="return false" onsubmit="return false" method="POST">
                       
                       <div align="right">
                         <button class="btn-jh waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i></button>                         
                       </div>
                        
                 <div class="row">
                   <div class="col s12 m12 l12" align="center" ><label style="color:#00BBC7; text-decoration:none; font-size:25px;"> MODIFICAR REGISTRO </label>
                       </div>
                
                  <div id="" class="col s12 m12 l12 " style="border: 1px solid #00818C; border-radius: 5px; background-color: white"><!--green lighten-5-->
                      <div class="card-content">
                      <div class="col s12 m12 l12">
                       <input id="idestanteImp" name="idestanteImp" type="hidden" >                        
                        <div class="input-field col s12 m6 l6"> 
                        <input id="idnombreImp" name="idnombreImp" type="text" class="validate" value=""  placeholder="">
                          <label for="idnombreImp"> Estante</label>
                        </div>
                        <div class="input-field col s12 m6 l6"> 
                        <input id="idcantidadImp" name="idcantidadImp" type="number" readonly class="validate" value="" placeholder="">
                          <label for="idcantidadImp" > Cantidad de Filas</label>
                        </div>
                        <div class="input-field col s12 m12 l12"> 
                          <input id="iddescripcionImp" name="iddescripcionImp" type="text" class="validate" value="" placeholder="Descripción">
                          <label for="iddescripcionImp" > Descripcion</label>
                        </div>
                      </div>
                      
                      </div>
                      <br><br><br><br><br><br>
                      </div>
                     
                 </div>

                    </form>
                  </div>
                  <div class="modal-footer">
                   <div class="col s12 m12 l12" style="text-align: right;"> 
                         <button id="btnSave" onclick="registrarMod();" style="font-size: 18px;" class="btn green"><i class="fa fa-save (alias)"></i> Modificar</button> 
                        </div>
                  </div>
                </div>
             </div>
            </div>  
          </div>
          
          <!--<?php
            //include_once("../footer.php");
          ?> -->
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
      
    $(document).ready(function() {
         $('#example0').DataTable( {
       "lengthMenu": [[5, 100, -1], [5, 100, "Todo"]],
       buttons: [
           
        ]
  });
      
      $('#example').DataTable({
        dom: 'Bfrtip',
      });
      $('#example2').DataTable({
        dom: 'Bfrtip',
        buttons: [
             'csv', 'excel', 'pdf' 
        ]
      });

  
    });


  //location.href='venta/index.php?lblcode='+id;  
//swal("ERROR!", "Valor no valido", "error")

    //---------------------------NUEVAS
  function registrar()
  {
    if (validar()) {
          swal({   
            title: "Estas Seguro?",   
            text: "Se realizara nuevo registro",   
            type: "warning",   
            showCancelButton: true,   
            closeOnConfirm: false,   
            showLoaderOnConfirm: true,
          }, 
          function(){
             var str = $( "#idform" ).serialize();
            $.ajax({
              url: "guardar.php",
              type: "POST",
              data: str,
              success: function(resp){
               // alert(resp);
                setTimeout(function(){     
                  console.log(resp);
                  $('#idresultado').html(resp);
                }, 1000); 
              }
            });
          });
        }else{
           swal("ERROR!", "Verificar datos faltantes", "error");
        }
  }

      function validar(retorno){
        var retorno=true;
        var nom=$("#idnombre").val();
        var num=$("#idcantidad").val();
        if (nom=="" || num=="") {
          retorno=false;
        }
        return retorno;
      }

    function cargar(idest)
     {
      //alert(idped);
       
        $.ajax({
          async: true,
          url: "../cargar/cargar_estante.php?idestante="+idest,
          type: "get",
          dataType: "html",
          success: function(data){
            var json = eval("("+data+")");

            $("#idestanteImp").val(json.idestante);
            $("#idnombreImp").val(json.nombre);
            $("#idcantidadImp").val(json.cantidad);
            $("#iddescripcionImp").val(json.descripcion);

          }

        });
        
     }

     function registrarMod()
  {
    if (validarMod()) {
          swal({   
            title: "Estas Seguro?",   
            text: "Modificar los datos",   
            type: "warning",   
            showCancelButton: true,   
            closeOnConfirm: false,   
            showLoaderOnConfirm: true,
          }, 
          function(){
             var str = $( "#idform2" ).serialize();
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
           swal("ERROR!", "Verificar datos faltantes", "error");
        }
  }

      function validarMod(retorno){
        var retorno=true;
        var nom=$("#idnombreImp").val();
        var des=$("#iddescripcionImp").val();
        if (nom=="" || des=="") {
          retorno=false;
        }
        return retorno;
      }
    </script>
</body>

</html>