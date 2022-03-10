<?php

/**
 * Esta funcion redirige a una pagina interna.
 *  - Para usar solo hace falta especificar la pagina de destino.
 *  - Por defecto redirige a auth.
 */
function redirect($page = "auth")
{
	require_once(ROOT . "/functions/themeEngine.php");
	$nexturl = $config['fullsiteurl'] . $page;
	header("location:$nexturl");
}

function is_image($path)
{
	$type = mime_content_type($path);
	if ($type == "image/gif" or $type == "image/png" or $type == "image/jpg" or $type == "image/jpeg" or $type == "image/webp") {
		return true;
	} else {
		return false;
	}
}
