<?php
	if ($_GET['jumpdest']) {
		$jumpdest = $_GET['jumpdest'];
	}
	if (!isset($jumpdest) || strlen($jumpdest) <= 0) {
		$jumpdest = "/";
        	//echo "NO dest";
	}
       // echo "试试".$jumpdest;
?>
<script>
	window.location="<?php echo $jumpdest ?>";
</script>
