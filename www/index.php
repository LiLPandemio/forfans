<?php
// ******************************
// ForFans Project - Bemen3     *
// Marc Moreno & Bryan Medrano  *
// ******************************

//DEBUG - MUESTRA LOS ERRORES EN EL NAVEGADOR
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//NO CACHE
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

//Establece el path absoluto a la raiz de la app web de forma dinamica
define('ROOT', getcwd());

//Carga de las funciones esenciales
require_once(ROOT . "/functions/system.php");
require_once(ROOT . "/functions/themeEngine.php");
require_once(ROOT . "/functions/db.php");
if (isset($_REQUEST['page'])) {
    // El usuario esta pidiendo una pagina en especifico
    $fullpage = $_REQUEST['page'];
    $param = preg_split("/\//", $fullpage, -1, PREG_SPLIT_NO_EMPTY);
    switch ($param[0]) {
            // Redirecciones especiales de la app (API, Admin)
        case 'api':
            require(ROOT."/api.php");
            break;
        case 'webmap':
            echo "Getting webmap"; //Obtener webmap
            break;
        case 'adminpanel':
            echo "Getting adminpanel"; //Panel de administrador
            break;
        default:                                            //Paginas del tema: Cargar pagina del tema actuar, si no hay, cargar perfil de usuario, si no hay, 404
            require(ROOT . "/config.php");                          //Importa la configuracion
            if (pageExists($param[0])) {                            //Si la pagina existe
                loadPage($_REQUEST["page"], $config['theme']);      //Carga la pagina
            } else {                                                //Si no existe
                                                            //*En el futuro aqui se cargaran perfiles
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
    // El usuario no pide ninguna pagina, mostrar landing o home si esta autenticado
}
