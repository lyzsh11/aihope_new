<?php
$path="../";
$dir="";//../aihope/";
require_once ($path."db.php");
$db_con = @mysql_connect($dbhost, $dbuser, $dbpasswd) or die;
@mysql_select_db($dbname);
if (!isset($_POST["id"])) {
	if (!isset($_GET["id"])) {
		echo "SHOULD HAS ID<br>";
		die;
	}
	$teacherID = $_GET["id"];
} else {
	$teacherID = $_POST["id"];
}
$sql = "select * from teacher where id=$teacherID";
$dbres = mysql_query($sql, $db_con);
if (!$dbres) { 
    echo "ID error\n";
    die;
}
$teacherInfo = mysql_fetch_array($dbres);
if (!$teacherInfo) { 
    echo "ID error\n";
    die;
}
$teacherName = $teacherInfo['name']."老师";

if (isset($_POST["comment"])) {
    if(!isset($_COOKIE['userid'])) {
        echo '<script>alert("您未登陆，请先登陆！");</script>';
        $jumpdest = "teacher_detail.php?id=$teacherID";
        require($dir."login_register.php");
    } else {
        $sql="insert into comment values (\"\", $teacherID, '".$_COOKIE['userid']."', now(), '".str_replace("\n", "<br>\n", $_POST["content"])."')";
        $dbres = mysql_query($sql, $db_con);
        if (!$dbres) { 
            echo "$sql 插入数据库失败: ".mysql_error()."<br>\n";
        }
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>爱心帮 - <?php echo $teacherName ?></title>
<link href="<?php echo $dir;?>css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $dir;?>css/detail.css" rel="stylesheet" type="text/css"/>
</head>

<body style="background: #dbdcd1">
<div class="container">
    <iframe src="<?php echo $dir; ?>header.php" scrolling="no" frameborder="0" width="100%" class="iframe_header"></iframe>
    <div style="margin: 0px">
    	<div class="title"><?php echo $teacherName ?></div>
    	<div class="content" style="background: #FFFFFF; padding:15px">
                <small>简介：<?php echo $teacherInfo['info'] ?></small>
                <br>
            <?php
			$infopage = //$infopage."&nbsp;".
                            $teacherInfo['recommender']."推荐&nbsp;";
			$infopage = $infopage."&nbsp;".$teacherInfo["position"]."&nbsp;";
                        $infopage = $infopage."<br>";
			$infopage = $infopage."银行账号:&nbsp;".$teacherInfo["bankname"]."&nbsp;";
			$infopage = $infopage."&nbsp;".$teacherInfo["bankacc"]."&nbsp;";
			$infopage = $infopage."&nbsp;<a href='".$teacherInfo["shopurl"]."'>我要帮TA</a>&nbsp;";
			//$infopage = $infopage."<img src=\"".$teacherInfo["piclink"]."\" />";*/
			//$infopage = $infopage."&nbsp;\n".str_replace("\n","<br>\n",$content)."\n&nbsp;\n";
			//$infopage = $infopage."<hr>&nbsp;<a href='".$teacherInfo["shopurl"]."'>我要帮TA</a>&nbsp;";
                        //$infopage = str_replace("\n","<br>\n",$infopage);
                        echo $infopage;
            ?>
                <br>
        	<img src="<?php echo $teacherInfo['pic'] ?>" class="content_image"/><br>
                <?php echo $teacherInfo['infopage'] ?>
    	</div>
        <div class="comment" style="background: #FFFFFF; margin-top:30px">
        	<div class="comment_title">评论</div>

            <?php
                require_once ($path."db.php");
                $db_con = @mysql_connect($dbhost, $dbuser, $dbpasswd) or die;
                @mysql_select_db($dbname);
                $sql="select * from comment where teacher_id = $teacherID";
                $dbres = mysql_query($sql, $db_con);

                $i = 0;
                while ($comment = mysql_fetch_array($dbres)) {
                    if ($i > 0) {
                         echo '<div class="line_gray"></div>';
                    }

                    echo '<div style="margin-top: 20px; overflow:hidden">';
                    echo '<div style="float:left"><img src="image/default_user_image.png" class="user_image"/></div>';
                    echo '<div class="comment_box" style="float: left; margin-left: 20px">';
                    echo '<a style="margin-top:10px" href="#">'.$comment['user_id'].'</a><br>';
                    echo '<p style="margin-top:5px; font-size:15px">'.$comment['info'].'<br></p>';
                    echo $comment['time'];
                    if ($_COOKIE["userid"] == $comment['user_id']) {
                        echo ' | <a href="'.$dir.'delete_comment.php?comment_id='.$comment['id'].'&url=teacher_detail.php&tid='.$teacherID.'">删除</a>';
                    }
                    echo '</div>';
                    echo '</div>';

                    $i ++;
                }
            ?>
            <!--<div class="comment_box">
            	评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论<br>
                <a style="float:left; margin-left:5px; margin-top:10px" href="#" style="">yinhang</a>
                <div style="float:right; margin-right:5px; margin-top:10px">2014|12|28</div>
                <br>
            </div>
            <div class="line_gray"></div>
            <div class="comment_box">
            	评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论<br>
                <a style="float:left; margin-left:5px; margin-top:10px" href="#" style="">yinhang</a>
                <div style="float:right; margin-right:5px; margin-top:10px">2014|12|28</div>
                <br>
            </div>
            <div class="line_gray"></div>
            <div class="comment_box">
            	评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论评论<br>
                <a style="float:left; margin-left:5px; margin-top:10px" href="#" style="">yinhang</a>
                <div style="float:right; margin-right:5px; margin-top:10px">2014|12|28</div>
                <br>
            </div><br>-->
            <form enctype="multipart/form-data" action="" method=POST class="comment_post">
            	我要评论
                <?php 
                    echo "<input type=hidden name=id value=\"$teacherID\" />";
                    if (!isset($_COOKIE['userid'])) {
                        echo '|请先<a target="_parent" href="../aihope/login_register.php?t=2">登录</a><br>';
                    }
                ?>
                <textarea class="form-control" rows=10 name=content style="margin-top:5px"></textarea>
                <input type="submit" class="btn btn-default" value="提交评论" name=comment style="margin-top:10px"/>
            </form>
        </div>
    </div>
    <iframe src="<?php echo $dir; ?>footer.php" scrolling="no" frameborder="0" width="100%" height="100px" style="margin-top:10px"></iframe>
</div>
</body>
</html>
<?php
//}  
?>
