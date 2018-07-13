<?php
require "app/dbconnect.php";

session_start();

$telefoneErr = $emailErr = $cepErr = "";
$vazio = False;
$tel = $email = $bairro = $rua = $num = $comp = $cep = True;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if($_POST['action'] == 'cancelar') {
    header('Location: mensalistas.php');
  }
  #verifica se os campos foram corretamentes preenchidos
  #-----------------------------------Telefone-----------------------------------
  if($_POST['action'] == 'login') {
    if (empty($_POST["telefone"])) {
      $tel = False;
    }
    else if (strlen($_POST["telefone"]) != 10 && strlen($_POST["telefone"]) != 11 ) {
      if(strlen($_POST["telefone"]) == 9 || strlen($_POST["telefone"]) == 8) {
        $telefoneErr = "*Telefone inválido(esqueceu o DDD?)";
        $vazio = True;
      } else {
        $telefoneErr = "*Telefone inválido";
        $vazio = True;
      }
    }
    #-----------------------------------Email-----------------------------------
    if (empty($_POST["email"])) {
      $email = False;
    }
    else if (!filter_var(($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
      $emailErr = "*Email inválido";
      $vazio = True;
    }
    #-----------------------------------Bairro-----------------------------------
    if (empty($_POST["bairro"])) {
      $bairro = False;
    }
    #-----------------------------------Rua-----------------------------------
    if (empty($_POST["rua"])) {
      $rua = False;
    }
    #-----------------------------------Numero-----------------------------------
    if (empty($_POST["numero"])) {
      $num = False;
    }
    #-----------------------------------Complemento-----------------------------------
    if (empty($_POST["complemento"])) {
      $comp = False;
    }
    #-----------------------------------CEP-----------------------------------
    if (empty($_POST["cep"])) {
      $cep = False;
    }
    else if (strlen($_POST["cep"]) != 8) {
      $cepErr = "*CEP inválido";
      $vazio = True;
    }
    #cadastra o usuario
    if($vazio == False) {
      if($tel) {
        $sql_query = "UPDATE mensalista SET telefone = '$_POST[telefone]' WHERE idMensa = '$_SESSION[idMensa]';";
        mysqli_query($con,$sql_query) or die (mysqli_error($con));
      }
      if($email) {
        $sql_query = "UPDATE mensalista SET email = '$_POST[email]' WHERE idMensa = '$_SESSION[idMensa]';";
        mysqli_query($con,$sql_query) or die (mysqli_error($con));
      }
      if($bairro) {
        $sql_query = "UPDATE endereco SET bairro = '$_POST[bairro]' WHERE idEndereco = '$_SESSION[idEnd]';";
        mysqli_query($con,$sql_query) or die (mysqli_error($con));
      }
      if($rua) {
        $sql_query = "UPDATE endereco SET rua = '$_POST[rua]' WHERE idEndereco = '$_SESSION[idEnd]';";
        mysqli_query($con,$sql_query) or die (mysqli_error($con));
      }
      if($num) {
        $sql_query = "UPDATE endereco SET numero = '$_POST[numero]' WHERE idEndereco = '$_SESSION[idEnd]';";
        mysqli_query($con,$sql_query) or die (mysqli_error($con));
      }
      if($comp) {
        $sql_query = "UPDATE endereco SET complemento = '$_POST[complemento]' WHERE idEndereco = '$_SESSION[idEnd]';";
        mysqli_query($con,$sql_query) or die (mysqli_error($con));
      }
      if($cep) {
        $sql_query = "UPDATE endereco SET CEP = '$_POST[cep]' WHERE idEndereco = '$_SESSION[idEnd]';";
        mysqli_query($con,$sql_query) or die (mysqli_error($con));
      }
      $_SESSION['page'] = 12;
      header('Location: confirmacao.php');

    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>alterarMensalista</title>
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
        <label for="Cadastro">Alterar Mensalista</label>
        <p>Altere os campos desejados do <?php echo $_SESSION['info'];?>:</p>
        <div class="input-group">
          <input type="text" class="form-control" name="telefone" placeholder="Telefone(somente números)">
          <span class="error"><?php echo $telefoneErr;?></span>
        </div>

        <div class="input-group">
          <input type="text" class="form-control" name="email" placeholder="Email">
          <span class="error"><?php echo $emailErr;?></span>
        </div>

        <div class="input-group">
          <input type="text" class="form-control" name="bairro" placeholder="Bairro">
        </div>

        <div class="input-group">
          <input type="text" class="form-control" name="rua" placeholder="Rua">
        </div>

        <div class="input-group">
          <input type="text" class="form-control" name="numero" placeholder="Número">
        </div>

        <div class="input-group">
          <input type="text" class="form-control" name="complemento" placeholder="Complemento">
        </div>

        <div class="input-group">
          <input type="text" class="form-control" name="cep" placeholder="CEP(somente números)">
          <span class="error"><?php echo $cepErr;?></span>
        </div>

        <div class="input-group">
          <button type="submit" onclick="return confirm('Alterar mensalista?');" name="action" value="login" class="btn btn-primary">Alterar</button>
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
