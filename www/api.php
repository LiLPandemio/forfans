<?php
//La api debe retornar todo en JSON
header('Content-Type: application/json');


if (isset($param['1'])) { //Si existe un segundo parametro para la api
  

    switch ($param['1']) {
        case 'login':
            require_once(ROOT."/functions/authEngine.php");
            //Do es el parametro en REQUEST que define que hay que hacer refernete a 
            //provide user pass via post and login
            if (isset($_REQUEST['username']) and isset($_REQUEST['password'])) {
                echo login($_REQUEST['username'], $_REQUEST['password']);
            }
            
            break;
        
        
        default:
            echo "Something went wrong";
            break;
    }
} else {
    echo "Not enough params";
}

?>