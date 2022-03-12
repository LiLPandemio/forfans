<?php
// ******************************
// ForFans Project - Bemen3     *
// Marc Moreno & Bryan Medrano  *
// ******************************

$showErrors = true;         //Mostrara o no los errores en la pagina web.
$disableCache = true;       //Desactivara el cache (Header)
$healthChecks = true;       //Activa o desactiva la comprobacion de salud del script

//DEBUG - MUESTRA LOS ERRORES EN EL NAVEGADOR
if ($showErrors) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
}
if ($disableCache) {
    //NO CACHE
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
}
if ($healthChecks) {
    //NO CACHE
    require_once "functions/healthEngine.php";
    checkHealth();
}

//Establece el path absoluto a la raiz de la app web de forma dinamica
define('ROOT', getcwd()); //No tiene trailing dashline ////

//Carga de las funciones esenciales
require_once(ROOT . "/functions/system.php");
require_once(ROOT . "/functions/themeEngine.php");
require_once(ROOT . "/functions/db.php");
require_once(ROOT . "/functions/authEngine.php");
require_once(ROOT . "/config.php");
require_once(ROOT . "/functions/utils1.php");
if (isset($_REQUEST['page'])) {                                         //Si se solicita una pagina
    $fullpage = $_REQUEST['page'];                                      //La pagina se guarda en $fullpage para dividirla luego en parametros
    $param = preg_split("/\//", $fullpage, -1, PREG_SPLIT_NO_EMPTY);    //$param[n] contiene los parametros siendo N el parametro solicitado.
    switch ($param[0]) {                                        //Si el parametro vale...
        case 'api':                                             //API:
            require(ROOT . "/api.php");                         //Se importa la api y se usa.
            break;                                              //Fin de index.php
        case 'webmap':                                          //WEBMAP:
            echo "Getting webmap";                              //Obtiene el webmap para buscadores web. Se pueden evadir en config
            break;                                              //Fin de index.php
            /**
             * Paginas del tema: Cargar pagina del tema actuar
             * Si no hay, cargar perfil de usuario $param[0],
             * si no hay, 404.
             */
        default:
            if (pageExists($param[0])) {                            //Si la pagina existe

                loadPage($param[0], $config['theme']);      //Carga la pagina
            } else {                                                //Si no existe                
                switch ($param[0]) {                        //Posibles redirecciones:

                    case 'login':                                   //Si el usuario pide ir a login
                        header("Location: ./auth");                 //Se redirecciona a auth
                        break;
                    case 'register':                                //Si el usuario pide ir a register
                        header("Location: ./auth");                 //Se redirecciona a auth
                        break;
                    case 'feed':                                    //Si el usuario pide ir a feed
                        header("Location: ./home");                 //Se redirecciona a home
                        break;

                    default:
                        loadPage("404", $config["theme"]);              //Carga la pagina 404
                        break;
                }
            }

            break;
    }
} else {
    if (isWebLoggedIn($_COOKIE)) {
        redirect("home");
    } else {
        redirect("landing");
    }
}
