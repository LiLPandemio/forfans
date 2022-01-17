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
            <div class="row">
            </div>
            <div class="row" style="margin-top: 60px;">
                <div class="col-sm-3">
                    <div class="collapse" id="collapseExample"> 
                        <!-- TODO: COLLAPSE SUGGESTIONS FOR MOBILE! -->

                        <div class="title-wrapper" style="padding:10px">
                            <ul class="breadcrumb">
                                <li>Perfiles sugeridos</li>
                            </ul>
                        </div>
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
                <div class="col-sm-8" style="overflow:scroll ">
                    <div class="title-wrapper" style="padding:10px">
                        <ul class="breadcrumb">
                            <li>Noticias!</li>
                        </ul>
                    </div>
                    <?php for ($i = 0; $i < 4; $i++) { ?>

                        <div style="padding: 0;" class="card text-left post-body">
                            <div style="flex:5" class="card-body">
                                <img style="object-fit:cover; margin: 10px; margin-top:0px; border-radius: 5px; width:95%; max-height:800px; max-width:800px" src="https://cataas.com/cat/says/Post!<?php echo rand(1, 5000)?>" alt="POST">
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
                    <div class="dynFlexHV Subs">
                        <?php for ($i = 0; $i < 4; $i++) { ?>
                            <img class="avatar sub-item" style="margin-left: 10px; border-radius: 50px; height: 50px; width: 50px" src="https://cataas.com/cat" alt="">
                        <?php } ?>
                    </div>
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
