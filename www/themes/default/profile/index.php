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
    <div class="row" style="margin-top: 60px;">
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?php include(ROOT . "/themes/" . $config["theme"] . "/components/left-profile-suggestions.phtml")?>
        </div>
        <div class="col-sm-6" style="padding-top: 10px">
            <div class="card text-left" style="padding: 10px">
                <img class="card-img-top" style="border-radius: 20px" src="https://dummyimage.com/600x200/000/fff&text=Profile+heading" alt="">
              <div class="card-body">
                <h4 class="card-title">@admin</h4>
                <p class="card-text">Name: El puto admin</p>
                <p class="card-text">Gender: <?= lang("war_helicopter") ?></p>
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