<?php
$path="../";
//print_r($_COOKIE);
if(!isset($_COOKIE['userid'])) {
    $jumpdest = "add_banklog.php";
    require("login_register.php");
} else {
    require_once ($path."db.php");
	$db_con = @mysql_connect($dbhost, $dbuser, $dbpasswd) or die;
	@mysql_select_db($dbname);
    //TODO: 检查用户的权限  
    $uid = $_COOKIE['userid'];
	$requiredperm = $PERM_POST;
	//echo "DEBUG 1<br>";
	require("check_perm.php");

    if(isset($_POST["addbanklog"])) {
		//echo $_POST["bankcontent"];
		//echo "DEBUG 1<br>";
		$succ = true;
		$i = 0;
		while (true) {
			if(!isset($_POST["money$i"])) {
				break;
			}
			++$i;
			$time = $_POST["time$i"];
			$money = $_POST["money$i"];
			$payee = $_POST["payee$i"];
			$donor = $_POST["donor$i"];
			$channel = $_POST["channel$i"];
			$memo = $_POST["memo$i"];
			$sql = "insert into bankdeal (time, money, payee, dealername, dealtype, memo) values (\"".$time."\",".$money.",".$payee.",\"$donor\",\"".$channel."\",\" ".$memo."\");";
	        $dbres = mysql_query($sql, $db_con);
            if (!$dbres) {
					$succ = false;
                    echo "$sql<br> <strong>插入数据库失败</strong>, 可根据以下信息修改<br> ".mysql_error()."<br>\n";
					$_POST["trybanklog"] = 1; //使其可以再改  
					break;
			}
        } 
		if ($succ) {
			echo "$i 条记录入库成功<br>\n";
		}

    }
    mysql_close($db_con);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>银行账户流水上传</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="css/form_upload.css" rel="stylesheet" type="text/css"/>
<link href="css/header.css" rel="stylesheet" type="text/css"/>
<script src="js/jquery-2.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</head>

<body style="background: #dbdcd1">
<div class="container">
	<iframe src="header.php" scrolling="no" frameborder="0" width="100%" class="iframe_header"></iframe>
    <div style="margin: 0px; padding-top:5px; padding-bottom:30px">
    	<div class="title">> 银行流水上传</div>
<?php
    if(isset($_POST["trybanklog"])) {
?>
        <form action="" method=POST class="content" style="background:#fff; margin-top:10px">
        <div class="box_in">
	<table>
		<tr align=center><td>序号</td><td>时间</td></td><td>钱数(分)</td><td>受赠老师id</td><td>捐赠人名称</td><td>转账类型</td><td>备注</td></tr>
<?php 
		$bankcontent = $_POST["bankcontent"];
		$deals = preg_split("/\n/", $_POST["bankcontent"]);
		echo "<input type=hidden name=bankcontent value=\"$bankcontent\" />";
		$last = 0.0 + $_POST["lastamount"];
		echo "<input type=hidden name=lastamount value=\"$last\" />";
		$unit = 100; //分->元的换算  
		$money = 0.0;
		$i=0;
		foreach ($deals as $log) {
				++$i;
				//echo $log.".";
				$items = preg_split("/[\s]+/", $log);
				//$time = $items[0]." ".$items[1];
				if (count($items) < 4) {
					continue;
				}
				$time = array_shift($items)." ".array_shift($items);
				$money = str_replace(",", "", array_shift($items));
				$money = $unit * (0.0+$money);
				$nowtotal = 0.0 + array_shift($items);
				$channel = substr(array_shift($items), 0, 12);
				$memo = "UNINIT";
				if ($nowtotal < $last) {
					$money = -$money;
				}
				$last = $nowtotal;
				$memo = implode($items); //range($items, 5, count($items)-1));
				if(strstr($memo,"王成霞")>0)$payee=2;else if(strstr($memo,"吴孟花")>0)$payee=15;else if(strstr($memo,"行知")>0)$payee=37;else $payee=1;
				//$x=`echo $t | /bin/awk 'BEGIN{last=0;}{ money=100*$3;if($4<last)money=-money; last=$4;memo=$6;for(i=7;i<=NF;i++)memo=memo" "$i; if(index(memo,"王成霞")>0)payee=2;else if(index(memo,"吴孟花")>0)payee=15;else if(index(memo,"行知")>0)payee=37;else payee=1;channel=substr($5,1,4); print "insert into bankdeal (time, money, payee, dealername, dealtype, memo) values (\""$1,$2"\","money","payee",\"\",\""channel"\",\"",memo"\");"}'`;
				$sql = "insert into bankdeal (time, money, payee, dealername, dealtype, memo) values (\"".$time."\",".$money.",".$payee.",\"\",\"".$channel."\",\" ".$memo."\");";
				echo "<tr><td>$i</td>";
				echo "<td><input type=text size=20 name=time$i value=\"$time\" /></td>";
				echo "<td><input type=text size=10 name=money$i value=\"$money\" /></td>";
				echo "<td><input type=text size=10 name=payee$i value=\"$payee\" /></td>";
				echo "<td><input type=text size=10 name=donor$i value=\"\" /></td>";
				echo "<td><input type=text size=12 name=channel$i value=\"$channel  \" /></td>";
				echo "<td><input type=text size=50 name=memo$i value=\"$memo\" /></td>";
				//echo "<td>$sql</td>";
				echo "</tr>";
		}
?>
        </table>
        </div>
        <div class="box_in">
        	<input type="submit" class="btn btn-default" value="正式提交" name="addbanklog" />
        </div>
        </form>
<?php }
?>
        <form action="" method=POST class="content" style="background:#fff; margin-top:10px">
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	上次账户余额：
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">   
				<input type="text" size=10 name="lastamount" value=0 /> 元钱
            </div>
        </div>
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	新增流水记录：
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
		 直接从网银页面copy paste覆盖掉例子即可.时间从早到晚排序,每行一条记录<br>
                 每项用若干个空格隔开。除了最后一段(备注)，其它中间不能有空格
            </div>
        </div>
        <div class="box_in">
                <textarea class="form-control" rows=10 name=bankcontent>
2014-09-16 16:59:21   1000.00 1002.00 银联渠道转入 银联卡转入 
2014-09-21 01:22:50   0.29 1002.29 账户结息 结息： 0.29 扣税： 0.00
2015-01-13 22:33:53 200.00   4708.35 客户转账 爱心网友奖赠行知月度优秀教师 孙秀华 
2015-01-15 00:37:43 1000.00   3708.35 转账汇款 给王成霞老师的奖教金每月一千元整 王兴院
</textarea>
        </div>
        <div class="box_in">
        	<input type="submit" class="btn btn-default" value="效果预览" name="trybanklog" />
        </div>
        </form>
    </div>
    <iframe src="footer.php" scrolling="no" frameborder="0" width="100%" height="100px" style="margin-top:10px"></iframe>
</div>
</body>
</html>
<?php
}
?>
