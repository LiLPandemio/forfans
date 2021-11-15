<?php
//Aqui se almacenan las claves con las cadenas de texto para el idioma INGLES

function lang($langkey)
{
    require(ROOT."/config.php");
    $lang['welcome_to']
        = "Welcome to {sitename}!";

    $lang['login']
        = "Login";

    $lang['register']
        = "Register";

    $lang['join_site']
        = "Join {sitename}";

    var_dump($lang);

    $text = str_replace("{sitename}", $config['sitename'], $lang[$langkey]);

    return $text;
}
