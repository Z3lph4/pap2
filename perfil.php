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
            
            <a href="perfil.php" class="active">
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

        <div class="wrapper">
        <div class="profile-card js-profile-card">
            <div class="profile-card__img">
            <img src="./img/profile-1.jpg" alt="profile card">
            <div class="overlay"></div>
            <div class="icon-container">
                <i class="fas fa-exchange-alt"></i>
            </div>
            </div>

        <script>
            // Seleciona o elemento .profile-card__img
        const profileImg = document.querySelector('.profile-card__img');

        // Seleciona o elemento .icon-container
        const iconContainer = document.querySelector('.icon-container');

        // Adiciona um ouvinte de evento de clique ao elemento .profile-card__img
        profileImg.addEventListener('click', () => {
        // Cria um elemento de entrada de arquivo
        const input = document.createElement('input');
        input.type = 'file';
        
        // Adiciona um ouvinte de evento de alteração ao elemento de entrada de arquivo
        input.addEventListener('change', (event) => {
            // Obtém a primeira imagem selecionada
            const selectedImage = event.target.files[0];
            
            // Define a imagem selecionada como a nova imagem de perfil
            const profileImg = document.querySelector('.profile-card__img img');
            profileImg.src = URL.createObjectURL(selectedImage);
        });
        
        // Dispara o clique no elemento de entrada de arquivo
        input.click();
        });

        // Adiciona uma classe ao elemento .icon-container quando o mouse estiver sobre o elemento .profile-card__img
        profileImg.addEventListener('mouseover', () => {
        iconContainer.classList.add('show');
        });

        // Remove a classe do elemento .icon-container quando o mouse sair do elemento .profile-card__img
        profileImg.addEventListener('mouseout', () => {
        iconContainer.classList.remove('show');
        });

        </script>

            <?php

                $sql ="SELECT * FROM users where id_user = 20";

                if($res=mysqli_query($conn,$sql)){

                $id_user = array();
                $nome_user = array();
                $tel_user = array();
                $email_user = array();

                $iol= 0;
                while($reg=mysqli_fetch_assoc($res)){

                    $id_user[$iol] = $reg['id_user'];
                    $nome_user[$iol] = $reg['nome_user'];
                    $email_user[$iol] = $reg['email_user'];
                    $tel_user = $reg['tel_user'];

                ?>

            <div class="profile-card__cnt js-profile-cnt">
            <div class="profile-card__name"><?php echo $nome_user[$iol]; ?></div>

                    <?php }} ?>

                    <?php

                $sql ="SELECT * FROM per_user";

                if($res=mysqli_query($conn,$sql)){

                $id_puser = array();
                $img_user = array();
                $desc_user = array();
                $loc_user = array();

                $iol= 0;
                while($reg=mysqli_fetch_assoc($res)){

                    $id_puser[$iol] = $reg['id_puser'];
                    $img_user[$iol] = $reg['img_user'];
                    $desc_user[$iol] = $reg['desc_user'];
                    $loc_user = $reg['loc_user'];

                ?>

            <div class="profile-card__txt"><?php echo $desc_user[$iol]; ?></div>
            <div class="profile-card-loc">
                <span class="profile-card-loc__txt">
                    <?php echo $loc_user[$iol]; ?>
                </span>
            </div>
            
            <?php }} ?>


            <div class="profile-card-inf">

            <?php

                $sql ="SELECT *, DATEDIFF(CURRENT_DATE, data_criacao) as data FROM users where id_user = 20";

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

                <div class="profile-card-inf__item">
                <div class="profile-card-inf__title"><?php echo $reg['data']; ?></div>
                <div class="profile-card-inf__txt">Dias na Empresa</div>
                </div>

                    <?php }} ?>

                <div class="profile-card-inf__item">
                <div class="profile-card-inf__title">85</div>
                <div class="profile-card-inf__txt">Trabalhos Realizados</div>
                </div>
            </div>

            <div class="profile-card-ctr">
                <button class="profile-card__button button--blue js-message-btn" onclick="myhref('chat.php');">Mensagem</button>
                
                <script type="text/javascript">
                        function myhref(chat){
                        window.location.href = chat;}
                    </script> 

                <button class="profile-card__button button--orange" onclick="myhref('perfil2.php');">Editar</button>
            </div>
            </div>
        <!-- partial -->
                    <script type="text/javascript">
                        function myhref(perfil2){
                        window.location.href = perfil2;}
                    </script>         
                    <script  src="./profile.js"></script>

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
                <small class="text-muted"><?php echo $_COOKIE["rank_user"]; ?></small> <!-- echo $rank[$iol]; ?> --> 
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
        
        <script type="text/javascript">
            function myhref(reuniao){
            window.location.href = reuniao;}
        </script>

        <?php }} ?>

    <script src="js/index.js"></script>

</body>
</html>