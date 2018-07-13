<?php
require "app/dbconnect.php";

session_start();

$nomeErr = "";
$vazio = False;
$nome = $dini = $dfim = $des = True;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if($_POST['action'] == 'cancelar') {
    header('Location: promocoes.php');
  }
  #verifica se os campos foram corretamentes preenchidos
  if($_POST['action'] == 'login') {
    #-----------------------------------Nome-----------------------------------
    if (empty($_POST["nome"])) {
      $nome = False;
    }
    else {
      $sql_query = "SELECT idPromo FROM promocao WHERE nome = '$_POST[nome]' and idEstab = '$_SESSION[id]';";
      $res = mysqli_query($con,$sql_query) or die (mysqli_error($con));

      $aux = mysqli_num_rows($res);
      if($aux > 0) {
        $nomeErr = "*Promoção já existe";
        $vazio = True;
      }
    }
    #-----------------------------------Data de inicio-----------------------------------
    if (empty($_POST["dataini"])) {
      $dini = False;
    }
    else {
      $dateini = date("d/m/Y", strtotime($_POST["dataini"]));
    }
    #-----------------------------------Data de termino-----------------------------------
    if (empty($_POST["datafim"])) {
      $dfim = False;
    }
    else {
      $datefim = date("d/m/Y", strtotime($_POST["datafim"]));
    }
    #-----------------------------------Descricao-----------------------------------
    if (empty($_POST["des"])) {
      $des = False;
    }
    #cadastra o usuario
    if($vazio == False) {
      $sql_query = "SELECT idPromo FROM promocao WHERE nome = '$_SESSION[info]' and idEstab = '$_SESSION[id]';";
      $res = mysqli_query($con,$sql_query) or die (mysqli_error($con));
      $row = $res->fetch_assoc();
      if($nome) {
        $sql_query = "UPDATE promocao SET nome = '$_POST[nome]' WHERE idPromo = '$row[idPromo]' and idEstab = '$_SESSION[id]';";
        mysqli_query($con,$sql_query) or die (mysqli_error($con));
        $_SESSION['info'] = $_POST['nome'];
      }
      if($dini) {
        $sql_query = "UPDATE promocao SET dataIni = '$dateini' WHERE idPromo = '$row[idPromo]' and idEstab = '$_SESSION[id]';";
        mysqli_query($con,$sql_query) or die (mysqli_error($con));
      }
      if($dfim) {
        $sql_query = "UPDATE promocao SET dataFim = '$datefim' WHERE idPromo = '$row[idPromo]' and idEstab = '$_SESSION[id]';";
        mysqli_query($con,$sql_query) or die (mysqli_error($con));
      }
      if($des) {
        $sql_query = "UPDATE promocao SET descricao = '$_POST[des]' WHERE idPromo = '$row[idPromo]' and idEstab = '$_SESSION[id]';";
        mysqli_query($con,$sql_query) or die (mysqli_error($con));
      }
      $_SESSION['page'] = 31;
      header('Location: confirmacao.php');
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>alterarPromocao</title>
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
        <label for="Cadastro">Alterar Promoção</label>
        <p>Altere os campos desejados do <?php echo $_SESSION['info'];?>:</p>
        <div class="input-group">
          <input type="text" class="form-control" name="nome" placeholder="Nome da promoção">
          <span class="error"><?php echo $nomeErr;?></span>
        </div>
        <p>Data de início:</p>
        <div class="input-group">
          <input type="date" class="form-control" name="dataini" placeholder="Data de início">
        </div>
        <p>Data de término:</p>
        <div class="input-group">
          <input type="date" class="form-control" name="datafim" placeholder="Data de término">
        </div>

        <div class="input-group">
          <textarea class="form-control" name="des" placeholder="Descrição" rows="3"></textarea>
        </div>

        <div class="input-group">
          <button type="submit" onclick="return confirm('Alterar promoção?');" name="action" value="login" class="btn btn-primary">Alterar</button>
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
