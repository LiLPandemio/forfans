<?php
//Simplemente elimina cookies y sesiones y redirige a login
require(ROOT."/functions/utils1.php");
if (isset($_COOKIE['token'])) {
    //Eliminar el token de la DB
    $token = $_COOKIE['token'];
    require(ROOT."/functions/authEngine.php");
    removeToken($token);
    redirect();
}
//No hay sesion :v
redirect();

?>