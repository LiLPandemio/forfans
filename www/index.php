<?php
// ******************************
// ForFans Project - Bemen3     *
// Marc Moreno & Bryan Medrano  *
// ******************************

//Path absoluto a la raiz de la app web
define('ROOT', getcwd());
//Carga de las funciones esenciales
require_once(ROOT . "/functions/system.php");


if (isset($_REQUEST['page'])) {
    // El usuario esta pidiendo una pagina en especifico
    switch ($REQUEST['page']) {
            // Redirecciones especiales de la app (API, Admin)
        case 'api':
            //Redireccionar a sistema API
            break;
        case 'webmap':
            //Obtener webmap
            break;
        case 'adminpanel':
            //Panel de administrador
            break;

        //Paginas del tema

        default:
            //Cargar pagina del tema actuar, si no hay, cargar perfil de usuario, si no hay, 404
            if (pageExists($REQUEST['page'])) {
                //La pagina existe en el tema actual
            } else {
                if (profileExists($REQUEST['page'])){
                    //El perfil existe
                } else {
                    //404
                }
            }
            
            break;
    }
} else {
    // El usuario no pide ninguna pagina, mostrar landing o home si esta autenticado
}

?>