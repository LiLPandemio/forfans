<?php
//Auth required!
require(ROOT . "/config.php");
require(ROOT . "/locale/" . $config["default_lang"] . ".php");

if (isset($_COOKIE['token'])) {                         //SI EXISTE LA COOKIE CON TOKEN
    $token = $_COOKIE['token'];                         //GUARDALA EN $token
    require_once ROOT . "/functions/authEngine.php";         //IMPORTA LAS FUNCIONES DE AUTENTICACION
    if (checkTokenStatus($token) != "INVALID_TOKEN") {  //Si el estado del token no es invalido
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
            </div>
            <div class="row">
                <div class="col-sm-3" style="padding-left: 50px;">
                    <div class="card text-left post-body" style="padding:12px; margin-bottom:4px">Basic info</div>
                    <div class="card text-left post-body" style="padding:12px; margin-bottom:4px">Security</div>
                </div>
                <div class="col-sm-8">
                    <div class="card text-left post-body">
                        <div class="row">
                            <div class="col-sm-6">A</div>
                            <div class="col-sm-6">A</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-1">

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
