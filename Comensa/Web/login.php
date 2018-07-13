<?php
require "app/dbconnect.php";

$userErr = $senhaErr = "";
$vazio = False;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if($_POST['action'] == 'cadastrar') {
    header('Location: cadastro.php');
  }
  if($_POST['action'] == 'login') {
    if (empty($_POST["user"])) {
      $userErr = "*Usuário é necessário";
      $vazio = True;
    }
    if (empty($_POST["senha"])) {
      $senhaErr = "*Senha é necessário";
      $vazio = True;
    }
    if($vazio == False) {

      $sql_query = "SELECT * FROM estabelecimento WHERE userEstab = '$_POST[user]';";
      $res = mysqli_query($con,$sql_query) or die (mysqli_error($con));

      if(mysqli_num_rows($res) == 0) {
        $userErr = "Usuário inválido";
      } else {
        $sql_query = "SELECT idEstab FROM estabelecimento WHERE userEstab = '$_POST[user]' and senha = '$_POST[senha]';";
        $res = mysqli_query($con,$sql_query) or die (mysqli_error($con));
        $row = $res->fetch_assoc();

        if(mysqli_num_rows($res) == 0) {
          $senhaErr = "Senha inválido";
        } else {
          session_start();
          $_SESSION['id'] = $row["idEstab"];
          $_SESSION['estab'] = $_POST['user'];
          header('Location: home.php');
        }
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
    <title>Login</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
    <link rel="stylesheet" href="style/login.css">
  </head>
  <body>
    <div class="home">
      <div class="item">
        <div class="content">
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="Login">Login</label>
            <div class="input-group">
              <input type="text" class="form-control" name="user" placeholder="Usuário">
              <span class="error"><?php echo $userErr;?></span>
            </div>

            <div class="input-group">
              <input type="password" class="form-control" name="senha" placeholder="Senha">
              <span class="error"><?php echo $senhaErr;?></span>
            </div>

            <div class="input-group">
              <button type="submit" name="action" value="login" class="btn btn-primary">Login</button>
            </div>

            <div class="input-group">
              <button type="submit" name="action" value="cadastrar" class="btn btn-primary">Cadastrar</button>
            </div>

          </form>

        </div>

      </div>

    </div>
  </body>
</html>
