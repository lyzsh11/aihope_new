<?php
    $path="../";
    require_once($path."db.php");
    $user_id = $_GET["user_id"];
    if ($user_id == "" && !isset($_COOKIE['userid'])) {
         $jumpdest="user_center.php";
         require("login_register.php");
    } else {
        if ($user_id =="") {
            $user_id = $_COOKIE['userid'];
        }
        if ($user_id == $_COOKIE['userid']) {
            $user_name = "我";
        } else {
            $user_name = $user_id;
        }
?>
<!doctype html>
<html>
<head>
<meta name="baidu-site-verification" content="X1GQFmfGBJ" />
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>爱心帮 - <?php echo $user_name;?>的个人中心</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="css/user_center.css" rel="stylesheet" type="text/css"/>
<script src="js/ellipsis.js"></script>
</head>

<body style="background: #dbdcd1; margin:0 0">
<div class="container">
    <iframe src="header.php" scrolling="no" frameborder="0" width="100%" class="iframe_header"></iframe>
    <div class="title" style="margin-top:15px">> <?php echo $user_name;?>的个人中心</div>
    <div class="row" style="margin-top:20px">
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div style="background:#FFF; padding:10px">
                <div class="user_info_box" style="overflow:hidden">
                    <img src="image/default_user_image.png" class="user_image" style="float:left"/>
                    <div class="user_info_text" style="float:left; margin-top:5px; margin-left:10px">
                         <?php
                         $db_con = @mysql_connect($dbhost, $dbuser, $dbpasswd) or $my_err = true;
                         @mysql_select_db($dbname);
                         $sql='select * from user where id = "'.$user_id.'"';
                         $dbres_user = mysql_query($sql, $db_con);
                         $user = mysql_fetch_array($dbres_user);
                         
                         echo '用户名：'.$user_id.'<br>';
                         echo '昵称：'.$user['name'].'';
                         ?>
                    </div>
                </div>
                <div class="user_record" style="margin-top:10px">
                    <?php
                    $sql='select * from teacher where recommender="'.$user_id.'"';
                    $dbres_teacher = mysql_query($sql, $db_con);
                    $sql='select * from comment where user_id="'.$user_id.'"';
                    $dbres_comment = mysql_query($sql, $db_con);
                    echo '已推荐老师<a href="#">'.mysql_num_rows($dbres_teacher).'</a>人<br>';
                    echo '已添加评论<a href="#">'.mysql_num_rows($dbres_comment).'</a>条';
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 right">
            <div style="background:#FFF; padding:10px">
                <div class="subtitle"><?php echo $user_name;?>推荐的老师</div>
                <?php
                    if (mysql_num_rows($dbres_teacher) == 0) {
                        echo '<div class="teacher_box teacher_content">';
                        echo $user_name.'还没有推荐过老师 <a href="add_teacher.php"> >>去推荐>></a>';
                        echo '</div>';
                    }

                    $i=0;
                    while ($teacher = mysql_fetch_array($dbres_teacher)) {
                        $teacher_url = 'teacher_detail.php?id='.$teacher['id'];
                        echo '<div class="teacher_box';
                        if ($i>0) { echo ' line';}
                        echo '">';
                        echo '<div class="teacher_title"><a href="'.$teacher_url.'">'.$teacher['name'].'老师</a></div>';
                        echo '<div class="teacher_content"><a href="'.$teacher_url.'">'.strip_tags($teacher['info']).'</a></div>';
                        echo '</div>';
                        $i++;
                    }
                ?>
                <!--<div class="teacher_box">
                    <div clsss="teacher_title">王成霞老师</div>
                    <div class="teacher_content">
                        <p>王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师</p>
                    </div>
                </div>
                <div class="teacher_box line">
                    <div clsss="teacher_title">王成霞老师</div>
                    <div class="teacher_content">
                        <p>王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师</p>
                    </div>
                </div>-->
            </div>
            <div style="background:#FFF; margin-top:15px; padding:10px">
                <div class="subtitle"><?php echo $user_name;?>评论过的老师</div>
                <?php
                    if (mysql_num_rows($dbres_comment) == 0) {
                        echo '<div class="teacher_box teacher_content">';
                        echo $user_name.'还没有评论过老师';
                        echo '</div>';
                    }

                    $i=0;
                    while ($comment = mysql_fetch_array($dbres_comment)) {
                        $sql='select * from teacher where id="'.$comment['teacher_id'].'"';
                        $dbres_teacher = mysql_query($sql, $db_con);
                        $teacher = mysql_fetch_array($dbres_teacher);
                        $teacher_url = 'teacher_detail.php?id='.$teacher['id'];
                        echo '<div class="teacher_box';
                        if ($i>0) { echo ' line';}
                        echo '">';
                        echo '<div class="teacher_title"><a href="'.$teacher_url.'">'.$teacher['name'].'老师</a></div>';
                        echo '<div class="teacher_content"><a href="'.$teacher_url.'">评论：'.strip_tags($comment['info']).'</a></div>';
                        echo '</div>';
                        $i++;
                    }
                ?>
                <!--<div class="teacher_box">
                    <div clsss="teacher_title">王成霞老师</div>
                    <div class="teacher_content">
                        <p>王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师</p>
                    </div>
                </div>
                <div class="teacher_box line">
                    <div clsss="teacher_title">王成霞老师</div>
                    <div class="teacher_content">
                        <p>王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师王成霞老师</p>
                    </div>
                </div>-->
            </div>
        </div>
    </div>
    <iframe src="footer.php" scrolling="no" frameborder="0" width="100%" height="100px" style="margin-top:10px"></iframe>
</div>
<script>
    ellipsis('teacher_content', 'a');
</script>
</body>
</html>
<?php
}
?>
