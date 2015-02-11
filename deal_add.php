<?php
$path="../";
//print_r($_COOKIE);
if(!isset($_COOKIE['userid'])) {
        require("loginform.php");
} else if(!isset($_POST['addteacher'])) {
        echo "本网页不能这样访问，抱歉";
        die;
} else {
	require_once ($path."db.php") ;
	$db_con = @mysql_connect($dbhost, $dbuser, $dbpasswd) or die;
	@mysql_select_db($dbname);
        //检查用户的权限  
        $uid = $_COOKIE['userid'];
	$requiredperm = $PERM_RECM;
	require("check_perm.php");

	$dir = $_POST["path"];
	$rootpath = '/usr/share/nginx/html/v1/';
	$url = "http://www.aihope.org/web/".$dir."/";
	$uploaddir = $rootpath.$dir;
	$error = 0;
	mkdir($uploaddir);
	//$sql="insert into teacher (name,create_time) values (\"测试3\",NOW())";
	//$sql="select * from teacher where url like \"%$dir\"";
	//$dbres = mysql_query($sql, $db_con);

	//创建老师的主网页  
        $infopage = "";
	$handle = fopen($uploaddir."/index.php", "w");
	fwrite($handle ,'<html>');
	$content = $_POST["content"];
	if (strlen($content) > 0) {
		if(isset($_POST["usehtml"])) {
			fwrite($handle, $infopage);
                        $infopage = $content;
		} else {
                        /*
                        $infopage = $infopage."<h2>".$_POST["teacher_name"]."老师介绍</h2>";
			$infopage = $infopage."<p>".$_COOKIE['userid']."推荐</p>";
			$infopage = $infopage."<p>".$_POST["position"]."</p>";
			$infopage = $infopage."<p><a href='".$_POST["shopurl"]."'>我要帮TA</a></p>";
			$infopage = $infopage."<img src=\"".$_POST["piclink"]."\" />";*/
			$infopage = $infopage."<p>\n".str_replace("\n","<br>\n",$content)."\n</p>\n";
			//$infopage = $infopage."<hr><p><a href='".$_POST["shopurl"]."'>我要帮TA</a></p>";
                        $infopage = str_replace("\n","<br>\n",$infopage);
		}
	}
	$link = $_POST["link"];
	if (strlen($link) > 0) {
		//此链接内容作为frame
		$infopage = $infopage.'<frameset cols=100%><frame width=100% height=100% src="'
		.$link
		.'" />';
		$infopage = $infopage.'</frameset>';

	}

	$infopage = $infopage.'</html>';
	fwrite($handle, $infopage);
	fclose($handle);

	//TODO:判断重复,考察覆盖数据的权限  
        $select = "select * from teacher where url=\"$url\"";
	$dbres = mysql_query($select, $db_con);
        $teacher = (mysql_fetch_array($dbres));
        if ($teacher != null) {
		echo "此老师已存在。";
                if ($teacher['recommender'] == $_COOKIE['userid']) {
                    echo "您是想修改吗？ <br>您可以\"后退\"重新编辑或联系我们修改\n";
                    //echo "您是想修改吗？ <br>您可以\"后退\"并按“修改”按钮\n";
                } else {
                    echo "您是否有权限编辑?  <br>您可以\"后退\"重新编辑，换一个不重复的老师ID\n";
                }
	        mysql_close($db_con);
        } else {

            $sql="insert into teacher (valid, name,recommender,create_time,pic,picSmall,info,position,url,shopurl,bankname,bankacc,infopage) values (1,\""
            .$_POST["teacher_name"]."\",\""
            .$_COOKIE['userid']
            ."\", NOW(),'"
            .$_POST["piclink"]
            ."', '"
            .$_POST["piclink"]
            ."', '"
            .$_POST["summary"]
            ."', '"
            .$_POST["position"]
            ."', '"
            .$url
            ."', '"
            .$_POST["shopurl"]
            ."', '"
            .$_POST["bankname"]
            ."', '"
            .$_POST["bankacc"]
            ."', '"
            .$infopage
            ."')";
            $dbres = mysql_query($sql, $db_con);
            if (!$dbres) {
                    echo "$sql 插入数据库失败: ".mysql_error()."<br>您可以\"后退\"重新编辑\n";
                    mysql_close($db_con);
            } else {
                    echo "数据库插入\"";
                    echo $sql;
                    echo "\"成功<br>\n";
                    $dbres = mysql_query($select, $db_con);
                    $teacher = (mysql_fetch_array($dbres));
                    if ($teacher != null) {
                        //print_r($dbres);
                        mysql_close($db_con);
                        $jumpdest = "teacher_detail.php?id=".$teacher['id']; //$url;
                        require("jump.php");
                    } else {
                        echo "但未见数据<br>您可以\"后退\"重新编辑\n";
                        mysql_close($db_con);
                    }
	    }
        }

}
?>
