<?php
require(ROOT. "/config.php");

$conn = new PDO("mysql:host=".$database['hostname'].";dbname=".$database['database'], $database['username'], $database['password']);
// $sql = "SELECT * FROM `usuarios` WHERE 1";
// $query = $conn -> prepare($sql);
// $query -> execute();
// $query = $query -> fetchAll();
// var_dump($query);
