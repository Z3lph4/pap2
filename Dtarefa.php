<?php
include 'config.php';

session_start();

// Verifique se o botão "Editar" foi clicado
if (isset($_POST['edit'])) {
    // Defina a variável de sessão 'editing' como true
    $_SESSION['editing'] = true;
} elseif (isset($_POST['save'])) { // Verifique se o botão "Salvar" foi clicado
    // Verifique se os campos desc_tarefa e data_tarefa estão definidos em $_POST
    if (isset($_POST['desc_tarefa']) && isset($_POST['data_tarefa']) && isset($_POST['responsavel'])) {
        // Obtenha os valores enviados do formulário
        $editedDescTarefa = mysqli_real_escape_string($conn, $_POST['desc_tarefa']);
        $editedDataTarefa = mysqli_real_escape_string($conn, $_POST['data_tarefa']);

        // Verifique se os campos foram preenchidos
        if (!empty($editedDescTarefa) && !empty($editedDataTarefa)) {
            // Obtenha o ID do responsável
            $responsavel = mysqli_real_escape_string($conn, $_POST['responsavel']);
            $sql_user = "SELECT id_user FROM users WHERE nome_user = '$responsavel'";

            if ($res_user = mysqli_query($conn, $sql_user)) {
                $reg_user = mysqli_fetch_assoc($res_user);
                $responsavelId = $reg_user['id_user'];

                // Execute a lógica de atualização dos campos no banco de dados
                $tarefaid = isset($_GET['id_tarefa']) ? $_GET['id_tarefa'] : null;

                if ($tarefaid !== null) {
                    // Execute a consulta SQL de atualização
                    $sql = "UPDATE tarefas SET desc_tarefa = '$editedDescTarefa', utilizador = $responsavelId WHERE id_tarefa = $tarefaid";

                    if (mysqli_query($conn, $sql)) {
                        // Os dados foram atualizados com sucesso na base de dados
                        // Defina a variável de sessão 'editing' como false
                        $_SESSION['editing'] = false;

                        // Redirecione para a página da tarefa atualizada
                        if ($tarefaid !== null) {
                            // Redirecione para a página da tarefa atualizada
                            header("Location: Dtarefa.php?id_tarefa=$tarefaid");
                            exit();
                        }
                    } else {
                        // Ocorreu um erro ao atualizar os dados na base de dados
                        // Exiba uma mensagem de erro ou realize outra ação apropriada
                        echo "Erro ao atualizar as informações da tarefa: " . mysqli_error($conn);
                    }
                }
            }
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
            
            <a href="perfil.php?id=<?php echo $_SESSION['user_id']; ?>">
                <span class="material-icons-sharp">account_circle</span>
                <h3>Perfil</h3>    
            </a>

            <a href="chat.php">
            <span class="material-icons-sharp">chat</span>
                <h3>Chat</h3>    
            </a>
            
            <!-- ======== Consuante o rank ========= -->
            <?php if(isset($_COOKIE['rank_user']) && $_COOKIE['rank_user'] != 'Func') { ?>
            <a href="register.php">
            <span class="material-icons-sharp">person_add</span>
                <h3>Registo</h3>    
            </a>
            <?php } ?>

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
        <!-- ============= END OF ASIDE ============ -->

        <main>
    <div class="wrapper">
        <div class="profile-card-tarefa js-profile-card">
            <div class="profile-card__tarefa js-profile-cnt">
                
            <?php
            // Recupere o ID da tarefa da URL
            $tarefaid = isset($_GET['id']) ? $_GET['id'] : null;

            if ($tarefaid !== null) {
                $sql = "SELECT * FROM tarefas WHERE id_tarefa = $tarefaid";

                if ($res = mysqli_query($conn, $sql)) {
                    while ($reg = mysqli_fetch_assoc($res)) {
                        $nome_tarefa = $reg['nome_tarefa'];
                        $data = $reg['data_tarefa'];
                        $desc = $reg['desc_tarefa'];
                        $utilizador = $reg['utilizador'];
                        $material = $reg['material'];

                        $sql_user = "SELECT nome_user FROM users WHERE id_user = $utilizador";

                        if ($res_user = mysqli_query($conn, $sql_user)) {
                            while ($reg_user = mysqli_fetch_assoc($res_user)) {
                                $nome_user = $reg_user['nome_user'];
                            }
                        }

                        $sql_material = "SELECT nome_material FROM material WHERE id_material = $material";

                        if ($res_material = mysqli_query($conn, $sql_material)) {
                            while ($reg_material = mysqli_fetch_assoc($res_material)) {
                                $nome_material = $reg_material['nome_material'];
                            }
                        }
                    ?>

                        <div class="profile-card__name"><?php echo $nome_tarefa; ?></div>
                        <div class="profile-card-inf">
                            <div class="profile-card-inf__item">
                                <div class="profile-card-inf__title2" <?php if (isset($_SESSION['editing']) && $_SESSION['editing'] == true) echo 'contenteditable="true"'; ?> id="desc_tarefa">
                                    <?php echo $desc; ?></div>
                                <div class="profile-card-inf__txt">Descrição da tarefa</div>
                            </div>

                            <div class="profile-card-inf__item">
                                <div class="profile-card-inf__title2"><?php echo $material !== null ? $nome_material : 'Sem material associado a esta tarefa'; ?></div>
                                <div class="profile-card-inf__txt">Material atribuído</div>
                            </div>

                            <div class="profile-card-inf">
                                <div class="profile-card-inf__item">
                                    <div class="profile-card-inf__title"><?php echo $nome_user; ?></div>
                                    <div class="profile-card-inf__txt">Responsável</div>
                                </div>

                                <div class="profile-card-inf__item">
                                    <div class="profile-card-inf__title" <?php if (isset($_SESSION['editing']) && $_SESSION['editing'] == true) echo 'contenteditable="true"'; ?> id="data_tarefa">
                                        <?php echo $data; ?></div>
                                    <div class="profile-card-inf__txt">Data de finalização</div>
                                </div>
                            </div>

                            <div class="profile-card-ctr">
                                <?php if (isset($_SESSION['editing']) && $_SESSION['editing'] == true): ?>
                                    <form method="POST" action="">
                                        <button class="profile-card__button button--blue" type="button" name="save" onclick="saveData();">Salvar</button>
                                        <button class="profile-card__button button--orange" onclick="cancelEditing()">Cancelar</button>
                                    </form>
                                <?php else: ?>
                                    <button class="profile-card__button button--blue js-message-btn" onclick="myhref('tarefas.php');">Voltar</button>
                                    <form method="POST" action="">
                                        <button class="profile-card__button button--orange" type="submit" name="edit">Editar</button>
                                    </form>
                                <?php endif; ?>
                            </div>

                            <?php
                        }
                    }
                }
                ?>

                <script>
                    function cancelEditing() {
                        window.location.href = 'Dtarefa.php?id_tarefa=<?php echo $tarefaid; ?>';
                        <?php $_SESSION['editing'] = false; ?>
                    }
                </script>

                
                <script>
                    function saveData() {
                        var desc_tarefa = document.getElementById('desc_tarefa').innerText;
                        var data_tarefa = document.getElementById('data_tarefa').innerText;

                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "update_tarefa_data.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.onreadystatechange = function() {
                            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                                window.location.href = 'Dtarefa.php?id=<?php echo $tarefaid; ?>';
                            }
                        };
                        xhr.send("tarefaId=<?php echo $tarefaid; ?>&desc_tarefa=" + encodeURIComponent(desc_tarefa) + "&data_tarefa=" + encodeURIComponent(data_tarefa));
                    }
                </script>

            </div>
        </div>
    </div>
    <script src="./profile.js"></script>
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

        <!-- ================ PERFIL ================= -->

        <a href="perfil.php?id=<?php echo $_SESSION['user_id']; ?>">
            <div class="profile">
            <div class="info">
                <p>Olá, <b><?php echo $_SESSION["user_name"]; ?></b></p>
                <small class="text-muted"><?php echo $_COOKIE["rank_user"]; ?></small> <!-- echo $rank[$iol]; ?> --> 
            </div>

            <?php
                // Verifique se a variável de sessão existe e tem um valor
                if (isset($_SESSION["user_img"])) {
                    $img_log = $_SESSION["user_img"];
                }
            ?>

            <div class="profile-photo">
            <img src="<?php echo $img_log ?>" alt="Imagem do utilizador">
            </div>
            </div>
        
        </a>
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
            <h2>Reuniões Marcadas</h2>

            <?php

                $sql = "SELECT * FROM reunioes WHERE DATE(data_reuniao) > CURDATE() LIMIT 2";

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
        
        <script type="text/javascript">
            function myhref(reuniao){
            window.location.href = reuniao;}
        </script>

        <?php }} ?>

    <script src="js/index.js"></script>

</body>
</html>