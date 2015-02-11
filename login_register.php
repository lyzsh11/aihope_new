<?php
$path="../";
if (isset($_POST["loginsubmit"])) {
    $errormsg="\n";//"<br><a href=\"login_register.php?t=2\">点此或返回重新登录</a>";
    $id=$_POST["id"];
    $pass=md5($id.$_POST["passwd"]);

    require_once ($path."db.php") ;

    $db_con = @mysql_connect($dbhost, $dbuser, $dbpasswd) or die;//(echo "抱歉！系统内部发生错误。请联系<a href='mailto:service@aihope.org'>站长</a>" && die);
    @mysql_select_db("teachers");
    $sql="update user set last_login=NOW() , login_num=login_num+1 where id='"
        .$id
        ."' and passwd='"
        .$pass
        ."'";
    $dbres = mysql_query($sql, $db_con);
    $affect = mysql_affected_rows();
    mysql_close($db_con);
    if (!$dbres || $affect != 1) {
        $_GET["t"]="2";
        echo "<script> alert(\"用户名或密码不正确\"); </script>";//.mysql_error();
        echo $errormsg;
        //die;
    } else {
        //ob_start();
        setcookie("userid", $id, time()+3600*72, "/");
        //ob_get_clean();
        //可跳转到个人中心  
        require("jump.php");
    }
} else if(isset($_POST["regsubmit"])) {
    $errormsg="\n";//"<br><a href=\"login_register.php?t=1\">点此或返回重新注册</a>";
    $minpasslen=6;
    if (strlen($_POST["passwd"]) < $minpasslen) {
        echo '<script> alert("对不起，密码过短，注册失败.\n请至少设置 '.$minpasslen.' 个字符。"); </script>';
        echo $errormsg;
    } else if ($_POST["passwd"] != $_POST["pass2"]) {
        echo '<script> alert("对不起，两次密码不一致，注册失败.\n为了避免输入错误，请重复输入两次密码。"); </script>';
        echo $errormsg;
    } else {
    //$pass=crypt($_POST["passwd"], $_POST["id"]);
    $pass=md5($_POST["id"].$_POST["passwd"]);
    require_once ($path."db.php") ;

    $db_con = @mysql_connect($dbhost, $dbuser, $dbpasswd) or die;//(echo "抱歉！系统内部发生错误。请联系<a href='mailto:service@aihope.org'>站长</a>" && die);
    @mysql_select_db("userS");
    $sql="insert into user (id, passwd, name, create_time, last_login, permission) values ('"
        .$_POST["id"]
        ."', '"
        .$pass
        ."', '"
        .$_POST["nick"]
        ."', NOW(), NOW(), 3)";
        //permission: 见db.php: 1--可读; 2--可推荐老师; 4--可添加微信内容和银行流水log ... 
        $dbres = mysql_query($sql, $db_con);
        mysql_close($db_con);
        if (!$dbres) {
            echo '<script> alert("创建用户失败，请换一个用户名"); </script>';//.mysql_error();
            echo $errormsg;
        } else {
            setcookie("userid",$_POST["id"], time()+3600*72, "/");
            echo "创建用户成功，已登录!";
            //可跳转到个人中心  
            require("jump.php");
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
<title>登录/注册</title>
<?php
    if(!isset($_GET["t"]) || $_GET["t"]=="2") {
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
    	<div class="title">
        	<input style="float:left; margin-top:8px" type="radio" name="register_login" onClick="show_hide('register','login')" <?php echo $regradio ?>/><div class="radio_text">注册</div>
			<input style="float:left; margin-top:8px" type="radio" name="register_login" onClick="show_hide('login','register')" <?php echo $loginradio ?>/><div class="radio_text">登录</div>
        </div>
        <div class="text_warning" style="margin-top:15px">登陆后您可以推荐老师、添加评论，给予老师们更多的关心。</div>
        <form id="register" class="content" style="background: #fff; margin-top:15px; display:<?php echo $reg ?>" action="" method=POST>
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	用户名：
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <input class="form-control" type=text size=16 name=id />
            </div>
        </div>
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	昵称：
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <input class="form-control" type=text size=16 name=nick value="匿名" />
            </div>
        </div>
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	密码：
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <input class="form-control" type=password size=16 name=passwd />
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
        	<input class="btn btn-default" type=submit name=regsubmit value="注册"/>
        </div>
        </form>
        <form id="login" class="content" style="background: #fff; margin-top:15px; display:<?php echo $login ?>" action="" method=POST>
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	用户名：
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <input class="form-control" type=text size=16 name=id />
            </div>
        </div>
        <div class="row box_in">
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left_tag">
            	密码：
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 content_input">     
                <input class="form-control" type=password size=16 name=passwd />
            </div>
        </div>
        
        <div class="box_in">
		<input class="btn btn-default" type=submit name=loginsubmit value="登录" />
        </div>
        </form>
    </div>
    <iframe src="../aihope/footer.php" scrolling="no" frameborder="0" width="100%" height="100px" style="margin-top:10px"></iframe>
</div>
</body>
</html>
