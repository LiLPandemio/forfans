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
                                    <small style="display: none;" id="help_username" class="form-text text-danger">
                                        Sólo puede tener letras en minuscula, números, puntos y guiones bajos. <br>
                                        No puede empezar ni acabar con punto (.) ni tener mas de un punto consecutivo.
                                    </small>
                                </div>
                            </div>
                            <!-- /USERNAME -->

                            <!-- DNAME -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="dname">Tu nombre a mostrar</label>
                                    <input type="text" class="form-control" name="dname" id="dname" aria-describedby="help_dname" placeholder="Pedro">
                                    <small style="display: none;" id="help_dname" class="form-text text-danger">
                                        Maximo 18 caracteres, letras A - Z.
                                    </small>
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
                                    <small style="display: none;" id="help_gender_id" class="form-text text-danger">
                                        El formulario se ha roto! Contacta al desarrollador.
                                    </small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="gender_id">Soy...</label>
                                    <select class="form-control" style="line-height: 1.5; height: 100%;" name="sexual_orientations_id" id="sexual_orientations_id">
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
                                    <small style="display: none;" id="help_sexual_orientations_id" class="form-text text-danger">
                                        El formulario se ha roto! Contacta al desarrollador.
                                    </small>
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
                                    <small style="display: none;" id="help_name" class="form-text text-danger">
                                        Entre 2 y 18 caracteres, solo letras mayusculas, minusculas y apostrofes.
                                    </small>
                                </div>
                            </div>
                            <!-- /RNAME -->

                            <!-- SURNAMES -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="surnames">Tus apellidos (No será visible a otros)</label>
                                    <input type="text" class="form-control" name="surnames" id="surnames" aria-describedby="help_surnames" placeholder="Sanchez Picapiedras">
                                    <small style="display: none;" id="help_surnames" class="form-text text-danger">
                                        Entre 2 y 200 caracteres, solo letras mayusculas, minusculas y apostrofes.
                                    </small>
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
                            <small style="display: none;" id="help_pwd1" class="form-text text-danger" style="display: none;">
                                La contraseña ha de tener mínimo 8 caracteres.
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="pwd1">Contraseña (repetir)</label>
                            <input type="password" class="form-control" name="pwd2" id="pwd2" aria-describedby="helpPassword" placeholder="P4s$w0rd">
                            <small style="display: none;" id="help_pwd2" class="form-text text-danger">
                                La contraseña no coincide
                            </small>
                        </div>
                        <h4 class="card-title">Unos datos mas...</h4>
                        <div class="form-group">
                            <label for="mail">Correo electronico</label>
                            <input class="form-control" name="mail" id="mail" aria-describedby="helpPassword" placeholder="address@example.com">
                            <small style="display: none;" id="help_mail" class="form-text text-danger">
                                Introduce una direccion de correo electronico válida.
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="birth">Fecha de nacimiento</label>
                            <input class="form-control" type="date" name="birth" id="birth" aria-describedby="helpPassword" placeholder="address@example.com">
                            <small style="display: none;" id="help_birth" class="form-text text-danger">
                                Introduce tu fecha de nacimiento
                            </small>
                        </div>
                        <button type="button" onclick="$('#security').fadeOut(200,() => {$('#about').fadeIn(200);updateURL('<?= $config['fullsiteurl']  . $param[0] . '/' . $param[1] . '/about' ?>','About you')})" class="btn btn-secondary">Atrás</button>
                        <button type="button" onclick="validateRegistration()" class="btn btn-primary">Crear cuenta</button>
                        <small style="display: none;" id="help_submit" class="form-text text-danger">
                            Hay campos invalidos, vuelve atras y actualiza la informacion.
                        </small>
                    </div>

                </div>
            </div>
        </div>
        <script>
            function setLoading() {
                console.log("LOADING...")
            }

            function unsetLoading() {
                console.log("DONE")
            }

            function validateUserName(username) {
                return usernameRegex.test(username);
            }

            function validateRegistration() {
                let username = $("#username").val();
                let mail = $("#mail").val();
                let dname = $("#dname").val();
                let gender_id = $("#gender_id").val();
                let sexual_orientations_id = $("#sexual_orientations_id").val();
                let name = $("#name").val();
                let surnames = $("#surnames").val();
                let pwd1 = $("#pwd1").val();
                let pwd2 = $("#pwd2").val();

                let isFormValid = true;
                //validating username
                usernameRegex = /^([a-z0-9_](?:(?:[a-z0-9_]|(?:\.(?!\.))){0,25}(?:[a-z0-9_]))?)$/
                if (username.length > 1 && username.length < 25 && usernameRegex.test(username)) {
                    console.log("Username: VALID")
                    $("#help_username").hide();
                } else {
                    console.log("Username: INVALID")
                    $("#help_username").show();
                    isFormValid = false;
                }

                //validating mail
                mailRegex = /^(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
                if (mail.length > 1 && mailRegex.test(mail)) {
                    console.log("Mail: VALID")
                    $("#help_mail").hide();

                } else {
                    console.log("Mail: INVALID")
                    $("#help_mail").show();
                    isFormValid = false;
                }

                //validating dname
                dnameRegex = /^[^0-9_!¡?÷?¿/\\+=@#$%ˆ&*(){}|~<>;:[\]]{2,18}$/;
                if (dname.length > 2 && dname.length < 18 && dnameRegex.test(dname)) {
                    console.log("dname: VALID")
                    $("#help_dname").hide();

                } else {
                    console.log("dname: INVALID")
                    $("#help_dname").show();
                    isFormValid = false;
                }

                //validating gender_id
                if (!isNaN(gender_id)) {
                    console.log("gender_id: VALID")
                    $("#help_gender_id").hide();

                } else {
                    console.log("gender_id: INVALID")
                    $("#help_gender_id").show();
                    isFormValid = false;
                }

                //validating sexual_orientations_id
                if (!isNaN(sexual_orientations_id)) {
                    console.log("sexual_orientations_id: VALID")
                    $("#help_sexual_orientations_id").hide();

                } else {
                    console.log("sexual_orientations_id: INVALID")
                    $("#help_sexual_orientations_id").show();
                    isFormValid = false;
                }

                //validating name
                nameRegex = /^[^0-9_!¡?÷?¿/\\+=@#$%ˆ&*(){}|~<>;:[\]]{2,}$/;
                if (name.length > 2 && name.length < 18 && nameRegex.test(name)) {
                    console.log("name: VALID")
                    $("#help_name").hide();

                } else {
                    console.log("name: INVALID")
                    $("#help_name").show();
                    isFormValid = false;
                }

                //validating surnames
                surnamesRegex = /^[^0-9_!¡?÷?¿/\\+=@#$%ˆ&*(){}|~<>;:[\]]{2,}$/;
                if (surnames.length > 2 && surnames.length < 18 && surnamesRegex.test(surnames)) {
                    console.log("surnames: VALID")
                    $("#help_surnames").hide();
                } else {
                    console.log("surnames: INVALID")
                    $("#help_surnames").show();
                    isFormValid = false;
                }

                //validating pwd1
                if (pwd1.length > 7) {
                    console.log("pwd1: VALID")
                    $("#help_pwd1").hide();
                } else {
                    console.log("pwd1: INVALID")
                    $("#help_pwd1").show();
                    isFormValid = false;
                }

                //validating pwd2
                if (pwd2 === pwd1) {
                    console.log("pwd2: VALID")
                    $("#help_pwd2").hide();
                } else {
                    console.log("pwd2: INVALID")
                    console.log("pwd2: " + pwd1)
                    console.log("pwd2: " + pwd2)
                    $("#help_pwd2").show();
                    isFormValid = false;
                }
                if (isFormValid) {
                    //Form valid
                    setLoading();
                    $("#help_submit").hide();

                    var formData = new FormData()
                    formData.append("invite", "<?= $param[1] ?>")
                    formData.append("birthdate", $("#birth").val())
                    formData.append("username", $("#username").val())
                    formData.append("email", mail)
                    console.log("ENVIANDO MAIL ADDR: " + mail);
                    formData.append("gender_id", $("#gender_id").val())
                    formData.append("sexual_orientations_id", $("#sexual_orientations_id").val())
                    formData.append("dname", $("#dname").val())
                    formData.append("rname", $("#name").val())
                    formData.append("rsurname", $("#surnames").val())
                    formData.append("pwd", $("#pwd1").val())
                    formData.append("rpwd", $("#pwd2").val())

                    $.ajax({
                            url: "<?= $config["fullsiteurl"] ?>" + "api/register",
                            type: 'POST',

                            // Form data
                            data: formData,
                            contentType: 'multipart/form-data',
                            // Tell jQuery not to process data or worry about content-type
                            // You *must* include these options!
                            cache: false,
                            contentType: false,
                            processData: false,

                            // Custom XMLHttpRequest
                            xhr: function() {
                                var myXhr = $.ajaxSettings.xhr();
                                if (myXhr.upload) {
                                    // For handling the progress of the upload
                                }
                                return myXhr;
                            },
                        }).done(function(r) {
                            unsetLoading()
                            console.log("---------------OK---------------");
                            console.log(r);
                        })
                        .fail(function(status, xhr, error) {
                            console.log("---------------ER---------------");
                            console.log(status);
                            console.log(xhr);
                            console.log(error);
                            alert("Something went wrong :(")
                        })

                } else {
                    //Invalid
                    $("#help_submit").show();
                }
            }
        </script>
        <div class="col-sm-3">
        </div>
    </div>
</body>