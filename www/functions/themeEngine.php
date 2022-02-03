<?php
//Aqui estaran las funciones relacionadas con los temas de la pagina, Consultar modificar etc


// Comprueba si en el tema actual existe la pagina que el usuario solicita, devolvera 0 en caso de error o que no exista y 1 si existe
function pageExists ($page) {
    require(ROOT."/config.php");                            //Se importa la configuracion de la pagina
    $page = preg_replace('/[^A-Za-z0-9\-]/', '', $page);    //Reemplaza por nada caracteres que no sean A-Z a-z 0-9 para evitar posibles vulnerabilidades
    if ($page == "") {                                      //Comprueba que la pagina no este en blanco
        return false;                                       //Se pide la pagina "", se retorna falso
    } else {                                                //Si la pagina no es ""
        if (file_exists(ROOT."/themes/".$config['theme']."/$page/index.php")) {  //Si existe el archivo en el tema, 
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
    require(ROOT."/themes/$theme/head/index.php");      //Carga el head y las primeras lineas HTML del tema.
    require(ROOT."/themes/$theme/".$page."/index.php"); //Carga el archivo principal de la pagina en el tema que se solicitó.
}