<?php
/*
*Para devolver valores en JSON:
$response = array('hash' => $hash);
echo json_encode($response);
*/
header('Content-Type: application/json');                                           //La api debe retornar todo en JSON
$json = file_get_contents('php://input');                                           //Obtener parametros enviados en JSON
if ($json == "") {                                                                  //Si no hay cositas en JSON
    //Viene en web post y no hay que hacer na
} else {                                                                            //Pero si vienen cosas en JSON
    $data = json_decode($json, true);                                               //Decodificame JSON
    $_REQUEST = $data;                                                              //Y mete todo en el array REQUEST de php
}                                                                                   //Sigue la ejecucion de la api con normalidad
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
            require_once(ROOT . "/functions/authEngine.php");                       //Cargamos las funciones de login
            if (isset($_REQUEST['username']) and isset($_REQUEST['password'])) {    //Si nos envia usuario y contraseña
                $response = login($_REQUEST['username'], $_REQUEST['password']);    //Devuelveme el resultado
            } else {                                                                //Si no se enviaron usuario y contraseña
                $response = array('response' => "Not enough params for login provided"); //Se lanza error por falta de parametros
            }                                                                       //Finaliza el login
            echo json_encode($response);
            break;                                                                  //Interrumpe el switch
        default:                                                                    //Si no hay coincidencias
            echo "Something went wrong";                                            //Lanzar mesnaje parametro desconocido
            break;                                                                  //Interrumpe el switch
    }
} else {
    echo "Not enough params";
}
