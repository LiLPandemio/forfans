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
                    ?>
                        <p style="width: 100%;text-align:center">This user has no posts yet!</p>
                    <?php
                    } else {

                        for ($i = 0; $i < count($posts); $i++) {
                            $post = $posts[$i];
                            $img_array = json_decode($post["post_img_array"]);
                            include(ROOT . "/themes/" . $config['theme'] . "/components/post.php");
                        }
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