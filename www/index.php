<?php
// ******************************
// ForFans Project - Bemen3     *
// Marc Moreno & Bryan Medrano  *
// ******************************

//DEBUG - MUESTRA LOS ERRORES EN EL NAVEGADOR
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Establece el path absoluto a la raiz de la app web de forma dinamica
define('ROOT', getcwd());

//Carga de las funciones esenciales
require_once(ROOT . "/functions/system.php");
require_once(ROOT . "/functions/themeEngine.php");

if (isset($_REQUEST['page'])) {
    // El usuario esta pidiendo una pagina en especifico
    switch ($_REQUEST['page']) {
            // Redirecciones especiales de la app (API, Admin)
        case 'api':
            //Redireccionar a sistema API
            echo "Getting api";
            break;
        case 'webmap':
            //Obtener webmap
            echo "Getting webmap";
            break;
        case 'adminpanel':
            //Panel de administrador
            echo "Getting adminpanel";
            break;

        //Paginas del tema

        default:
            //Cargar pagina del tema actuar, si no hay, cargar perfil de usuario, si no hay, 404
            require(ROOT."/config.php");                    //Importa la configuracion
            if (pageExists($_REQUEST['page'])) {                //Si la pagina existe
                loadPage($_REQUEST["page"], $config['theme']);  //Carga la pagina
                echo "BREAKPOINT";
            } else {                                            //Si no existe
                //!En el futuro aqui se cargaran perfiles
                loadPage("404", $config["theme"]);              //Carga la pagina 404
            }
            
            break;
    }
} else {
    // El usuario no pide ninguna pagina, mostrar landing o home si esta autenticado
}
?>