<?php

header('Content-Type: application/json');   //La api debe retornar todo en JSON
$json = file_get_contents('php://input');   //Obtener parametros enviados en JSON
if ($json == "") {                          //Si no hay cositas en JSON
                                            //Viene en web post y no hay que hacer na
} else {                                    //Pero si vienen cosas en JSON
    $data = json_decode($json, true);       //Decodificame JSON
    $_REQUEST = $data;                      //Y mete todo en el array REQUEST de php
}                                           //Sigue la ejecucion de la api con normalidad

if (isset($param['1'])) {                   //Si existe un segundo parametro para la api (Necesario)
    switch ($param['1']) {                  //Haz x si el parametro vale y
        case 'login':                       //Si la ruta es login
            require_once(ROOT."/functions/authEngine.php");                         //Cargamos las funciones de login
            if (isset($_REQUEST['username']) and isset($_REQUEST['password'])) {    //Si nos envia usuario y contraseña
                echo login($_REQUEST['username'], $_REQUEST['password']);           //Devuelveme el resultado
            } else {                                                                //Si no se enviaron usuario y contraseña
                echo "Not enough params for login provided";                        //Se lanza error por falta de parametros
            }                                                                       //Finaliza el login
            break;                                                                  //Interrumpe el switch
        default:                                                                    //Si no hay coincidencias
            echo "Something went wrong";                                            //Lanzar mesnaje parametro desconocido
            break;                                                                  //Interrumpe el switch
    }
} else {
    echo "Not enough params";
}
