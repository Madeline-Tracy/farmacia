<?php
session_start();
include_once("../../class/ventadetalletemp.php");
$ventadetalletemp=new ventadetalletemp;
extract($_POST);
$idventatemp = $_SESSION['idventatemp'];

echo "
        <table id='example3' class='table' >
           <thead>
          <tr>                                       
            <th>Cod</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th></th>
            <th>Total</th>
            <th>Proc.</th>
          </tr>
        </thead>
        <tbody>
      ";
      $suma=0;
       foreach($ventadetalletemp->mostrarTodo("idventatemp=".$idventatemp) as $f)
      {
        $suma=$suma+$f['total']; 
        $idvdt=$f['idventadetalletemp']; 
        echo "
              <tr>
                <td>".$f['idventadetalletemp']."</td>
                <td>".$f['producto']."</td>
                 <td>".$f['precio']."</td>               
                <td id='m_cantidad' data-idmc='".$f['idventadetalletemp']."'contenteditable>".$f['cantidad']."</td>
                  <td><button id='restaC' data-idr='".$f['idventadetalletemp']."' class='btn-jh red'>-</button><button id='sumarC' data-ids='".$f['idventadetalletemp']."' class='btn-jh green' >+</button></td>
                 <td>".$f['total']."</td>
                <td>
                <button id='eliminar' data-ide='".$f['idventadetalletemp']."' class='btn-jh red' ><i class='fa fa-trash'></i>Eliminar</button> 

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
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </tfoot>
        </table>
         <div class='tituloVentas'>
          <div>PRECIO TOTAL</div>                            
          </div> 
          <div class='total'>Bs <span id='idpreciototales'>".$suma."</span></div>

          
                                
        ";     
          
?> 
   
     

