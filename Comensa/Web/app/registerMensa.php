<?php

require "dbconnect.php";

$UserMensa = $_POST["usua"];
$CPF = $_POST["cpf"];
$Nome = $_POST["nome"];
$Telefone = $_POST["tele"];
$Email = $_POST["email"];
$Senha = $_POST["senha"];
$IdEndereco;
$Bairro = $_POST["bairro"];
$Rua = $_POST["rua"];
$Numero = $_POST["nume"];
$Complemento = $_POST["comple"];
$CEP = $_POST["cep"];

$sql_query = "SELECT * FROM mensalista WHERE userMensa = '$UserMensa';";
$res = mysqli_query($con,$sql_query) or die (mysqli_error($con));

$aux = mysqli_num_rows($res);

if($aux > 0) {
	echo "false";
} else {

	$sql_query = "INSERT INTO endereco(bairro, rua, numero, complemento, CEP) VALUES ('$Bairro','$Rua','$Numero', '$Complemento','$CEP');";
	mysqli_query($con,$sql_query) or die (mysqli_error($con));
	$res = mysqli_insert_id($con);

	$sql_query = "INSERT INTO mensalista(userMensa, CPF, nome, telefone, email, senha, idEndereco) VALUES ('$UserMensa','$CPF',
		'$Nome', '$Telefone','$Email','$Senha','$res');";

	if(mysqli_query($con,$sql_query) or die (mysqli_error($con))) {
		$res = mysqli_insert_id($con);
		echo "$res";
	} else {
		echo "false";
	}
}

?>
