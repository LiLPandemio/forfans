<?php
// Este archivo contine las funciones que se usan para autenticar a un usuario, getionar las cuentas eliminar crear etc.


/**
 * Esta funcion devuelve un token o false si las credenciales no coinciden
 * Posibles respuestas:
 * WrongCredentials: Es un error generico que puede significar: WrongPassword UserNotFound MissingPassword MissingUsername
 * $TOKEN: Se proveera de un token en lugar de un mensaje de error cuando las credenciales coincidan.
 */
function login($username, $password)
{
    require(ROOT . "/functions/db.php");                       //Importar la base de datos
    $username = str_replace(" ", "", $username);                    //Limpiar espacios en blanco
    if ($username !== "") {                                         //Si el nombe de usuario no esta en blanco
        if ($password !== "") {                                     //Y la contraseña no esta en blanco

            //Comprobar login
            $stmt = $conn->prepare("SELECT * FROM `usuarios` WHERE `correo` = ?");
            $stmt->execute(array($username));
            $count = $stmt->rowCount();
            if ($count > 0) {
                $user = $stmt->fetch();
                $pass_verification = password_verify($password, $user['contraseña']);
                if ($pass_verification == true) {
                    //PASSWORD OK
                    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {                       //
                        $ip = $_SERVER['HTTP_CLIENT_IP'];                           ///
                    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {           /// Este codigo extrae la IP
                        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];                     /// original del usuario
                    } else {                                                        ///
                        $ip = $_SERVER['REMOTE_ADDR'];                              //
                    }
                    //Se declara lo necesario para guardar el token en la base de datos
                    $IP      = $ip;                   //ip REAL del usuario
                    $TOKEN   = tokenGenerator();      //el token generado
                    $UID     = $user['id_usuarios'];  //el id del usuario
                    //Se prepara la query con placeholders que evitan inyecciones SQL
                    $sth = $conn->prepare("INSERT INTO tokens (token_id, ip_issued, timestamp, token, user_id) VALUES (NULL, :ip, current_timestamp(), :token, :userid);");                 //Mandamos a la conexion con la base de datos a preparar la consulta
                    // $sth->execute(array($IP, $TOKEN, $UID));    //Ejecutamos la consolta con los parametros del usuario
                    $sth->execute(array(':ip' => $IP, ':token' => $TOKEN, ':userid' => intval($UID)));
                    return $TOKEN;
                } else {
                    return "WrongCredentials"; //WrongPassword - No se especifica al usuario el motivo por seguridad.
                }
            } else {
                return "WrongCredentials"; //UserNotFound - No se especifica al usuario el motivo por seguridad.
            }
        } else {
            return "WrongCredentials"; //MissingPassword - No se especifica al usuario el motivo por seguridad.
        }
    } else {
        return "WrongCredentials"; //MissingUsername - No se especifica al usuario el motivo por seguridad.
    }
}

//*Esta funcion genera un token aleatorio
function tokenGenerator()
{
    $token = openssl_random_pseudo_bytes(60);
    $token = bin2hex($token);
    return $token;
}
/**
 * ESTA FUNCION COMPRUEBA EL ESTADO DEL TOKEN. POSIBLES RESPUESTAS:
 * ADVERTENCIA: ESTA FUNCION NO COMPRUEBA QUE EL TOKEN ESTE VACIO
 *      INVALID_TOKEN: EL token no existe
 *      TOKEN_EXPIRED: El token ha caducado
 *      INT(): El token corresponde al usuario con id INT
 */
function checkTokenStatus($token)
{
    require(ROOT . "/functions/db.php");            //Antes de comprobar el token se importa la base de datos para poder comprobarlo
    $stmt = $conn->prepare("SELECT * FROM `tokens` WHERE `token` = :token");
    $stmt->execute(array(':token' => $token));
    $crows = $stmt->rowCount();
    if ($crows > 0) {
        //There's rows
        $row = $stmt->fetch();
        return $row['user_id'];
    } else {
        return "INVALID_TOKEN";
    }
}
/**
 * TOMA COMO VALOR UN TOKEN, SI EL TOKEN NO ES VALIDO DEVUELVE INVALID_TOKEN, SI EL TOKEN
 * EXISTE ELIMINARA EL TOKEN DE LA BASE DE DATOS Y DARA SUCCESS COMO RETORNO.
 */
function removeToken($token)
{
    if (checkTokenStatus($token) != "INVALID_TOKEN") {
        require(ROOT . "/functions/db.php");
        $stmt = $conn->prepare("DELETE FROM `tokens` WHERE `token` = :token");
        $stmt->execute(array(':token' => $token));
        $drows = $stmt->rowCount();
        if ($drows > 0) {
            //There's rows
            return "SUCCESS";
        } else {
            return "SOMETHING_WENT_WRONG";
        }
    } else {
        return "INVALID_TOKEN";
    }
}
/**
 * Recibe la cookie y da true o false si esta o no con una sesion valida.
 * $sesdata = $_COOKIE
 */
function isWebLoggedIn($sesdata){
    if (isset($sesdata['token'])) {
        if ($sesdata['token'] !== "") {
            if (checkTokenStatus($_COOKIE['token']) != "INVALID_TOKEN") {
                return true;
            }
        }
    }
    return false;
}