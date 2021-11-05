<?php
//Aqui estaran las funciones relacionadas con los temas de la pagina, Consultar modificar etc


// Comprueba si en el tema actual existe la pagina que el usuario solicita, devolvera 0 en caso de error o que no exista y 1 si existe
function pageExists ($page) {
    require_once(ROOT."/config.php");
    //limpiamos el input para evitar posibles vulnerabilidades
    $page = preg_replace('/[^A-Za-z0-9\-]/', '', $page);    // Reemplaza por nada caracteres que no sean A-Z a-z 0-9
    if ($page = "") {                                       //Comprueba que la pagina no este en blanco
        return 0;                                           //Se pide la pagina "", se retorna falso
    } else {
        //Comprueba que exista el archivo
        if (file_exists(ROOT."/themes/".$config['theme']."/$page/index.php")) {  //Si la pagina existe, 
            return true;                                    //Devuelve TRUE
        } else {                                            //Si no existe
            return false;                                   //Devuelve false
        }
        return false;                                       //Retorna falso si no se puede ejecutar el condicional de arriba
    }
    return false;                                           //Retorna falso si no se puede ejecutar el conficional de arriba
}

//Esta funcion carga una pagina del tema actual en $config["theme"]
function loadPage ($page, $theme = "default") {

    require_once(ROOT."/themes/$theme/head/index.php"); //Carga el archivo principal del tema de la pagina que se solicitó.
    require_once(ROOT."/themes/$theme/".$page."/index.php"); //Carga el archivo principal del tema de la pagina que se solicitó.
}

// <!DOCTYPE html>
// <html lang="en">
// <head>
//     <meta charset="UTF-8">
//     <meta http-equiv="X-UA-Compatible" content="IE=edge">
//     <meta name="viewport" content="width=device-width, initial-scale=1.0">
//     <title>Document</title>
// </head>
// <body>
    
// </body>
// </html>