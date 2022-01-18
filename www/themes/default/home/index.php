<?php
require(ROOT . "/locale/" . $config["default_lang"] . ".php");      //Cargar idioma
if (isset($_COOKIE['token'])) {                                     //SI EXISTE LA COOKIE CON TOKEN
    $token = $_COOKIE['token'];                                     //GUARDALA EN $token
    if (checkTokenStatus($token) != "INVALID_TOKEN") {              //Si el estado del token no es invalido
        //Mostrar la pagina
?>
        <!-- Aqui puedes añadir contenido exta a head -->
        <link rel="stylesheet" href="<?= $config["fullsiteurl"] . "themes/" . $config["theme"] . "/home/" . "index" ?>.css">

        <!-- Hasta aqui el contenido head -->
        </head>

        <body>
            <!-- Aqui va el contenido principal de la pagina -->
            <!-- Load navbar -->
            <?php require(ROOT . "/themes/" . $config["theme"] . "/components/navbar.phtml"); ?>
            <div class="row" style="width:100%">
            </div>
            <div class="row" style="margin-top: 60px; width:100%">
                <div class="col-sm-3">

                    <div id="accordion">
                        <div data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="title-wrapper" style="padding:10px">
                            <ul style="cursor:pointer" class="breadcrumb">
                                <li>Perfiles sugeridos</li>
                            </ul>
                        </div>

                        <div id="collapseOne" class="collapse hide" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body" style="padding-top: 0px;">
                                <?php for ($i = 0; $i < 4; $i++) { ?>
                                    <a href="#">
                                        <div class="card text-left" style="margin-bottom: 10px; margin-left: 10px; margin-right: 10px;">
                                            <div class="card-body" style="display: flex; flex-direction: row;">
                                                <img class="avatar" style="border-radius: 50px; height: 50px; width: 50px" src="https://cataas.com/cat" alt="">
                                                <div style="display:flex; flex-direction:column; margin-left:10px">
                                                    <div style="height: 50%;">
                                                        <p class="card-text">@admin</p>
                                                    </div>
                                                    <div style="height: 50%;">
                                                        <a style="margin:2px" class="badge badge-primary" href="#">12 Posts</a>
                                                        <a style="margin:2px" class="badge badge-success" href="#">Suscribirse</a>
                                                        <a style="margin:2px" class="badge badge-accent" href="#">Seguir</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8" style="overflow:scroll ">
                    <div class="title-wrapper" style="padding:10px">
                        <ul class="breadcrumb">
                            <li>Noticias!</li>
                        </ul>
                    </div>
                    <?php for ($i = 0; $i < 4; $i++) { ?>

                        <div style="padding: 0;" class="card text-left post-body">
                            <div style="flex:5" class="card-body">
                                <img style="object-fit:cover; margin: 10px; margin-top:0px; border-radius: 5px; width:95%" src="https://cataas.com/cat/says/Post!<?php echo rand(1, 5000) ?>" alt="POST">
                            </div>
                            <div class="card-body" style="display:flex; flex-direction:row; flex:9">
                                <img class="avatar" style="border-radius: 50px; height: 50px; width: 50px" src="https://cataas.com/cat/says/Profile!" alt="">
                                <div style="display:flex; flex-direction:column; margin-left:10px; max-height: 40px">
                                    <div style="height: 50%;">
                                        <p class="card-text">@admin</p>
                                    </div>
                                    <div style="height: 50%;">
                                        <a class="badge badge-primary" href="#">12 Posts</a>
                                        <a class="badge badge-success" href="#">Suscribirse</a>
                                        <a class="badge badge-accent" href="#">Seguir</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-sm-1">
                    <div class="dynFlexHV Subs" id="accordion-subs">
                        <div data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" class="title-wrapper" style="padding:10px; padding-top: 0px;">
                            <ul style="cursor:pointer" class="breadcrumb">
                                <li>Subs</li>
                            </ul>
                        </div>

                        <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion-subs">
                            <div class="card-body" style="padding-top: 0px;">
                                <?php for ($i = 0; $i < 4; $i++) { ?>
                                    <img class="avatar sub-item" style="margin-left: 10px; border-radius: 50px; height: 50px; width: 50px" src="https://cataas.com/cat" alt="">
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Espacio necesario para que en la version movil no se solapen los menus -->
            <div class="separator" style="margin-top: 80px;"></div>
        </body>
<?php
    } else {
        redirect();
    }
} else {
    redirect();
}
