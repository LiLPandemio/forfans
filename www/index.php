<?php
// ******************************
// ForFans Project - Bemen3     *
// Marc Moreno & Bryan Medrano  *
// ******************************

//Path absoluto a la raiz de la app web
define('ROOT', getcwd());
//Carga de las funciones esenciales
require_once(ROOT."/functions/system.php");


if (isset($_REQUEST['page'])) {
    // El usuario esta pidiendo una pagina en especifico
} else {
    // El usuario no pide ninguna pagina, mostrar landing o home si esta autenticado
}

?>
