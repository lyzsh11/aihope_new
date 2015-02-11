<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>修改爱心帮密码</title>
<link href="../aihope/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="../aihope/css/form_upload.css" rel="stylesheet" type="text/css"/>
<link href="../aihope/css/header.css" rel="stylesheet" type="text/css"/>
<script src="..aihope/js/jquery-2.1.1.min.js"></script>
<script src="../aihope/js/bootstrap.min.js"></script>
<script>
function show_hide(id1,id2){
	div1=document.getElementById(id1);
	div2=document.getElementById(id2);
	div1.style.display='block';
	div2.style.display='none';
}
</script>
</head>

<body style="background: #dbdcd1">
<div class="container">
	<iframe src="../aihope/header.php" scrolling="no" frameborder="0" width="100%" class="iframe_header"></iframe>
    <div style="margin: 0px; padding-top:15px; padding-bottom: 30px">

<?php
$path="../";
if(!isset($_COOKIE['userid'])) {
    $jumpdest = "modi_passwd.php";
    require("login_register.php");
}
if (isset($_POST["newpasswd"])) {
    $errormsg="\n";//"<br><a href=\"login_register.php?t=2\">点此或返回重新登录</a>";
    if ($_POST["newpasswd"] != $_POST["pass2"]) {
        echo '<script> alert("对不起，两次密码不一致，注册失败.\n为了避免输入错误，请重复输入两次密码。"); </script>';
        echo $errormsg;
    } else {
    $id = $_COOKIE['userid'];
    $pass = md5($id.$_POST["passwd"]);
    $newpass = md5($id.$_POST["newpasswd"]);

    require_once ($path."db.php") ;

    $db_con = @mysql_connect($dbhost, $dbuser, $dbpasswd) or die;//(echo "抱歉！系统内部发生错误。请联系<a href='mailto:service@aihope.org'>站长</a>" && die);
    @mysql_select_db("teachers");
    $sql="update user set passwd=\"".$newpass."\" where id='"
        .$id
        ."' and passwd='"
        .$pass
        ."'";
    $dbres = mysql_query($sql, $db_con);
    $affect = mysql_affected_rows();
    mysql_close($db_con);
    if (!$dbres || $affect != 1) {
        echo "<script> alert(\"原密码不正确\"); </script>";//.mysql_error();
        echo $errormsg;
        //die;
    } else {
        echo "<script> alert(\"修改成功\"); </script>";//.mysql_error();
    }
}
} 
?>

<?php
    if(false) {//!isset($_GET["t"]) || $_GET["t"]=="2") {
        //?t=2 表示登录  
        $reg="none";
        $login="block";
        $regradio="";
        $loginradio="checked";
    } else {
        //url中没有t参数或t不是2表示新注册  
        $reg="block";
        $login="none";
        $regradio="checked";
        $loginradio="";
    }
?>
    	<div class="title">
        </div>
        <form id="register" class="content" style="background: #fff; margin-top:15px; display:<?php echo $reg ?>" action="" method=POST>
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	原密码：
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <input class="form-control" type=password size=16 name=passwd />
            </div>
        </div>
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	新密码：
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <input class="form-control" type=password size=16 name=newpasswd />
            </div>
        </div>
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	重复密码：
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <input class="form-control" type=password size=16 name=pass2 />
            </div>
        </div>
        <div class="box_in">
        	<input class="btn btn-default" type=submit name=modipasssubmit value="修改密码"/>
        </div>
        </form>
    </div>
    <iframe src="../aihope/footer.php" scrolling="no" frameborder="0" width="100%" height="100px" style="margin-top:10px"></iframe>
</div>
</body>
</html>
