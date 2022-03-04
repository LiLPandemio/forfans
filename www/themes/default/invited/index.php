<?php
require(ROOT . "/config.php");
require(ROOT . "/functions/db.php");
//TODO: OPTIMIZAR BUSQUEDAS SQL, OBTENER VALIDEZ Y ORIGEN EN UNA UNICA CONSULTA

$fullpage = $_REQUEST['page'];                                      //La pagina se guarda en $fullpage para dividirla luego en parametros
$param = preg_split("/\//", $fullpage, -1, PREG_SPLIT_NO_EMPTY);    //$param[n] contiene los parametros siendo N el parametro solicitado.
if (!isset($param[1])) {
    header("Location:" . $config["fullsiteurl"] . "auth/invalid_invitation");
}
if (!isInviteValid($param[1])) {
    header("Location:" . $config["fullsiteurl"] . "auth/invalid_invitation");
}
if (!isset($param[2])) {
    header("Location:" . $config['fullsiteurl'] . $param['0'] . "/" . $param['1'] . "/welcome");
} else {
    switch ($param[2]) {
        case 'welcome':
            //custom if welcome
            break;
        case 'about':
            //custom if welcome
            break;
        case 'security':
            //custom if welcome
            break;

        default:
            // Pagina no definida, redirigir a welcome
            header("Location:" . $config['fullsiteurl'] . $param['0'] . "/" . $param['1'] . "/welcome");
            break;
    }
}

if (isset($_COOKIE["token"])) {
    $tokenStatus = checkTokenStatus($_COOKIE["token"]);
    if ($tokenStatus !== "INVALID_TOKEN" and $tokenStatus !== "TOKEN_EXPIRED") {
        $udata = getUserData(whoami($_COOKIE["token"]));
        $config["default_lang"] = $udata["lang"];
    }
}
require(ROOT . "/locale/" . $config["default_lang"] . ".php");

//Obtener informacion del invitador par $invitator
$stmt = $conn->prepare("SELECT `invitation_codes`.*, `usuarios`.*, `sexual_orientations`.* FROM `invitation_codes` LEFT JOIN `usuarios` ON `invitation_codes`.`invitation_creator` = `usuarios`.`id_usuarios` LEFT JOIN `sexual_orientations` ON `usuarios`.`sexual_orientations_id` = `sexual_orientations`.`id` WHERE invitation_code = ?;");
$stmt->execute(array($param[1]));
$r = $stmt->fetchAll();
$invitator = $r[0];
$useCyborgTheme = false;
$useDarklyTheme = false;
$useLiteraTheme = false;
$useMintyXTheme = false;
$useQuartzTheme = false;
$useMorphTheme = false;
$useVaporTheme = false;
$useLuxTheme = false;
$useJournalTheme = false;
$overrider = $invitator["default_theme_variable"];
switch ($overrider) {
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

?>
<script>
    const URL = "<?= $config["fullsiteurl"] . $param[0] . "/" . $param[1] . "/" ?>";

    function updateURL(nextURL, nextTitle) {
        const nextState = {
            additionalInformation: 'Updated the URL with JS'
        };

        // This will create a new entry in the browser's history, without reloading
        window.history.pushState(nextState, nextTitle, nextURL);

        // This will replace the current entry in the browser's history, without reloading
        window.history.replaceState(nextState, nextTitle, nextURL);
    }
</script>
<!-- Aqui puedes añadir contenido exta a head -->
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

    html {
        min-height: 100%;
    }
</style>
<!-- Hasta aqui el contenido head -->
</head>

<body>
    <!-- Aqui va el contenido principal de la pagina -->
    <!-- Load navbar -->
    <div class="row">
    </div>
    <div class="row">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-6">
            <div class="card text-left" style="margin-top: 8%; padding:5px; text-align: center; height: 200%; border:none">
                <div id="welcome" <?php
                                    if ($param[2] !== "welcome") {
                                        echo "style='display:none'";
                                    }
                                    ?>>
                    <img class="card-img-top" style="border-radius: 20px" src="<?php echo $config['fullsiteurl'] . $invitator['cover_picture_rpath'] ?>" alt="">

                    <!-- VV PROFILE PICTURE VV -->
                    <div class="cust_spinner" style="margin: auto; margin-top: -50px; height:100px; width:100px; object-fit: cover; border-radius: 100px; background: <?= $invitator['css-cone-flag'] ?>">
                        <img class="cust_rspinner" src="<?php echo $config['fullsiteurl'] . $invitator['profile_picture_rpath'] ?>" style="height:90px; margin-top: 5px; margin-left: 5px; width:90px; border-radius: 50px" alt="">
                    </div>


                    <div class="card-body" style="text-align: center;">
                        <h4 class="card-title">@<?= $invitator["username"] ?> te invita a <?= $config["sitename"] ?></h4>
                        <button type="button" onclick="$('#welcome').fadeOut(200,() => {$('#about').fadeIn(200);updateURL('<?= $config['fullsiteurl']  . $param[0] . '/' . $param[1] . '/about' ?>','About you')});" class="btn btn-primary">Registrarme</button>
                    </div>
                </div>
                <div id="about" <?php
                                if ($param[2] !== "about") {
                                    echo "style='display:none'";
                                }
                                ?>>
                    <div class="card-body" style="text-align: center;">
                        <h2 class="card-title">Cuentanos de tí</h2>
                        <h4 class="card-title">Informacion pública</h4>
                        <div class="row">

                            <!-- USERNAME -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="username">Nombre de usuario <b>único</b></label>
                                    <input type="text" class="form-control" name="username" id="username" aria-describedby="help_username" placeholder="pedropicapiedra">
                                    <small id="help_username" class="form-text text-muted"></small>
                                </div>
                            </div>
                            <!-- /USERNAME -->

                            <!-- DNAME -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="dname">Tu nombre a mostrar</label>
                                    <input type="text" class="form-control" name="dname" id="dname" aria-describedby="help_dname" placeholder="Pedro">
                                    <small id="help_dname" class="form-text text-muted"></small>
                                </div>
                            </div>
                            <!-- /DNAME -->
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="gender_id">Me identifico como...</label>
                                    <select class="form-control" style="line-height: 1.5; height: 100%;" name="gender_id" id="gender_id">
                                        <?php
                                        $genders = getGendersList();
                                        for ($i = 0; $i < count($genders); $i++) {
                                            $g = $genders[$i];
                                        ?>
                                            <option value="<?= $g[0] ?>" style="color:var(--bs-primary)" class="form-select"><?= ucfirst(lang($g[1])) ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="gender_id">Soy...</label>
                                    <select class="form-control" style="line-height: 1.5; height: 100%;" name="sexual_orientation_id" id="sexual_orientation_id">
                                        <?php
                                        $sexorients = getSexualOrientationsList();
                                        for ($i = 0; $i < count($sexorients); $i++) {
                                            $g = $sexorients[$i];
                                        ?>
                                            <option value="<?= $g[0] ?>" style="color:var(--bs-primary)" class="form-select"><?= ucfirst(lang($g[1])) ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <h4 class="card-title">Informacion privada</h4>
                        <div class="row">

                            <!-- RNAME -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Tu nombre (No será visible a otros)</label>
                                    <input type="text" class="form-control" name="name" id="name" aria-describedby="help_name" placeholder="Pedro">
                                    <small id="help_name" class="form-text text-muted"></small>
                                </div>
                            </div>
                            <!-- /RNAME -->

                            <!-- SURNAMES -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="surnames">Tu nombre (No será visible a otros)</label>
                                    <input type="text" class="form-control" name="surnames" id="surnames" aria-describedby="help_surnames" placeholder="Sanchez Picapiedras">
                                    <small id="help_surnames" class="form-text text-muted"></small>
                                </div>
                            </div>
                            <!-- /SURNAMES -->
                        </div>

                        <button type="button" onclick="$('#about').fadeOut(200,() => {$('#welcome').fadeIn(200);updateURL('<?= $config['fullsiteurl']  . $param[0] . '/' . $param[1] . '/welcome' ?>','Welcome')})" class="btn btn-secondary">Atrás</button>
                        <button type="button" onclick="$('#about').fadeOut(200,() => {$('#security').fadeIn(200);updateURL('<?= $config['fullsiteurl']  . $param[0] . '/' . $param[1] . '/security' ?>','Security')})" class="btn btn-primary">Continuar</button>
                    </div>

                </div>
                <div id="security" <?php
                                    if ($param[2] !== "security") {
                                        echo "style='display:none'";
                                    }
                                    ?>>
                    <div class="card-body" style="text-align: center;">
                        <h4 class="card-title">Hora de proteger tu cuenta</h4>
                        <div class="form-group">
                            <label for="pwd1">Contraseña</label>
                            <input type="password" class="form-control" name="pwd1" id="pwd1" aria-describedby="helpPassword" placeholder="P4s$w0rd">
                            <small id="helpPassword" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="pwd1">Contraseña (repetir)</label>
                            <input type="password2" class="form-control" name="pwd2" id="pwd2" aria-describedby="helpPassword" placeholder="P4s$w0rd">
                            <small id="helpPassword2" class="form-text text-muted"></small>
                        </div>
                        <button type="button" onclick="$('#security').fadeOut(200,() => {$('#about').fadeIn(200);updateURL('<?= $config['fullsiteurl']  . $param[0] . '/' . $param[1] . '/about' ?>','About you')})" class="btn btn-secondary">Atrás</button>
                        <button type="button" onclick="" class="btn btn-primary">Crear cuenta</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-sm-3">
        </div>
    </div>
</body>