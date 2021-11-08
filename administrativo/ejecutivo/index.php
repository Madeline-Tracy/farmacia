<?php
  $ruta="../../";
  
  include_once($ruta."class/rol.php");
  $rol=new rol;
  include_once($ruta."funciones/funciones.php");
 
  session_start();  
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="USUARIOS";
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
          $idmenu=12;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                </div>
              </div>
            </div>
          </div>


 <div class="row">
      <div class="col s12">
        <ul class="tabs tab-demo-active z-depth-1 cyan">
          <li class="tab col s3"><a class="white-text waves-effect waves-light " href="#activeone">LISTADO DE USUARIOS</a>
          </li>
        </ul>
      </div>
      <div class="col s12">
        <div id="activeone" class="col s12  ">
         <div class="container">
            <div class="section">
              <div class="col s12 m12 l12">
                <table id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr> 
                      <th>N</th>  
                      <th>Nombre</th>    
                      <th>Ingreso</th> 
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr> 

                      <th>N</th> 
                      <th>Nombre</th> 
                      <th>Rol</th>    
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    $x =1;
                    foreach($vusuario->mostrarTodo("") as $f) 
                    {  

                      $lblcode=ecUrl($f['idpersona']);
                      switch ($f['activo']) {
                        case '0':
                          $estilo="background-color: #18CDCA;";
                        break;
                        case '1':
                          $estilo="background-color: #6cd17f;";
                        break;
                      }
                    ?>
                    <tr style="<?php echo $estilo ?>">

                      <td><?php echo $x ?></td> 

                      <td><?php echo $f['nombre']." ".$f['paterno']." ".$f['materno'] ?></td>
                       
                      
                      <td><?php echo $f['rol'] ?></td>
                     
                      <td>
                        <?php 
                          if ($f['activo']==0) echo "INACTIVO";else echo "ACTIVO";
                        ?>
                      </td>
                      <td>


                        <a href="nuevo/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-4 red"><i class="fa fa-lock"></i>  </a>
                      </td>
                    </tr>
                    <?php
                      $x=$x+1;
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>     
            </div>
        </div>
      </div>
    </div>


        


          </div>
          <?php
            include_once("../footer.php");
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
      include_once($ruta."includes/script_tablax.php");
    ?>
   <script type="text/javascript">
    $('#example').DataTable({
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        responsive: true,
        "bAutoWidth": true,
      });
    function cambiaestado(id,estado){
      swal({
        title: "Estas Seguro?",
        text: "Cambiaras el estado al ejecutivo",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "Estoy Seguro",
        closeOnConfirm: false
      }, function () {      
        $.ajax({
          url: "cambiaestado.php",
          type: "POST",
          data: "id="+id+"&estado="+estado,
          success: function(resp){
            console.log(resp);
            $("#idresultado").html(resp);
          }   
        });
      }); 
    }
    </script>
</body>

</html>