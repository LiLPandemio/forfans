<?php
require(ROOT . "/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="<?php echo $config["fullsiteurl"]."themes/".$config['theme']."/" ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="<?php echo $config["fullsiteurl"]."themes/".$config['theme']."/" ?>assets/bootstrap/css/bootstrap.min.css">
	<title><?php echo $config["sitename"] . " - " . $_REQUEST["page"]; ?></title>
</head>

<body>
	<a class="btn btn-primary btn-lg" href="#" role="button">ASDASD</a>
</body>

<footer>
</footer>

</html>