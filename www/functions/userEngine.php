<?php
// Aqui estan las funciones que gestionan usuarios. Crear eliminar modificar y consultar usuarios.

/**
 * Obtiene la cantidad que especifiques de usuarios y te da informacion sobre ellos.
 */
function getSuggestedUsers($amount = 5)
{
    require(ROOT . "/functions/db.php");
    $stmt = $conn->prepare("SELECT `username`,`gender_langkey`,`nombre`,`apellidos`,`profile_picture_rpath` FROM `usuarios` ORDER BY RAND () LIMIT $amount;");
    $stmt->execute();
    $result = $stmt->fetchAll();
    $drows = $stmt->rowCount();
    if ($drows > 0) {
        //There's rows
        return $result;
    } else {
        return "SOMETHING_WENT_WRONG";
    }
}

/**
 * Returns array from database with user relevant data (SENSITIVE DATA ON.)
 */
function getUserData($username){
    require(ROOT . "/functions/db.php");
    $stmt = $conn->prepare("SELECT * FROM `usuarios` WHERE `username` = ?;");
    $stmt->execute(array($username));
    $result = $stmt->fetchAll();
    $drows = $stmt->rowCount();
    if ($drows > 0) {
        //There's rows
        return $result[0];
    } else {
        return "SOMETHING_WENT_WRONG";
    }
}

function whoami($tkp = "") {
    require(ROOT . "/functions/db.php");
    if ($tkp == "") {
        $token = $_COOKIE['token'];
    } else {
        $token = $tkp;
    }
    
    $stmt = $conn->prepare("SELECT `tokens`.*, `usuarios`.* FROM `tokens` LEFT JOIN `usuarios` ON `tokens`.`user_id` = `usuarios`.`id_usuarios` WHERE `tokens`.`token` = ?;");
    $stmt->execute(array($token));
    $result = $stmt->fetchAll();
    $drows = $stmt->rowCount();
    if ($drows > 0) {
        return $result[0]["username"];
    } else {
        return "NOT_FOUND";
    }
    
}