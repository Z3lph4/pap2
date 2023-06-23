<?php
// Verifica o estado da sessão
$sessionStatus = session_status();

if ($sessionStatus == PHP_SESSION_ACTIVE) {
    echo "Uma sessão está ativa.";
    session_destroy();
} 
else
{

  include 'config.php';

session_start();
error_reporting(0);

if (isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit();
}

if (isset($_POST["signin"])) {
  $email = mysqli_real_escape_string($conn, $_POST["email"]);
  $pass = mysqli_real_escape_string($conn, md5($_POST["pass"]));

  $check_email = mysqli_query($conn, "SELECT id_user, nome_user, desc_user, loc_user, rank_user, imagem FROM users WHERE email_user='$email' AND pass_user='$pass'");

  if (mysqli_num_rows($check_email) > 0) {
    $row = mysqli_fetch_assoc($check_email);
    $_SESSION["user_id"] = $row['id_user']; 
    $_SESSION["user_name"] = $row['nome_user'];
    $_SESSION["user_desc"] = $row['desc_user'];
    $_SESSION["user_loc"] = $row['loc_user'];
    setcookie("rank_user", $row['rank_user']);
    setcookie("user_img", $row['imagem']);
    header("Location: index.php"); 
    exit();
  } else {
    echo "<script>alert('Dados incorretos.');</script>";
  }
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GestEMP</title>
  <link rel="shortcut icon" href="img/logo2.png" type="image/x-icon" />
  <link rel="icon" href="img/logo2.png" type="image/x-icon" />
  <!-- === MATERIAL ICON === -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
  <!-- === Style sheet === -->
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="profile">
    <div class="allprof">
      <div class="mainprof">
        <div class="containerprof b-containerprof" id="b-container">
          <form class="formprof" id="b-form" method="post" action="">
            <h2 class="form_titleprof titleprof" style="padding-bottom: 25px;">Bom dia!</h2>
            <input class="form__inputprof" type="text" placeholder="Email" name="email" value="<?php echo $_POST["email"]; ?>" required/>
            <input class="form__inputprof" type="password" placeholder="Palavra-pass" name="pass" value="<?php echo $_POST["pass"]; ?>" required/>
            <input type="submit" value="Entrar" name="signin" class="form__buttonprof buttonprof submitprof" />
          </form>
        </div>

        <div class="switchprof" id="switch-cnt">
          <div class="switch__circleprof"></div>
          <div class="switch__circleprof switch__circle--tprof"></div>
          <div class="switch__containerprof" id="switch-c1">
            <h2 class="switch__titleprof titleprof">Bem-vindo!</h2>
            <p class="switch__descriptionprof descriptionprof">É sempre um prazer poder revê-lo aqui conosco!</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>