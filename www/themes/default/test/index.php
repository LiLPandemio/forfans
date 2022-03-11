<?php
//En esta pagina se hacen pruebas con los engines de la pagina.
require_once(ROOT . "/config.php");
require_once(ROOT . "/functions/authEngine.php");
require_once(ROOT . "/functions/contentEngine.php");
require_once(ROOT . "/functions/userEngine.php");
require_once(ROOT . "/functions/backupEngine.php");
require_once(ROOT . "/locale/" . $config["default_lang"] . ".php");

?>

<body>
    <br>
    <?php
    dbExport();
    ?>
</body>

</html>