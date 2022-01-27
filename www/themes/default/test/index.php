<?php
//En esta pagina se hacen pruebas con los engines de la pagina.
echo "This page is for testing purpose";
require_once(ROOT . "/config.php");
require_once(ROOT . "/functions/authEngine.php");
require_once(ROOT . "/functions/userEngine.php");
require_once(ROOT . "/locale/" . $config["default_lang"] . ".php");

?>

<body>
    <?php echo print_r(getUserData("bacon")) ?>
    
</body>

</html>