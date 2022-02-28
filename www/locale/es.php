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

    $lang['lithsexual']
        = "Lithsexual";

    $lang['autosexual']
        = "Autosexual";

    $lang['antrosexual']
        = "Antrosexual";

    $lang['na']
        = "na";

    $lang['male']
        = "male";

    $lang['female']
        = "female";

    $lang['transgender']
        = "transgender";

    $lang['transexual']
        = "transexual";

    $lang['transgender_mtf']
        = "Transgenero hombre a mujer";

    $lang['transsexual_mtf']
        = "Transexual hombre a mujer";

    $lang['transgender_ftm']
        = "Transgenero mujer a hombre";

    $lang['transsexual_ftm']
        = "Transexual mujer a hombre";

    $lang['fluid']
        = "Fluido";

    $lang['fluid_cis_f']
        = "Fluido (CIS Mujer)";

    $lang['fluid_cis_m']
        = "Fluido (CIS Hombre)";
        
    $lang['suggested_profiles']
    = "Perfiles sugeridos";

    $str = str_replace("{sitename}", $config["sitename"], $lang[$langkey]);
    // Para añadir mas variables copia la linea de abajo y reemplaza $config['sitename'] con lo que quieras y {sitename} por tu placeholder.
    // $text = str_replace("{sitename}", $config['sitename'], $lang[$langkey]);

    return $str;
}
