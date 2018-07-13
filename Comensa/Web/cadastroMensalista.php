<?php
require "app/dbconnect.php";

$userErr = $senhaErr = $nomeErr = $cpfErr = $telefoneErr = $emailErr
 = $bairroErr = $ruaErr = $numeroErr = $compErr = $cepErr = "";
$vazio = False;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if($_POST['action'] == 'cancelar') {
    header('Location: home.php');
  }
  #verifica se os campos foram corretamentes preenchidos
  #-----------------------------------Usuario-----------------------------------
  if($_POST['action'] == 'login') {
    if (empty($_POST["user"])) {
      $userErr = "*Usuário é necessário";
      $vazio = True;
    }
    else {
      $sql_query = "SELECT userMensa FROM mensalista WHERE userMensa = '$_POST[user]';";
      $res = mysqli_query($con,$sql_query) or die (mysqli_error($con));

      $aux = mysqli_num_rows($res);
      if($aux > 0) {
        $userErr = "*Usuário já existe";
        $vazio = True;
      }
    }
    #-----------------------------------Senha-----------------------------------
    if (empty($_POST["senha"])) {
      $senhaErr = "*Senha é necessário";
      $vazio = True;
    }
    else if (strlen($_POST["senha"]) < 6) {
      $senhaErr = "*Senha necessita de pelo menos 6 dígitos";
      $vazio = True;
    }
    #-----------------------------------Nome-----------------------------------
    if (empty($_POST["nome"])) {
      $nomeErr = "*Nome do mensalista é necessário";
      $vazio = True;
    }
    #-----------------------------------Telefone-----------------------------------
    if (empty($_POST["telefone"])) {
      $telefoneErr = "*Telefone é necessário";
      $vazio = True;
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
    #-----------------------------------CPF-----------------------------------
    if (empty($_POST["cpf"])) {
      $cpfErr = "*CPF é necessário";
      $vazio = True;
    }
    else if (strlen($_POST["cpf"]) != 11) {
      $cpfErr = "*CPF inválido";
      $vazio = True;
    }
    #-----------------------------------Email-----------------------------------
    if (empty($_POST["email"])) {
      $emailErr = "*Email é necessário";
      $vazio = True;
    }
    else if (!filter_var(($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
      $emailErr = "*Email inválido";
      $vazio = True;
    }
    #-----------------------------------Bairro-----------------------------------
    if (empty($_POST["bairro"])) {
      $bairroErr = "*Bairro é necessário";
      $vazio = True;
    }
    #-----------------------------------Rua-----------------------------------
    if (empty($_POST["rua"])) {
      $ruaErr = "*Rua é necessário";
      $vazio = True;
    }
    #-----------------------------------Numero-----------------------------------
    if (empty($_POST["numero"])) {
      $numeroErr = "*Número é necessário";
      $vazio = True;
    }
    #-----------------------------------CEP-----------------------------------
    if (empty($_POST["cep"])) {
      $cepErr = "*CEP é necessário";
      $vazio = True;
    }
    else if (strlen($_POST["cep"]) != 8) {
      $cepErr = "*CEP inválido";
      $vazio = True;
    }
    #cadastra o usuario
    if($vazio == False) {
      $sql_query = "INSERT INTO endereco(bairro, rua, numero, complemento, CEP) VALUES ('$_POST[bairro]','$_POST[rua]','$_POST[numero]',
        '$_POST[complemento]','$_POST[cep]');";
    	mysqli_query($con,$sql_query) or die (mysqli_error($con));
    	$res = mysqli_insert_id($con);

    	$sql_query = "INSERT INTO mensalista(userMensa, CPF, nome, telefone, email, senha, idEndereco) VALUES ('$_POST[user]','$_POST[cpf]',
    		'$_POST[nome]', '$_POST[telefone]','$_POST[email]','$_POST[senha]','$res');";
      mysqli_query($con,$sql_query) or die (mysqli_error($con));
      $res = mysqli_insert_id($con);

      session_start();
      $sql_query = "INSERT INTO contas(saldo,idEstab,idMensa) VALUES ('0.00','$_SESSION[id]','$res');";

    	if(mysqli_query($con,$sql_query) or die (mysqli_error($con))) {
        $_SESSION['info'] = $_POST['user'];
        $_SESSION['page'] = 10;
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
  <title>cadastroMensalista</title>
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
        <label for="Cadastro">Cadastro Mensalista</label>
        <p>Criação de conta no restaurante para mensalista não cadastrado no sistema:</p>
        <div class="input-group">
          <input type="text" class="form-control" name="user" placeholder="Usuário">
          <span class="error"><?php echo $userErr;?></span>
        </div>

        <div class="input-group">
          <input type="password" class="form-control" name="senha" placeholder="Senha">
          <span class="error"><?php echo $senhaErr;?></span>
        </div>

        <div class="input-group">
          <input type="text" class="form-control" name="nome" placeholder="Nome do mensalista">
          <span class="error"><?php echo $nomeErr;?></span>
        </div>

        <div class="input-group">
          <input type="text" class="form-control" name="telefone" placeholder="Telefone(somente números)">
          <span class="error"><?php echo $telefoneErr;?></span>
        </div>

        <div class="input-group">
          <input type="text" class="form-control" name="cpf" placeholder="CPF(somente números)">
          <span class="error"><?php echo $cpfErr;?></span>
        </div>

        <div class="input-group">
          <input type="text" class="form-control" name="email" placeholder="Email">
          <span class="error"><?php echo $emailErr;?></span>
        </div>

        <div class="input-group">
          <input type="text" class="form-control" name="bairro" placeholder="Bairro">
          <span class="error"><?php echo $bairroErr;?></span>
        </div>

        <div class="input-group">
          <input type="text" class="form-control" name="rua" placeholder="Rua">
          <span class="error"><?php echo $ruaErr;?></span>
        </div>

        <div class="input-group">
          <input type="text" class="form-control" name="numero" placeholder="Número">
          <span class="error"><?php echo $numeroErr;?></span>
        </div>

        <div class="input-group">
          <input type="text" class="form-control" name="complemento" placeholder="Complemento">
        </div>

        <div class="input-group">
          <input type="text" class="form-control" name="cep" placeholder="CEP(somente números)">
          <span class="error"><?php echo $cepErr;?></span>
        </div>

        <div class="input-group">
          <button type="submit" onclick="return confirm('Cadastrar mensalista?');" name="action" value="login" class="btn btn-primary">Cadastrar</button>
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
