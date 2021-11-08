<?php
session_start();
include_once("../../../class/invitem.php");
$invitem=new invitem;
include_once("../../../class/invventadet.php");
$invventadet=new invventadet;
include_once("../../../class/invventa.php");
$invventa=new invventa;
include_once("../../../funciones/funciones.php");
extract($_POST);
$ve=$invventa->muestra($idventa);

  echo "
     <div class='col s12 m12 l12' style='text-align:center;'>Razon social: <b style='color:#2C648C'>".$ve['razon']."</b></div>
       <div class='col s12 m12 l12' style='text-align:center;'>NIT: <b>".$ve['nit']."</b></div>
      <fieldset class='buscador'>
        <legend>
        <div class='titulo'><strong></strong>";
                switch ($ve['estado']) {
                  case '1':
                  echo"
                          <button onclick='revertirV($idventa);' class='btn-jh waves-effect waves-light red darken-4' ><i class='fa fa fa-times'></i> REVERTIR VENTA
                         </button> 
                     ";    
                    break;
                  
                 case '2':
                    echo"
                          <label style='color:red;' ><i class='fa fa fa-times'></i> Venta Anulado
                         </label> 
                     ";
                    break;
                }
        echo "
            
          </div>
        </legend>
        
        <table  id='example2' class='display' cellspacing='0' width='100%'>
           <thead>
          <tr>                                       
            <th style='width:50px;'>COD</th>
            <th>Item</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Total(Bs.)</th>
          </tr>
        </thead>
        <tbody>
      ";
               
       foreach($invventadet->mostrarTodo("idventa=".$idventa) as $f)
      {
        $it=$invitem->muestra($f['iditem']);
        // $lblcode2=ecUrl($f['idobra']);  
         $total=floatval($f['cantidad'])* floatval($f['precio']);
        echo "
              <tr>
              <td>".$f['idinvventadet']."</td>
                <td>".$it['nombre']."</td>
                <td>".$f['cantidad']."</td>
                <td>".number_format($f['precio'], 2, '.', '')."</td> 
                <td>".number_format($total, 2, '.', '')."</td> 
              </tr>
            ";
      }

 echo "  </tbody>
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
              
  </fieldset>       
                                
        "; 


    
          
?> 
 <script type="text/javascript">
    $(document).ready(function() {
      
       $('#example2').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });

    });

    </script>  
     

