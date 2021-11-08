<?php
$ruta="../../";
  include_once($ruta."class/lote.php");
  $lote=new lote;
  include_once($ruta."class/estante.php");
  $estante=new estante;
  include_once($ruta."class/fila.php");
  $fila=new fila;
	session_start();
	extract($_POST);
 $lo=$lote->muestra($idlote);
 $est=$estante->muestra($lo['idestante']);
 $fil=$fila->muestra($lo['idfila']);
$nom='Estante '.$est['nombre'].' - '.$fil['nombre'].', '.$lo['fecha_vencimiento'];
		?>
			<script type="text/javascript">
				$("#idloteImp").val('<?php echo $idlote ?>'); 
                $("#idubicacionImp").val('<?php echo $nom ?>'); 
			</script>
		<?php
?>