<?php
$path="../";
//print_r($_COOKIE);
if(!isset($_COOKIE['userid'])) {
    $jumpdest = "add_teacher.php";
    require("login_register.php");
} else {
    //TODO: 检查用户的权限  
    require_once ($path."db.php") ;
    $db_con = @mysql_connect($dbhost, $dbuser, $dbpasswd) or die;
    @mysql_select_db($dbname);
    $uid = $_COOKIE['userid'];
    $requiredperm = $PERM_POST;
    require("check_perm.php");

    $defaultpic = "http://www.aihope.org/web/wcx/teaching1.jpg";
    if(isset($_POST["fileupload"])) {
        //print_r($_FILES);
        $uploaddir = '/usr/share/nginx/html/v1/'.$_POST["path"];
        $error = 0;
        mkdir($uploaddir);
        $filename = basename($_FILES['userfile']['name']);
        $uploadfile = "$uploaddir/$filename";

        //echo '<pre>';
        date_default_timezone_set('Asia/Chongqing');
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        $defaultpic = "http://www.aihope.org/web/".$_POST["path"]."/".$filename;
        echo "上传成功，可在 <a href=\"$defaultpic\">这里</a>访问<br>\n";
        } else {
        print_r(error_get_last());
        echo $_FILES['userfile']['tmp_name']."=>$uploadfile 文件上传失败\n";
        $error = 1;
        }

        echo '<!--Here is some more debugging info:';
        print_r($_FILES);
        echo '-->';
 
    }
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>添加老师</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="css/form_upload.css" rel="stylesheet" type="text/css"/>
<link href="css/header.css" rel="stylesheet" type="text/css"/>
<script src="js/jquery-2.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</head>

<body style="background: #dbdcd1">
<div class="container">
	<iframe src="header.php" scrolling="no" frameborder="0" width="100%" class="iframe_header"></iframe>
    <div style=" margin: 0px; padding-top:15px; padding-bottom:30px">
    	<div class="title">> 推荐老师</div>
        <form enctype="multipart/form-data" action="" method=POST class="content" style="background: #FFFFFF; margin-top:10px">
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	上传图片资源：
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <input type="file" name="userfile"/>
            </div>
        </div>
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	老师ID(拼音即可，如WangChengXia)：
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <input type="text" class="form-control" name=path value="<?php echo $_POST["path"] ?>"/>
            </div>
        </div>
        <div class="box_in">
        	<input class="btn btn-default" type="submit" name="fileupload" value="上传"/>
        </div>
        </form>
        <form action="deal_add.php" method=POST class="content" style="background: #FFFFFF; margin-top:10px">
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	老师姓名：
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <input type="text" class="form-control" size=20 name=teacher_name />
            </div>
        </div>
        <div class="row box_in">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
                老师ID：
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <input type="text" class="form-control" size=20 name=path value="<?php echo $_POST["path"] ?>" />
            </div>
        </div>
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	捐赠链接:
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <input type="text" class="form-control" size=100 name=shopurl value="http://wd.koudai.com/?userid=208388189" />
            </div>
        </div>
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	图片链接:
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <input type="text" class="form-control" size=100 name=piclink value="<?php echo $defaultpic ?>"/>
            </div>
        </div>
        <div class="row box_in">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
                银行账号：
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <input type="text" class="form-control" size=20 name=bankacc />
            </div>
        </div>
        <div class="row box_in">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
                开户银行名称：
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <input type="text" class="form-control" size=20 name=bankname />
            </div>
        </div>
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	执教地点:
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <input type="text" class="form-control" size=20 name=position />
            </div>
        </div>
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	事迹摘要:
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <input type="text" class="form-control" size=20 name=summary />
            </div>
        </div>
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	事迹链接:
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <input type="text" class="form-control" size=20 name=link />
            </div>
        </div>
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	或文字描述:
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <textarea class="form-control" rows=10 name=content></textarea>
            </div>
        </div>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-1me" name="usehtml">文中使用了html标签(请自行保证语法正确性)
          </label>
        </div>
        <div class="box_in">
        	<input type="submit" class="btn btn-default" value="推荐新老师" name=addteacher />
        	<!--input type="submit" class="btn btn-default" value="修改以前推荐的信息" name=moditeacherinfo /-->
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
