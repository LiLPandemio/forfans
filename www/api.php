<?php
/*
*Para devolver valores en JSON:
$response = array('hash' => $hash);
echo json_encode($response);
*/
header('Content-Type: application/json');                                           //La api debe retornar todo en JSON
if (isset($param['1'])) {                                                           //Si existe un segundo parametro para la api (Necesario)
    switch ($param['1']) {                                                          //Haz x si el parametro vale y
        case 'hash':                                                                //Si se solicita la seccion hash de api
            if (isset($_REQUEST['password'])) {                                     //Y existe la variable PASSWORD en la peticion
                $response = array('hash' => password_hash($_REQUEST['password'], PASSWORD_DEFAULT)); //Definimos la respuesta
            } else {                                                                //Si no se ha dado un parametro password
                $response = array('hash' => "Error");                               //Definimos la respuesta
            }
            echo json_encode($response);                                            //Entregamos la respuesta
            break;                                                                  //Interrumpe el switch
        case 'login':                                                               //Si la ruta es login
            if (isset($_REQUEST['username']) and isset($_REQUEST['password'])) {    //Si nos envia usuario y contraseña
                $response = array("response" => login($_REQUEST['username'], $_REQUEST['password']));    //Devuelveme el resultado
            } else {                                                                //Si no se enviaron usuario y contraseña
                $response = array('response' => "Not enough params for login provided"); //Se lanza error por falta de parametros
            }                                                                       //Finaliza el login
            echo json_encode($response);
            break;                                                                  //Interrumpe el switch
        case 'checklogin':                                                          //Comprobar el estado del token
            if (isset($_REQUEST['token'])) {                                        //Si recibimos un token
                if ($_REQUEST['token'] !== "") {                                    //Y el token no esta vacio
                    $tokenStatus = checkTokenStatus($_REQUEST['token']);            //Se lanza la funcion de comprobacion del token con el token provisto
                    if ($tokenStatus == "INVALID_TOKEN") {
                        $response = array('response' => "InvalidToken");
                    } else {
                        $response = array(
                            'response' => 'TOKEN_OK',
                            'user_id' => $tokenStatus,
                        );
                    }
                } else {
                    $response = array("response" => "ErrorTokenEmpty");
                }
                echo json_encode($response);
                break;
            } else {
                # 
            }
            break;
        case "update":
            //REQUIRE LOGIN
            require_once(ROOT . "/functions/userEngine.php");
            if (isWebLoggedIn($_COOKIE) || isset($_REQUEST['token'])) {
                switch ($param[2]) {
                    case 'theme_variable':
                        if (isset($_REQUEST['newTheme'])) {
                            if ($_REQUEST['newTheme'] == "cyborg" || $_REQUEST['newTheme'] == "darkly" || $_REQUEST['newTheme'] == "minty" || $_REQUEST['newTheme'] == "litera" || $_REQUEST['newTheme'] == "quartz") {
                                //Update theme
                                var_dump(setUser__default_theme_variable(whoami("TOKEN_MANUAL"), $_REQUEST['newTheme']));
                            } else {
                                $response = array('Error' => "Your theme is not valid");
                                echo json_encode($response);
                            }
                        } else {
                            $response = array('Error' => "Provide a theme via POST JSON");
                            echo json_encode($response);
                        }
                        break;
                    default:
                        # code...
                        break;
                }
            } else {
                $response = array('Error' => "Not logged in");
                echo json_encode($response);
            }

        case "test":
            break;
        default:                                                                    //Si no hay coincidencias
            $response = array("response" => "Something went wrong");
            echo json_encode($response);
            break;                                                                  //Interrumpe el switch
    }
} else {
    echo "Not enough params";
}
