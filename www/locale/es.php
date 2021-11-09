<?php
//Aqui se almacenan las claves con las cadenas de texto para el idioma ESPAÑOL

function lang($phrase)
{
    require(ROOT."/config.php");
    
    $lang['welcome_to']
        = "Bienvenido a {sitename}!";
    
    $lang['welcome_back']
        = "Bienvenido de nuevo!";

    $lang['login']
        = "Iniciar sesion";

    $lang['login_subtitle']
        = "¿Ya tienes una cuenta?<br/>¡Inicia sesion!";

    $lang['register_subtitle']
        = "¿Aun no tienes cuenta?<br/>¡Crea una!";

    $lang['register']
        = "Registrarse";

    $lang['join_site']
        = "Unirme a {sitename}";

    $lang['create_account']
        = "Crear cuenta";

    $str = str_replace("{sitename}", $config["sitename"], $lang[$phrase]);
    return $str;
}