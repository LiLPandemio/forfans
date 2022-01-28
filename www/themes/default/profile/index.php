<?php
require(ROOT . "/config.php");
require(ROOT . "/locale/" . $config["default_lang"] . ".php");

if (isset($_COOKIE['token'])) {                         //SI EXISTE LA COOKIE CON TOKEN
    $token = $_COOKIE['token'];                         //GUARDALA EN $token
    require_once ROOT . "/functions/authEngine.php";         //IMPORTA LAS FUNCIONES DE AUTENTICACION
    require_once ROOT . "/functions/userEngine.php";         //IMPORTA LAS FUNCIONES DE AUTENTICACION
    if (checkTokenStatus($token) != "INVALID_TOKEN") {  //Si el estado del token no es invalido
        //Cargar informacion del perfil
        $fullpage = $_REQUEST['page'];                                      //La pagina se guarda en $fullpage para dividirla luego en parametros
        $param = preg_split("/\//", $fullpage, -1, PREG_SPLIT_NO_EMPTY);    //$param[n] contiene los parametros siendo N el parametro solicitado.
        if (isset($param[1])) {
            $isMyProfile = false;
            $username = $param[1];
        } else {
            $isMyProfile = true;
            $username = whoami();
        }

        //Mostrar la pagina
?>
        <!-- Aqui puedes añadir contenido exta a head -->

        <!-- Hasta aqui el contenido head -->
        </head>

        <body>
            <!-- Aqui va el contenido principal de la pagina -->
            <!-- Load navbar -->
            <?php require(ROOT . "/themes/" . $config["theme"] . "/components/navbar.phtml"); ?>
            <div class="row" style="margin-top: 80px;">
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?php include(ROOT . "/themes/" . $config["theme"] . "/components/left-profile-suggestions.phtml") ?>
                </div>
                <div class="col-sm-6" style="padding-top: 10px">
                    <div class="card text-left" style="padding: 10px">
                        <img class="card-img-top" style="border-radius: 20px" src="https://www.societyplus.net/upload/photos/d-cover.jpg" alt="">
                        <div style="margin-top: -50px; height:110px; width:110px; object-fit: cover; margin-left: 50px; border-radius: 100px; background-color:white">
                            <img src="https://forfans.societyplus.net//upload/pictures/admin_pfp.jpg" style="height:100px; margin-left: 5px; margin-top: 5px; width:100px; border-radius: 50px" alt="">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">@admin</h4>
                            <p class="card-text">
                                Name: El puto admin <br>
                                Gender: <?= lang("war_helicopter") ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">

                </div>
            </div>
        </body>
<?php
    } else {
        echo "SESSION ERROR X1";
    }
} else {
    echo "SESSION ERROR X2";
}
?>