<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>无标题文档</title>
<link href="css/header.css" rel="stylesheet" type="text/css"/>
</head>

<body style="background: #dbdcd1; margin: 0 0">
<div class="top">
  <img src="image/logo.png" class="logo"/>
  <div class="text">
    <?php if(isset($_COOKIE['userid'])) {
            ?>
        <a target="_parent" href="modi_passwd.php">修改密码</a>/
	<a target="_parent" href="logout.php">登出</a>
    <?php } else { ?>
        <a target="_parent" href="login_register.php?t=1">注册</a>/
        <a target="_parent" href="login_register.php?t=2">登录</a>
    <?php } ?>
  </div>
</div>
<div class="nav">
  <div class="nav_inner">
    <a target="_parent" href="index.php"><div class="nav_item">首页</div></a>
    <a target="_parent" href="reward_list.php"><div class="nav_item">奖赠列表</div></a>
    <a target="_parent" href="add_teacher.php"><div class="nav_item">我要推荐</div></a>
    <a target="_parent" href="about.php"><div class="nav_item">关于我们</div></a>
  </div>
</div>
</body>
</html>
