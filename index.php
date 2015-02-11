<?php
    $path="../";
?>
<!doctype html>
<html>
<head>
<meta name="baidu-site-verification" content="X1GQFmfGBJ" />
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>爱心帮 - 爱心帮教:奖赠教师,支持教育,开拓未来</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="css/index.css" rel="stylesheet" type="text/css"/>
<script src="js/ellipsis.js"></script>
<script src="js/carousel.js"></script>
</head>

<body style="background: #dbdcd1; margin:0 0">
<div class="container">
    <iframe src="header.php" scrolling="no" frameborder="0" width="100%" class="iframe_header"></iframe>
    <?php
        require_once ($path."db.php") ; 
        $db_con = @mysql_connect($dbhost, $dbuser, $dbpasswd) or $my_err = true;
        @mysql_select_db($dbname);
        $sql="select * from bankdeal order by time desc";
        $dbres = mysql_query($sql, $db_con);
        while ($bankdeal = (mysql_fetch_array($dbres))) {
            echo '<div class="header_info_text" style="margin-top: 10px">';
            echo '<img src="image/money_icon.png" style="float:left" height=20/>';
	    $money = $bankdeal['money']/100.0;
	    if ($money < 0) {
	    	$money = -$money;
		$type = '[捐出] ';
	    } else {
	    	$type = '[捐赠] ';
	    }
            echo '<a href="view_banklog.php" style="margin-left:20px">'.$bankdeal['time'].' '.$type.$bankdeal['memo'].' '.$money.'元';
            if (($bankdeal['dealername'] != null) &&
                           ($bankdeal['dealername'] != "")) {
                 echo '——'.$bankdeal['payee'].'';
            }
            echo '</a>';
            echo '</div>';
            break;
        }

        $sql="select * from article order by create_time desc";
        $dbres = mysql_query($sql, $db_con);

        while ($article = (mysql_fetch_array($dbres))) {
            echo '<div class="header_info_text" style="margin-top: 10px">';
            echo '<img src="image/notify_icon.png" style="float:left" height=20/>';
            echo '<a href="'.$article['link'].'" style="margin-left:20px">'.$article['title'].'</a>';
            echo '</div>';
            break;
        }
        //$sql="insert into teacher (name,create_time) values (\"测试3\",CURTIME())";
        $sql="select * from teacher where valid=0"; //只显示valid(验证过的)老师  
        $dbres = mysql_query($sql, $db_con);
    ?>
    <div id="carousel">
    	<div style="height:inherit; width: inherit; overflow:hidden">
            <div style="height:inherit;  width: inherit; overflow:hidden">
                <?php
                    $i = -1;
                    while($teacher = (mysql_fetch_array($dbres))) {
                         if ($i >= 0) {
                            $teacher_page = 'teacher_detail.php?id='.$teacher['id']; //也可以用 $teacher['url']
                            if ($i == 0) {
                                echo '<p id="pic'.$i.'" style="display:block;  width: inherit">';
                                //echo '<a href="'.$teacher['url'];
                                echo '<a href="'.$teacher_page;
                                echo '"><img src="'.$teacher['picBanner'].'" class="image_banner" onload="initProgress(\''.$teacher_page.'\','
                                    .$teacher['moneyDone'].','.$teacher['moneyNeed'].',\''.$teacher['name'].'老师\',\''.$teacher['info'].'\')"/></a>';
                                echo '</p>';
                            } else {
                                echo '<p id="pic'.$i.'" style="display:none">';
                                echo '<a href="'.$teacher_page.'"><img src="'.$teacher['picBanner'].'" class="image_banner" onload="initProgress(\''.$teacher_page.'\','
                                    .$teacher['moneyDone'].','.$teacher['moneyNeed'].',\''.$teacher['name'].'老师\',\''.$teacher['info'].'\')"/></a>';
                                echo '</p>';
                            }
                        }
                        $i ++;
                        if ($i >= 4) break;
                    }
                ?>
            </div>
            <div id="img_mask" class="img_mask">
            	<div id="mask_title" class="mask_title" style="margin-top:5px"><a href="#">吴梦花老师</a></div>
                <div id="mask_content" class="mask_content" style="margin-top:5px"><a href="#">吴梦花老老师吴梦花老师</a></div>
                <div class="mask_title" style="margin-top:5px">捐赠进度</div>
                <div style="width:250px; margin-top:10px">
                    <center id="progress_text">2000/5000</center>
                    <div id="progress_bar" class="progress_bar" style="margin-top:10px; margin-left: 25px">
                        <img id="progress" src="image/progress.png" style="margin-left:100px"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="num">
            <li id="tag0" class="select" onClick="goNext(0)">1</li>
            <li id="tag1" onClick="goNext(1)">2</li>
            <li id="tag2" onClick="goNext(2)">3</li>
            <li id="tag3" onClick="goNext(3)">4</li>
        </div>
    </div>
    <?php 
        mysql_data_seek($dbres,0);
        $i = 0;
        while($teacher = (mysql_fetch_array($dbres))) {
            if ($i == 0) {
                $teacher_page = $teacher['url'];
                echo '<div class="auto_manage_titie" style="margin-top: 30px; margin-left: 5px"><a href="'.$teacher_page.'">'.$teacher['name'].'老师</a></div>';
                echo '<div class="auto_manage_content" style="margin-top: 5px; margin-left: 5px">';
                echo '<a href="'.$teacher_page.'">'.$teacher['info'].'</a>';
                echo '</div> ';

                echo '<div class="row" style="margin: 0px; margin-top:20px">';
                echo '<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="padding:0">';
                echo '<div style="background-color:#FFFFFF; padding: 30px; padding-top:1px">';
            } else {
                $teacher_page = 'teacher_detail.php?id='.$teacher['id']; //也可以用 $teacher['url']
                echo '<div class="teacher_title">';
                echo '<a href="'.$teacher_page.'">'.$teacher['name'].'老师</a>';
                echo '</div>';
                echo '<div class="teacher_content">';
                echo '<a href="'.$teacher_page.'">'.$teacher['info'].'</a>';
                echo '</div>';
            }
            $i++;
            if ($i > 4) break;       
        }
        echo '</div>';
        echo '</div>';
    ?>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 right">
        	<div class="right_title">关注我们</div>
            <img src="image/erweima.jpg" width="170" style="margin:20px"/>
            <div class="right_title">微信消息</div>
            <div class="weixin_content seamless allowStop">
                <?php
                    $sql="select * from article";
                    $dbres = mysql_query($sql, $db_con);
                    while($article = (mysql_fetch_array($dbres))) {
                        echo '<div class="weixin_content_in"><a href="'.$article["link"].'">'.$article["title"].'</a></div>';
                    }
                ?>
            </div>
        </div>
    </div>
    <?php
        mysql_close($db_con);
    ?>
    <iframe src="footer.php" scrolling="no" frameborder="0" width="100%" height="100px" style="margin-top:10px"></iframe>
</div>
<script type="text/javascript">
    ellipsis('teacher_content', 'a');
    ellipsis('auto_manage_content', 'a');
    ellipsis('weixin_content_in', 'a');
    ellipsis('header_info_text', 'a');

    (function(c){
    var obj=document.getElementsByTagName("div");
    var _l=obj.length;
    var o;
    for(var i=0;i<_l;i++){
    o=obj[i];
    var n2=o.clientHeight;
    var n3=o.scrollHeight;
    o.s=0;
    if(o.className.indexOf(c)>=0){
    if(n3<=n2){return false;}
    var delay=parseInt(o.getAttribute("delay"),10);
    if(isNaN(delay)){delay=100;}
    if(o.className.indexOf("allowStop")>=0){
    o.onmouseover=function(){this.Stop=true;}
    o.onmouseout=function(){this.Stop=false;}
    }
    giveInterval(autoRun,delay,o);
    //关键之处！！
    o.innerHTML=o.innerHTML+o.innerHTML;
    }
    }
    //注册函数
    function giveInterval(funcName,time){var args=[];for(var i=2;i<arguments.length;i++){args.push(arguments[i]);}return window.setInterval(function(){funcName.apply(this,args);},time);}
    function autoRun(o,s){
    if(o.Stop==true){return false;}
    var n1=o.scrollTop;
    var n3=o.scrollHeight;
    o.s++;
    o.scrollTop=o.s;
    if(n1>=n3/2){
    o.scrollTop=0;
    o.s=0;
    }
    }
    })('seamless')
</script>
</body>
</html>
