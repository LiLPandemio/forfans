<?php
//Simplemente elimina cookies y sesiones y redirige a login
if (isset($_COOKIE['token'])) {
    //Eliminar el token de la DB
    $token = $_COOKIE['token'];
    require(ROOT."/functions/authEngine.php");
    require(ROOT."/functions/utils1.php");
    removeToken($token);
    redirect();
}
//No hay sesion :v
require(ROOT."/functions/utils1.php");
redirect();

?>