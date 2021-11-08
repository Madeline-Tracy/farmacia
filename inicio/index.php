<?php
 
  $ruta="../";  
  session_start();
  include_once($ruta."funciones/funciones.php");
  $lblcode=ecUrl(3898);
  //echo $lblcode;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Bienvenido a Administracion del Sistema";
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
          $idmenu=1000;
         include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <center>
                    
                  <h5 class="breadcrumbs-title titulo"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                  </center>
                  <ol></ol>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
          <section id="content">

<!--start container-->
<div class="container">

 

    <!-- //////////////////////////////////////////////////////////////////////////// -->

    <!--card stats start-->
    <div id="card-stats">
        <div class="row">
            <div class="col s12 m6 l3">
                <div class="card">
                    <div class="card-content  green white-text">
                        <p class="card-stats-title"><i class="mdi-editor-attach-money"></i> Gastos</p>
                        <h4 class="card-stats-number">Bs.- 120</h4>
                         
                    </div> 
                    <div class="card-action  green darken-2">
                        <div id="invoice-line" class="center-align"></div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l3">
                <div class="card">
                    <div class="card-content pink lighten-1 white-text">
                        <p class="card-stats-title"><i class="mdi-editor-insert-invitation"></i> Por Vencer</p>
                        <h4 class="card-stats-number">20 items</h4>
                         
                    </div>
                    <div class="card-action  pink darken-2">
                        <div id="invoice-line" class="center-align"></div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l3">
                <div class="card">
                    <div class="card-content blue-grey white-text">
                        <p class="card-stats-title"><i class="mdi-file-cloud-off"></i> Poco Stock</p>
                        <h4 class="card-stats-number">5 items</h4>
                         
                    </div>
                    <div class="card-action blue-grey darken-2">
                        <div id="profit-tristate" class="center-align"></div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l3">
                <div class="card">
                    <div class="card-content purple white-text">
                        <p class="card-stats-title"><i class="mdi-editor-attach-money"></i>Ventas Hoy</p>
                        <h4 class="card-stats-number">Bs.- 8990.63</h4>
                         
                    </div>
                    <div class="card-action purple darken-2">
                        <div id="sales-compositebar" class="center-align"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--card stats end-->
    <div id="chart-dashboard">
                        <div class="row">
                            <div class="col s12 m8 l8">
                                <div class="card">
                                    <div class="card-move-up waves-effect waves-block waves-light">
                                        <div class="move-up cyan darken-1">
                                            <div>
                                                <span class="chart-title white-text">VENTAS</span>
                                                <div class="chart-revenue cyan darken-2 white-text">
                                                    <p class="chart-revenue-total">Bs. 2,500.85</p> 
                                                </div>
                                                <div class="switch chart-revenue-switch right">
                                                    <label class="cyan-text text-lighten-5">
                                                      Mes
                                                      <input type="checkbox">
                                                      <span class="lever"></span> año
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="trending-line-chart-wrapper">
                                                <canvas id="trending-line-chart" height="70"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <a class="btn-floating btn-move-up waves-effect waves-light darken-2 right"><i class="mdi-content-add activator"></i></a>
                                        <div class="col s12 m3 l3">
                                            <div id="doughnut-chart-wrapper">
                                                <canvas id="doughnut-chart" height="200"></canvas>
                                                <div class="doughnut-chart-status">4500
                                                    <p class="ultra-small center-align">Sold</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 m2 l2">
                                            <ul class="doughnut-chart-legend">
                                                <li class="mobile ultra-small"><span class="legend-color"></span>Mobile</li>
                                                <li class="kitchen ultra-small"><span class="legend-color"></span> Kitchen</li>
                                                <li class="home ultra-small"><span class="legend-color"></span> Home</li>
                                            </ul>
                                        </div>
                                        <div class="col s12 m5 l6">
                                            <div class="trending-bar-chart-wrapper">
                                                <canvas id="trending-bar-chart" height="90"></canvas>                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-reveal">
                                        <span class="card-title grey-text text-darken-4">Revenue by Month <i class="mdi-navigation-close right"></i></span>
                                        <table class="responsive-table">
                                            <thead>
                                                <tr>
                                                    <th data-field="id">ID</th>
                                                    <th data-field="month">Month</th>
                                                    <th data-field="item-sold">Item Sold</th>
                                                    <th data-field="item-price">Item Price</th>
                                                    <th data-field="total-profit">Total Profit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>January</td>
                                                    <td>122</td>
                                                    <td>100</td>
                                                    <td>$122,00.00</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>February</td>
                                                    <td>122</td>
                                                    <td>100</td>
                                                    <td>$122,00.00</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>March</td>
                                                    <td>122</td>
                                                    <td>100</td>
                                                    <td>$122,00.00</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>April</td>
                                                    <td>122</td>
                                                    <td>100</td>
                                                    <td>$122,00.00</td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>May</td>
                                                    <td>122</td>
                                                    <td>100</td>
                                                    <td>$122,00.00</td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>June</td>
                                                    <td>122</td>
                                                    <td>100</td>
                                                    <td>$122,00.00</td>
                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <td>July</td>
                                                    <td>122</td>
                                                    <td>100</td>
                                                    <td>$122,00.00</td>
                                                </tr>
                                                <tr>
                                                    <td>8</td>
                                                    <td>August</td>
                                                    <td>122</td>
                                                    <td>100</td>
                                                    <td>$122,00.00</td>
                                                </tr>
                                                <tr>
                                                    <td>9</td>
                                                    <td>Septmber</td>
                                                    <td>122</td>
                                                    <td>100</td>
                                                    <td>$122,00.00</td>
                                                </tr>
                                                <tr>
                                                    <td>10</td>
                                                    <td>Octomber</td>
                                                    <td>122</td>
                                                    <td>100</td>
                                                    <td>$122,00.00</td>
                                                </tr>
                                                <tr>
                                                    <td>11</td>
                                                    <td>November</td>
                                                    <td>122</td>
                                                    <td>100</td>
                                                    <td>$122,00.00</td>
                                                </tr>
                                                <tr>
                                                    <td>12</td>
                                                    <td>December</td>
                                                    <td>122</td>
                                                    <td>100</td>
                                                    <td>$122,00.00</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                            </div>

                            <div class="col s12 m4 l4">
                                <div class="card">
                                    <div class="card-move-up teal waves-effect waves-block waves-light">
                                        <div class="move-up">
                                            <p class="margin white-text">Browser Stats</p>
                                            <canvas id="trending-radar-chart" height="114"></canvas>
                                        </div>
                                    </div>
                                    <div class="card-content  teal darken-2">
                                        <a class="btn-floating btn-move-up waves-effect waves-light darken-2 right"><i class="mdi-content-add activator"></i></a>
                                        <div class="line-chart-wrapper">
                                            <p class="margin white-text">Revenue by country</p>
                                            <canvas id="line-chart" height="114"></canvas>
                                        </div>
                                    </div>
                                    <div class="card-reveal">
                                        <span class="card-title grey-text text-darken-4">Revenue by country <i class="mdi-navigation-close right"></i></span>
                                        <table class="responsive-table">
                                            <thead>
                                                <tr>
                                                    <th data-field="country-name">Country Name</th>
                                                    <th data-field="item-sold">Item Sold</th>
                                                    <th data-field="total-profit">Total Profit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>USA</td>
                                                    <td>65</td>
                                                    <td>$452.55</td>
                                                </tr>
                                                <tr>
                                                    <td>UK</td>
                                                    <td>76</td>
                                                    <td>$452.55</td>
                                                </tr>
                                                <tr>
                                                    <td>Canada</td>
                                                    <td>65</td>
                                                    <td>$452.55</td>
                                                </tr>
                                                <tr>
                                                    <td>Brazil</td>
                                                    <td>76</td>
                                                    <td>$452.55</td>
                                                </tr>
                                                <tr>

                                                    <td>India</td>
                                                    <td>65</td>
                                                    <td>$452.55</td>
                                                </tr>
                                                <tr>
                                                    <td>France</td>
                                                    <td>76</td>
                                                    <td>$452.55</td>
                                                </tr>
                                                <tr>
                                                    <td>Austrelia</td>
                                                    <td>65</td>
                                                    <td>$452.55</td>
                                                </tr>
                                                <tr>
                                                    <td>Russia</td>
                                                    <td>76</td>
                                                    <td>$452.55</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
  
    <!--work collections start-->
    <div id="work-collections">
        <div class="row">
            <div class="col s12 m12 l6">
                <ul id="projects-collection" class="collection">
                    <li class="collection-item avatar">
                        <i class="mdi-file-folder circle light-blue darken-2"></i>
                        <span class="collection-header">LISTA DE ITEMS </span>
                        <p>Proximo vencimiento</p>
                        <a href="#" class="secondary-content"><i class="mdi-action-grade"></i></a>
                    </li>
                    <li class="collection-item">
                        <div class="row">
                            <div class="col s6">
                                <p class="collections-title">Web App</p>
                                <p class="collections-content">AEC Company</p>
                            </div>
                            <div class="col s3">
                                <span class="task-cat cyan">Development</span>
                            </div>
                            <div class="col s3">
                                <div id="project-line-1"></div>
                            </div>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div class="row">
                            <div class="col s6">
                                <p class="collections-title">Mobile App for Social</p>
                                <p class="collections-content">iSocial App</p>
                            </div>
                            <div class="col s3">
                                <span class="task-cat grey darken-3">UI/UX</span>
                            </div>
                            <div class="col s3">
                                <div id="project-line-2"></div>
                            </div>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div class="row">
                            <div class="col s6">
                                <p class="collections-title">Website</p>
                                <p class="collections-content">MediTab</p>
                            </div>
                            <div class="col s3">
                                <span class="task-cat teal">Marketing</span>
                            </div>
                            <div class="col s3">
                                <div id="project-line-3"></div>
                            </div>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div class="row">
                            <div class="col s6">
                                <p class="collections-title">AdWord campaign</p>
                                <p class="collections-content">True Line</p>
                            </div>
                            <div class="col s3">
                                <span class="task-cat green">SEO</span>
                            </div>
                            <div class="col s3">
                                <div id="project-line-4"></div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col s12 m12 l6">
                <ul id="issues-collection" class="collection">
                    <li class="collection-item avatar">
                        <i class="mdi-action-bug-report circle red darken-2"></i>
                        <span class="collection-header">Items con poco Stock</span>
                        <p>Cantidades minimas</p>
                        <a href="#" class="secondary-content"><i class="mdi-action-grade"></i></a>
                    </li>
                    <li class="collection-item">
                        <div class="row">
                            <div class="col s7">
                                <p class="collections-title"><strong>#102</strong> Home Page</p>
                                <p class="collections-content">Web Project</p>
                            </div>
                            <div class="col s2">
                                <span class="task-cat pink accent-2">P1</span>
                            </div>
                            <div class="col s3">
                                <div class="progress">
                                     <div class="determinate" style="width: 70%"></div>   
                                </div>                                                
                            </div>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div class="row">
                            <div class="col s7">
                                <p class="collections-title"><strong>#108</strong> API Fix</p>
                                <p class="collections-content">API Project </p>
                            </div>
                            <div class="col s2">
                                <span class="task-cat yellow darken-4">P2</span>
                            </div>
                            <div class="col s3">
                                <div class="progress">
                                    <div class="determinate" style="width: 40%"></div>   
                                </div>                                                
                            </div>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div class="row">
                            <div class="col s7">
                                <p class="collections-title"><strong>#205</strong> Profile page css</p>
                                <p class="collections-content">New Project </p>
                            </div>
                            <div class="col s2">                                                
                                <span class="task-cat light-green darken-3">P3</span>
                            </div>
                            <div class="col s3">
                                <div class="progress">
                                    <div class="determinate" style="width: 95%"></div>   
                                </div>                                                
                            </div>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div class="row">
                            <div class="col s7">
                                <p class="collections-title"><strong>#188</strong> SAP Changes</p>
                                <p class="collections-content">SAP Project</p>
                            </div>
                            <div class="col s2">
                                <span class="task-cat pink accent-2">P1</span>
                            </div>
                            <div class="col s3">
                                <div class="progress">
                                     <div class="determinate" style="width: 10%"></div>   
                                </div>                                                
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--work collections end-->

   

</div>
<!--end container-->
</section>
          </div>
        
        </section>
      </div>
    </div>
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
    ?>
    
    <!-- Toast Notification -->
    <script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable({
        responsive: true
      });
    });
    // Toast Notification
    $(window).load(function() {
        
        setTimeout(function() {
            Materialize.toast('<span>Bienvenido</span>', 1500);
        }, 1500);
        setTimeout(function() {
            Materialize.toast('<span>No Olvides revisar tu stock</span>', 3000);
        }, 5000);
        
    });
    </script>
</body>

</html>