<?php
//Simplemente elimina cookies y sesiones y redirige a login
if (isset($_COOKIE['token'])) {
    $token = $_COOKIE['token']; //$token vale ahora el token
    removeToken($token);        //Eliminar el token de la base de datos
    redirect();                 //El token pasa a ser invalido y eres redirigido a auth.
}
//Limpieza de cookies!
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}
//No hay sesion. Redirigir a landing
redirect("auth");
