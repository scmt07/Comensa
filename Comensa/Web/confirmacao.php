<?php
require "app/dbconnect.php";

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>confirmacao</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="style/confirmacao.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<!--Menu-->
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
      <li><a href="login.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
  </div>
</nav>
<!--Cadastro-->
<div class="home">
  <div class="item">
    <div class="content">
      <p align = 'center'>
<?php
  if(!empty($_SESSION['info'])) {
    if($_SESSION['page'] == 40) {
      echo "Novo saldo de R$ $_SESSION[info]";
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST['action'] == 'cancelar') {
          header('Location: home.php');
        }
      }
    }
    else if($_SESSION['page'] == 1) {
      echo "Senha foi trocada";
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST['action'] == 'cancelar') {
          header('Location: home.php');
        }
      }
    }
    else if($_SESSION['page'] == 10) {
      echo "Mensalista $_SESSION[info] foi cadastrado";
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST['action'] == 'cancelar') {
          header('Location: home.php');
        }
      }
    }
    else if($_SESSION['page'] == 11) {
      echo "Conta criada para mensalista $_SESSION[info]";
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST['action'] == 'cancelar') {
          header('Location: home.php');
        }
      }
    }
    else if($_SESSION['page'] == 12) {
      echo "Alterados os dados do mensalista $_SESSION[info]";
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST['action'] == 'cancelar') {
          header('Location: detalhesMensa.php');
        }
      }
    }
    else if($_SESSION['page'] == 13) {
      echo "Deletado a conta do mensalista $_SESSION[info]";
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST['action'] == 'cancelar') {
          header('Location: home.php');
        }
      }
    }
    else if($_SESSION['page'] == 20) {
      echo "Produto $_SESSION[info] foi cadastrado";
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST['action'] == 'cancelar') {
          header('Location: cadastroProduto.php');
        }
      }
    }
    else if($_SESSION['page'] == 21) {
      echo "Produto $_SESSION[info] foi alterado";
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST['action'] == 'cancelar') {
          header('Location: detalhesProd.php');
        }
      }
    }
    else if($_SESSION['page'] == 22) {
      echo "Produto $_SESSION[info] foi deletado";
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST['action'] == 'cancelar') {
          header('Location: home.php');
        }
      }
    }
    else if($_SESSION['page'] == 30) {
      echo "Promocao $_SESSION[info] foi cadastrado";
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST['action'] == 'cancelar') {
          header('Location: cadastroPromocao.php');
        }
      }
    }
    else if($_SESSION['page'] == 31) {
      echo "Promocao $_SESSION[info] foi alterado";
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST['action'] == 'cancelar') {
          header('Location: detalhesProm.php');
        }
      }
    }
    else if($_SESSION['page'] == 32) {
      echo "Promocao $_SESSION[info] foi deletado";
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST['action'] == 'cancelar') {
          header('Location: home.php');
        }
      }
    }
    else {
      echo "Ocorreu um erro";
    }
  }
  else {
    echo "vazio $_SESSION[info]";
  }
?>
      </p>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="input-group">
          <button type="submit" name="action" value="cancelar" class="btn btn-primary">OK</button>
        </div>

      </form>

    </div>

  </div>

</div>

</body>
</html>
