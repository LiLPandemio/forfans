<?php
/**
 * Esta funcion redirige a una pagina interna.
 *  - Para usar solo hace falta especificar la pagina de destino.
 *  - Por defecto redirige a auth.
 */
function redirect($page = "auth"){
    require_once(ROOT . "/functions/themeEngine.php");
    $nexturl = $config['fullsiteurl'].$page;
    header("location:$nexturl");
}
?>