<?php

include 'config.php';

session_start();

if (isset($_POST["action"])) {
    switch(strtoupper($_POST["action"])) {
      case "DELETEMATERIAL":
        if (isset($_POST["MaterialId"])) {
          $deleteTarefa = "DELETE FROM tarefas WHERE id_tarefa = " . $_POST["MaterialId"];
  
          mysqli_query($conn, $deleteTarefa);
        }
        break;
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
        <h1>Tarefas</h1>

            <form method="POST">
                <div class="date">
                    <input type="date" name="data_pesquisa">
                    <button type="submit" class="buttonreun">Pesquisar</button>
                </div>
            </form> 

            <?php
                // Verifica se o usuário possui classificação 'func' (funcionário)
                if (isset($_COOKIE['rank_user']) && $_COOKIE['rank_user'] == 'Func') {
                    // Obtém o ID do usuário logado
                    $user_id = $_SESSION["user_id"];

                    $sql = "SELECT t.* FROM tarefas AS t INNER JOIN user_tarefas AS ut ON t.id_tarefa = ut.id_tarefas WHERE ut.id_user = $user_id AND DATE(t.data_tarefa) >= CURDATE()";

                    if (isset($_POST['data_pesquisa'])) {
                        $data_pesquisa = $_POST['data_pesquisa'];
                        $sql .= " AND DATE(data_tarefa) = '$data_pesquisa'";
                    }

                    $sql .= " ORDER BY data_tarefa ASC LIMIT 4";
                } else {
                    $sql = "SELECT * FROM tarefas WHERE DATE(data_tarefa) >= CURDATE()";

                    if (isset($_POST['data_pesquisa'])) {
                        $data_pesquisa = $_POST['data_pesquisa'];
                        $sql .= " AND DATE(data_tarefa) = '$data_pesquisa'";
                    }

                    $sql .= " ORDER BY data_tarefa ASC LIMIT 4";
                }

                if ($res = mysqli_query($conn, $sql)) {
                    if (mysqli_num_rows($res) > 0) {
                        while ($reg = mysqli_fetch_assoc($res)) {
                            $id_tarefa = $reg['id_tarefa'];
                        
                            $material_id = $reg['material'];

                            // Consulta SQL para obter o nome do material correspondente
                            $sql_material = "SELECT nome_material FROM material WHERE id_material = $material_id";
                            $res_material = mysqli_query($conn, $sql_material);

                            if ($res_material && mysqli_num_rows($res_material) > 0) {
                                $row_material = mysqli_fetch_assoc($res_material);
                                $material_nome = $row_material['nome_material'];
                            } else {
                                $material_nome = "Nenhum material necessário";
                            }
            ?>
            
            <div class="recent-orders">
                <table>
                    <thead>
                        <tr>
                            <th>Nome da tarefa</th>
                            <th>Data da tarefa</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                
                    <tbody>
                        <tr>
                            <td style="width: 260px; max-width: 260px;"><?php echo $reg['nome_tarefa']; ?></td>
                            <td style="width: 260px; max-width: 260px;"><?php echo $reg['data_tarefa']; ?></td>
                            <td style="width: 260px; max-width: 260px;" class="<?php echo $reg['estado'] === 'Concluída' ? 'success' : 'danger'; ?>">
                                <?php echo $reg['estado']; ?>
                            </td>
                            <td class="primary pointer" style="padding-right: 15px;">
                                <a style="color: #007bff; padding: 10px;" href="Dtarefa.php?id=<?php echo $id_tarefa; ?>">Detalhes</a>
                            </td>

                            <?php if(isset($_COOKIE['rank_user']) && $_COOKIE['rank_user'] != 'Func') { ?>
                                <td>
                                <div class="productdel pointer">
                                    <?php
                                    $form_id = "DeleteMaterial" . $reg['id_tarefa'];
                                    ?>
                                    <form method="post" action="tarefas.php" id="<?php echo $form_id ?>">
                                        <input type="hidden" name="MaterialId" value="<?php echo $reg['id_tarefa'] ?>" />
                                        <input type="hidden" name="action" value="DeleteMaterial" />
                                        <a class="tm-product-delete-link" onClick="showConfirmation('<?php echo $form_id ?>');">
                                            <i class="material-icons-sharp">delete</i>
                                        </a>
                                    </form>
                                </div>
                            </td>

                            <script>
                                function showConfirmation(formId) {
                                    if (confirm("Tem certeza de que deseja excluir esta tarefa?")) {
                                        document.getElementById(formId).submit();
                                    }
                                }
                                </script>

                            <?php } ?>
                        </tr>
                    </tbody>

                </table>
                    </div>

                    <?php
                }
            } else {
                ?>
                <span class="notfind">Nenhuma tarefa encontrada para a data pesquisada.</span>
                <?php
            }
        } else {
            ?>
            <span class="notfind">Erro ao realizar a consulta.</span>
            <?php
        }             
            ?>

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

        <!-- ============ Perfil =========== -->

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
            <h2>Reuniões Marcadas</h2>

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
        
        <script type="text/javascript">
            function myhref(reuniao){
            window.location.href = reuniao;}
        </script>

        <?php }} ?>

        <?php if(isset($_COOKIE['rank_user']) && $_COOKIE['rank_user'] != 'Func') { ?>
        <div class="item add-product" onclick="myhref('Ctarefa.php');">
                <div>
                    <span class="material-icons-sharp">add</span>
                <h3>Adicionar Tarefas</h3>
            </div>
        </div>
        <?php } ?>

        <script type="text/javascript">
            function myhref(Ctarefa){
            window.location.href = Ctarefa;}
        </script>

    <script src="js/index.js"></script>

</body>
</html>