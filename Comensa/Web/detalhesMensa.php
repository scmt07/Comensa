<?php
require "app/dbconnect.php";
session_start();
$estab = $_SESSION['estab'];
$mensa = $_SESSION['idMensa'];

$sql_query = "SELECT * FROM mensalista WHERE idMensa = $mensa;";
$res = mysqli_query($con,$sql_query) or die (mysqli_error($con));
$row = $res->fetch_assoc();
$aux = mysqli_num_rows($res);
$user = $row['userMensa'];
$cpf = $row['CPF'];
$nome = $row['nome'];
$tel = $row['telefone'];
$email = $row['email'];
$sql_query = "SELECT * FROM endereco WHERE idEndereco = '$row[idEndereco]';";
$res = mysqli_query($con,$sql_query) or die (mysqli_error($con));
$row = $res->fetch_assoc();
$bairro = $row['bairro'];
$rua = $row['rua'];
$num = $row['numero'];
$comp = $row['complemento'];
$cep = $row['CEP'];
$sql_query = "SELECT saldo FROM contas WHERE idMensa = $mensa;";
$res = mysqli_query($con,$sql_query) or die (mysqli_error($con));
$conta = $res->fetch_assoc();
$saldo = $conta['saldo'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if($_POST['action'] == 'voltar') {
    header('Location: mensalistas.php');
  }
  if($_POST['action'] == 'deletar') {
    header('Location: delMensa.php');
  }
  if($_POST['action'] == 'alterar') {
    $_SESSION['info'] = $user;
    $_SESSION['idEnd'] = $row['idEndereco'];
    header('Location: altMensa.php');
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>detalhesMensa</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="style/detalhesMensa.css">
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
        <label for="Cadastro">Mensalista Detalhes</label>
        <p>Usuário: <?php echo $user?></p>
        <p>CPF: <?php echo $cpf?></p>
        <p>Nome: <?php echo $nome?></p>
        <p>Telefone: <?php echo $tel?></p>
        <p>E-mail: <?php echo $email?></p>
        <p>Bairro: <?php echo $bairro?></p>
        <p>Rua: <?php echo $rua?></p>
        <p>Numero: <?php echo $num?></p>
        <p>Complemento: <?php echo $comp?></p>
        <p>CEP: <?php echo $cep?></p>
        <p>Saldo: <?php echo $saldo?></p>
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
