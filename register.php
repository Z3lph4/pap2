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
    $imagem_padrao = './img/users/padrao.png'; // Caminho da imagem padrão

    $check_email = mysqli_num_rows(mysqli_query($conn, "SELECT email_user From users WHERE email_user='$email'"));

    if($pass !== $cpass) {
        echo "<script>alert('Password incorreta.');</script>";
    } elseif ($check_email > 0) {
        echo "<script>alert('Email já existe.');</script>";
    } else {
        $sql = "INSERT INTO users (nome_user, email_user, tel_user, pass_user, rank_user, imagem, loc_user, desc_user) 
        VALUES ('$full_name', '$email', '$tel', '$pass', '$rank', '$imagem_padrao', 'Inserir localização', 'Inserir descrição')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $_POST["signup_nome_user"] = "";
            $_POST["signup_email"] = "";
            $_POST["signup_tel_user"] = "";
            $_POST["signup_pass"] = "";
            $_POST["signup_cpass"] = "";
            $_POST["rank_user"] = "";

            // Redirecionamento após a inserção da nova tarefa
            header("Location: funcionarios.php");
            exit();

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
    <title>EmTec</title>
    <link rel="shortcut icon" href="img/logo2.png" type="image/x-icon" />
    <link rel="icon" href="img/logo2.png" type="image/x-icon" />
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
                    <h2>Em<span class="clogo">Tec</span></h2>
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

            <a href="perfil.php?id=<?php echo $_SESSION['user_id']; ?>">
                <span class="material-icons-sharp">account_circle</span>
                <h3>Perfil</h3>    
            </a>

            <a href="chat.php">
            <span class="material-icons-sharp">chat</span>
                <h3>Chat</h3>    
            </a>
            
            <!-- ======== Consuante o rank ========= -->
            <a href="register.php" class="active">
            <span class="material-icons-sharp">person_add</span>
                <h3>Registo</h3>    
            </a>

            <!-- <a href="definicoes.php">
            <span class="material-icons-sharp">settings</span>
                <h3>Definições</h3>    
            </a> -->

            <?php
            // Verifica se o botão foi clicado
            if(isset($_POST['delcookie'])) {
                // Destroi a sessão atual
                session_destroy();

                // Remove a cookie PHPSESSID
                if(isset($_COOKIE['PHPSESSID'])) {
                    setcookie('PHPSESSID', '', time() - 3600, '/');
                }

                // Redireciona para outra página após remover a cookie
                header('Location: login.php');
                exit(); 
            }
            ?>

            <form method="post" action="">
                <button type="submit" name="delcookie" class="invbtn">
                    <a><span class="material-icons-sharp">logout</span>
                    <h3>Sair</h3></a>
                </button>
            </form>
            
            </div>
        </aside>
    
    <body>

      <div class="mainprof2">
      
      <div class="containerprof2 a-containerprof" id="a-container">
        <form action="" class="formprof" id="a-form" method="post" enctype="multipart/form-data">
          <h2 class="form_titleprof titleprof">Criar Conta</h2>
          <input class="form__inputprof" type="text" placeholder="Nome" name="signup_nome_user" value="<?php echo $_POST["signup_nome_user"]; ?>" required/>
          <input class="form__inputprof" type="email" placeholder="Email" name="signup_email" value="<?php echo $_POST["signup_email"]; ?>" required/>
          <input class="form__inputprof" type="number" placeholder="Telemóvel" name="signup_tel_user" value="<?php echo $_POST["signup_tel_user"]; ?>" required/>
          <input class="form__inputprof" type="password" placeholder="Palavra-pass" name="signup_pass" value="<?php echo $_POST["signup_pass"]; ?>" required/>
          <input class="form__inputprof" type="password" placeholder="Confirmar Palavra-pass" name="signup_cpass" value="<?php echo $_POST["signup_cpass"]; ?>" required/>

          <!-- <input type="file" name="signup_imagem" accept="image/*" required /> -->

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
            
            <!-- =========== Mudança de tema ======== -->
        <div class="theme-toggler">
            <span class="material-icons-sharp active" id="light-mode-btn" onclick="setTheme('light')">light_mode</span>
            <span class="material-icons-sharp" id="dark-mode-btn" onclick="setTheme('dark')">dark_mode</span>
        </div>

        <script>
        function setTheme(theme) {
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                document.getElementById('dark-mode-btn').classList.add('active');
                document.getElementById('light-mode-btn').classList.remove('active');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                document.getElementById('light-mode-btn').classList.add('active');
                document.getElementById('dark-mode-btn').classList.remove('active');
            }
        }

        const theme = localStorage.getItem('theme');
        if (theme === 'dark') {
            setTheme('dark');
        } else {
            setTheme('light');
        }

        const themeSwitchers = document.querySelectorAll('.theme-toggler .material-icons-sharp');
        themeSwitchers.forEach((switcher) => {
            switcher.addEventListener('click', () => {
                setTheme(switcher.innerText === 'dark_mode' ? 'dark' : 'light');
            });
        });
        </script>

        <!-- ==== Perfil ==== -->

        <?php
                // Recupere o ID do usuário logado
                $userId = $_SESSION["user_id"];

                // Consulta para obter a imagem do usuário
                $sql = "SELECT imagem FROM users WHERE id_user = $userId";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $img_user = $row['imagem'];
                }
            ?>

            <a href="perfil.php?id=<?php echo $_SESSION['user_id']; ?>">
            <div class="profile">
            <div class="info">
                <p>Olá, <b><?php echo $_SESSION["user_name"]; ?></b></p>
                <small class="text-muted"><?php echo $_COOKIE["rank_user"]; ?></small> <!-- echo $rank[$iol]; ?> --> 
            </div>
            <div class="profile-photo">
                <img src="<?php echo $img_user ?>" alt="Imagem do utilizador">
            </div>
            </div></a>

        </div>
        <!-- END OF TOP -->

         <div class="recent-updates">  
            <h2>Utilizadores Recentes</h2>              
            <div class="updates"> 

            <?php
    $sql = "SELECT *, DATEDIFF(CURRENT_DATE, data_criacao) as data FROM users ORDER BY id_user DESC LIMIT 3";

    if ($res = mysqli_query($conn, $sql)) {
        while ($reg = mysqli_fetch_assoc($res)) {
            $id_user = $reg['id_user'];
            $full_name = $reg['nome_user'];
            $data = $reg['data'];

            // Consulta para obter a imagem do usuário
            $img_sql = "SELECT imagem FROM users WHERE id_user = $id_user";
            $img_result = mysqli_query($conn, $img_sql);

            if ($img_result && mysqli_num_rows($img_result) > 0) {
                $img_row = mysqli_fetch_assoc($img_result);
                $img_user = $img_row['imagem'];
            } else {
                // Imagem padrão caso não seja encontrada
                $img_user = "caminho/para/uma/imagem/default.png";
            }
?>
            <div class="recent-updates" onclick="myhref('funcionarios.php');">
                <div class="update">
                    <div class="profile-photo">
                        <img src="<?php echo $img_user; ?>" alt="Imagem do utilizador">
                    </div>
                    <div class="message">
                        <p><b><?php echo $full_name; ?></b> acabou de se juntar à nossa empresa!</p>
                        <small class="text-muted"><?php echo $data; ?> dias atrás</small>
                    </div>
                </div>
            </div>
            <?php
                    }
                }
            ?>

            <script type="text/javascript">
                function myhref(funcionarios){
                window.location.href = funcionarios;}
            </script>
               
            </div>
        </div>

         <!--------------------- END OF RECENT UPDATES ------------------->

         <div class="sales-analytics">
            <h2>Reuniões Recentes</h2>

            <?php

                // Verifica se o usuário possui classificação 'func' (funcionário)
                if (isset($_COOKIE['rank_user']) && $_COOKIE['rank_user'] == 'Func') {
                    // Obtém o ID do usuário logado
                    $user_id = $_SESSION["user_id"];

                    $sql = "SELECT t.* FROM reunioes AS t INNER JOIN user_reunioes AS ut ON t.id_reuniao = ut.id_reuniao WHERE ut.id_user = $user_id AND DATE(t.data_reuniao) >= CURDATE()";

                   

                    $sql .= " ORDER BY data_reuniao ASC LIMIT 2";
                } else {
                    $sql = "SELECT * FROM reunioes WHERE DATE(data_reuniao) >= CURDATE()";

                   

                    $sql .= " ORDER BY data_reuniao ASC LIMIT 2";
                }

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