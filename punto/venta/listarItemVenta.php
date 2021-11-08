<?php 
	$ruta="../../";
    include_once($ruta."class/itemalmacenventa.php");
    $itemalmacenventa=new itemalmacenventa;
	extract($_GET);
    session_start();
	$arrayName = array();
	//foreach($pedido->mostrarTodo("idproyecto=$idproyecto") as $f)
    foreach($itemalmacenventa->mostrarTodo("idalmacen in($idalmacen,0) ") as $f)
    {
		$iditaml=$f['iditemalmacenventa'];
		$id=$f['iditem'];
		$cntdd=$id."cantidad";
		//$lblcode=ecUrl($f['idpedido']);
		if ($f['existencias']>0) 
		{

			$boton1="<button onclick='fn_agregarPRO($id,$iditaml);'  class='btn-jh orange'>Adicionar</button>";
		}else{
			$boton1="";
		}
    	$val4=array(
    		"iditem"=>$f['iditem'],
			"nombre"=>$f['nombre'],
			//"lblcode"=>$lblcode,""
			"precio"=>$f['precio'],
			"cantidad"=>"<input type='number' value='1' id='$cntdd' style='text-align:center; font-size:20px; color:green'> ",
			"medicamento"=>$f['medicamento'],
            "atq"=>$f['grupo']." ".$f['accion'],
            "existencia"=>$f['existencias'],          
            "bootones"=>$boton1
            
            
		);
	    array_push($arrayName,$val4);
	}
	$arreglo['data']=$arrayName;
	echo json_encode($arreglo);
?>