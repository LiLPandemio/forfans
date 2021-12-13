<?php 
require(ROOT . "/config.php");
require(ROOT . "/functions/authEngine.php");
require(ROOT . "/functions/utils1.php");
if (isset($_COOKIE)) {
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

<body>
    <div class="container" id="container">
        <div class="site-controllers" id="sitecontrollers">
            <i onclick="toggleSettings()" id="settings-icon" class="settings-icon fa-solid fa-gear"></i><br>
            <i onclick="" class="fa-solid fa-palette settings-option"></i><br>
            <i onclick="" class="fa-solid fa-globe settings-option"></i><br>
            <i onclick="" style="position: relative; display:inline-block; right:5.5" class="fa-solid fa-scale-balanced settings-option"></i><br>
        </div>
        <div class="form-container sign-up-container">
            <form action="#">
                <h1><?= lang("create_account") ?></h1>
                <input type="text" placeholder="Name" />
                <input type="email" placeholder="Email" />
                <input type="password" placeholder="Password" />
                <button><?= lang("register") ?></button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="#">
                <h1><?= lang("login") ?></h1>
                <input type="email" id="login_email" value="admin@societyplus.net" placeholder="Email" />
                <input type="password" id="login_password" value="admin1234" placeholder="Password" />
                <a href="#">Forgot your password?</a>
                <button onclick="do_login()"><?= lang("login") ?></button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1><?= lang("welcome_to") ?></h1>
                    <p><?= lang("login_subtitle") ?></p>
                    <button class="ghost" id="signIn"><?= lang("login") ?></button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1><?= lang("welcome_back") ?></h1>
                    <p><?= lang("register_subtitle") ?></p>
                    <button class="ghost" id="signUp"><?= lang("register") ?></button>
                </div>
            </div>
        </div>
    </div>
</body>
<script>const siteURL = "<?php echo $config["fullsiteurl"]?>"</script>
<script src="<?php echo $config["fullsiteurl"] . "themes/" . $config['theme'] . "/" ?>auth/index.js"></script>