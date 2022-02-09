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
 * Obtiene la cantidad de posts publicos de un usuario especifico que quieras
 */
function getUserPublicPosts($amount = 5, $username)
{
    //TODO: SANITIZE $AMOUNT
    require(ROOT . "/functions/db.php");    //Se importa la base de datos
    //Preparamos la consulta SQL con 5 por defecto
    $stmt = $conn->prepare("SELECT `posts`.*, `usuarios`.* FROM `posts` LEFT JOIN `usuarios` ON `posts`.`user_id` = `usuarios`.`id_usuarios` WHERE `usuarios`.`username` = ? ORDER BY `posts`.`post_id` DESC LIMIT 10;");
    $stmt->execute(array($username));      //Se ejecuta la consulta
    $result = $stmt->fetchAll();                    //Se exporta el resultado a un arreglo bidimensional
    $drows = $stmt->rowCount();                     //Se cuenta cuantas filas hay
    if ($drows < 1) {                               //Si hay menos de 1
        return "NO_POSTS_FOUND";                    //Se indica que NO HAY POSTS encontrados
    } else {                                        //En caso contrario
        return $result;                             //Entregamos los posts
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

/**
 * Funcion para crear publicaciones. Es obligatorio pasar el id del usuario que crea el post y almenos un parametro opcional
 */
function createPost($user_id, $for_id = NULL, $post_text = NULL, $isNSFW = false, $post_img_array = NULL, $post_video_array = NULL, $post_file_array = NULL, $post_audio_array = NULL, $post_gif_array = NULL, $for_fans = false, $for_everyone = true)
{
    require(ROOT . "/functions/db.php");
    $sql = "INSERT INTO `posts` (`post_id`, `user_id`, `for_id`, `post_text`, `is_nsfw`, `post_img_array`, `post_video_array`, `post_file_array`, `post_audio_array`, `post_gif_array`, `for_fans`, `for_everyone`, `post_time`, `post_donations`, `post_removed`) VALUES 
    (NULL, :userid, :forid, :posttext, :nsfw, :post_img_array, :post_video_array, :post_file_array, :post_audio_array, :post_gif_array, :forfans, :for_everyone, current_timestamp(), '0.00', '0');";
    $sth = $conn->prepare($sql);
    //$sth->execute(array(':ip' => $IP, ':token' => $TOKEN, ':userid' => intval($UID)));
    $sth->execute(array(
        ':userid' => $user_id,
        ':forid' => $for_id,
        ':posttext' => $post_text,
        ':nsfw' => $isNSFW,
        ':post_img_array' => $post_img_array,
        ':post_video_array' => $post_video_array,
        ':post_file_array' => $post_file_array,
        ':post_audio_array' => $post_audio_array,
        ':post_gif_array' => $post_gif_array,
        ':forfans' => $for_fans,
        ':for_everyone' => $for_everyone,
    ));
}

/**
 * Indica la cantidad de publicaciones que tiene un usuario (INT)
 */
function displayPostByID($pid)
{
?>
    <!-- SPAWN A POST -->
<?php
}
