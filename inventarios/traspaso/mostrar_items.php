<?php
session_start();
include_once("../../class/vitem.php");
$vitem=new vitem;
include_once("../../class/almacen.php");
$almacen=new almacen;
include_once("../../class/item_almacen.php");
$item_almacen=new item_almacen;
include_once("../../funciones/funciones.php");
extract($_POST);
$datosalm = $almacen->muestra($idalmacenO);
$lblcode2=ecUrl($datosalm['idalmacen']); 
  echo "
     <div class='col s12 m12 l12' style='text-align:center;'><b style='font-size:25px; color:#2C648C'>".$datosalm['nombre']."</b></div>
       <div class='col s12 m12 l12' style='text-align:center;'><b>ALMACEN</b></div>  
       <div class='col s12 m12 l12'>     
        <table  id='example2' class='display' cellspacing='0' width='100%'>
           <thead>
          <tr>                                       
            <th>Item.</th>
            <th>Existecia </th>
            <th>Cantidad </th>
          </tr>
        </thead>
        <tbody>
      ";
          switch ($datosalm['tipo_almacen']) {
             case '1':
                    $condicion="tipouso in(2)";
              break;
             case '2':
                  $condicion="tipouso in(1)";
              break; 
              case '3':
                  $condicion="tipouso in(1,2)";
              break;
          }      
       foreach($vitem->mostrarTodo($condicion) as $f)
      {
          $datoIA=$item_almacen->mostrarUltimo("idalmacen=".$idalmacenO." and iditem=".$f['idvitem']);
          $existecia=$datoIA['existencias'];
          $lblcode=ecUrl($f['idvitem']);
          $idvitem=$f['idvitem'];
          $idcantidad=$f['idvitem'].'cantidad';
          $inDis="";
          if ($datoIA['existencias']<=0) {
            $inDis="disabled";
            $neg='text-align:center;';
          }else{
               $neg='text-align:center; font-size:20px; color:blue';
          }
        echo "
              <tr>
                <td>".$f['nombre']."</td>
                <td style='text-align:center; font-size:17px; color:green'>".$datoIA['existencias']."</td> 
                <td style='width: 50px;'>
                  <input $inDis id='$idcantidad' name='$idcantidad' onblur='fn_agregarPRO($idvitem,$existecia)' type='number' style='$neg' min='1' max='10000' step='1' value='0'>
                  </td>
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
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });

    });

    </script>  
     

