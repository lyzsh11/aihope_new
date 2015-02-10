<?php
$path="../";
$dir="";//../aihope/";
require_once ($path."db.php");
$db_con = @mysql_connect($dbhost, $dbuser, $dbpasswd) or die;
@mysql_select_db($dbname);
if (isset($_POST["comment"])) {
    if(!isset($_COOKIE['userid'])) {
        echo '<script>alert("您未登陆，请先登陆！");</script>';
        $jumpdest = "teacher_detail.php";
        require($dir."login_register.php");
    } else {
        $sql="insert into comment values (\"\", 2, '".$_COOKIE['userid']."', now(), '".$_POST["content"]."')";
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
<title>王成霞老师</title>
<link href="<?php echo $dir;?>css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $dir;?>css/detail.css" rel="stylesheet" type="text/css"/>
</head>

<body style="background: #dbdcd1">
<div class="container">
    <iframe src="<?php echo $dir; ?>header.php" scrolling="no" frameborder="0" width="100%" class="iframe_header"></iframe>
    <div style="margin: 0px">
    	<div class="title">王成霞老师</div>
    	<div class="content" style="background: #FFFFFF; padding:15px">
    		王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师<br>
        	<img src="#" class="content_image"/><br>
    	</div>
        <div class="comment" style="background: #FFFFFF">
        	<div class="comment_title">评论</div>

            <?php
                require_once ($path."db.php");
                $db_con = @mysql_connect($dbhost, $dbuser, $dbpasswd) or die;
                @mysql_select_db($dbname);
                $sql="select * from comment where teacher_id = 2";
                $dbres = mysql_query($sql, $db_con);

                $i = 0;
                while ($comment = mysql_fetch_array($dbres)) {
                    if ($i > 0) {
                         echo '<div class="line_gray"></div>';
                    }

                    echo '<div class="comment_box">';
                    echo $comment['info'].'<br>';
                    echo '<a style="float:left; margin-top:10px" href="#">'.$comment['user_id'].'</a>';
                    if ($_COOKIE["userid"] == $comment['user_id']) {
                        echo '<a style="float:left; margin-left:5px; margin-top:10px" href="'.$dir.'delete_comment.php?comment_id='.$comment['id'].'&url=../WangChengXia/teacher_detail.php">删除</a>';
                    }
                    echo '<div style="float:right; margin-right:5px; margin-top:10px">'.$comment['time'].'</div>';
                    echo '<br></div>';

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
