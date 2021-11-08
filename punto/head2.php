<?php
  //link clic logo definir a donde va para cada rol
  $rutaLogo=$ruta."inicio";
?>
  <?php
   $sw_h=false;
   if ($sw_h) {
     # code...
   
  ?>

  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>
  <?php
  }
  ?>
      <header id="header" class="page-topbar">
        <!-- start header nav-->
        <div class="navbar-fixed">
            <!-- HORIZONTL NAV START-->
             <nav id="horizontal-nav" class="hide-on-med-and-down" style="background-color:#237D9E; border-bottom: 3px solid #3F3334;  height:85px;">
                <div class="nav-wrapper"> 
                   <ul class="left">  
                      <li class="">
                        <a href="<?php echo $rutaLogo ?>"><img src="<?php echo $ruta ?>recursos/images/materialize-logo.png" style="width:200px;"></a>
                      </li>

                    </ul>                 
                  <ul id="ul-horizontal-nav" class="left hide-on-med-and-down bordMenu">
                    <li class="<?php if ($tab == 1) echo "active";?> barraMenu">
                        <a aria-expanded="false" role="button" href="<?php echo $ruta;?>punto/venta/?lblcode=<?php echo $lblcode ?>" style="color:white;"><img src="<?php echo $ruta; ?>punto/iconos/venta.png" style="width:60px;">VENTAS</a>
                    
                    </li>
                        <li class="<?php if ($tab == 2) echo "active";?> barraMenu ">
                        <a aria-expanded="false" role="button" href="<?php echo $ruta;?>punto/gastos/?lblcode=<?php echo $lblcode ?>" style="color:white;"><img src="<?php echo $ruta; ?>punto/iconos/gastos.png" style="width:60px;">GASTOS</a>
                    
                    </li>                  
                    <li class="barraMenu">
                        <a class="dropdown-menu" href="#!" data-activates="CSSdropdown">
                        <img src="<?php echo $ruta; ?>punto/iconos/reporte.png" style="width:60px;">
                           <i class="mdi-navigation-arrow-drop-down right"></i>REPORTES
                        </a>
                    </li>
                    <li class="<?php if ($tab == 3) echo "active";?> barraMenu">
                        <a  class="modal-trigger" onclick="obtener_total(<?php echo $idsucursal ?>);" aria-expanded="false" role="button" href="#modal5" style="color:white;"><img src="<?php echo $ruta; ?>punto/iconos/money.png" style="width:60px;"></a>
                    </li>
                    
                  </ul>
                   <ul class="right hide-on-med-and-down">
                    <li>Sistema de administracion</li>
                    <li><a href="javascript:void(0);" class="waves-effect waves-block waves-light toggle-fullscreen"><i class="mdi-action-settings-overscan"></i></a>
                    </li>     
                    <li><a href="<?php echo $ruta ?>session/salir.php"><i class="fa fa-sign-out"></i> Cerrar Sesion</a>
                    </li>
                    <li>&nbsp;&nbsp;&nbsp;&nbsp; </li>
                </ul>
                </div>
              </nav>

                <!-- CSSdropdown -->
                <ul id="CSSdropdown" class="dropdown-content dropdown-horizontal-list">
                  <li><a href="<?php echo $ruta;?>punto/venta/imprimir/detalleventa.php?lblcode=<?php echo $lblcode ?>" class="cyan-text"  target="_blank">Ventas y gastos</a></li>
                   <li><a href="<?php echo $ruta;?>inventarios/imprimir/existencias.php?lblcode=<?php echo $lblcode ?>" class="cyan-text"  target="_blank">Existencia en almacen</a></li> 
                </ul>

            <!-- HORIZONTL NAV END-->
            
        </div>
        <!-- end header nav-->
    </header>
      <div class="container">
            <div class="section">
             <div class="row">
              <div id="modal5" class="modal bottom-sheet">
                  <div class="modal-content">
                          <div class="table-responsive">  
                          <div><b>RESUMEN</b></div>                                          
                            <div id="result"></div>
                          </div>

                  </div>
                </div>
             </div>
            </div>  
          </div>
<script type="text/javascript">
     function obtener_total(idsuc){
        $.ajax({
          url: "mostrar_total.php?idalmacen="+idsuc,
          method: "POST",
          success: function(data){
              $("#result").html(data)
          }
        });
      }
    </script>