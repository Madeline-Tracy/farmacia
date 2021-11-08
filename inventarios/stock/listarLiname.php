<?php 
	$ruta="../../";
    include_once($ruta."class/vliname.php");
    $vliname=new vliname;
	extract($_GET);
    session_start();
	$arrayName = array();

    foreach($vliname->mostrarTodo("activo=".$estado) as $f)
    {
    	
		$id=$f['idvliname'];
		$codigo=$f['codigo'];
		

			$boton2="
            <button id='btnasiga' class='btn-jh waves-effect waves-light green darken-4' onclick='asigna($id);'>VINCULAR</button>
      ";
    	$val5=array(
      			"medicamento"=>$f['medicamento'],
      			"forma"=>$f['forma'],
      			"concentracion"=>$f['concentracion'],
            "grupo"=>$f['grupo'],
            "accion"=>$f['accion'],        
            "bootones"=>$boton2            
            
		);
	    array_push($arrayName,$val5);
	}
	$arreglo['data']=$arrayName;
	echo json_encode($arreglo);
?>