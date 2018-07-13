<?php
require "app/dbconnect.php";

$userErr = $senhaErr = $nomeErr = $cnpjErr = $telefoneErr
 = $bairroErr = $ruaErr = $numeroErr = $compErr = $cepErr = "";
$vazio = False;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if($_POST['action'] == 'cancelar') {
    header('Location: login.php');
  }
  #verifica se os campos foram corretamentes preenchidos
  #-----------------------------------Usuario-----------------------------------
  if($_POST['action'] == 'login') {
    if (empty($_POST["user"])) {
      $userErr = "*Usuário é necessário";
      $vazio = True;
    }
    else {
      $sql_query = "SELECT userEstab FROM estabelecimento WHERE userEstab = '$_POST[user]';";
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
      $nomeErr = "*Nome do estabelecimento é necessário";
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
    #-----------------------------------CNPJ-----------------------------------
    if (empty($_POST["cnpj"])) {
      $cnpjErr = "*CNPJ é necessário";
      $vazio = True;
    }
    else if (strlen($_POST["cnpj"]) != 14) {
      $cnpjErr = "*CNPJ inválido";
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

    	$sql_query = "INSERT INTO estabelecimento(userEstab, CNPJ, nome, telefone, senha, idEndereco) VALUES ('$_POST[user]','$_POST[cnpj]',
    		'$_POST[nome]', '$_POST[telefone]','$_POST[senha]','$res');";

    	if(mysqli_query($con,$sql_query) or die (mysqli_error($con))) {
        session_start();
        $_SESSION['id'] = mysqli_insert_id($con);
        $_SESSION['estab'] = $_POST['user'];
    		header('Location: home.php');
    	} else {
    		$userErr = "*Problema no cadastramento(conexao)";
    	}
    }
  }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Cadastro</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
    <link rel="stylesheet" href="style/cadastro.css">
  </head>
  <body>
    <div class="home">
      <div class="item">
        <div class="content">
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="Cadastro">Cadastro</label>
            <div class="input-group">
              <input type="text" class="form-control" name="user" placeholder="Usuário">
              <span class="error"><?php echo $userErr;?></span>
            </div>

            <div class="input-group">
              <input type="password" class="form-control" name="senha" placeholder="Senha">
              <span class="error"><?php echo $senhaErr;?></span>
            </div>

            <div class="input-group">
              <input type="text" class="form-control" name="nome" placeholder="Nome do estabelecimento">
              <span class="error"><?php echo $nomeErr;?></span>
            </div>

            <div class="input-group">
              <input type="text" class="form-control" name="telefone" placeholder="Telefone(somente números)">
              <span class="error"><?php echo $telefoneErr;?></span>
            </div>

            <div class="input-group">
              <input type="text" class="form-control" name="cnpj" placeholder="CNPJ(somente números)">
              <span class="error"><?php echo $cnpjErr;?></span>
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
              <button type="submit" onclick="return confirm('Cadastrar?');" name="action" value="login" class="btn btn-primary">Cadastrar</button>
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
