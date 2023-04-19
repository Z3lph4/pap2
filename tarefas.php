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

            <a href="definicoes.php">
            <span class="material-icons-sharp">settings</span>
                <h3>Defenições</h3>    
            </a>
            <a href="login.php">
            <span class="material-icons-sharp">logout</span>
                <h3>Sair</h3>    
            </a>
            
            </div>
        </aside>
        <!-- ============= END OF ASIDE ============ -->
        <main>
            <h1>Tarefas</h1>

            <div class="date">
                <input type="date">
            </div>

            <?php

            $sql ="SELECT * FROM tarefas where data_tarefa > CURDATE() order by id_tarefa desc LIMIT 4";

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
                    <td style="width: 260px; max-width: 260px;"><?php echo $nome_tarefa[$iol]; ?></td>
                    <td style="width: 260px; max-width: 260px;"><?php echo $data_tarefa[$iol]; ?></td>
                    <td style="width: 260px; max-width: 260px;" class="warning"><?php echo $reg['utilizador']; ?></td>
                    <td style="width: 330px; max-width: 330px;"><?php echo $reg['desc_tarefa']; ?></td>
                    <td style="width: 70px; max-width: 70px;"><div class="productsdel">
                        <?php
                                $form_id = "DeleteMaterial" . $id_tarefa[$iol];
                            ?>
                            <form method="post" action="tarefas.php" id="<?php echo $form_id ?>">
                                <input type="hidden" name="MaterialId" value="<?php echo $id_tarefa[$iol] ?>" />
                                <input type="hidden" name="action" value="DeleteMaterial" />  
                            <a class="tm-product-delete-link" onClick="document.getElementById('<?php echo $form_id ?>').submit();">
                                <i class="material-icons-sharp">delete</i></a>
                            </div>
                        </form>
                    </td>
                </tr>
                    </tbody>
                </table>
            </div>

            <?php }} ?>
        </main>
        <!-- ============== END OF MAIN ============ -->

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

        <div class="item add-product" onclick="myhref('Ctarefa.php');">
                <div>
                    <span class="material-icons-sharp">add</span>
                <h3>Adicionar Tarefas</h3>
            </div>
        </div>

        <script type="text/javascript">
            function myhref(Ctarefa){
            window.location.href = Ctarefa;}
        </script>

    <script src="js/index.js"></script>

</body>
</html>