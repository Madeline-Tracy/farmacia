<?php
	$ruta="../../";
	include_once($ruta."class/estante.php");
	$estante=new estante;
	include_once($ruta."class/fila.php");
	$fila=new fila;

	include_once($ruta."funciones/funciones.php");
	extract($_POST);
	session_start();
    /*********** actualiza contrato  ***********/
	
    $valores=array(
	     "nombre"=>"'$idnombre'",
	     "cantidadfila"=>"'$idcantidad'",
	     "descripcion"=>"'$iddescripcion'",
	     "estado"=>"'1'"
	);
	if ($estante->insertar($valores)) 
	{	
		$es=$estante->mostrarUltimo("nombre='".$idnombre."' and cantidadfila=".$idcantidad." and estado=1");
		$idestante=$es['idestante'];
		for ($i=1; $i <= $idcantidad; $i++) 
		{ 
			$nombre="FILA ".$i;
			$valores=array(
			     "idestante"=>"'$idestante'",
			     "nro"=>"'$i'",
			     "nombre"=>"'$nombre'",
			     "estado"=>"'1'"
			);
			if ($fila->insertar($valores))
			{}
		}
		?>
			<script  type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Datos guardados correctamente",
					type: "success",
					//showCancelButton: false,
					confirmButtonColor: "#28e29e",
					confirmButtonText: "OK",
					closeOnConfirm: false
		        }, function () {  
		            location.reload();
		        });
			</script>
		<?php
	}else{
		?>
		<script type="text/javascript">
			swal("ERROR!", "No se guardo, intente de nuevo", "error");
		</script>
		<?php		
	}
    
?>