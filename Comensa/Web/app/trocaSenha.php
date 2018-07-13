<?php

require "dbconnect.php";

$idMensa = $_POST["idMensa"];
$senha = $_POST["senha"];

$sql_query = "UPDATE mensalista SET senha = '$senha' WHERE idMensa = '$idMensa';";
if(mysqli_query($con,$sql_query) or die (mysqli_error($con))) {
  echo "inserido";
} else {
  echo "false";
}

?>
