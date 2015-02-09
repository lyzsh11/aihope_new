<?php
$path="../";
//print_r($_COOKIE);
if(!isset($_COOKIE['userid'])) {
    $jumpdest = "add_article.php";
    require("login_register.php");
} else {
    require_once ($path."db.php");
	$db_con = @mysql_connect($dbhost, $dbuser, $dbpasswd) or die;
	@mysql_select_db($dbname);
    //TODO: 检查用户的权限  
    $uid = $_COOKIE['userid'];
	$requiredperm = $PERM_POST;
	require("check_perm.php");

    if(isset($_POST["addarticle"])) {
        $sql="insert into article (title, type, pic, link, create_time) values ('"
            .$_POST["title"]
            ."', "
            .$_POST["articletype"]
            .", '"
            .$_POST["pic"]
            ."', '"
            .$_POST["link"]
            ."', NOW())";
        $dbres = mysql_query($sql, $db_con);
            if (!$dbres) {
                    echo "$sql 插入数据库失败: ".mysql_error()."<br>\n";
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
<title>微信文章上传</title>
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
    	<div class="title">> 微信文章上传</div>
        <form action="" method=POST class="content" style="background:#fff; margin-top:10px">
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	文章标题：
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <input type="text" class="form-control" size=20 name=title/>
            </div>
        </div>
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	文章分类：
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <select name=articletype>
					<option name=articletype value=1>教育</option>
					<option name=articletype value=2>社会</option>
				</select>
            </div>
        </div>
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	图片链接：
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <input type="text" class="form-control" size=20 size=100 name=piclink value="http://www.aihope.org/web/pic/heart.jpg"/>
            </div>
        </div>
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	微信链接：
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <input type="text" class="form-control" size=100 name=link/>
            </div>
        </div>
        <div class="box_in">
        	<input type="submit" class="btn btn-default" value="提交" name=addarticle/>
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
