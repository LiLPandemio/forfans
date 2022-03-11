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
// TODO: THEME PICKER FOR DEMO!
?>

<!-- Hasta aqui el contenido head -->
<style>
    .themePickerWrapper {
        padding: 10px;
        filter: none;
    }

    .pick_theme_preview {
        flex: 1 1 10px;
        margin-right: 10px;
        margin-bottom: 10px;
        width: 100px;
        height: 150px;
        object-fit: fill;
        cursor: pointer;
        border: 1px solid gold;
        border-radius: 5px;
    }

    .overlay_menu_hide {
        display: none;
        position: fixed;
        top: 15%;
        left: 5%;
        background-color: var(--bs-body-bg);
        border: 4px solid gold;
        border-radius: 10px;
        width: 90%;
        z-index: 10000;
        flex-wrap: wrap;
        overflow: auto;
        max-height: 70%
    }

    .selected-item {
        border: 5px solid gold;
    }

    .menu-selection {
        flex-wrap: wrap;
    }

    html {
        min-height: 100%;
    }

    @media(min-width: 1000px) {

        /* ESCRITORIO */
        .overlay_menu {
            display: block;
            position: fixed;
            top: 25%;
            left: 20%;
            background-color: var(--bs-body-bg);
            border: 4px solid gold;
            border-radius: 10px;
            width: 60%;
            z-index: 10;
            flex-wrap: wrap;
            overflow: auto;
            max-height: 70%
        }

        .overlay_menu_hide {
            display: none;
            position: fixed;
            top: 25%;
            left: 20%;
            background-color: var(--bs-body-bg);
            border: 4px solid gold;
            border-radius: 10px;
            width: 60%;
            z-index: 10;
            flex-wrap: wrap;
            overflow: auto;
            max-height: 70%
        }
    }
</style>
<script>
    var themePickerIsVisible = true;

    function toggleThemePicker() {
        if (themePickerIsVisible) {
            //hide
            $("#themePicker").fadeIn(100)
        } else {
            //show
            $("#themePicker").fadeOut(100)
        }
        themePickerIsVisible = !themePickerIsVisible;
    }
</script>
</head>

<body>
    <div class="overlay_menu_hide" id="themePicker">
        <div class="themePickerWrapper">

            <div class="menu_selection">
                <a href="<?= '/landing/' . base64_encode(urlencode('theme=default')) ?>"><img class="pick_theme_preview" src="<?php echo $config["fullsiteurl"] . "themes/" . $config['theme'] . "/" ?>assets/img/default_theme.png" alt="default"></a>
                <a href="<?= '/landing/' . base64_encode(urlencode('theme=cyborg')) ?>"><img class="pick_theme_preview" src="<?php echo $config["fullsiteurl"] . "themes/" . $config['theme'] . "/" ?>assets/img/cyborg.png" alt="cyborg"></a>
                <a href="<?= '/landing/' . base64_encode(urlencode('theme=darkly')) ?>"><img class="pick_theme_preview" src="<?php echo $config["fullsiteurl"] . "themes/" . $config['theme'] . "/" ?>assets/img/darkly.png" alt="darkly"></a>
                <a href="<?= '/landing/' . base64_encode(urlencode('theme=litera')) ?>"><img class="pick_theme_preview" src="<?php echo $config["fullsiteurl"] . "themes/" . $config['theme'] . "/" ?>assets/img/litera.png" alt="litera"></a>
                <a href="<?= '/landing/' . base64_encode(urlencode('theme=minty')) ?>"><img class="pick_theme_preview" src="<?php echo $config["fullsiteurl"] . "themes/" . $config['theme'] . "/" ?>assets/img/minty.png" alt="minty"></a>
                <a href="<?= '/landing/' . base64_encode(urlencode('theme=quartz')) ?>"><img class="pick_theme_preview" src="<?php echo $config["fullsiteurl"] . "themes/" . $config['theme'] . "/" ?>assets/img/quartz.png" alt="quartz"></a>
                <a href="<?= '/landing/' . base64_encode(urlencode('theme=morph')) ?>"><img class="pick_theme_preview" src="<?php echo $config["fullsiteurl"] . "themes/" . $config['theme'] . "/" ?>assets/img/morph.png" alt="morph"></a>
                <a href="<?= '/landing/' . base64_encode(urlencode('theme=vapor')) ?>"><img class="pick_theme_preview" src="<?php echo $config["fullsiteurl"] . "themes/" . $config['theme'] . "/" ?>assets/img/vapor.png" alt="vapor"></a>
                <a href="<?= '/landing/' . base64_encode(urlencode('theme=lux')) ?>"><img class="pick_theme_preview" src="<?php echo $config["fullsiteurl"] . "themes/" . $config['theme'] . "/" ?>assets/img/lux.png" alt="lux"></a>
                <a href="<?= '/landing/' . base64_encode(urlencode('theme=journal')) ?>"><img class="pick_theme_preview" src="<?php echo $config["fullsiteurl"] . "themes/" . $config['theme'] . "/" ?>assets/img/journal.png" alt="journal"></a>
            </div>
            <button type="button" onclick="toggleThemePicker()" class="btn btn-success">Cerrar</button>
        </div>
    </div>
    <!-- Aqui va el contenido principal de la pagina -->
    <!-- Load navbar -->
    <?php require(ROOT . "/themes/" . $config["theme"] . "/components/navbar-no-session.phtml");
    // LOAD THEME PREVIEW!
    $fullpage = $_REQUEST['page'];                                      //La pagina se guarda en $fullpage para dividirla luego en parametros
    $param = preg_split("/\//", $fullpage, -1, PREG_SPLIT_NO_EMPTY);    //$param[n] contiene los parametros siendo N el parametro solicitado.
    if (isset($param[1])) {
        if ($param[1] !== "") {
            $instructions = explode("=", urldecode(base64_decode($param[1])));
            switch ($instructions[0]) {
                case 'theme':
                    $theme2load = $instructions[1];
                    if ($instructions[1] == "cyborg" || $instructions[1] == "darkly" || $instructions[1] == "default" || $instructions[1] == "morph" || $instructions[1] == "vapor" || $instructions[1] == "minty" || $instructions[1] == "litera" || $instructions[1] == "quartz" || $instructions[1] == "lux" || $instructions[1] == "journal") {

                        $useCyborgTheme = false;
                        $useDarklyTheme = false;
                        $useLiteraTheme = false;
                        $useMintyXTheme = false;
                        $useQuartzTheme = false;
                        $useMorphTheme = false;
                        $useVaporTheme = false;
                        $useLuxTheme = false;
                        $useJournalTheme = false;
                        switch ($instructions[1]) {
                            case 'cyborg':
                                $useCyborgTheme = true;    //WARNING: MUST BE true OR false
                                break;
                            case 'darkly':
                                $useDarklyTheme = true;     //WARNING: MUST BE true OR false
                                break;
                            case 'litera':
                                $useLiteraTheme = true;    //WARNING: MUST BE true OR false
                                break;
                            case 'minty':
                                $useMintyXTheme = true;    //WARNING: MUST BE true OR false
                                break;
                            case 'quartz':
                                $useQuartzTheme = true;    //WARNING: MUST BE true OR false
                                break;
                            case 'morph':
                                $useMorphTheme = true;    //WARNING: MUST BE true OR false
                                break;
                            case 'vapor':
                                $useVaporTheme = true;    //WARNING: MUST BE true OR false
                                break;
                            case 'lux':
                                $useLuxTheme = true;    //WARNING: MUST BE true OR false
                                break;
                            case 'journal':
                                $useJournalTheme = true;    //WARNING: MUST BE true OR false
                                break;
                            default:
                                // Don't override nothing
                                break;
                        }
                        if ($useCyborgTheme) {
    ?>
                            <link rel="stylesheet" href="<?php echo $config['fullsiteurl'] . "themes/" . $config['theme'] . "/" ?>assets/cyborg/cyborg.min.css">
                        <?php
                        }
                        if ($useDarklyTheme) {
                        ?>
                            <link rel="stylesheet" href="<?php echo $config['fullsiteurl'] . "themes/" . $config['theme'] . "/" ?>assets/darkly/darkly.min.css">
                        <?php
                        }
                        if ($useLiteraTheme) {
                        ?>
                            <link rel="stylesheet" href="<?php echo $config['fullsiteurl'] . "themes/" . $config['theme'] . "/" ?>assets/litera/litera.min.css">
                        <?php
                        }
                        if ($useMintyXTheme) {
                        ?>
                            <link rel="stylesheet" href="<?php echo $config['fullsiteurl'] . "themes/" . $config['theme'] . "/" ?>assets/minty/minty.min.css">
                        <?php
                        }
                        if ($useQuartzTheme) {
                        ?>
                            <link rel="stylesheet" href="<?php echo $config['fullsiteurl'] . "themes/" . $config['theme'] . "/" ?>assets/quartz/quartz.min.css">
                        <?php
                        }
                        if ($useMorphTheme) {
                        ?>
                            <link rel="stylesheet" href="<?php echo $config['fullsiteurl'] . "themes/" . $config['theme'] . "/" ?>assets/morph/morph.min.css">
                        <?php
                        }
                        if ($useVaporTheme) {
                        ?>
                            <link rel="stylesheet" href="<?php echo $config['fullsiteurl'] . "themes/" . $config['theme'] . "/" ?>assets/vapor/vapor.min.css">
                        <?php
                        }
                        if ($useLuxTheme) {
                        ?>
                            <link rel="stylesheet" href="<?php echo $config['fullsiteurl'] . "themes/" . $config['theme'] . "/" ?>assets/lux/lux.min.css">
                        <?php
                        }
                        if ($useJournalTheme) {
                        ?>
                            <link rel="stylesheet" href="<?php echo $config['fullsiteurl'] . "themes/" . $config['theme'] . "/" ?>assets/journal/journal.min.css">
    <?php
                        }
                    }
                    break;

                default:
                    # code...
                    break;
            }
        }
    } else {
        # code...
    }


    ?>

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
                                <h2 class="card-title"><img class="avatar" style="border-radius: 50px; height: 50px; width: 50px; position:relative; top:-2.5px" src="<?php echo $config["fullsiteurl"] . $users[$i]["profile_picture_rpath"] ?>" alt=""> <?= $u["displayName"] ?></h2>
                                <h2 class="card-subtitle mb-2 text-muted">@<?= $u["username"] ?></h2>
                                <p class="card-text"><?= $u["bio"] ?></p>
                            </div>
                            <div class="card-footer"><a class="btn btn-primary btn-sm" href="<?php echo $config["fullsiteurl"] . "profile/" . $u["username"] ?>">Ver perfil</a></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php
        }
        ?>
        <!-- Footer-->
        <footer class="py-5">
            <div class="container px-4 px-lg-5">
                <p class="m-0 text-center">Copyright &copy; <?= $config["sitename"] ?> <?php echo date("Y"); ?></p>
            </div>
        </footer>












</body>






</head>

<body>

    </html>