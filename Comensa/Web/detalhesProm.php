<?php
require "app/dbconnect.php";
session_start();

$sql_query = "SELECT * FROM promocao WHERE nome = '$_SESSION[info]' AND idEstab = '$_SESSION[id]';";
$res = mysqli_query($con,$sql_query) or die (mysqli_error($con));
$row = $res->fetch_assoc();
$aux = mysqli_num_rows($res);
$nome = $row['nome'];
$dini = $row['dataIni'];
$dfim = $row['dataFim'];
$des = $row['descricao'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if($_POST['action'] == 'voltar') {
    header('Location: promocoes.php');
  }
  if($_POST['action'] == 'deletar') {
    header('Location: delProm.php');
  }
  if($_POST['action'] == 'alterar') {
    header('Location: altProm.php');
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>detalhesPromo</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="style/detalhesProd.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>

  </script>
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
        <li><a href="login.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </nav>

<!--Cadastro-->
<div class="home">
  <div class="item">
    <div class="content">
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="Cadastro">Promoção Detalhes</label>
        <p>Nome: <?php echo $nome?></p>
        <p>Data de início: <?php echo $dini?></p>
        <p>Data de término: <?php echo $dfim?></p>
        <p>Descrição: <?php echo $des?></p>
        <div class="input-group">
          <button type="submit" name="action" value="alterar" class="btn btn-primary">Alterar</button>
        </div><!-- /input-group -->
        <div class="input-group">
          <button type="submit" name="action" value="deletar" class="btn btn-primary">Deletar</button>
        </div><!-- /input-group -->
        <div class="input-group">
          <button type="submit" name="action" value="voltar" class="btn btn-primary">Voltar</button>
        </div><!-- /input-group -->
      </form>
    </div><!-- /.col-lg-6 -->
  </div><!-- /.row -->
</div>

</body>
</html>
