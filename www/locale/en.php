<?php
//Aqui se almacenan las claves con las cadenas de texto para el idioma INGLES

function lang($langkey)
{
    require(ROOT . "/config.php");

    $lang['welcome_to']
        = "Welcome to {sitename}!";

    $lang['welcome_back']
        = "Welcome back!";

    $lang['login']
        = "Login";

    $lang['login_subtitle']
        = "Already have an account? Log in!";

    $lang['register_subtitle']
        = "Don't have an account yet?<br/>┬íRegister now!";

    $lang['register']
        = "Register";

    $lang['join_site']
        = "Join {sitename}";

    $lang['create_account']
        = "Create account";

    $lang['name']
        = "Nombre";

    $lang['posts']
        = "Posts";

    $lang['donated']
        = "Donated";

    $lang['donate']
        = "Donate";

    $lang['search']
        = "Search";

    $lang['more']
        = "More";

    $lang['others']
        = "Others";

    $lang['change_theme']
        = "Change theme";

    $lang['feed']
        = "Home";

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
        = "Male";

    $lang['female']
        = "Woman";

    $lang['war_helicopter']
        = "War helicopter";

    $lang['transgender']
        = "Transgender";

    $lang['transexual']
        = "Transexual";

    $lang['transgender_mtf']
        = "Transgender male to female";

    $lang['transsexual_mtf']
        = "Transexual male to female";

    $lang['transgender_ftm']
        = "Transgender female to male";

    $lang['transsexual_ftm']
        = "Transexual female to male";

    $lang['fluid']
        = "Fluid gender";

    $lang['fluid_cis_f']
        = "Fluid (CIS Female)";

    $lang['fluid_cis_m']
        = "Fluid (CIS Male)";

    $lang['suggested_profiles']
        = "Suggested profiles";

    $lang['inspired_publish_something']
        = "Inspired? Post something!";

    $lang['new_post_placeholder_text']
        = "Post something! #Anime #Hentai #xXx";

    $lang['add_content']
        = "Add content";

    $lang['add_gif']
        = "Add gif";

    $lang['adult_content']
        = "NSFW Content";


    $str = str_replace("{sitename}", $config['sitename'], $lang[$langkey]);
    // Para a├▒adir mas variables copia la linea de abajo y reemplaza $config['sitename'] con lo que quieras y {sitename} por tu placeholder.
    // $text = str_replace("{sitename}", $config['sitename'], $lang[$langkey]);

    return $str;
}
