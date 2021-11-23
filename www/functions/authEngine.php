<?php
// Este archivo contine las funciones que se usan para autenticar a un usuario, getionar las cuentas eliminar crear etc.

//*Esta funcion devuelve un token o false si las credenciales no coinciden
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

//*Esta funcion genera un token aleatorio de 80 caracteres
function tokenGenerator()
{
    $token = openssl_random_pseudo_bytes(60);
    $token = bin2hex($token);
    return $token;
}
