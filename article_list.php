<?php
    $path="../";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>最新微信消息</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="css/article_list.css" rel="stylesheet" type="text/css"/>
<script src="js/bootstrap.min.js"></script>
</head>

<body style="background: #dbdcd1">
<div class="container">
	<iframe src="header.php" scrolling="no" frameborder="0" width="100%" class="iframe_header"></iframe>
    <div style="margin: 0px; padding-top:15px; padding-bottom: 30px">
	<div class="title">> 最新微信消息</div>
  	<div class="table-responsive" style="margin-top:20px; padding:10px; padding-top:20px; background:#fff">
	<table class="table table-striped">
        <?php
            require_once ($path."db.php") ; 
            $db_con = @mysql_connect($dbhost, $dbuser, $dbpasswd) or $my_err = true;
            @mysql_select_db($dbname);
            //$sql="insert into teacher (name,create_time) values (\"测试3\",CURTIME())";
             $sql="select * from article order by create_time desc";
             $dbres = mysql_query($sql, $db_con);
             $i = 0;
             while ($article = mysql_fetch_array($dbres)) {
                 echo '<tr><td class="article_title"><a href="'.$article['link'].'"';
                 if ($i > 0) {
                     echo 'style="font-weight:normal"';
                 }
                 echo '>'.$article['title'].'</a></td><td class="article_title" style="text-align:right">'.$article['create_time'].'</td></tr>';
                 $i ++;
             }
             mysql_close($db_con);
        ?>
	</table>
	</div>
    <iframe src="footer.php" scrolling="no" frameborder="0" width="100%" height="100px" style="margin-top:10px"></iframe>
</div>
</body>
</html>
