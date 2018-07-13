<?php
require "app/dbconnect.php";

session_start();

$nomeErr = $precoErr = "";
$vazio = False;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if($_POST['action'] == 'cancelar') {
    header('Location: home.php');
  }
  #verifica se os campos foram corretamentes preenchidos
  if($_POST['action'] == 'login') {
    #-----------------------------------Nome-----------------------------------
    if (empty($_POST["nome"])) {
      $nomeErr = "*Nome é necessário";
      $vazio = True;
    }
    else {
      $sql_query = "SELECT nome FROM produto WHERE nome = '$_POST[nome]' and idEstab = '$_SESSION[id]';";
      $res = mysqli_query($con,$sql_query) or die (mysqli_error($con));

      $aux = mysqli_num_rows($res);
      if($aux > 0) {
        $nomeErr = "*Produto já existe";
        $vazio = True;
      }
    }
    #-----------------------------------Preço-----------------------------------
    if (empty($_POST["preco"])) {
      $precoErr = "*Preço é necessário";
      $vazio = True;
    }
    else {
      $preco = number_format($_POST["preco"],2);
    }
    #cadastra o usuario
    if($vazio == False) {
      $sql_query = "INSERT INTO produto(idEstab, nome, preco, descricao) VALUES ('$_SESSION[id]','$_POST[nome]','$preco','$_POST[des]');";

    	if(mysqli_query($con,$sql_query) or die (mysqli_error($con))) {
        $_SESSION['info'] = $_POST['nome'];
        $_SESSION['page'] = 20;
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
  <title>cadastroProduto</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="style/cadMensa.css">
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
        <label for="Cadastro">Cadastro Produto</label>

        <div class="input-group">
          <input type="text" class="form-control" name="nome" placeholder="Nome do produto">
          <span class="error"><?php echo $nomeErr;?></span>
        </div>

        <div class="input-group">
          <input type="number" min="0" step="0.01" class="form-control" name="preco" placeholder="Preço">
          <span class="error"><?php echo $precoErr;?></span>
        </div>

        <div class="input-group">
          <textarea class="form-control" name="des" placeholder="Descrição" rows="3"></textarea>
        </div>

        <div class="input-group">
          <button type="submit" name="action" value="login" class="btn btn-primary">Cadastrar</button>
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
