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
        <table  id='exampleEgre' class='display' cellspacing='0' width='100%'>
           <thead>
          <tr>                                       
            <th>Ubicación.</th>
            <th>Fecha vencimiento </th>
            <th>Cantidad existente</th>
            <th>Seleccionar</th>
          </tr>
        </thead>
        <tbody>
      ";
            
       foreach($lote->mostrarTodo("idalmacen=".$idalmacen." and iditem=".$iditem." and cantidad>0") as $f)
      {
          $est=$estante->muestra($f['idestante']);
          $fil=$fila->muestra($f['idfila']);
          $idlote=$f['idlote'];     
        echo "
              <tr>
                <td> Estante ".$est['nombre'].' - '.$fil['nombre']."</td>
                <td>".$f['fecha_vencimiento']."</td>
                <td style='text-align:center; font-size:17px; color:green'>".$f['cantidad']."</td> 
                <td> <button id='btnagre' class='btn-jh blue' onclick='agregalote($idlote);'><i class='fa fa-check-square-o'></i></button></td>
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
           </tr>
        </tfoot>
        </table>      
         </div>                         
        "; 


    
          
?> 
 <script type="text/javascript">
    $(document).ready(function() {
      
       $('#exampleEgre').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            //'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });

    });
 function agregalote(idlot)
 {

      $.ajax({
          url: "mostrarLote.php",
          type: "POST",
          data: "idlote="+idlot,
          success: function(resp){
            console.log(resp);
            $('#idresultado').html(resp);
          }
        });
    

 }
    </script>  
     

