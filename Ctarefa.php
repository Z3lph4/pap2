<?php

include 'config.php';

session_start();

error_reporting(0);

if (isset($_POST["signup"])) {
    $full_name = mysqli_real_escape_string($conn, $_POST["signup_nome_user"]);
    $email = mysqli_real_escape_string($conn, $_POST["signup_email"]);
    $tel = mysqli_real_escape_string($conn, $_POST["signup_tel_user"]);
    $uti = mysqli_real_escape_string($conn, $_POST["signup_pass"]);

    if($pass !== $cpass) {
        echo "<script>alert('Password incorreta.');</script>";
      } elseif ($check_email > 0) {
        echo "<script>alert('Email já existe.');</script>";
      } else {
      $sql = "INSERT INTO tarefas (nome_tarefa, data_tarefa, desc_tarefa, utilizador) VALUES ('$full_name', '$tel', '$email', '$uti')";
      $result = mysqli_query($conn, $sql);
      if ($result) {
        $_POST["signup_nome_user"] = "";
        $_POST["signup_email"] = "";
        $_POST["signup_tel_user"] = "";
        $_POST["signup_pass"] = "";

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

<!-- SET DARKMODE/ LIGHTMODE -->
<?php 
    if (isset($_COOKIE["darkMode"]) && $_COOKIE["darkMode"] == "true") { echo "<body class='dark-theme-variables'>"; } 
    else { echo "<body>"; } 
    ?>

<body>
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
            
            <a href="tarefas.php" class="active">
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
            <a href="register.php">
            <span class="material-icons-sharp">person_add</span>
                <h3>Registo</h3>    
            </a>

            <!-- <a href="definicoes.php">
            <span class="material-icons-sharp">settings</span>
                <h3>Definições</h3>    
            </a> -->

            <a href="login.php">
            <span class="material-icons-sharp">logout</span>
                <h3>Sair</h3>    
            </a>
            
            </div>
        </aside>
        <!-- ============= END OF ASIDE ============ -->

        <main>

        <div class="mainprof2">
      
      <div class="containerprof2 a-containerprof" id="a-container">
        <form action="" class="formprof" id="a-form" method="post">
          <h2 class="form_titleprof titleprof">Criar Tarefa</h2>
          <input class="form__inputprof" type="text" placeholder="Tarefa" name="signup_nome_user" value="<?php echo $_POST["signup_nome_user"]; ?>" required/>
          <input class="form__inputprof" type="date" placeholder="Data" name="signup_tel_user" value="<?php echo $_POST["signup_tel_user"]; ?>" required/>
          <input class="form__inputprof" type="text" placeholder="Descrição" name="signup_email" value="<?php echo $_POST["signup_email"]; ?>" required/>

          <div class="form__select-container">
            <select id="inserir" name="inserir" class="form__selectprof">
                <?php
                // Estabelecer conexão com a Base de dados
                $conn = mysqli_connect("localhost", "root", "", "pap2");

                // Verificar se a conexão foi estabelecida com sucesso
                if (!$conn) {
                    die("Falha na conexão: " . mysqli_connect_error());
                }

                // Consulta SQL para selecionar os utilizadores na tabela "users"
                $sql = "SELECT id_user, nome_user FROM users";

                // Executa a consulta SQL e armazena o resultado em uma variável
                $result = mysqli_query($conn, $sql);

                // Exibe a opção padrão e as opções do banco de dados
                echo '<option value="" disabled selected hidden>Selecione um responsável</option>';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['id_user'] . '">' . $row['nome_user'] . '</option>';
                }
                ?>
            </select>
            <i class="fa fa-chevron-down form__select-icon" aria-hidden="true"></i>
        </div>

            <input type="submit" class="form__buttonprof buttonprof submitprof" name="signup" value="Submeter" />
        </form>
      </div>
    </div>

        </main>

        <!-- ============== END OF MAIN ============ -->

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

            <div onclick="myhref('perfil.php');" class="profile">
            <div class="info">
                <p>Olá, <b><?php echo $_SESSION["user_name"]; ?></b></p>
                <small class="text-muted"><?php echo $_COOKIE["rank_user"]; ?></small>
            </div>
            <div class="profile-photo">
                <img src="./img/profile-1.jpg">
            </div>
            </div>

            <script type="text/javascript">
                function myhref(perfil){
                window.location.href = perfil;}
            </script>

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