<?php
//En esta pagina se hacen pruebas con los engines de la pagina.
echo "This page is for testing purpose";
require(ROOT . "/config.php");
require(ROOT . "/locale/".$config["default_lang"].".php");
?>

<body>
    <?php echo lang("welcome_to"); ?>
</body>
</html>