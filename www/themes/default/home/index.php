<?php
require_once(ROOT . "/functions/contentEngine.php");
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
            <div class="row" style="margin-top: 80px; width:100%">
                <div class="col-sm-3">

                    <!-- Include suggestions at left -->
                    <?php include(ROOT . "/themes/" . $config["theme"] . "/components/left-profile-suggestions.phtml") ?>

                </div>
                <div class="col-sm-8" style="overflow:scroll ">
                    <div class="title-wrapper" style="padding:10px">
                        <div id="accordion-newpost">

                            <div data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree" class="title-wrapper" style="padding:10px; padding-top: 0px;">
                                <ul style="cursor:pointer" class="breadcrumb">
                                    <li>¿Inspirado? ¡Publica algo!</li>
                                </ul>
                            </div>

                            <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion-newpost">
                                <div class="card card-body" style="padding-top: 0px;">
                                    Menu para posts pronto
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $posts = getPublicPosts();
                    for ($i = 0; $i < count($posts); $i++) {
                        $post = $posts[$i];
                        $img_array = json_decode($post["post_img_array"]);
                    ?>

                        <div style="padding: 0; min-height: 160px" class="card text-left post-body">
                            <div style="flex:5" class="card-body">
                                <?php
                                if ($img_array != "") {
                                    for ($j = 0; $j < count($img_array); $j++) {
                                ?>
                                        <img style="object-fit:cover; margin: 10px; margin-top:10px; border-radius: 5px; width:95%" src="<?php echo $img_array[$j] ?>" alt="POST">
                                <?php
                                    }
                                }

                                ?>
                            </div>
                            <div class="card-body" style="display:flex; flex-direction:row; flex:9">
                                <img class="avatar" style="border-radius: 50px; height: 50px; width: 50px" src="<?= $config["fullsiteurl"] . $post["profile_picture_rpath"] ?>" alt="">
                                <div style="display:flex; flex-direction:column; margin-left:10px; max-height: 40px">
                                    <div style="height: 50%;">
                                        <p class="card-text">@<?= $post["username"] ?></p>
                                    </div>
                                    <div style="height: 50%;">
                                        <a class="badge badge-primary" href="#"><?php echo howManyPostsHasUsername($post['username']) ?> Posts</a>
                                        <a class="badge badge-danger" href="#">Suscribirse</a>
                                        <a class="badge badge-success" href="#">Donado $<?= $post["post_donations"] ?></a>
                                        <a class="badge badge-accent" href="#">Seguir</a>
                                    </div>
                                    <div style="margin-top:25px; margin-left:-60px">
                                        <?= $post["post_text"] ?>
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
                            <div class="card-body subs ccard" style="padding-top: 0px;">
                                <?php for ($i = 0; $i < 4; $i++) { ?>
                                    <img class="avatar sub-item" style="border-radius: 50px; height: 50px; width: 50px" src="https://cataas.com/cat/says/<?php echo rand(1, 5000) ?>" alt="">
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
