<?php
	$ruta="../../../";
	include_once($ruta."class/invitem.php");
	$invitem=new invitem;

	include_once($ruta."funciones/funciones.php");
	extract($_POST);
	session_start();
    /*********** actualiza contrato  ***********/
    $valores=array(
	     "idcategoria"=>"'$idcategoria'",
		"nombre"=>"'$idnombre'",
		//"codigo"=>"'0'",
		"precio"=>"'$idprecio'",
		"idmarca"=>"'$idmarca'",
		"tipoitem"=>"'$idtipoitem'",
		"tipouso"=>"'$idtipouso'",
		"idtipoproducto"=>"'$idtipoproducto'",
		//"cantidad"=>"'1'",
		"descripcion"=>"'$iddesc'"
	);
	if ($invitem->actualizar($valores,$iditem)) {
		?>
			<script  type="text/javascript">
				swal("EXITO","Datos guardados correctamente","success");
			</script>
		<?php
	}else{
		?>
		<script type="text/javascript">
			swal("ERROR","No se pudo guardar","error");
		</script>
		<?php		
	}
    
?>