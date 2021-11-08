<?php
session_start();
include_once("../../class/vitem.php");
$vitem=new vitem;
include_once("../../class/almacen.php");
$almacen=new almacen;
include_once("../../class/lote.php");
$lote=new lote;
include_once("../../class/estante.php");
$estante=new estante;
include_once("../../class/fila.php");
$fila=new fila;
include_once("../../funciones/funciones.php");
extract($_POST); 
  echo "
       <div class='col s12 m12 l12'>     
        <table  id='example2' class='display' cellspacing='0' width='100%'>
           <thead>
          <tr>                                       
            <th>Ubicación.</th>
            <th>Fecha vencimiento </th>
            <th>Cantidad existente</th>
          </tr>
        </thead>
        <tbody>
      ";
            
       foreach($lote->mostrarTodo("idalmacen=".$idalmacen." and iditem=".$iditem) as $f)
      {
          $est=$estante->muestra($f['idestante']);
          $fil=$fila->muestra($f['idfila']);
         
        echo "
              <tr>
                <td> Estante ".$est['nombre'].' - '.$fil['nombre']."</td>
                <td>".$f['fecha_vencimiento']."</td>
                <td style='text-align:center; font-size:17px; color:green'>".$f['cantidad']."</td> 
              </tr>
            ";
      }

 echo "  </tbody>
        <tfoot>
          <tr>
            <th></th>
            <th></th>
            <th></th>
           </tr>
        </tfoot>
        </table>      
         </div>                         
        "; 


    
          
?> 
 <script type="text/javascript">
    $(document).ready(function() {
      
       $('#example2').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            //'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });

    });

    </script>  
     

