<?php
    $path="../";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>爱心帮银行账户流水</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="css/banklog.css" rel="stylesheet" type="text/css"/>
<script src="js/bootstrap.min.js"></script>
</head>

<body style="background: #dbdcd1">
<div class="container">
	<iframe src="header.php" scrolling="no" frameborder="0" width="100%" class="iframe_header"></iframe>
    <div style="margin: 0px; padding-top:15px; padding-bottom: 30px">
	<div class="title">> 银行账户流水</div>
    <?php
        require_once ($path."db.php") ; 
        $db_con = @mysql_connect($dbhost, $dbuser, $dbpasswd) or $my_err = true;
        @mysql_select_db($dbname);
        //$sql="insert into teacher (name,create_time) values (\"测试3\",CURTIME())";
        $sql="select id,name from teacher";
        $dbres = mysql_query($sql, $db_con);
	$teachername = array();
        while($items = (mysql_fetch_array($dbres))) {
		$teachername[$items['id']] = $items['name'];
	}

        $sql="select * from bankdeal order by time desc";
        $dbres = mysql_query($sql, $db_con);
        $i = 0;
            {
                echo '<div class="title_1" style="margin-top: 20px; margin-left: 5px"><a href="about.php">关于我们的账户信息</a></div>';
                echo '<div class="content_1" style="margin-top: 15px; margin-left: 5px">';
                echo '招商银行网上银行可查询最新更新，我们每周会在这里同步备份</div>';
            } 
?>
	<div class="table-responsive" style="margin-top:20px; padding:10px; padding-top:20px; background:#fff">
	<table class="table table-striped table-bordered">
		<tr align=center><td>序号</td><td>时间</td></td><td>钱数(元)</td><td>受赠老师</td><td>捐赠人名称</td><td>转账类型</td><td>备注</td></tr>
<?php
        while($items = (mysql_fetch_array($dbres))) {

	    /*{
                echo '<div style="background-color:#FFF; margin-top: 20px; padding:20px">';
                echo '<div class="teacher_title">';
                echo '<a href="'.$teacher['url'].'">'.$teacher['name'].'老师</a>';
                echo '<a href="'.$teacher['shopurl'].'" style="float:right">我来帮TA</a></div>';
                echo '<div class="row">';
                echo '<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12" style="margin-top:20px">';
                echo '<a href="'.$teacher['url'].'"><img src="'.$teacher['picSmall'].'" width="120px" height="120px"/></a></div>';
                echo '<div class="col-lg-10 col-md-9 col-sm-8 col-xs-12 teacher_content" style="margin-top:20px; height:120px; overflow:hidden"><a href="'.$teacher['url'].'">'.$teacher['info'].'</a></div>';
                echo '</div></div>';
            }*/
            $i++;
			$money = ((0.0+$items["money"])/100);
			if ($money > 0) {
				$payeename = "";
			} else {
				$payeeid = $items["payee"];
				if (isset($teachername[$payeeid])) {
					$payeename = $teachername[$payeeid];
				} else {
					$payeename = '自动分配';
				}
			}
			echo "<tr><td>$i</td>";
			echo "<td>".$items["time"]."</td>";
			echo "<td>".$money."</td>";
			echo "<td>".$payeename."</td>";
			echo "<td>".$items["dealername"]."</td>";
			echo "<td>".$items["dealtype"]."</td>";
			echo "<td>".$items["memo"]."</td>";
			//echo "<td>$sql</td>";
			echo "</tr>";
        }

        mysql_close($db_con);
    ?>
	</table>
	</div>
    <iframe src="footer.php" scrolling="no" frameborder="0" width="100%" height="100px" style="margin-top:10px"></iframe>
</div>
<script>
	ellipsis('auto_manage_content', 'a');
	ellipsis('teacher_content', 'a');
</script>
</body>
</html>
