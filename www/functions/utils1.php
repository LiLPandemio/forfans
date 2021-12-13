<?php
function redirect($page = "auth"){
    require_once(ROOT . "/functions/themeEngine.php");
    $nexturl = $config['fullsiteurl'].$page;
    header("location:$nexturl");
}
?>