<?php 
include_once("../../class/marca.php");
$marca=new marca;
extract($_POST);
$marcas=array();
foreach($marca->mostrarTodo("estado=1") as $m)//mostrarAsc
{
	$arraymarca=new arraymarca($m['idmarca'],$m['nombre']);
	array_push($marcas, $arraymarca);	  
}
echo json_encode($marcas);	
class arraymarca
{
	public $id;
	public $nombre;
	
	function __construct($id,$nombre)
	{
		$this->id=$id;
		$this->nombre=$nombre;
	}
}
?>
