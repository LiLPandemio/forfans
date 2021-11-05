<?php
//Aqui se almacenan las claves con las cadenas de texto para el idioma ESPAÑOL

function lang($phrase)
{
    require(ROOT."/config.php");
    
    $lang['welcome_to']
        = "Bienvenido a {sitename}!";

    $lang['login']
        = "Iniciar sesion";

    $lang['register']
        = "Registrarse";

    $lang['join_site']
        = "Unirme a {sitename}";

    $str = str_replace("{sitename}", $config["sitename"], $lang[$phrase]);
    return $str;
}