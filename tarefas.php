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
            
            <a href="perfil.php">
            <span class="material-icons-sharp">account_circle</span>
                <h3>Perfil</h3>    
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

            <a href="login.php">
            <span class="material-icons-sharp">logout</span>
                <h3>Sair</h3>    
            </a>
            
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
    $sql = "SELECT * FROM tarefas";

    if(isset($_POST['data_pesquisa'])){
        $data_pesquisa = $_POST['data_pesquisa'];
        $sql .= " WHERE DATE(data_tarefa) = '$data_pesquisa'";
    }
    $sql .= " ORDER BY data_tarefa DESC LIMIT 4";
    
    if($res=mysqli_query($conn,$sql)){
        if(mysqli_num_rows($res) > 0){
            while($reg=mysqli_fetch_assoc($res)){
                ?>

                <div class="recent-orders">
                    <table>
                        <thead>
                            <tr>
                                <th>Nome da tarefa</th>
                                <th>Data da tarefa</th>
                                <th>Funcionário</th>
                                <th>Descrição</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width: 260px; max-width: 260px;"><?php echo $reg['nome_tarefa']; ?></td>
                                <td style="width: 260px; max-width: 260px;"><?php echo $reg['data_tarefa']; ?></td>
                                <td style="width: 260px; max-width: 260px;" class="warning"><?php echo $reg['utilizador']; ?></td>
                                <td style="width: 330px; max-width: 330px;"><?php echo $reg['desc_tarefa']; ?></td>
                                <?php if(isset($_COOKIE['rank_user']) && $_COOKIE['rank_user'] != 'Func') { ?>
                                <td>
                                    <div class="productdel pointer">
                                        <?php
                                            $form_id = "DeleteMaterial" . $reg['id_tarefa'];
                                        ?>
                                        <form method="post" action="tarefas.php" id="<?php echo $form_id ?>">
                                            <input type="hidden" name="MaterialId" value="<?php echo $reg['id_tarefa'] ?>" />
                                            <input type="hidden" name="action" value="DeleteMaterial" />  
                                            <a class="tm-product-delete-link" onClick="document.getElementById('<?php echo $form_id ?>').submit();">
                                                <i class="material-icons-sharp">delete</i>
                                            </a>
                                        </form>
                                    </div>
                                </td> <?php } ?>
                            </tr>
                        </tbody>
                    </table>
                </div>

            <?php
            }
        } else {
            ?>
            <span class="">Nenhuma tarefa encontrada para a data pesquisada.</span>
            <?php
        }
    } else {
        ?>
        <span class="">Erro ao realizar a consulta.</span>
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

            <div class="profile">
            <div class="info">
                <p>Olá, <b><?php echo $_SESSION["user_name"]; ?></b></p>
                <small class="text-muted"><?php echo $_COOKIE["rank_user"]; ?></small> <!-- echo $rank[$iol]; ?> --> 
            </div>
            <div class="profile-photo">
                <img src="./img/profile-1.jpg">
            </div>
            </div>
        </div>
        <!-- END OF TOP -->
        <div class="recent-updates">  
            <h2>Utilizadores Recentes</h2>              
            <div class="updates"> 

        <?php

            $sql ="SELECT *, DATEDIFF(CURRENT_DATE, data_criacao) as data FROM users order by id_user desc LIMIT 2";

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