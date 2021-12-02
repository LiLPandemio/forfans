<?php
require(ROOT . "/config.php");
?>

<head>
	<meta charset="UTF-8">
	<meta name="description" content="<?php echo $config["description"]?>">
	<meta name="keywords" content="<?php echo $config["keywords"]?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="<?php echo $config["fullsiteurl"] . "themes/" . $config['theme'] . "/" ?>assets/jquery/jquery.min.js"></script>
	<script src="<?php echo $config["fullsiteurl"] . "themes/" . $config['theme'] . "/" ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="<?php echo $config["fullsiteurl"] . "themes/" . $config['theme'] . "/" ?>assets/bootstrap/css/bootstrap.min.css">
	<title><?php echo $config["sitename"] . " - " . $_REQUEST["page"]; ?></title>
