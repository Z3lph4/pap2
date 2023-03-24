<?php

include 'config.php';

session_start();

error_reporting(0);

if (isset($_POST["signup"])) {
    $full_name = mysqli_real_escape_string($conn, $_POST["signup_nome_user"]);
    $email = mysqli_real_escape_string($conn, $_POST["signup_email"]);
    $tel = mysqli_real_escape_string($conn, $_POST["signup_tel_user"]); 
    $pass = mysqli_real_escape_string($conn, md5($_POST["signup_pass"]));
    $cpass = mysqli_real_escape_string($conn, md5($_POST["signup_cpass"]));
    $rank = filter_input(INPUT_POST,'inserir', FILTER_SANITIZE_STRING);

    $check_email = mysqli_num_rows(mysqli_query($conn, "SELECT email_user From users WHERE email_user='$email'"));

    if($pass !== $cpass) {
      echo "<script>alert('Password incorreta.');</script>";
    } elseif ($check_email > 0) {
      echo "<script>alert('Email já existe.');</script>";
    } else {
      $sql = "INSERT INTO users (nome_user, email_user, tel_user, pass_user, rank_user) VALUES ('$full_name', '$email', '$tel', '$pass', '$rank')";
      $result = mysqli_query($conn, $sql);
      if ($result) {
        $_POST["signup_nome_user"] = "";
        $_POST["signup_email"] = "";
        $_POST["signup_tel_user"] = "";
        $_POST["signup_pass"] = "";
        $_POST["signup_cpass"] = "";
        $_POST["rank_user"] = "";

        echo "<script>alert('Registado com sucesso.');</script>";
      } else {
        echo "<script>alert('Falha no registo. Tente novamente!');</script>";
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
    <!-- === MATERIAL ICON === -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <!-- === Style sheet === -->
    <link rel="stylesheet" href="css/style.css">
</head>
<div class="container">
        <aside>
            <div class="top">
            <a href="index.php">
                <div class="logo"> 
                    <img src="img/logo2.png">
                    <h2>Gest<span class="clogo">EMP</span></h2>
                </div>
                <div class="close" id="close-btn">
                <span class="material-icons-sharp">close</span>
                </div>
                </a>
            </div>
            
            <div class="sidebar">
                <a href="index.php">
                <span class="material-icons-sharp">home</span>
                <h3>Home</h3>    
            </a>
            
            <a href="tarefas.php">
            <span class="material-icons-sharp">checklist</span>
                <h3>Tarefas</h3>    
            </a>

            <a href="funcionarios.php">
            <span class="material-icons-sharp">group</span>
                <h3>Funcionários</h3>    
            </a>

            <a href="reuniao.php">
            <span class="material-icons-sharp">video_camera_front</span>
                <h3>Reunião</h3> 
                <!-- <span class="message-count">26</span> -->   
            </a>

            <a href="material.php">
            <span class="material-icons-sharp">home_repair_service</span>
                <h3>Material</h3>    
            </a>

            <a href="perfil.php">
            <span class="material-icons-sharp">account_circle</span>
                <h3>Perfil</h3>    
            </a>
            
            <!-- ======== Consuante o rank ========= -->
            <a href="register.php" class="active">
            <span class="material-icons-sharp">person_add</span>
                <h3>Registo</h3>    
            </a>

            <a href="definicoes.php">
            <span class="material-icons-sharp">settings</span>
                <h3>Defenições</h3>    
            </a>

            <a href="login.php">
            <span class="material-icons-sharp">logout</span>
                <h3>Sair</h3>
                <script type="text/javascript">
                    function myhref(logout){
                    window.location.href = logout;}
                </script>
            </a>
            
            </div>
        </aside>

    <!-- SET DARKMODE/ LIGHTMODE -->
    <?php 
    if (isset($_COOKIE["darkMode"]) && $_COOKIE["darkMode"] == "true") { echo "<body class='dark-theme-variables'>"; } 
    else { echo "<body>"; } 
    ?>

    
    <body>

      <div class="mainprof2">
      
      <div class="containerprof2 a-containerprof" id="a-container">
        <form action="" class="formprof" id="a-form" method="post">
          <h2 class="form_titleprof titleprof">Criar Conta</h2>
          <input class="form__inputprof" type="text" placeholder="Nome" name="signup_nome_user" value="<?php echo $_POST["signup_nome_user"]; ?>" required/>
          <input class="form__inputprof" type="email" placeholder="Email" name="signup_email" value="<?php echo $_POST["signup_email"]; ?>" required/>
          <input class="form__inputprof" type="text" placeholder="Telemóvel" name="signup_tel_user" value="<?php echo $_POST["signup_tel_user"]; ?>" required/>
          <input class="form__inputprof" type="password" placeholder="Palavra-pass" name="signup_pass" value="<?php echo $_POST["signup_pass"]; ?>" required/>
          <input class="form__inputprof" type="password" placeholder="Confirmar Palavra-pass" name="signup_cpass" value="<?php echo $_POST["signup_cpass"]; ?>" required/>
            <div class="form__select-container">
            <select id="inserir" name="inserir" class="form__selectprof">
                <option id="inserir" value="" disabled selected hidden>Selecione uma opção</option>
                <option id="inserir" value="Admin">Administrador</option>
                <option id="inserir" value="Func">Funcionário</option>
            </select>
            <i class="fa fa-chevron-down form__select-icon" aria-hidden="true"></i>
            </div>
            <input type="submit" class="form__buttonprof buttonprof submitprof" name="signup" value="Registar" />
        </form>
      </div>
    </div>

      <div class="right">
            <div class="top">
            <button id="menu-btn">
                <span class="material-icons-sharp">menu</span>
            </button>
            <div class="theme-toggler">
                <?php if (isset($_COOKIE["darkMode"]) && $_COOKIE["darkMode"] == "true") {
                    echo "<span class='material-icons-sharp'>light_mode</span>";
                    echo "<span class='material-icons-sharp active'>dark_mode</span>";
                }
                else
                {
                    echo "<span class='material-icons-sharp active'>light_mode</span>";
                    echo "<span class='material-icons-sharp'>dark_mode</span>";
                } ?>
            </div>
            <div class="profile">
            <div class="info">
                <p>Hey, <b><?php echo $_SESSION["user_name"]; ?></b></p>
                <small class="text-muted">Admin</small>
            </div>
            <div class="profile-photo">
                <img onclick="myhref('perfil.php');" src="./img/profile-1.jpg">
                <script type="text/javascript">
                    function myhref(perfil){
                    window.location.href = perfil;}
                </script>
            </div>
            </div>
        </div>
        <!-- END OF TOP -->

         <div class="recent-updates">  
            <h2>Utilizadores Recentes</h2>              
            <div class="updates"> 

        <?php

            $sql ="SELECT *, DATEDIFF(CURRENT_DATE, data_criacao) as data FROM users order by id_user desc LIMIT 3";

            if($res=mysqli_query($conn,$sql)){

            $id_user = array();
            $full_name = array();
            $data = array();

            $iol= 0;
            while($reg=mysqli_fetch_assoc($res)){

                $id_user[$iol] = $reg['id_user'];
                $full_name[$iol] = $reg['nome_user'];
                $data[$iol] = $reg['data'];
        ?>
                <div class="recent-updates" onclick="myhref('funcionarios.php');">
                <div class="update">
                    <div class="profile-photo">
                        <img src="./img/profile-2.jpg">
                    </div>
                <div class="message">
                    <p><b><?php echo $full_name[$iol]; ?></b> acabou de se juntar á nossa empresa!</p>
                    <small class="text-muted"> <?php echo $reg['data']; ?> dias atrás</small>
                </div>
                </div>
                 <?php }} ?>
            </div>

            <script type="text/javascript">
                function myhref(funcionarios){
                window.location.href = funcionarios;}
            </script>
               
            </div>
        </div>
            </div>  

         <!--------------------- END OF RECENT UPDATES ------------------->

         <div class="sales-analytics">
            <h2>Reuniões Recentes</h2>

            <?php

                $sql ="SELECT * FROM reunioes where data_reuniao > CURDATE() order by id_reuniao desc LIMIT 2";

                if($res=mysqli_query($conn,$sql)){

                $id_reuniao = array();
                $nome_reuniao = array();
                $data_reuniao = array();
                $desc_reuniao = array();

                $iol= 0;
                while($reg=mysqli_fetch_assoc($res)){

                    $id_reuniao[$iol] = $reg['id_reuniao'];
                    $nome_reuniao[$iol] = $reg['nome_reuniao'];
                    $data_reuniao[$iol] = $reg['data_reuniao'];
                    $desc_reuniao[$iol] = $reg['desc_reuniao'];

            ?>

        <div class="item online" onclick="myhref('reuniao.php');">
            <div class="icon">
                <span class="material-icons-sharp">video_camera_front</span>
            </div>
        <div class="right">
            <div class="info" style="max-width: 110px;">
                <h3><?php echo $nome_reuniao[$iol]; ?></h3>
                <small class="text-muted"><?php echo $desc_reuniao[$iol]; ?></small>
            </div>
                <h3><?php echo $data_reuniao[$iol]; ?></h3>
            </div>
        </div>

        <?php }} ?>

        <script type="text/javascript">
            function myhref(reuniao){
            window.location.href = reuniao;}
        </script>

    <script src="js/index.js"></script>
</body>
</html>