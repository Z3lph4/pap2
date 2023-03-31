<?php

include 'config.php';

session_start();

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
<body>
    <div class="container">
        <aside>
            <div class="top">
                <div class="logo"> 
                    <img src="img/logo2.png">
                    <h2>Gest<span class="clogo">EMP</span></h2>
                </div>
                <div class="close" id="close-btn">
                <span class="material-icons-sharp">close</span>
                </div>
            </div>

            <div class="sidebar">
                <a href="index.php" class="active">
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
            <?php if(isset($_COOKIE['rank_user']) && $_COOKIE['rank_user'] != 'Func') { ?>
                <a href="register.php">
                    <span class="material-icons-sharp">person_add</span>
                    <h3>Registo</h3>    
                </a>
            <?php } ?>

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
        <!-- ============= END OF ASIDE ============ -->
        <main>
            <h1>Dashboard</h1>

            <div class="date">
                <input type="date">
            </div>

            

            <div class="insights">
                <div class="sales">
                    <span class="material-icons-sharp">analytics</span>
                    <div class="middle"> <!-- style="width: 220px;" --> 
                        <div class="left">
                            <h3></h3>
                        </div>
                    </div>
                    <small class="text-muted"></small>
                </div>

                <!-- ========== End of Income ========== -->
            </div>
            <!-- ========== End of Insights ========== -->
            
            <?php

            $sql ="SELECT * FROM tarefas";

            if($res=mysqli_query($conn,$sql)){

            $id_tarefa = array();
            $nome_tarefa = array();
            $data_tarefa = array();
            $desc_tarefa = array();
            $utilizador = array();

            $iol= 0;
            while($reg=mysqli_fetch_assoc($res)){

                $id_tarefa[$iol] = $reg['id_tarefa'];
                $nome_tarefa[$iol] = $reg['nome_tarefa'];
                $data_tarefa[$iol] = $reg['data_tarefa'];
                $desc_tarefa = $reg['desc_tarefa'];
                $utilizador = $reg['utilizador'];

            ?>

            <div class="recent-orders">
                <h2>Tarefas Recentes</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Nome da tarefa</th>
                                <th>Data da tarefa</th>
                                <th>Funcionário</th>
                                <th>Descrição</th>
                                <th></th>
                            </tr>
                    </thead>
                <tbody>
                <tr>
                    <td><?php echo $nome_tarefa[$iol]; ?></td>
                    <td><?php echo $data_tarefa[$iol]; ?></td>
                    <td class="warning"><?php echo $reg['utilizador']; ?></td>
                    <td><?php echo $reg['desc_tarefa']; ?></td>
                    <td class="primary" onclick="myhref('tarefas.php');">Detalhes</td>
                </tr>
                    </tbody>
                </table>
            </div>

            <script type="text/javascript">
                function myhref(tarefas){
                window.location.href = tarefas;}
            </script>

            <?php }} ?>

        </main>
        <!-- ============== END OF MAIN ============ -->

        <div class="right">
            <div class="top">
            <button id="menu-btn">
                <span class="material-icons-sharp">menu</span>
            </button>
            <div class="theme-toggler">
                <span class="material-icons-sharp active" onclick="document.cookie = 'darkMode=false';">light_mode</span>
                <span class="material-icons-sharp" onclick="document.cookie = 'darkMode=true';">dark_mode</span>
            </div>
            <div class="profile">
            <div class="info">
                <p>Hey, <b><?php echo $_SESSION["user_name"]; ?></b></p>
                <small class="text-muted"><?php echo $_COOKIE["rank_user"]; ?></small> <!-- echo $rank[$iol]; ?> --> 
            </div>
            <div class="profile-photo">
                <?php if (isset($_COOKIE["user_img"])){
                echo "<img onclick='myhref('perfil.php');' src='". $_COOKIE["user_img"] . "'>";} ?>
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