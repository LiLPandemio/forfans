<?php
// Este archivo contine las funciones que se usan para autenticar a un usuario, getionar las cuentas eliminar crear etc.

//*Esta funcion devuelve un token o false si las credenciales no coinciden
function login($username, $password){
    require_once(ROOT. "/functions/db.php");                        //Importar la base de datos
    $username = str_replace(" ", "", $username);                    //Limpiar espacios en blanco
    if ($username !== "") {                                         //Si el nombe de usuario no esta en blanco
        if ($password !== "") {                                     //Y la contraseña no esta en blanco
            
            //Comprobar login
            $stmt = $conn->prepare("SELECT * FROM 'usuarios' WHERE `correo` = ?");  //Buscar en la BD
            $stmt->bind_param("s", $username);                                      //Por el correo

            $user = $stmt->count();

            var_dump($user);
            
        } else {
            json_encode(array("response" => "username_password"));
        }
        
    } else {
        json_encode(array("response" => "username_error"));
    }
    
}
