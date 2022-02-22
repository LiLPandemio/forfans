<?php
/*
*Para devolver valores en JSON:
$response = array('hash' => $hash);
echo json_encode($response);
*/
// $json = file_get_contents('php://input');
// if ($json == "") {
//     //Do not replace with json, its web post
// } else {
//     //Request comes in json
//     $data = json_decode($json, true);
//     $_REQUEST = $data;
// }
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
        case "post":
            require_once(ROOT . "/functions/db.php");                               //INCLUYENDO FUNCIONES NECESARIAS
            require_once(ROOT . "/functions/userEngine.php");                       //INCLUYENDO FUNCIONES NECESARIAS
            require_once(ROOT . "/functions/utils1.php");                           //INCLUYENDO FUNCIONES NECESARIAS
            //Create a post;
            ob_flush();                                                             //Limpia todo el output
            ob_start();                                                             //Graba el output

            $response = array();                                                    //Prepara un arreglo para el JSON Que se le enviara al cliente
            $post_text = $_REQUEST["postTextTextarea"];                             //Se almacena el valor en una variable
            $post_nsfw = $_REQUEST["newPostIsNSFW"];                                //Se almacena el valor en una variable
            $post_free = $_REQUEST["newPostIsPublic"];                              //Se almacena el valor en una variable
            $images = [];                                                           //Arreglo de fotos para luego añadir los paths y exportarlos a la BDD
            if (isset($_FILES[0])) {                                                //Si hay archivos subidos
                if (($_FILES[0]['name'] != "")) {                                   //Y los archivos no tienen el nombre en blanco
                    array_push($response, array('INFO' => "CHECKING FILES"));       //Se notifica el proceso de imagenes.
                    for ($i = 0; $i < count($_FILES); $i++) {                       //Por cada archivo i...
                        $target_dir = "upload/pictures/";                           //Se guardaran en la carpeta upload/pictures/
                        $file = $_FILES[$i]['name'];                                //El archivo a tratar es el i
                        $path = pathinfo($file);                                    //Se saca la ubicacion fisica del archivo
                        $filename = $path['filename'];                              //El nombre del archivo
                        $ext = $path['extension'];                                  //La extension
                        $temp_name = $_FILES[$i]['tmp_name'];                       //y la carpeta donde esta ubicado durante la subida

                        if (is_image($temp_name) == false) {                //Si no es una imagen
                            array_push($response, array('error' => $_FILES[$i]['name'] . " IS NOT AN IMAGE")); //Solo notificamos al usuario
                        } else {                                            //Pero si es una imagen
                            array_push($response, array('success' => $_FILES[$i]['name'] . " IS AN IMAGE"));    //Notificamos al usuario
                            $path_filename_ext_webp = $target_dir . md5_file($temp_name) . ".webp";             //Se prepara su ubicacion
                            $image = imagecreatefromstring(file_get_contents($temp_name));                      //Se convierte a cadena te texto la imagen
                            if ($image == false) {                                                              //Si el archivo vale falso NO ES UNA IMAGEN
                                array_push($response, array('error' => $_FILES[$i]['name'] . " COULD NOT BE LOADED")); //Se notifica al usuario
                            } else {                                                                            //Si no es false, es una GDImage
                                imagewebp($image, $target_dir . md5_file($temp_name) . "." . "webp", 80);       //Se exporta la GDImage a webp (Mas ligero)
                            }
                            array_push($images, "{fullsiteurl}" . $path_filename_ext_webp);                          //Se añade al array de fotos la imagen webp
                        }    //El archivo ha sido subido
                    }    //Todos los archivos han sido procesados
                }
            }
            array_push($response, array('INFO' => "CHECKING POST DATA"));           //Se notifica que inicia el saneo de los datos

            $post_text = htmlspecialchars($post_text);                              //Se codifican los simbolos especiales HTML en codigo HTML (& => &amp;)
            $post_text = stripslashes($post_text);                                  //Se eliminan caracteres "'//\\'"
            $post_text = trim($post_text);                                          //Se eliminan los dobles espacios en blanco y al principio y final

            array_push($response, array('FILES_INCLUDED' => count($images) > 0));    //SE INFORMA DE SI HAY ARCHIVOS
            array_push($response, array('TEXT_INCLUDED' => $post_text != ""));      //SE INFORMA DE SI HAY TEXTO

            if (count($images) > 0 or $post_text != "") {                            //Si hay texto o imagenes validos
                array_push($response, array('INFO' => "CREATING POST"));            //Se notifica al usuario de que se empieza a crear la publicacion
                $post_img_array = json_encode($images);                             //Las imagenes se convierten en JSON para guardarse y servirse posteriormente
                $id = myid();                                                       //Se prepara el ID del usuario que publica

                if (count($images) > 0) {                                           //Si hay imagenes, se prepara esta consulta
                    array_push($response, array('INFO' => "DETECTED IMAGES: " . count($images)));
                    $sql = "INSERT IGNORE INTO `posts` (`post_id`, `user_id`, `for_id`, `post_text`, `is_nsfw`, `post_img_array`, `post_video_array`,
            `post_file_array`, `post_audio_array`, `post_gif_array`, `for_fans`, `for_everyone`, `post_time`, `post_donations`, `post_removed`) VALUES 
            (NULL, :userid, NULL, :posttext, :isnsfw, :postimgarray, NULL, NULL, NULL, NULL, NULL, :forall, NULL, '0.00', '0')";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':userid', $id);
                    $stmt->bindParam(':posttext', $post_text);
                    $stmt->bindParam(':isnsfw', $post_nsfw);
                    $stmt->bindParam(':forall', $post_free);
                    $stmt->bindParam(':postimgarray', $post_img_array);
                } else {                                                            //Si no hay imagenes, se prepara esta
                    array_push($response, array('INFO' => "DETECTED IMAGES: " . count($images)));
                    $sql = "INSERT IGNORE INTO `posts` (`post_id`, `user_id`, `for_id`, `post_text`, `is_nsfw`, `post_img_array`, `post_video_array`,
            `post_file_array`, `post_audio_array`, `post_gif_array`, `for_fans`, `for_everyone`, `post_time`, `post_donations`, `post_removed`) VALUES 
            (NULL, :userid, NULL, :posttext, :isnsfw, NULL, NULL, NULL, NULL, NULL, NULL, :forall, NULL, '0.00', '0')";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':userid', $id);
                    $stmt->bindParam(':posttext', $post_text);
                    $stmt->bindParam(':isnsfw', $post_nsfw);
                    $stmt->bindParam(':forall', $post_free);
                }
                $res = $stmt->execute();                                            //Se ejecuta la consulta preparada
                $err = $stmt->errorCode();                                          //El SQLSTATE code se guarda en $err
                array_push($response, array('MYSQL STATUS' => $err));               //Se envia el SQLSTATE al usuario (DEBUG)
            } else {                                                                //Si no se provee de contenido valido
                array_push($response, "INVALID CONTENT PROVIDED.");                 //Se notifica al usuario
            }
            file_put_contents("dump.txt", ob_get_flush());  //El otput se guarda en dump.txt
            echo json_encode($response);                    //Se saca la respuesta en JSON
            break;
        case "update":
            //REQUIRE LOGIN
            require_once(ROOT . "/functions/userEngine.php");
            switch ($param[2]) {
                case 'theme_variable':
                    if (isset($_REQUEST['newTheme']) and isset($_REQUEST['token'])) {
                        if ($_REQUEST['newTheme'] == "cyborg" || $_REQUEST['newTheme'] == "darkly" || $_REQUEST['newTheme'] == "minty" || $_REQUEST['newTheme'] == "litera" || $_REQUEST['newTheme'] == "quartz") {
                            if (checkTokenStatus($_REQUEST['token'] != "INVALID_TOKEN" and $_REQUEST['token'] !=  "TOKEN_EXPIRED")) {
                                setUser__default_theme_variable(whoami($_REQUEST['token']), $_REQUEST['newTheme']);
                                $response = array('OK' => "Theme updated successfully");
                                echo json_encode($response);
                            } else {
                                $response = array('error' => "Token provided invalid");
                                echo json_encode($response);
                            }
                        } else {
                            $response = array('error' => "Theme provided invalid");
                            echo json_encode($response);
                        }
                    } else {
                        $response = array('error' => "Missing theme and/or token");
                        echo json_encode($response);
                    }
                    break;
                default:
                    # code...
                    break;
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
