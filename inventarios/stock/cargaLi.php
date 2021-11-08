<?php
      $ruta="../../";
	include_once($ruta."class/vliname.php");
	$vliname=new vliname;
	session_start();
	extract($_POST);
	//echo "NIT ".$idnit;
	$lin = $vliname->muestra($idliname);
    $codigo=$lin['codigo'];
		?>
			<script type="text/javascript">
				$("#idli").val("<?php echo $idliname ?>");
				$("#idcodigo").val("<?php echo $codigo ?>");
			</script>
		<?php
	
?>