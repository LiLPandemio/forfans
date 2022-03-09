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
    require(ROOT . "/functions/db.php");                                        //Antes de comprobar el token se importa la base de datos para poder comprobarlo
    $stmt = $conn->prepare("SELECT * FROM `tokens` WHERE `token` = :token");    //Se prepara una consulta reservando espacio para el token
    $stmt->execute(array(':token' => $token));                                  //Se indica que el token es $token
    $crows = $stmt->rowCount();                                                 //Cuenta cuantos registros afectados hay
    if ($crows > 0) {                                                           //Si hay mas de 0 filas afectadas
        $row = $stmt->fetch();                                                  //Se coge la primera fila
        return $row['user_id'];                                                 //Extraes el nombre de usuario
    } else {                                                                    //Si no hay filas
        return "INVALID_TOKEN";                                                 //El token no es valido
    }
}
/**
 * TOMA COMO VALOR UN TOKEN, SI EL TOKEN NO ES VALIDO DEVUELVE INVALID_TOKEN, SI EL TOKEN
 * EXISTE ELIMINARA EL TOKEN DE LA BASE DE DATOS Y DARA SUCCESS COMO RETORNO.
 */
function removeToken($token)
{
    if (checkTokenStatus($token) != "INVALID_TOKEN") {                          //Si el token no es invalido (Es valido)
        require(ROOT . "/functions/db.php");                                    //Se importa la base de datos a la funcion
        $stmt = $conn->prepare("DELETE FROM `tokens` WHERE `token` = :token");  //Se prepara la consulta SQL para eliminar el token
        $stmt->execute(array(':token' => $token));                              //Se ejecuta el token reemplazando :token por "$token" de forma segura
        $drows = $stmt->rowCount();                                             //Se cuenta cuantas filas han sido afectadas (Deberia ser solo 1)
        if ($drows > 0) {                                                       //Si hay mas de 0 filas afectadas
            return "SUCCESS";                                                   //Retornamos un mensaje de SUCCESS conforme ha ido todo bien
        } else {                                                                //Si no han habido filas afectadas
            return "SOMETHING_WENT_WRONG";                                      //Algo ha ido mal con la consulta.
        }
    } else {                                                                    //Si el token es invalido
        return "INVALID_TOKEN";                                                 //Se retorna INVALID_TOKEN
    }
}
/**
 * Recibe la cookie y da true o false si esta o no con una sesion valida.
 * $sesdata = $_COOKIE
 */
function isWebLoggedIn($sesdata)
{
    if (isset($sesdata['token'])) {                                             //Se provee la cookie o la informacion de la sesion, si tiene un token
        if ($sesdata['token'] !== "") {                                         //Y si el token no vale ""
            if (checkTokenStatus($_COOKIE['token']) != "INVALID_TOKEN") {       //Y el token existe
                return true;                                                    //Se devuelve TRUE
            }
        }
    }
    return false;                                                               //Si alguna de las condiciones de arriba no se cumple se retorna false.
}

/**
 * Devuelve true o false si la invitacion es valida o no respectivamente.
 */
function isInviteValid($invite)
{
    require(ROOT . "/functions/db.php");                                    //Se importa la base de datos a la funcion
    $sql = "SELECT * FROM `invitation_codes` WHERE invitation_code = ? AND `uses_left`>0;";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($invite));
    $r = $stmt->fetchAll();
    if (count($r) > 0) {
        return true;
    } else {
        return false;
    }
}

/**
 * Devuelve true o false si la invitacion es valida o no respectivamente.
 */
function inviteInfo($invite)
{
    require(ROOT . "/functions/db.php");                                    //Se importa la base de datos a la funcion
    $sql = "SELECT * FROM `invitation_codes` WHERE invitation_code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($invite));
    $r = $stmt->fetchAll();
    if (count($r) > 0) {
        return $r[0];
    } else {
        return false;
    }
}
