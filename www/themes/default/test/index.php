<?php
//En esta pagina se hacen pruebas con los engines de la pagina.
echo "This page is for testing purpose";
require(ROOT . "/config.php");
require(ROOT . "/functions/authEngine.php");
require(ROOT . "/locale/" . $config["default_lang"] . ".php");
if (isset($_REQUEST['username']) and $_REQUEST["password"]) {
    echo login($_REQUEST['username'], $_REQUEST['password']);
} else {
?>

    <body>
        <?php echo lang("welcome_to"); ?>
    </body>

    </html>

<?php
}

?>