<?php
	session_start();
	extract($_POST);
	//echo "NIT ".$idnit;
	if ($idnit=="20005") {
		?>
			<script type="text/javascript">
				$("#idnit").val("NIT-SN");
				$("#idnombre").val("INGRESE NOMBRE");
			</script>
		<?php
	}
?>