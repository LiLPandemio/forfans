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
                                <ul style="cursor:pointer; text-align: center; width: 100%" class="breadcrumb">
                                    <li style="text-align: center; width: 100%">¿Inspirado? ¡Publica algo!</li>
                                </ul>
                            </div>

                            <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" style="margin-bottom: 10px;" data-parent="#accordion-newpost">
                                <div class="card card-body" style="padding:20px;">
                                    <div style="text-align: center;">
                                        <label for="postTextTextarea">Texto de la publicacion</label>
                                        <p id="tooLongTextWarn" style="display:none" class="text-danger">El texto es demasiado largo. Limite de 1200 caracteres.</p>
                                        <textarea onkeydown="controlInput()" onkeyup="controlInput()" onchange="controlInput()" placeholder="Publica lo que quieras! #Anime #Hentai #xXx" class="form-control" id="postTextTextarea" rows="3" style="background-color: var(--bs-body-bg); color: var(--bs-body-color)"></textarea>
                                    </div>
                                    <script>
                                        function controlInput() {
                                            let text = $("#postTextTextarea").val();
                                            if (text.length > 1200) {
                                                $("#chars-left-btn").addClass("btn-outline-danger");
                                                $("#chars-left-btn").removeClass("btn-outline-warning");
                                                $("#chars-left-btn").removeClass("btn-outline-success");
                                                $("#tooLongTextWarn").show();
                                            } else {
                                                $("#tooLongTextWarn").hide();
                                                $("#chars-left-btn").removeClass("btn-outline-danger");
                                                if (text.length > 1000) {
                                                    // WARN
                                                    $("#chars-left-btn").addClass("btn-outline-warning");
                                                    $("#chars-left-btn").removeClass("btn-outline-success");
                                                } else {
                                                    // OK
                                                    $("#chars-left-btn").addClass("btn-outline-success");
                                                    $("#chars-left-btn").removeClass("btn-outline-warning");
                                                    console.log("OK");
                                                }
                                            }
                                            $("#chars-left").html(text.length);
                                        }
                                    </script>
                                    <div style="margin-top: 10px; text-align:center">
                                        <button type="button" class="btn btn-sm btn-primary"><i class="fa fa-camera" aria-hidden="true"></i> Add Content</button>
                                        <button type="button" class="btn btn-sm btn-primary"><i class="fa fa-sticky-note" aria-hidden="true"></i> Add Gif</button>
                                        <button type="button" id="chars-left-btn" disabled class="btn btn-sm btn-outline-success"><i class="fa fa-font" aria-hidden="true"></i> <span id="chars-left">0</span></button>
                                    </div>
                                    <span style="margin-top: 10px; display:flex; flex-direction:row">
                                        <span style="position: relative; top:5px">
                                            <p>NSFW Content&nbsp;&nbsp;&nbsp;</p>
                                        </span>
                                        <label class="form-check-label switch">
                                            <input class="form-check-input" name="newPostIsNSFW" id="newPostIsNSFW" value="checkedValue" type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                    </span>
                                    <span style="margin-top: 10px; display:flex; flex-direction:row">
                                        <span style="position: relative; top:5px">
                                            <p>Public Content&nbsp;&nbsp;&nbsp;</p>
                                        </span>
                                        <label class="form-check-label switch">
                                            <input class="form-check-input" name="newPostIsPublic" id="newPostIsPublic" value="checkedValue" type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                    </span>
                                    <button type="button" style="margin-top: 5px; width:60%; margin-left:20%" class="btn btn-primary">Publicar</button>
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
                                <?php
                                if ($img_array != "") {
                                ?>
                                    <div style="flex:5" class="card-body">
                                        <?php

                                        for ($j = 0; $j < count($img_array); $j++) {
                                        ?>
                                            <img style="object-fit:cover; margin: 10px; margin-top:10px; border-radius: 5px; width:95%" src="<?php echo $img_array[$j] ?>" alt="POST">
                                        <?php
                                        }
                                        ?>
                                    </div>

                                <?php

                                } else {

                                ?>
                                    <div style="flex:3" class=""></div>
                                <?php

                                }

                                ?>
                                <div class="card-body" style="display:flex; flex-direction:row; flex:6">
                                    <img class="avatar" style="border-radius: 50px; height: 50px; width: 50px; margin-right:10px;" src="<?= $config["fullsiteurl"] . $post["profile_picture_rpath"] ?>" alt="">
                                    <div style="flex-wrap: wrap;">
                                        <div class="post-info-about" style="max-height: 40px">
                                            <div style="height: 50%;">
                                                <p class="card-text">@<?= $post["username"] ?></p>
                                            </div>
                                            <div style="height: 50%;">
                                                <a class="badge badge-primary" href="#"><?php echo howManyPostsHasUsername($post['username']) ?> Posts</a>
                                                <a class="badge badge-danger" href="#">Suscribirse</a>
                                                <a class="badge badge-success" href="#">Donado $<?= $post["post_donations"] ?></a>
                                                <a class="badge badge-accent" href="#">Seguir</a>
                                            </div>
                                        </div>
                                        <div style="flex: 1 1 250px; margin-top:40px; margin-left:-50px">
                                            <?= $post["post_text"] ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if ($img_array !== "") {
                                ?>
                                    <div style="flex:3" class=""></div>
                                <?php
                                }
                                ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="dynFlexHV Subs" id="accordion-subs">
                        <div data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" class="title-wrapper" style="padding:10px; padding-top: 0px;">
                            <ul style="cursor:pointer" class="breadcrumb">
                                <li style="text-align: center; width: 100%">Subs</li>
                            </ul>
                        </div>

                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion-subs">
                            <div class="card">
                                <div class="card-body subs ccard" style="padding-top: 0px; text-align: center;">
                                    <img class="avatar sub-item" src="https://cataas.com/cat/says/<?php echo rand(1, 5000) ?>" alt="">
                                    <img class="avatar sub-item" src="https://cataas.com/cat/says/<?php echo rand(1, 5000) ?>" alt="">
                                    <img class="avatar sub-item" src="https://cataas.com/cat/says/<?php echo rand(1, 5000) ?>" alt="">
                                    <img class="avatar sub-item" src="https://cataas.com/cat/says/<?php echo rand(1, 5000) ?>" alt="">
                                    <img class="avatar sub-item" src="https://cataas.com/cat/says/<?php echo rand(1, 5000) ?>" alt="">
                                </div>
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
