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
