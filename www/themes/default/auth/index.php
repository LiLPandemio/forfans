<?php require(ROOT . "/config.php"); require(ROOT . "/locale/".$config['default_lang'].".php");  ?>
<link rel="stylesheet" href="<?php echo $config["fullsiteurl"] . "themes/" . $config['theme'] . "/" ?>auth/style.css">
</head>

<body>
    <div class="container" id="container">
        <div class="site-controllers">
        <i id="settings-icon" class="fa-solid fa-gear"></i>
        </div>
        <div class="form-container sign-up-container">
            <form action="#">
                <h1><?=lang("create_account")?></h1>
                <input type="text" placeholder="Name" />
                <input type="email" placeholder="Email" />
                <input type="password" placeholder="Password" />
                <button><?=lang("register")?></button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="#">
                <h1><?=lang("login")?></h1>
                <input type="email" placeholder="Email" />
                <input type="password" placeholder="Password" />
                <a href="#">Forgot your password?</a>
                <button><?=lang("login")?></button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1><?=lang("welcome_to")?></h1>
                    <p><?=lang("login_subtitle")?></p>
                    <button class="ghost" id="signIn"><?=lang("login")?></button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1><?=lang("welcome_back")?></h1>
                    <p><?=lang("register_subtitle")?></p>
                    <button class="ghost" id="signUp"><?=lang("register")?></button>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="<?php echo $config["fullsiteurl"] . "themes/" . $config['theme'] . "/" ?>auth/index.js"></script>