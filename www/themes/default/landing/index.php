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
// require(ROOT . "/themes/" . $config["theme"] . "/head/index.php");
?>

<!-- Hasta aqui el contenido head -->
</head>

<body>
    <!-- Aqui va el contenido principal de la pagina -->
    <!-- Load navbar -->
    <?php require(ROOT . "/themes/" . $config["theme"] . "/components/navbar-no-session.phtml"); ?>

    <!-- Page Content-->
    <div class="container px-4 px-lg-5">
        <!-- Heading Row-->
        <div class="row gx-4 gx-lg-5 align-items-center my-5">
            <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0" src="<?= $config["fullsiteurl"] . "/themes/" . $config["theme"] . "/assets/img/logo-900x400.png" ?>" alt="..." /></div>
            <div class="col-lg-5">
                <h1 class="font-weight-light">ForFans, For creators.</h1>
                <p>Enjoy and create your favorite content no matter what.</p>
                <a class="btn btn-primary" href="/auth">Join/Login now!</a>
            </div>
        </div>
        <!-- Content Row-->
        <?php $users = getSuggestedUsers(3);
        if ($users > 0) {
        ?>
            <h1 class="font-weight-light">Meet our creators!</h1>
            <div class="row gx-4 gx-lg-5">
                <?php
                for ($i = 0; $i < count($users); $i++) {
                    $u = $users[$i];
                ?>
                    <div class="col-md-4 mb-5">
                        <div class="card h-100">
                            <div class="card-body">
                                <h2 class="card-title"><img class="avatar" style="border-radius: 50px; height: 50px; width: 50px; position:relative; top:-2.5px" src="<?php echo $config["fullsiteurl"].$users[$i]["profile_picture_rpath"]?>" alt=""> <?= $u["displayName"] ?></h2>
                                <h2 class="card-subtitle mb-2 text-muted">@<?= $u["username"] ?></h2>
                                <p class="card-text"><?=$u["bio"]?></p>
                            </div>
                            <div class="card-footer"><a class="btn btn-primary btn-sm" href="<?php echo $config["fullsiteurl"]."profile/".$u["username"]?>">Ver perfil</a></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php
        }
        ?>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container px-4 px-lg-5">
                <p class="m-0 text-center text-white">Copyright &copy; <?= $config["sitename"] ?> 2022</p>
            </div>
        </footer>












</body>






</head>

<body>

    </html>