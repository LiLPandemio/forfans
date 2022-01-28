<?php

/**
 * Obtiene la cantidad de posts publicos que quieras, amount no esta filtrado y HA DE SER INT
 */
function getPublicPosts($amount = 5){
    require(ROOT . "/functions/db.php");
    $stmt = $conn->prepare("SELECT `posts`.*, `usuarios`.* FROM `posts` LEFT JOIN `usuarios` ON `posts`.`user_id` = `usuarios`.`id_usuarios` ORDER BY `posts`.`post_id` DESC LIMIT $amount");
    $stmt->execute();
    $result = $stmt->fetchAll();
    $drows = $stmt->rowCount();
    if ($drows < 1) {
        return "NO_POSTS_FOUND";
    } else {
        return $result;
    }
    
}

function howManyPostsHasUsername($username){
    require(ROOT . "/functions/db.php");
    $stmt = $conn->prepare("SELECT `posts`.*, `usuarios`.* FROM `posts` LEFT JOIN `usuarios` ON `posts`.`user_id` = `usuarios`.`id_usuarios` WHERE `username` = ?");
    $stmt->execute(array($username));
    $drows = $stmt->rowCount();
    return $drows;
}