<?php
//Auth required!
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
    if (checkTokenStatus($token) != "INVALID_TOKEN") {  //Si el estado del token no es invalido
        //Cargar datos
        $userdata = getUserData(whoami());
        //Mostrar la pagina

?>
        <!-- Aqui puedes añadir contenido exta a head -->
        <style>
            /* MOBILE FRIENDLY */
            .sidemenus {
                padding-left: 15px;
                padding-right: 15px;
            }

            @media (min-width: 1000px) {

                /* DESKTOP ONLY */
                .sidemenus {
                    padding-left: 50px;
                }
            }

            .aviableInvitations {
                animation: color-change 5s infinite;
            }

            @keyframes color-change {
                0% {
                    color: red;
                    text-shadow: 0 0 1px red;
                }

                12.5% {
                    color: orange;
                    text-shadow: 0 0 1px orange;
                }

                25% {
                    color: yellow;
                    text-shadow: 0 0 1px yellow;
                }

                37.5% {
                    color: green;
                    text-shadow: 0 0 1px green;
                }

                50% {
                    color: blue;
                    text-shadow: 0 0 1px blue;
                }

                62.5% {
                    color: purple;
                    text-shadow: 0 0 1px purple;
                }

                75% {
                    color: violet;
                    text-shadow: 0 0 1px violet;
                }

                100% {
                    color: red;
                    text-shadow: 0 0 1px red;
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
            </div>
            <div class="row">
                <div class="col-sm-3 sidemenus">
                    <div class="card text-left post-body" onclick='loadSection("basicInfo")' style="cursor: pointer; padding:12px; margin-bottom:4px">Basic info</div>
                    <div class="card text-left post-body" onclick='loadSection("security")' style="cursor: pointer; padding:12px; margin-bottom:4px">Security</div>
                    <div class="card text-left post-body" onclick='loadSection("eco")' style="cursor: pointer; padding:12px; margin-bottom:4px">Balance</div>
                    <?php
                    if ($config["register_mode"] == "invite") {
                    ?>
                        <div class="card text-left post-body" onclick='loadSection("invis")' style="cursor: pointer; padding:12px; margin-bottom:4px">Invitaciones</div>
                    <?php
                    } ?>
                </div>
                <div class="col-sm-8">
                    <div id="basicInfo">
                        <div class="card text-left post-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card-body">
                                        <h4 class="card-title">Datos personales basicos</h4>
                                        <div class="form-group">
                                            <label for="nombre">Nombre</label>
                                            <input onchange="updateProfileField(this)" value="<?php echo $userdata['nombre']; ?>" type="text" class="form-control" name="nombre" id="nombre" aria-describedby="helpId" placeholder="Juan">
                                            <!-- <small id="helpId" class="form-text text-muted">Your public name</small> -->
                                        </div>
                                        <div class="form-group">
                                            <label for="apellidos">Apellidos</label>
                                            <input onchange="updateProfileField(this)" value="<?php echo $userdata['apellidos']; ?>" type="text" class="form-control" name="apellidos" id="apellidos" aria-describedby="helpId" placeholder="Caballos">
                                            <!-- <small id="helpId" class="form-text text-muted">Your public name</small> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card-body">
                                        <h4 class="card-title">Informacion personal</h4>
                                        <div class="form-group">
                                            <label for="gender_id">Me identifico como...</label>
                                            <select onchange="updateProfileField(this)" class="form-control" style="line-height: 1.5; height: 100%;" name="gender_id" id="gender_id">
                                                <?php
                                                $genders = getGendersList();
                                                for ($i = 0; $i < count($genders); $i++) {
                                                    $g = $genders[$i];
                                                ?>
                                                    <option value="<?= $g[0] ?>" style="color:var(--bs-primary)" <?php if ($userdata["gender_id"] == $g[0]) {
                                                                                                                        echo 'selected="selected"';
                                                                                                                    } ?> class="form-select"><?= ucfirst(lang($g[1])) ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Soy...</label>
                                            <select onchange="updateProfileField(this)" class="form-control" style="line-height: 1.5; height: 100%;" name="sexual_orientations_id" id="sexual_orientations_id">
                                                <?php
                                                $sexs = getSexualOrientationsList();
                                                for ($i = 0; $i < count($sexs); $i++) {
                                                    $s = $sexs[$i];
                                                ?>
                                                    <option value="<?= $s[0] ?>" style="color:var(--bs-primary)" <?php if ($userdata["sexual_orientations_id"] == $s[0]) {
                                                                                                                        echo 'selected="selected"';
                                                                                                                    } ?> class="form-select"><?= ucfirst(lang($s[1])) ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="display: none;" id="security">
                        <div class="card text-left post-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card-body">
                                        <h4 class="card-title">Datos de la cuenta</h4>
                                        <div class="form-group">
                                            <label for="user_password">Contraseña (cambiar)</label>
                                            <input disabled type="password" class="form-control" name="user_password" id="user_password" aria-describedby="helpId" placeholder="__*Y0uR_P@$Sw0rD***">
                                            <label for="user_password">Contraseña (cambiar)</label>
                                            <input disabled type="password" class="form-control" name="user_password_repeat" id="user_password_repeat" aria-describedby="helpId" placeholder="__*Y0uR_P@$Sw0rD***">
                                            <button disabled style="margin-top: 10px; width:100%" type="button" onclick="chpasswd()" class="btn btn-sm btn-primary">Change password</button>
                                            <small id="outputTextPasswordUpdate" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="display: none;" id="eco">
                        <div class="card text-left post-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card-body">
                                        <h2 class="card-title">Dinero en la cuenta</h2>
                                        <div class="form-group">
                                            <div class="d-flex flex-row justify-content-between text-align-center">
                                                <div class="d-flex flex-column"><span>Cantidad actual</span>
                                                    <p>&euro; <span class="text-white"><?php echo $userdata['balance']; ?></span></p>
                                                </div> <button class="btn btn-secondary">Retirar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card-body">
                                        <h2 class="card-title">Puntos</h2>
                                        <div class="form-group">
                                            <div class="d-flex flex-row justify-content-between text-align-center">
                                                <div class="d-flex flex-column"><span>Puntos <?= $config["sitename"] ?></span>
                                                    <p><span class="text-white"><?php echo $userdata['points']; ?></span></p>
                                                </div> <button class="btn btn-secondary">Canjear</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($config["register_mode"] == "invite") {
                    ?>

                        <div id="invis" style="display: none;">
                            <div class="card text-left post-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card-body">
                                            <h2 class="card-title">Invitaciones</h2>
                                            <div class="form-group">
                                                <h4 class="card-title">Invitaciones creadas: <span class="aviableInvitations"><?= howManyUsedInvites() ?>/<?php echo $userdata['aviable_invites']; ?></span></h4>
                                                <table class="table" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Uses left</th>
                                                            <th scope="col">Code</th>
                                                            <th scope="col">Tools</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $myInvites = getMyInvites();
                                                        for ($i = 0; $i < count($myInvites); $i++) {
                                                        ?>
                                                            <tr>
                                                                <th scope="row"><?= $myInvites[$i]["uses_left"] ?></th>
                                                                <td><?= $myInvites[$i]["invitation_code"] ?></td>
                                                                <td>
                                                                    <button type="button" onclick="navigator.clipboard.writeText('<?php echo $config['fullsiteurl'] . '/invited/' . $myInvites[$i]['invitation_code'] ?>');" class="btn btn-primary">Copy link</button>
                                                                    <button type="button" class="btn btn-danger">Delete</button>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card-body">
                                            <h2 class="card-title">Invitaciones</h2>
                                            <div class="form-group">

                                                <h4 class="card-title">Usadas: <span class="usedInvitations">12</span></h4>
                                                <table class="table" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Key used</th>
                                                            <th scope="col">User joined</th>
                                                            <th scope="col">Tools</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $myUsedInvites = getMyUsedInvites();
                                                        for ($i = 0; $i < count($myUsedInvites); $i++) {
                                                        ?>
                                                            <tr>
                                                                <th scope="row"><?= $myUsedInvites[$i]["invitation_code"] ?></th>
                                                                <td>@<?= $myUsedInvites[$i]["username"] ?></td>
                                                                <td>
                                                                    <a class="btn btn-primary" href="<?= $config["fullsiteurl"] . "profile/" . $myUsedInvites[$i]["username"] ?>" role="button">Visit profile</a>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    } ?>
                </div>
                <div class="col-sm-1">

                </div>
                <script>
                    function chpasswd() {
                        var pwd = $("#user_password").val()
                        console.log(pwd)
                        console.log(rpwd)
                        var rpwd = $("#user_password_repeat").val()
                        if (pwd !== "") {
                            if (pwd === rpwd) {
                                if (pwd.length > 6) {
                                    $("#outputTextPasswordUpdate").html("Password changed")
                                } else {
                                    $("#outputTextPasswordUpdate").html("Password too short")
                                }
                            } else {
                                $("#outputTextPasswordUpdate").html("Passwords don't match")
                            }
                        } else {
                            $("#outputTextPasswordUpdate").html("La contraseña no puede estar en blanco")
                        }
                    }
                    var currSection = "basicInfo";

                    function getToken() {
                        cookie = document.cookie.split('; ').reduce((prev, current) => {
                            const [name, ...value] = current.split('=');
                            prev[name] = value.join('=');
                            return prev;
                        }, {});
                        return cookie.token;
                    }

                    function updateProfileField(data) {
                        let newValue = $("#" + data.id).val();
                        let param = data.name;
                        let token = getToken();
                        console.log(newValue)
                        console.log(param)
                        console.log(token)


                        $.post(siteURL + "api/editUser", {
                                "token": token,
                                "param": param,
                                "newValue": newValue
                            }, )
                            .done(function(data) {
                                console.log("REQUEST DONE");
                                let response = data.response;
                                console.log(response);
                            }).fail(function(xhr, status, error) {
                                console.log("REQUEST FAIL");
                                console.log(status);
                            });

                    }

                    function loadSection(sectionid) {
                        $("#" + currSection).hide()
                        $("#" + sectionid).show()
                        currSection = sectionid;
                    }
                </script>
            </div>
        </body>
<?php
    } else {
        echo "SESSION ERROR X1";
    }
} else {
    echo "SESSION ERROR X2";
}
