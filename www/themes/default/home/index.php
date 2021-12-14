<?php
require(ROOT . "/locale/" . $config["default_lang"] . ".php");      //Cargar idioma
if (isset($_COOKIE['token'])) {                                     //SI EXISTE LA COOKIE CON TOKEN
    $token = $_COOKIE['token'];                                     //GUARDALA EN $token
    if (checkTokenStatus($token) != "INVALID_TOKEN") {              //Si el estado del token no es invalido
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
        redirect();
    }
} else {
    redirect();
}