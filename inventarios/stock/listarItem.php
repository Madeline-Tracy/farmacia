<?php 
	$ruta="../../";
    include_once($ruta."class/vitem.php");
    $vitem=new vitem;
    include_once($ruta."class/almacen.php");
    $almacen=new almacen;
    include_once($ruta."class/item_almacen.php");
    $item_almacen=new item_almacen;
	extract($_GET);
    session_start();
	$arrayName = array();
	$datosalmacen = $almacen ->muestra($idalmacen);
     //$lblcode2=ecUrl($datosalmacen['idalmacen']);
	switch ($datosalmacen['tipo_almacen']) {                               
                                
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
    	
      $datoIA=$item_almacen->mostrarTodo("idalmacen=".$idalmacen." and iditem=".$f['idvitem']);
      $datoIA=array_shift($datoIA);
		$id=$f['idvitem'];
		$cntdd=$id."existen";
		$precio=number_format($f['precio'], 2, '.', ' ').' Bs.-';
    $existencia=$datoIA['existencias'];
    $exis="<label style='color: #434343' id='$cntdd' >$existencia</label>";
		if ($datoIA['existencias']==0) 
		{
			$boton1="<button onclick='cargar($id);'  class='btn-jh green'>Ingreso</button>";
		}else{
			$boton1="<button onclick='cargar($id);'  class='btn-jh green'>Ingreso</button>
			         <button onclick='cargarEgre($id);'  class='btn-jh red'>Egreso</button>";			
		}
    	$val4=array(
    		"iditem"=>$f['idvitem'],
			"nombre"=>$f['nombre'],
			//"lblcode"=>$lblcode,""
			"marca"=>$f['marca'],
			//"cantidad"=>"<input type='number' value='1' id='$cntdd' style='text-align:center; font-size:20px; color:green'> ",
			"uso"=>$f['uso'],
      "tipo"=>$f['tipo'],
      "precio"=>$precio,
      "existencia"=>$exis,          
      "bootones"=>$boton1            
            
		);
	    array_push($arrayName,$val4);
	}
	$arreglo['data']=$arrayName;
	echo json_encode($arreglo);
?>