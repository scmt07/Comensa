<?php
require "app/dbconnect.php";

session_start();

$nomeErr = "";
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
      $sql_query = "SELECT idPromo FROM promocao WHERE nome = '$_POST[nome]' and idEstab = '$_SESSION[id]';";
      $res = mysqli_query($con,$sql_query) or die (mysqli_error($con));
      $row = $res->fetch_assoc();

      $aux = mysqli_num_rows($res);
      if($aux < 1) {
        $nomeErr = "*Promoção não existe";
        $vazio = True;
      }
    }
    #deleta o produto
    if($vazio == False) {
      $sql_query = "DELETE FROM promocao WHERE idPromo = '$row[idPromo]' AND idEstab = '$_SESSION[id]';";

    	if(mysqli_query($con,$sql_query) or die (mysqli_error($con))) {
        $_SESSION['info'] = $_POST['nome'];
        $_SESSION['page'] = 32;
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
  <title>DeletarPromoção</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="style/delMensa.css">
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
        <label for="Cadastro">Deletar Promoção</label><br>
        <div class="input-group">
          <input type="text" class="form-control" name="nome" placeholder="Nome da promoção">
          <span class="error"><?php echo $nomeErr;?></span>
        </div>

        <div class="input-group">
          <button type="submit" onclick="return confirm('Deletar promoção?');" name="action" value="login" class="btn btn-primary">Deletar</button>
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
