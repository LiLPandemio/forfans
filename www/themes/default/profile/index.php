<?php
require(ROOT . "/config.php");
if (isset($_COOKIE["token"])) {
    $tokenStatus = checkTokenStatus($_COOKIE["token"]);
    if ($tokenStatus !== "INVALID_TOKEN" and $tokenStatus !== "TOKEN_EXPIRED") {
        $udata = getUserData(whoami($_COOKIE["token"]));
        $config["default_lang"] = $udata["lang"];
    }
}
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
        $user = getUserData($username);
        //Mostrar la pagina
?>
        <!-- Aqui puedes añadir contenido exta a head -->
        <link rel="stylesheet" href="<?= $config["fullsiteurl"] . "themes/" . $config["theme"] . "/home/" . "index" ?>.css">
        <style>
            .cust_spinner {
                animation-name: spin;
                animation-duration: 2500ms;
                animation-iteration-count: infinite;
                animation-timing-function: linear;
            }

            .cust_rspinner {
                animation-name: rspin;
                animation-duration: 2500ms;
                animation-iteration-count: infinite;
                animation-timing-function: linear;
            }

            @keyframes spin {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }

            @keyframes rspin {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(-360deg);
                }
            }
        </style>
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
                    <div class="card text-left" style="padding: 10px; margin:10px">
                        <img class="card-img-top" style="border-radius: 20px" src="<?php echo $config['fullsiteurl'] . $user['cover_picture_rpath'] ?>" alt="">
                        <div class="cust_spinner" style="margin-top: -50px; height:110px; width:110px; object-fit: cover; margin-left: 50px; border-radius: 100px; background: <?= $user['css-cone-flag'] ?>">
                            <img class="cust_rspinner" src="<?php echo $config['fullsiteurl'] . $user['profile_picture_rpath'] ?>" style="height:100px; margin-left: 5px; margin-top: 5px; width:100px; border-radius: 50px" alt="">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">@<?= $user['username'] ?></h4>
                            <div style="display:flex; flex:1; flex-direction:row">

                                <?php if ($isMyProfile) {
                                ?>
                                    <span style="margin-bottom: 10px;">
                                        <a name="" id="" class="btn btn-sm btn-primary" href="<?php echo $config['fullsiteurl'] . "editprofile" ?>" role="button">Editar perfil</a>
                                        <!-- <a name="" id="" class="btn btn-sm btn-primary" href="<?php echo $config['fullsiteurl'] . "editprofile" ?>" role="button">Earnings</a> -->
                                        <!-- <a name="" id="" class="btn btn-sm btn-primary" href="<?php echo $config['fullsiteurl'] . "editprofile" ?>" role="button">Stats</a> -->
                                    </span>
                                <?php
                                } ?>
                            </div>
                            <p class="card-text">
                                Name: <?= $user['displayName'] ?> <br>
                                Identified as: <?= lang("war_helicopter") ?>
                            </p>
                        </div>
                    </div>

                    <?php $posts = getUserPublicPosts(10, $username); ?>

                    <?php
                    if ($posts == "NO_POSTS_FOUND") {
                        echo "NO POSTS FOUND";
                    } else {

                        for ($i = 0; $i < count($posts); $i++) {
                            $post = $posts[$i];
                            $img_array = json_decode($post["post_img_array"]);
                    ?>

                            <div style="padding: 0; min-height: 160px" class="card text-left post-body">
                                <?php
                                if ($img_array != "") {
                                ?>
                                    <script>
                                        function next_picture(elem) {
                                            var ids = $(elem).attr("id");
                                            var ids_array = ids.split("_");
                                            next = parseInt(ids_array[1]) + 1;
                                            if ($("#" + ids_array[0] + "_" + next).length) {
                                                //Exists
                                                $("#" + ids).hide();
                                                $("#" + ids_array[0] + "_" + next).show();
                                                $("#currentImages_" + ids_array[0]).html(next + 1)
                                            } else {
                                                //Not exists
                                                $("#" + ids).hide();
                                                $("#" + ids_array[0] + "_" + 0).show();
                                                $("#currentImages_" + ids_array[0]).html(1)
                                            }
                                        }
                                    </script>
                                    <div style="flex:5" class="card-body">
                                        <?php
                                        if (count($img_array) > 1) {
                                        ?>
                                            <p class="text-muted text-center" style="font-size: 70%;">Haz click en la imagen para ver mas<br><span id="currentImages_<?= $post["post_id"] ?>">1</span>/<?= count($img_array) ?></p>
                                        <?php }
                                        ?>
                                        <div id="images_<?= $post["post_id"] ?>">
                                            <?php
                                            for ($j = 0; $j < count($img_array); $j++) {
                                                $img_array = str_replace("{fullsiteurl}", $config["fullsiteurl"], $img_array) //remplaza {fullsiteurl} por cfg fullsiteurl
                                            ?>
                                                <img onclick="next_picture(this)" id="<?php echo $post["post_id"] . "_" . $j  ?>" style="object-fit:cover; margin: 10px; margin-top:10px; border-radius: 5px; width:95%;<?php if ($j > 0) {
                                                                                                                                                                                                                            echo " display:none";
                                                                                                                                                                                                                        } ?>" src="<?php echo $img_array[$j] ?>" alt="POST">
                                            <?php
                                            }
                                            ?>
                                        </div>
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
                                            <div class="row" style="height: 50%;">
                                                <div class="col-sm-6">
                                                    <p class="card-text">@<?= $post["username"] ?></p>
                                                </div>
                                                <div style="text-align: right;" class="col-sm-6">
                                                    <small class="text-muted"><?php
                                                                                //2022-02-22 16:49:39
                                                                                $ptarr = explode("_", str_replace(array("-", ":", " "), "_", $post["post_time"]));
                                                                                echo $ptarr[2] . "/" . $ptarr[1] . "/" . $ptarr[0];
                                                                                ?></small>
                                                </div>
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
                    <?php }
                    }
                    ?>


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