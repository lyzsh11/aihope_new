<?php
    $path="../";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>捐赠列表</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="css/reward_list.css" rel="stylesheet" type="text/css"/>
<script src="js/bootstrap.min.js"></script>
<script src="js/ellipsis.js"></script>
</head>

<body style="background: #dbdcd1">
<div class="container">
	<iframe src="header.php" scrolling="no" frameborder="0" width="100%" class="iframe_header"></iframe>
    <div style="margin: 0px; padding-top:15px; padding-bottom: 30px">
	<div class="title">> 可捐赠列表</div>
    <?php
        require_once ($path."db.php") ; 
        $db_con = @mysql_connect($dbhost, $dbuser, $dbpasswd) or $my_err = true;
        @mysql_select_db($dbname);
        //$sql="insert into teacher (name,create_time) values (\"测试3\",CURTIME())";
        $sql="select * from teacher";
        $dbres = mysql_query($sql, $db_con);
        $i = 0;
        while($teacher = (mysql_fetch_array($dbres))) {
            if ($i == 0) {
                echo '<div class="auto_manage_titie" style="margin-top: 20px; margin-left: 5px"><a href="'.$teacher['shopurl'].'">'.$teacher['name'].'老师</a></div>';
                echo '<div class="auto_manage_content" style="margin-top: 5px; margin-left: 5px">';
                echo '<a href="'.$teacher['url'].'">'.$teacher['info'].'</a></div>';
            } else {
                echo '<div style="background-color:#FFF; margin-top: 20px; padding:20px">';
                echo '<div class="teacher_title">';
                echo '<a href="'.$teacher['url'].'">'.$teacher['name'].'老师</a>';
                echo '<a href="'.$teacher['shopurl'].'" style="float:right">我来帮TA</a></div>';
                echo '<div class="row">';
                echo '<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12" style="margin-top:20px">';
                echo '<a href="'.$teacher['url'].'"><img src="'.$teacher['pic'].'" width="120px" height="120px"/></a></div>';
                echo '<div class="col-lg-10 col-md-9 col-sm-8 col-xs-12 teacher_content" style="margin-top:20px; height:120px; overflow:hidden"><a href="'.$teacher['url'].'">'.$teacher['info'].'</a></div>';
                echo '</div></div>';
            }
            $i++;
        }

        mysql_close($db_con);
    ?>
    </div>
    <iframe src="footer.php" scrolling="no" frameborder="0" width="100%" height="100px" style="margin-top:10px"></iframe>
</div>
<script>
	ellipsis('auto_manage_content', 'a');
	ellipsis('teacher_content', 'a');
</script>
</body>
</html>