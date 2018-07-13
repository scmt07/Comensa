<?php
session_start();
$estab = $_SESSION['estab'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="style/home.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Comensa</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Mensalista
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="cadastroMensalista.php">Cadastrar</a></li>
          <li><a href="criarConta.php">Criar Conta</a></li>
          <li><a href="mensalistas.php">Alterar</a></li>
          <li><a href="delMensa.php">Deletar</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Produto
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="cadastroProduto.php">Cadastrar</a></li>
          <li><a href="produtos.php">Alterar</a></li>
          <li><a href="delProd.php">Deletar</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Promoção
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="cadastroPromocao.php">Cadastrar</a></li>
          <li><a href="promocoes.php">Alterar</a></li>
          <li><a href="delProm.php">Deletar</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Saldo
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="adCredito.php">Adicionar Crédito</a></li>
          <li><a href="adGasto.php">Adicionar Gasto</a></li>
        </ul>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="trocaSenha.php">Trocar Senha</a></li>
      <li><a href="login.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
  </div>
</nav>

<div class="container">
  <h3>Bem vindo <?php echo $estab;?></h3>
</div>

</body>
</html>
