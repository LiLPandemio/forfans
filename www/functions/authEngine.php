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
                    return "PASS_OK";
                } else {
                    return "WrongPassword";
                }
            } else {
                return "UserNotFound";
            }
        } else {
            return "MissingPassword";
        }
    } else {
        return "MissingUsername";
    }
}

//*Esta funcion genera un token aleatorio de 80 caracteres
function tokenGenerator()
{
    $token = openssl_random_pseudo_bytes(80);
    $token = bin2hex($token);
    return $token;
}
