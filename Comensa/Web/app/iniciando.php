<?php

require "dbconnect.php";
require "Refresh.php";

#$idMensa = $_GET["idMensa"];
$idMensa = 10;
#---------------------------Pega as contas--------------------------------
#$idMensa = 10;
$contas = array();

$sql_query = "SELECT saldo, idEstab, idMensa FROM contas WHERE idMensa = $idMensa;";
$res = mysqli_query($con,$sql_query) or die (mysqli_error($con));


while ($row = $res->fetch_array(MYSQL_ASSOC)) {
  $contas[] = $row;
}
#---------------------------Fim de pega as contas--------------------------------

$refresh = new Refresh;
$refresh->setContas($contas);

$estabs = array();
$produtos = array();
$promocoes = array();
$enderecos = array();
foreach ($contas as $conta) {
  #---------------------------Pega os estabelecimentos--------------------------------
  $idEstab = $conta['idEstab'];

  $sql_query = "SELECT idEstab, nome, telefone, idEndereco FROM estabelecimento WHERE idEstab = $idEstab;";
  $res = mysqli_query($con,$sql_query) or die (mysqli_error($con));

  $row = $res->fetch_array(MYSQL_ASSOC);
  $estabs[] = $row;
  #---------------------------Fim de pega os estabelecimentos--------------------------------
  #---------------------------Pega os enderecos--------------------------------
  $idEnd = $row['idEndereco'];

  $sql_query = "SELECT idEndereco, bairro, rua, numero, complemento, CEP FROM endereco WHERE idEndereco = $idEnd;";
  $res = mysqli_query($con,$sql_query) or die (mysqli_error($con));

  $row = $res->fetch_array(MYSQL_ASSOC);

  $enderecos[] = $row;
  #---------------------------Fim de pega os enderecos--------------------------------
  #---------------------------Pega os produtos--------------------------------
  $sql_query = "SELECT idProd, idEstab, nome, preco, descricao FROM produto WHERE idEstab = $idEstab;";
  $res = mysqli_query($con,$sql_query) or die (mysqli_error($con));

  while ($row = $res->fetch_array(MYSQL_ASSOC)) {
    $produtos[] = $row;
  }
  #---------------------------Fim de pega os produtos--------------------------------
  #---------------------------Pega as promocoes--------------------------------
  $sql_query = "SELECT idPromo, idEstab, nome, dataIni, dataFim, descricao FROM promocao WHERE idEstab = $idEstab;";
  $res = mysqli_query($con,$sql_query) or die (mysqli_error($con));

  while ($row = $res->fetch_array(MYSQL_ASSOC)) {
    $promocoes[] = $row;
  }
  #---------------------------fim de pega as promocoes--------------------------------
}

$refresh->setEstabs($estabs);
$refresh->setEnds($enderecos);
$refresh->setProds($produtos);
$refresh->setProms($promocoes);
echo json_encode($refresh);
?>
