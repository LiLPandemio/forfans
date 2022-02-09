<?php
if (isset($_COOKIE['token'])) {
    if ($_COOKIE['token'] !== "") {
        if (checkTokenStatus($_COOKIE['token']) != "INVALID_TOKEN") {
            redirect("home");
        }
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
</script>

<body style="overflow: hidden ">
    <div class="row">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-6">
            <div class="container">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" style="cursor: pointer" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" id="headingOne">
                            <h5 class="mb-0">
                                <h4 style="margin-bottom: 0;" class="card-title">Already user? Login</h4>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <div class="login-form">
                                    <!-- Username -->
                                    <div style="display: flex; flex-wrap:wrap">
                                        <div style="flex: 1 1 200px" class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><i class="fa-solid fa-at"></i></span>
                                            </div>
                                            <input id="login_email" placeholder="e-Mail" type="email" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                        </div>
                                        <!-- /Username -->
                                        <!-- Password -->
                                        &nbsp;
                                        <div style="flex: 1 1 200px" class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"><i class="fa-solid fa-lock"></i></span>
                                            </div>
                                            <input id="login_password" type="password" class="form-control" placeholder="Password" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <button onclick="ToggleLoginVisiblePassword()" class="btn btn-outline-secondary" type="button"><i id="VisiblePasswordIndicator" class="fa-solid fa-eye"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Password -->
                                    <button type="button" onclick="do_login()" id="signIn" class="btn btn-primary">Login</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" style="cursor: pointer" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <h4 style="margin-bottom: 0;" class="card-title">New over here? Register</h4>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                Register form here
                                <button type="button" id="signUp" class="btn btn-primary">SignUp</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
        </div>
    </div>
</body>
<script src="<?php echo $config["fullsiteurl"] . "themes/" . $config['theme'] . "/" ?>auth/index.js"></script>