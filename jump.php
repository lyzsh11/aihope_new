<?php
	if (!isset($jumpdest) || strlen($jumpdest) <= 0) {
		$jumpdest = "/";
	}
?>
<script>
	window.location="<?php echo $jumpdest ?>";
</script>
