<?php
// Aqui estan las funciones que gestionan usuarios. Crear eliminar modificar y consultar usuarios.

/**
 * Obtiene la cantidad que especifiques de usuarios y te da informacion sobre ellos.
 */
function getSuggestedUsers($amount = 5)
{
    //TODO: SANITIZE AMOUNT VALUE
    require(ROOT . "/functions/db.php");        //Comprueba que exista el archivo
    //Prepara la consulta SQL
    $stmt = $conn->prepare("SELECT * FROM `usuarios` ORDER BY RAND () LIMIT $amount;");
    $stmt->execute();                           //Se ejecuta la consulta SQL
    $result = $stmt->fetchAll();                //Se sacan todas las filas a $result
    $drows = $stmt->rowCount();                 //Se cuenta cuantas filas hay
    if ($drows > 0) {                           //Si hay mas de 1 fila
        return $result;                         //Se devuelve el arreglo bidimensional con los perfiles
    } else {                                    //Si no hay filas (menos de 1; o 0)
        return "NO_USERS_FOUND";                //Se devuelve que no hay
    }
}

/**
 * Returns array from database with user relevant data (SENSITIVE DATA ON.)
 */
function getUserData($username)
{
    require(ROOT . "/functions/db.php");                                        //Comprueba que exista el archivo
    $stmt = $conn->prepare("SELECT `usuarios`.*, `sexual_orientations`.* FROM `usuarios` LEFT JOIN `sexual_orientations` ON `usuarios`.`sexual_orientations_id` = `sexual_orientations`.`id` WHERE `username` = ?;");   //Se prepara una consulta con nombre de usuario
    $stmt->execute(array($username));                                           //Se ejecuta la consulta con el nombre de usuario
    $result = $stmt->fetchAll();                                                //Se extraen los datos de la consulta
    $drows = $stmt->rowCount();                                                 //Se comprueba que haya algun resultado
    if ($drows > 0) {                                                           //Si hay algun resultado
        return $result[0];                                                      //Se retorna el arreglo con la informacion del usuario
    } else {                                                                    //Si no hay resultados
        return "NO_USERS_FOUND";                                                //Se retorna un error
    }
}

/**
 * Toma el token opcionalmente que le des y te devuelve el nomrbe de usuario, por defecto el token es el del usuario que hace la peticion.
 */
function whoami($tkp = "")
{
    require(ROOT . "/functions/db.php");    //Importo la base de datos
    if ($tkp == "") {                       //Si no se me da un token
        $token = $_COOKIE['token'];         //Uso el token de la cookie
    } else {                                //Si me dan un token
        $token = $tkp;                      //Uso ese token
    }
    //Preparado de la consulta SQL con placeholder para token
    $stmt = $conn->prepare("SELECT `tokens`.*, `usuarios`.* FROM `tokens` LEFT JOIN `usuarios` ON `tokens`.`user_id` = `usuarios`.`id_usuarios` WHERE `tokens`.`token` = ?;");
    $stmt->execute(array($token));          //Ejecucion de la consulta SQL con el $token
    $result = $stmt->fetchAll();            //Extraemos la informacion del usuario de la consulta ejecutada
    $drows = $stmt->rowCount();             //Contamos las filas que tenemos por si no ha llegado ninguna (El token no existe)
    if ($drows > 0) {                       //Si hay una fila o mas
        return $result[0]["username"];      //Devolvemos de la primera fila el token pertinente
    } else {                                //Si no hay filas
        return "TOKEN_NOT_FOUND";           //Devolvemos que no se encuentra nada con el token especificado
    }
}

/**
 * Toma el token opcionalmente que le des y te devuelve el id de usuario, por defecto el token es el del usuario que hace la peticion.
 */
function myid($tkp = "")
{
    require(ROOT . "/functions/db.php");    //Importo la base de datos
    if ($tkp == "") {                       //Si no se me da un token
        $token = $_COOKIE['token'];         //Uso el token de la cookie
    } else {                                //Si me dan un token
        $token = $tkp;                      //Uso ese token
    }
    //Preparado de la consulta SQL con placeholder para token
    $stmt = $conn->prepare("SELECT `tokens`.*, `usuarios`.* FROM `tokens` LEFT JOIN `usuarios` ON `tokens`.`user_id` = `usuarios`.`id_usuarios` WHERE `tokens`.`token` = ?;");
    $stmt->execute(array($token));          //Ejecucion de la consulta SQL con el $token
    $result = $stmt->fetchAll();            //Extraemos la informacion del usuario de la consulta ejecutada
    $drows = $stmt->rowCount();             //Contamos las filas que tenemos por si no ha llegado ninguna (El token no existe)
    if ($drows > 0) {                       //Si hay una fila o mas
        return $result[0]["id_usuarios"];      //Devolvemos de la primera fila el token pertinente
    } else {                                //Si no hay filas
        return "TOKEN_NOT_FOUND";           //Devolvemos que no se encuentra nada con el token especificado
    }
}

/**
 * Esta funcion pertenece al grupo de funciones setUser__ que se encargan de establecer distintos parametros.
 */
function setUser__default_theme_variable($username, $newValue)
{
    require(ROOT . "/functions/db.php");
    if ($newValue == "default") {
        $newValue = NULL;
    }
    
    $stmt = $conn->prepare("UPDATE `usuarios` SET `default_theme_variable` = ? WHERE `usuarios`.`username` = ?; ");
    $stmt->execute(array($newValue, $username));
    $drows = $stmt->rowCount();
    if ($drows > 0) {
        return "OK";
    } else {
        return $stmt->fetchAll();
    }
}

/**
 * Esta funcion pertenece al grupo de funciones setUser__ que se encargan de establecer distintos parametros.
 */
function setUser__username($username, $newValue)
{
    require(ROOT . "/functions/db.php");
    $stmt = $conn->prepare("UPDATE `usuarios` SET `username` = ? WHERE `usuarios`.`username` = ?; ");
    $stmt->execute(array($newValue, $username));
    $drows = $stmt->rowCount();
    if ($drows > 0) {
        return "OK";
    } else {
        return $stmt->fetchAll();
    }
}

/**
 * Esta funcion pertenece al grupo de funciones setUser__ que se encargan de establecer distintos parametros.
 */
function setUser__name($username, $newValue)
{
    require(ROOT . "/functions/db.php");
    $stmt = $conn->prepare("UPDATE `usuarios` SET `nombre` = ? WHERE `usuarios`.`username` = ?; ");
    $stmt->execute(array($newValue, $username));
    $drows = $stmt->rowCount();
    if ($drows > 0) {
        return "OK";
    } else {
        return $stmt->fetchAll();
    }
}

/**
 * Esta funcion pertenece al grupo de funciones setUser__ que se encargan de establecer distintos parametros.
 */
function setUser__surname($username, $newValue)
{
    require(ROOT . "/functions/db.php");
    $stmt = $conn->prepare("UPDATE `usuarios` SET `apellidos` = ? WHERE `usuarios`.`username` = ?; ");
    $stmt->execute(array($newValue, $username));
    $drows = $stmt->rowCount();
    if ($drows > 0) {
        return "OK";
    } else {
        return $stmt->fetchAll();
    }
}

/**
 * Esta funcion pertenece al grupo de funciones setUser__ que se encargan de establecer distintos parametros.
 */
function setUser__genderID($username, $newValue)
{
    require(ROOT . "/functions/db.php");
    $stmt = $conn->prepare("UPDATE `usuarios` SET `gender_id` = ? WHERE `usuarios`.`username` = ?; ");
    $stmt->execute(array($newValue, $username));
    $drows = $stmt->rowCount();
    if ($drows > 0) {
        return "OK";
    } else {
        return $stmt->fetchAll();
    }
}

/**
 * Esta funcion pertenece al grupo de funciones setUser__ que se encargan de establecer distintos parametros.
 */
function setUser__sexOrientID($username, $newValue)
{
    require(ROOT . "/functions/db.php");
    $stmt = $conn->prepare("UPDATE `usuarios` SET `sexual_orientations_id` = ? WHERE `usuarios`.`username` = ?; ");
    $stmt->execute(array($newValue, $username));
    $drows = $stmt->rowCount();
    if ($drows > 0) {
        return "OK";
    } else {
        return $stmt->fetchAll();
    }
}

/**
 * Devuelve un array de todos los generos y sus ids
 */
function getGendersList() {
    require(ROOT . "/functions/db.php");
    $stmt = $conn->prepare("SELECT * FROM `genders` ORDER BY `gender_id` ASC");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

/**
 * Devuelve un array de todos los generos y sus ids
 */
function getSexualOrientationsList() {
    require(ROOT . "/functions/db.php");
    $stmt = $conn->prepare("SELECT * FROM `sexual_orientations` ORDER BY `sexual_orientations`.`id` ASC");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function getMyInvites() {
    require(ROOT . "/functions/db.php");
    $sql = "SELECT * FROM `invitation_codes` WHERE `invitation_creator` = ?";
    $id = myid();
    $stmt = $conn -> prepare($sql);
    $stmt -> execute(array(intval($id)));
    $result = $stmt -> fetchAll();
    return $result;
}

function getMyUsedInvites() {
    require(ROOT . "/functions/db.php");
    $sql = "SELECT `invitation_codes`.*, `usuarios`.* FROM `invitation_codes` LEFT JOIN `usuarios` ON `invitation_codes`.`invitation_creator` = `usuarios`.`invite_used` WHERE `invitation_codes`.`invitation_creator` = ?;";
    $id = myid();
    $stmt = $conn -> prepare($sql);
    $stmt -> execute(array(intval($id)));
    $result = $stmt -> fetchAll();
    return $result;
}