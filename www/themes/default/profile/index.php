<?php
require(ROOT . "/config.php");
require(ROOT . "/locale/" . $config["default_lang"] . ".php");

if (isset($_COOKIE['token'])) {                         //SI EXISTE LA COOKIE CON TOKEN
    $token = $_COOKIE['token'];                         //GUARDALA EN $token
    require_once ROOT . "/functions/authEngine.php";         //IMPORTA LAS FUNCIONES DE AUTENTICACION
    if (checkTokenStatus($token) != "INVALID_TOKEN") {  //Si el estado del token no es invalido
        //Cargar informacion del perfil
        $fullpage = $_REQUEST['page'];                                      //La pagina se guarda en $fullpage para dividirla luego en parametros
        $param = preg_split("/\//", $fullpage, -1, PREG_SPLIT_NO_EMPTY);    //$param[n] contiene los parametros siendo N el parametro solicitado.
        if (isset($param[1])){
            $isMyProfile = false;
        } else {
            $isMyProfile = true;
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
    <div class="row">
    </div>
    <div class="row">
        <div style="background-color: #ff8888;" class="col-sm-3">
            Menu template
        </div>
        <div style="background-color: #88ff88;" class="col-sm-6">
            Main content template
        </div>
        <div style="background-color: #8888ff;" class="col-sm-3">
            Menu template
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