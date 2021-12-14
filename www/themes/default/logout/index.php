<?php
//Simplemente elimina cookies y sesiones y redirige a login
if (isset($_COOKIE['token'])) {
    $token = $_COOKIE['token']; //$token vale ahora el token
    removeToken($token);        //Eliminar el token de la base de datos
    redirect();                 //El token pasa a ser invalido y eres redirigido a auth.
}
//No hay sesion. Redirigir a landing
redirect("landing");

?>