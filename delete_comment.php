<?php
    $path="../";
    if (isset($_GET["comment_id"])) {
        require_once($path."db.php");
        $db_con = @mysql_connect($db_host, $dbuser, $dbpasswd) or die;
        @mysql_select_db($dbname);
        $sql="delete from comment where id = ".$_GET["comment_id"];
        $dbres = mysql_query($sql, $db_con);
        if (!$dbres) {
            echo "$sql 删除评论失败：".mysql_error()."<br>\n";
        }
    }
    $jumpdest = $_GET["url"]."?id=".$_GET["tid"];
    require("../aihope/jump.php"); 
?>
