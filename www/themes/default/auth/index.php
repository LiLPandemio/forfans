<?php
if (isset($_COOKIE['token'])) {
    if ($_COOKIE['token'] !== "") {
        if (checkTokenStatus($_COOKIE['token']) != "INVALID_TOKEN") {
            redirect("/home");
        } else {
            redirect("logout");
        }
    } else {
        redirect("logout");
    }
}
require(ROOT . "/locale/" . $config['default_lang'] . ".php");
?>

<link rel="stylesheet" href="<?php echo $config["fullsiteurl"] . "themes/" . $config['theme'] . "/" ?>auth/style.css">
</head>
<div class="site-controllers" id="sitecontrollers">
    <script>
        const siteURL = "<?php echo $config["fullsiteurl"] ?>"
    </script>
    <i onclick="toggleSettings()" id="settings-icon" class="settings-icon fa-solid fa-gear"></i><br>
    <i onclick="" class="fa-solid fa-palette settings-option"></i><br>
    <i onclick="" class="fa-solid fa-globe settings-option"></i><br>
    <i onclick="" style="margin-left: 8px; position: relative; display:inline-block; right:5.5" class="fa-solid fa-scale-balanced settings-option"></i><br>
</div>
<?php
$fullpage = $_REQUEST['page'];
$param = preg_split("/\//", $fullpage, -1, PREG_SPLIT_NO_EMPTY);
?>

<style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

    .site-controllers {
        position: fixed;
        left: 50%;
        /* right: 42%; */
        bottom: 20px;
        width: 75px;
        margin-left: -37.5px;
        height: 75px;
        /* SET TO 350 TO SHOW MORE */
        background-color: #fff;
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
        border-radius: 50px;
        z-index: 9999 !important;
        cursor: pointer;
        transition: all 2s;
        transform: scaleY(1);
    }

    .site-controllers-expanded {
        position: fixed;
        left: 50%;
        /* right: 42%; */
        bottom: 60%;
        width: 75px;
        margin-left: -37.5px;
        height: 265px;
        /* SET TO 350 TO SHOW MORE */
        background-color: #fff;
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
        border-radius: 50px;
        z-index: 9999 !important;
        transition: all 1.2s;
        transform: scaleY(1);
        cursor: pointer;
    }

    .settings-option {
        display: inline-block;
        font-size: 48px;
        margin-left: 13px;
        margin-top: 13.5px;
    }

    #settings-icon {
        display: inline-block;
        font-size: 48px;
        margin-left: 13px;
        margin-top: 13.5px;
        transform: rotate(0deg);
    }

    #settings-icon:hover {
        transition: all 1s;
        transform: rotate(180deg);
    }
</style>
<script>
    var isExpanded = false;
    const toggleSettings = () => {
        if (isExpanded) {
            $(".settings-option").fadeOut()
            $("#sitecontrollers").addClass("site-controllers")
            $("#sitecontrollers").removeClass("site-controllers-expanded")
            isExpanded = !isExpanded;
            console.log("Shrinked")
        } else {
            $("#sitecontrollers").addClass("site-controllers-expanded")
            $("#sitecontrollers").removeClass("site-controllers")
            setTimeout(() => {
                $(".settings-option").fadeIn("slow", ).css("display", "inline-block");
            }, 500)
            isExpanded = !isExpanded;
            console.log("Expanded")
        }
    }
    $(".settings-option").hide()
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    var loginPasswordVisible = false;
    const ToggleLoginVisiblePassword = () => {
        if (loginPasswordVisible) {
            $("#VisiblePasswordIndicator").removeClass("fa-eye-slash")
            $("#VisiblePasswordIndicator").addClass("fa-eye")
            $("#login_password").attr("type", "password");
        } else {
            $("#VisiblePasswordIndicator").removeClass("fa-eye")
            $("#VisiblePasswordIndicator").addClass("fa-eye-slash")
            $("#login_password").attr("type", "text");
        }
        loginPasswordVisible = !loginPasswordVisible;
    }

    function do_login() {
        $(document).ready(() => {
            let email = $("#login_email").val();
            let password = $("#login_password").val();
            $.post(siteURL + "api/login", {
                    "username": email,
                    "password": password
                }, )
                .done(function(data) {
                    let response = data.response;
                    if (response !== "WrongCredentials") {
                        document.cookie = "token=" + response;
                        <?php

                        if (isset($param[1])) {
                            $next = urldecode(base64_decode($param[1]));
                            $do = explode("=", $next);
                            //HAY PARAM 1, POSIBLE REDIRECCION AL LOGIN

                            if (substr($do[1], 0, strlen($config["fullsiteurl"])) === $config["fullsiteurl"]) {
                                //La URL es segura y valida
                        ?>
                                window.location.replace("<?= $do[1] ?>");
                            <?php
                            } else {
                            ?>
                                alert("LA URL DESDE LA QUE HA ACCEDIDO SE HA DETECTADO COMO MANIPULADA, PORFAVOR, ENVIENOS INFORMACION SOBRE DONDE HA OBTENIDO EL ENLACE. GRACIAS");
                                window.location.replace("<?= $config["fullsiteurl"] . "contact" ?>");
                            <?php
                            }
                        } else {
                            ?>
                            window.location.replace("<?= $config["fullsiteurl"] . "home" ?>");
                        <?php
                        }
                        ?>
                    } else {
                        alert("Tus credenciales son incorrectas :c")
                    }
                }).fail(function(xhr, status, error) {
                    console.log(status);
                });
        })
    }

    function getToken() {
        cookie = document.cookie.split('; ').reduce((prev, current) => {
            const [name, ...value] = current.split('=');
            prev[name] = value.join('=');
            return prev;
        }, {});
        return cookie.token;
    }
</script>
<script src="<?php echo $config["fullsiteurl"] . "themes/" . $config['theme'] . "/" ?>auth/index.js"></script>

<body style="overflow: hidden ">
    <div class="row">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-6">
            <div class="container">
                <div style="text-align: center; font-size: large; padding:10px" class="errmsg">
                    <style>
                        .progressbar {
                            height: 15px;
                            animation: progressbar-countdown;
                            /* Placeholder, this will be updated using javascript */
                            animation-duration: 10s;
                            /* We stop in the end */
                            animation-iteration-count: 1;
                            /* We want a linear animation, ease-out is standard */
                            animation-timing-function: linear;
                            animation-fill-mode: forwards;
                        }

                        @keyframes progressbar-countdown {
                            0% {
                                width: 100%;
                            }

                            100% {
                                width: 0%;
                            }
                        }
                    </style>
                    <?php
                    if (isset($param[1])) {
                        if ($param[1] == "invalid_invitation") {
                    ?>
                            <div class="card bg-danger">
                                <div class="card-body text-white">
                                    Invalid invite code.
                                </div>
                                <div style="padding:10px" class="wrapper">
                                    <div class="progressbar" id="progress-bar" style="width: 100%; height: 3px; background-color: #fff; position:relative; bottom:1rem"></div>
                                    <script>
                                        function updateURL(nextURL, nextTitle) {
                                            const nextState = {
                                                additionalInformation: 'Updated the URL with JS'
                                            };

                                            // This will create a new entry in the browser's history, without reloading
                                            window.history.pushState(nextState, nextTitle, nextURL);

                                            // This will replace the current entry in the browser's history, without reloading
                                            window.history.replaceState(nextState, nextTitle, nextURL);
                                        }
                                        setTimeout(() => {
                                            $(".errmsg").fadeOut()
                                            updateURL("<?= $config["fullsiteurl"] ?>auth", "<?= $config["sitename"] ?> - Auth")
                                        }, 10000);
                                    </script>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" style="cursor: pointer" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" id="headingOne">
                            <h5 class="mb-0">
                                <h4 style="margin-bottom: 0;" class="card-title">Already user? Login</h4>
                            </h5>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <div class="login-form" style="text-align: center;">
                                    <!-- Username -->
                                    <div style="display: flex; flex-wrap:wrap">
                                        <div style="flex: 1 1 200px" class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><i class="fa-solid fa-at"></i></span>
                                            </div>
                                            <input id="login_email" value="admin@societyplus.net" placeholder="e-Mail" type="email" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                        </div>
                                        <!-- /Username -->
                                        <!-- Password -->
                                        &nbsp;
                                        <div style="flex: 1 1 200px" class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><i class="fa-solid fa-lock"></i></span>
                                            </div>
                                            <input id="login_password" value="admin1234" type="password" class="form-control" placeholder="Password" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <button onclick="ToggleLoginVisiblePassword()" class="btn btn-outline-secondary" type="button"><i id="VisiblePasswordIndicator" class="fa-solid fa-eye"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Password -->
                                    <button type="button" onclick="do_login()" id="signIn" class="btn btn-primary">Login</button>
                                    <p>
                                        Or
                                    </p>
                                    <button type="button" disabled class="btn btn-primary">
                                        <img style="width: 30px; border-radius: 100px; background-color: white; padding:5px" src="https://www.google.com/images/branding/googleg/1x/googleg_standard_color_128dp.png" alt="G">
                                        Sign in with google
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($config["register_mode"] == "open") {
                    ?>
                        <div class="card">
                            <div class="card-header" style="cursor: pointer" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <h4 style="margin-bottom: 0;" class="card-title">New over here? Register</h4>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                <div class="card-body" style="text-align: center;">
                                    <button onclick='window.location.href = "<?= $config["fullsiteurl"] ?>register"' type="button" id="signUp" class="btn btn-primary">Registrarse</button>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <?php
                    if ($config["register_mode"] !== "closed") {
                    ?>
                        <script>
                            function goInvited() {
                                let invite = $("#inviteCodeInput").val();
                                window.location.href = "<?= $config['fullsiteurl'] ?>invited/" + invite;
                            }
                        </script>
                        <div class="card">
                            <div class="card-header" style="cursor: pointer" id="headingTwo" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <h4 style="margin-bottom: 0;" class="card-title">Having an invite code? Over here sir/miss</h4>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="inviteCodeInput" placeholder="Your invitation here :)">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" onclick="goInvited()">Go!</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
        </div>
    </div>
    <script>
        $(document).keydown(
            function(event) {
                if (event.which == 13) {
                    do_login();
                }
            }
        );
    </script>
</body>