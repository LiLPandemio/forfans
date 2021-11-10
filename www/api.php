<?php

if (isset($param['1'])) { //Si existe un segundo parametro para la api
    switch ($param['1']) {
        case 'login':
            require_once(ROOT."/functions/authEngine.php");
            //provide user pass via post and login
            if (isset($_REQUEST['username']) and isset($_REQUEST['password'])) {
                echo login($_REQUEST['username'], $_REQUEST['password']);
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