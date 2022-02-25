<?php
//Auth required!
require(ROOT . "/config.php");
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
                                                                                                                    } ?> class="form-select"><?= lang($g[1]) ?></option>
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
                                                                                                                    } ?> class="form-select"><?= lang($s[1]) ?></option>
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
                                            <input type="password" class="form-control" name="user_password" id="user_password" aria-describedby="helpId" placeholder="__*Y0uR_P@$Sw0rD***">
                                            <label for="user_password">Contraseña (cambiar)</label>
                                            <input type="password" class="form-control" name="user_password_repeat" id="user_password_repeat" aria-describedby="helpId" placeholder="__*Y0uR_P@$Sw0rD***">
                                            <button style="margin-top: 10px; width:100%" type="button" onclick="chpasswd()" class="btn btn-sm btn-primary">Change password</button>
                                            <small id="outputTextPasswordUpdate" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
