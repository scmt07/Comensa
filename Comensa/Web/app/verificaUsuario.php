<?php

require "dbconnect.php";

$user = $_GET["user"];
$senha = $_GET["senha"];
$row;

$sql_query = "SELECT idMensa, userMensa, CPF, senha FROM mensalista WHERE userMensa = '$user';";
$res = mysqli_query($con,$sql_query) or die (mysqli_error($con));

$aux = mysqli_num_rows($res);

if($aux == 0) {
  $row = [
    "idMensa" => "-2",
    "userMensa" => "",
    "CPF" => "",
    "senha" => "",
  ];
} else {
  $sql_query = "SELECT idMensa, userMensa, CPF, senha FROM mensalista WHERE userMensa = '$user' and senha = '$senha';";
  $res = mysqli_query($con,$sql_query) or die (mysqli_error($con));

  $aux = mysqli_num_rows($res);

  if($aux == 0) {
    $row = [
      "idMensa" => "-1",
      "userMensa" => "",
      "CPF" => "",
      "senha" => "",
    ];
  } else {
    $row = $res->fetch_array(MYSQL_ASSOC);
  }
}

echo json_encode($row);

?>
