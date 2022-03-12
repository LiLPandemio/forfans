<?php

/**
 * Comprueba el estado del script e intenta corregir errores previstos.
 **/
function checkHealth()
{
    $healthIssues = array();
    $filename = getcwd()."/GLOBAL.php";
    if (!file_exists($filename)) {
        if (is_writable($filename)) {
            if (!$fp = fopen($filename, 'a')) {
                die("CANNOT WRITE $filename, CHECK PERMISSIONS");
            }
            fclose($fp);
        } else {
            die("CANNOT WRITE $filename, CHECK PERMISSIONS");
        }
    }
    
    return $healthIssues;
}
