<?php
session_start();
include_once("../../class/ventadetalletemp.php");
$ventadetalletemp=new ventadetalletemp;
extract($_POST);

        
              $ventadetalletemp->deleteRecord("idventadetalletemp=".$idventadetalletemp);
            
      echo '1';
 ?>