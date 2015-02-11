<?php
	$sql="select id,permission from user where id=\"".$_COOKIE['userid']."\"";
	$dbres = mysql_query($sql, $db_con);
	//echo "DEBUG 2<br>";
	($dbline = (mysql_fetch_array($dbres))) or die;
	//echo "DEBUG 3:".$dbline."<br>";
	$perm = 0+$dbline['permission'];
	//echo "DEBUG 4:".$perm."<br>";
	if( ($perm & $requiredperm) == false) {
            ?>
            抱歉，您的权限不足！请联系我们获取权限<br>
            <a href="/">回首页</a><br>
            <iframe src="footer.php" scrolling="no" frameborder="0" width="100%" height="100px" style="margin-top:10px"></iframe>
            <?php
		die;
	}
?>
