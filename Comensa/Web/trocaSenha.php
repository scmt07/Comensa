<?php
require "app/dbconnect.php";

session_start();

$senhaErr = $novaErr = "";
$vazio = False;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if($_POST['action'] == 'cancelar') {
    header('Location: home.php');
  }
  #verifica se os campos foram corretamentes preenchidos
  #-----------------------------------Senha-----------------------------------
  if($_POST['action'] == 'login') {
    if (empty($_POST["senha"])) {
      $senhaErr = "*Senha é necessário";
      $vazio = True;
    }
    else {
      $sql_query = "SELECT senha FROM estabelecimento WHERE idEstab = '$_SESSION[id]';";
      $res = mysqli_query($con,$sql_query) or die (mysqli_error($con));
      $row = $res->fetch_assoc();

      if($_POST["senha"] != $row['senha']) {
        $senhaErr = "*Senha incorreta";
        $vazio = True;
      }
    }
    #-----------------------------------Nova Senha-----------------------------------
    if (empty($_POST["nova"])) {
      $novaErr = "*Nova senha é necessário";
      $vazio = True;
    }
    else if (strlen($_POST["nova"]) < 6) {
      $novaErr = "*Senha necessita de pelo menos 6 dígitos";
      $vazio = True;
    }
    #cadastra o usuario
    if($vazio == False) {
      $sql_query = "UPDATE estabelecimento SET senha = '$_POST[nova]' WHERE idEstab = '$_SESSION[id]';";

    	if(mysqli_query($con,$sql_query) or die (mysqli_error($con))) {
        $_SESSION['info'] = "senha";
        $_SESSION['page'] = 1;
    		header('Location: confirmacao.php');
    	} else {
    		$userErr = "*Problema no cadastramento(conexao)";
    	}
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>TrocarSenha</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="style/altProd.css">
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
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="Cadastro">Trocar Senha</label><br>
        <div class="input-group">
          <input type="password" class="form-control" name="senha" placeholder="Senha">
          <span class="error"><?php echo $senhaErr;?></span>
        </div>

        <div class="input-group">
          <input type="password" class="form-control" name="nova" placeholder="Nova senha">
          <span class="error"><?php echo $novaErr;?></span>
        </div>

        <div class="input-group">
          <button type="submit" onclick="return confirm('Trocar senha?');" name="action" value="login" class="btn btn-primary">Trocar</button>
        </div>

        <div class="input-group">
          <button type="submit" name="action" value="cancelar" class="btn btn-primary">Cancelar</button>
        </div>

      </form>

    </div>

  </div>

</div>

</body>
</html>
