<?php 
	$ruta="../../../../web-admin/";
  	$rutaRaiz="../../../../../";
	extract($_POST);
	session_start();
	$total=0;
	foreach ($_SESSION["carritoSesta"] as $f) //copiamos todos los items del array
	{
		$subtotal=$f['precio']*$f['cantidad'];
		$total=$total+$subtotal;
	}
	$_SESSION['carritoDatos']['total']=$total;
	//echo $total;
	?>
		<script type="text/javascript">

			$("#idmonto").val(total);
			$("#idmontooriginal").val(total);
	        $("#idsaldo").val("0");
	        $("#idnit").focus();
		</script>
	<?php
?>