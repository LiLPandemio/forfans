<?php
//Aqui se almacenan las claves con las cadenas de texto para el idioma ESPAÑOL

function lang($langkey)
{
    require(ROOT . "/config.php");

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

    $lang['male']
        = "Hombre";

    $lang['woman']
        = "Mujer";

    $lang['war_helicopter']
        = "Helicoptero de guerra";

    $lang['name']
        = "Nombre";

    $lang['posts']
        = "Publicaciones";

    $lang['donated']
        = "Donado";

    $lang['donate']
        = "Donation";

    $lang['search']
        = "Buscar";

    $lang['more']
        = "Mas";

    $lang['others']
        = "Otros";

    $lang['change_theme']
        = "Change theme";

    $lang['feed']
        = "Noticias";

    $lang['heterosexual']
        = "Heterosexual";

    $lang['homosexual']
        = "Homosexual";

    $lang['bisexual']
        = "Bisexual";

    $lang['pansexual']
        = "Pansexual";

    $lang['demisexual']
        = "Demisexual";

    $str = str_replace("{sitename}", $config["sitename"], $lang[$langkey]);
    // Para añadir mas variables copia la linea de abajo y reemplaza $config['sitename'] con lo que quieras y {sitename} por tu placeholder.
    // $text = str_replace("{sitename}", $config['sitename'], $lang[$langkey]);

    return $str;
}
