<?php

/**
 * Obtiene la cantidad de posts publicos que quieras, amount no esta filtrado y HA DE SER INT
 */
function getPublicPosts($amount = 5)
{
    //TODO: SANITIZE $AMOUNT
    require(ROOT . "/functions/db.php");    //Se importa la base de datos
    //Preparamos la consulta SQL con 5 por defecto
    $stmt = $conn->prepare("SELECT `posts`.*, `usuarios`.* FROM `posts` LEFT JOIN `usuarios` ON `posts`.`user_id` = `usuarios`.`id_usuarios` ORDER BY `posts`.`post_id` DESC LIMIT $amount");
    $stmt->execute();                       //Se ejecuta la consulta
    $result = $stmt->fetchAll();            //Se exporta el resultado a un arreglo bidimensional
    $drows = $stmt->rowCount();             //Se cuenta cuantas filas hay
    if ($drows < 1) {                       //Si hay menos de 1
        return "NO_POSTS_FOUND";            //Se indica que NO HAY POSTS encontrados
    } else {                                //En caso contrario
        return $result;                     //Entregamos los posts
    }
}

/**
 * Indica la cantidad de publicaciones que tiene un usuario (INT)
 */
function howManyPostsHasUsername($username)
{
    require(ROOT . "/functions/db.php");        //Se importa la base de datos
    //Prepara la consulta con un vacio en el nombre de usuario
    $stmt = $conn->prepare("SELECT `posts`.*, `usuarios`.* FROM `posts` LEFT JOIN `usuarios` ON `posts`.`user_id` = `usuarios`.`id_usuarios` WHERE `username` = ?");
    $stmt->execute(array($username));           //Reemplaza de forma segura el nombre de usuario. 
    $drows = $stmt->rowCount();                 //Contamos cuantas filas han salido
    return $drows;                              //Retorna el valor
}
