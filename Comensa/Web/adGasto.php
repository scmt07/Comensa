<?php
require "app/dbconnect.php";

session_start();

$userErr = $valorErr = $verificar = "";
$pedido = False;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if($_POST['action'] == 'cancelar') {
    header('Location: home.php');
  }
#---------------------------------verificando credito-----------------------
  if($_POST['action'] == 'verificar') {
    $vazio = False;
    if (empty($_POST["user"])) {
      $userErr = "*Usuário é necessário";
      $vazio = True;
    }
    else {
      $sql_query = "SELECT idMensa FROM mensalista WHERE userMensa = '$_POST[user]';";
      $res = mysqli_query($con,$sql_query) or die (mysqli_error($con));
      $row = $res->fetch_assoc();

      $aux = mysqli_num_rows($res);
      if($aux < 1) {
        $userErr = "*Usuário não existe";
        $vazio = True;
      }
      else {
        $sql_query = "SELECT saldo FROM contas WHERE idMensa = '$row[idMensa]' and idEstab = '$_SESSION[id]';";
        $res = mysqli_query($con,$sql_query) or die (mysqli_error($con));
        $conta = $res->fetch_assoc();
        $aux = mysqli_num_rows($res);

        if($aux < 1) {
          $userErr = "*Usuário não tem conta";
          $vazio = True;
        }
      }
    }
    if($vazio == False) {
        $verificar = $conta['saldo'];
        $pedido = True;
    }
  }
  #verifica se os campos foram corretamentes preenchidos
  #-----------------------------------Usuario-----------------------------------
  if($_POST['action'] == 'login') {
    $vazio = False;
    if (empty($_POST["user"])) {
      $userErr = "*Usuário é necessário";
      $vazio = True;
    }
    else {
      $sql_query = "SELECT idMensa FROM mensalista WHERE userMensa = '$_POST[user]';";
      $res = mysqli_query($con,$sql_query) or die (mysqli_error($con));
      $row = $res->fetch_assoc();

      $aux = mysqli_num_rows($res);
      if($aux < 1) {
        $userErr = "*Usuário não existe";
        $vazio = True;
      }
      else {
        $sql_query = "SELECT saldo FROM contas WHERE idMensa = '$row[idMensa]' and idEstab = '$_SESSION[id]';";
        $res = mysqli_query($con,$sql_query) or die (mysqli_error($con));
        $conta = $res->fetch_assoc();
        $aux = mysqli_num_rows($res);

        if($aux < 1) {
          $userErr = "*Usuário não tem conta";
          $vazio = True;
        }
      }
    }
    if (empty($_POST["valor"])) {
      $valorErr = "*Valor é necessário";
      $vazio = True;
    }
    else {
      $valor = number_format($_POST["valor"],2);
    }
    #cadastra o usuario
    if($vazio == False) {
      $saldo = $conta['saldo'] - $valor;
      $saldo = number_format($saldo,2);
      $sql_query = "UPDATE contas SET saldo = '$saldo' WHERE idMensa = '$row[idMensa]' AND idEstab = '$_SESSION[id]';";

    	if(mysqli_query($con,$sql_query) or die (mysqli_error($con))) {
        $_SESSION['info'] = $saldo;
        $_SESSION['page'] = 40;
    		header("Location: confirmacao.php");
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
  <title>AdicionarGasto</title>
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
        <label for="Cadastro">Adicionar Gasto</label><br>
        <div class="input-group">
          <input type="text" class="form-control" name="user" placeholder="Usuário do mensalista">
          <span class="error"><?php echo $userErr;?></span>
        </div>

        <div class="input-group">
          <input type="number" min="0" step="0.01" class="form-control" name="valor" placeholder="Valor">
          <span class="error"><?php echo $valorErr;?></span>
        </div>

        <div class="input-group">
          <button type="submit" onclick="return confirm('Adicionar gasto?');" name="action" value="login" class="btn btn-primary">Adicionar</button>
        </div>

        <div class="input-group">
          <button type="submit" name="action" value="verificar" class="btn btn-primary">Verificar saldo do mensalista</button>
          <?php if ($pedido) {
            echo "Saldo do mensalista é de: R$ $verificar";
          }?>
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