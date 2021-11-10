<?php

if (isset($param['1'])) { //Si existe un segundo parametro para la api
    switch ($param['1']) {
        case 'login':
            //provide user pass via post and login
            if (isset($_POST['username']) and isset($_POST['password'])) {
                echo login($_POST['username'], $_POST['password']);
            } else {
                # code...
            }
            
            break;
        
        default:
            echo "something went wrong";
            break;
    }
} else {
    echo "Not enough params";
}

?>