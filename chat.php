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
                <div class="logo"> 
                    <img src="img/logo2.png">
                    <h2>Em<span class="clogo">Tec</span></h2>
                </div>
                <div class="close" id="close-btn">
                <span class="material-icons-sharp">close</span>
                </div>
            </div>

            <div class="sidebar">
                <a href="index.php" >
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
            
            <a href="chat.php" class="active">
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
        <main class="chat-main">
        <div id="frame">
	<div id="sidepanel">

		<div id="profile">
			<div class="wrap no-poiter">

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

                <img src="<?php echo $img_user ?>" alt="Imagem do utilizador">
				<p><?php echo $_SESSION['user_name']; ?></p>

                <!-- <i class="fa fa-chevron-down expand-button" aria-hidden="true"></i> -->

				<!-- <div id="status-options">
					<ul>
						<li id="status-online" class="active"><span class="status-circle"></span> <p>Online</p></li>
						<li id="status-away"><span class="status-circle"></span> <p>Away</p></li>
						<li id="status-busy"><span class="status-circle"></span> <p>Busy</p></li>
						<li id="status-offline"><span class="status-circle"></span> <p>Offline</p></li>
					</ul>
				</div> -->

			</div>
		</div>

		<div id="search">
            <label for=""><span class="material-icons-sharp">search</span></label>
            <input type="text" placeholder="Procurar contacto..." oninput="filterContacts(this.value)" />
        </div>

		<div id="contacts">
            <ul class="chat_users">
                <?php
                // Obter o ID do usuário logado (supondo que você esteja armazenando o ID na sessão)
                $userIdLogado = $_SESSION['user_id'];

                // Obter os utilizadores da base de dados, excluindo o usuário logado
                $sql = "SELECT * FROM users WHERE id_user != $userIdLogado";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $userId = $row['id_user'];
                        $username = $row['nome_user'];
                        $img = $row['imagem'];
                        /* $lastActivity = $row['ultima_atividade']; */

                        // Verificar se o utilizador está online com base no tempo de inatividade
                        $onlineThreshold = 60; // Tempo em segundos para considerar o utilizador online
                        /* $isOnline = (time() - strtotime($lastActivity) <= $onlineThreshold); */

                        // Saída HTML para cada utilizador
                        echo '<li class="contact">';
                        echo '<div class="wrap">';
                        /* echo '<span class="contact-status ' . ($isOnline ? 'online' : '') . '"></span>'; */
                        echo '<img src="' . $img . '" alt="" />';
                        echo '<div class="meta">';
                        echo '<p class="name">' . $username . '</p>';
                        /* echo '<p class="preview">' . ($isOnline ? 'Online' : 'Offline') . '</p>'; */
                        echo '</div>';
                        echo '</div>';
                        echo '</li>';
                    }
                }
                ?>
            </ul>
        </div>

        <script>
            function filterContacts(searchTerm) {
                // Obtém todos os elementos <li> da lista de usuários
                var contacts = document.querySelectorAll('#contacts .chat_users li');

                for (var i = 0; i < contacts.length; i++) {
                    var contact = contacts[i];
                    var name = contact.querySelector('.name').textContent.toLowerCase();

                    // Verifica se o nome do usuário contém o termo de pesquisa
                    if (name.includes(searchTerm.toLowerCase())) {
                        contact.style.display = 'block'; // Exibe o usuário
                    } else {
                        contact.style.display = 'none'; // Oculta o usuário
                    }
                }
            }
        </script>

		<!-- <div id="bottom-bar">
			<button id="addcontact"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Add contact</span></button>
			<button id="settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Settings</span></button>
		</div> -->

	</div>

	<div class="content">

		<div class="contact-profile">
            <img id="selected-user-img" src="" alt="" />
            <p id="selected-user-name"></p>
		</div>

        <script>
            var contactListItems = document.querySelectorAll("#contacts .contact");

            contactListItems.forEach(function(item) {
                item.addEventListener("click", function() {
                    var selectedUserImg = document.getElementById("selected-user-img");
                    var selectedUserName = document.getElementById("selected-user-name");

                    selectedUserImg.src = item.querySelector("img").src;
                    selectedUserName.textContent = item.querySelector(".name").textContent;
                });
            });
        </script>

            <!-- ==== Chat Corpo ==== -->

            <div class="messages">
            <ul id="message-list">

                

            </ul>
            </div>

            <div class="message-input">
            <div class="wrap">
                <input type="text" id="message-input" placeholder="Escreva a sua mensagem..." />
                <i class="fa fa-paperclip attachment" aria-hidden="true"></i>
                <button class="submit" id="send-button"><span class="material-icons-sharp">send</span></button>
            </div>
            </div>

            <?php
                // Verifique se a variável de sessão existe e tem um valor
                if (isset($_SESSION["user_img"])) {
                    $img_log = $_SESSION["user_img"];
                }
            ?>

            <script>
            document.getElementById('send-button').addEventListener('click', function() {
                var messageInput = document.getElementById('message-input').value;
                var userImage = "<?php echo $img_log ?>";  

                if (messageInput.trim() !== '') {
                var messageList = document.getElementById('message-list');
                var newMessage = document.createElement('li');
                newMessage.className = 'replies';

                var imageElement = document.createElement('img');
                imageElement.src = userImage;
                imageElement.alt = 'User Image';

                var messageParagraph = document.createElement('p');
                messageParagraph.textContent = messageInput;

                newMessage.appendChild(imageElement);
                newMessage.appendChild(messageParagraph);

                messageList.appendChild(newMessage);

                // Limpa o campo de entrada
                document.getElementById('message-input').value = '';
                }
            });
            </script>

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


            <!-- //LOCAL STORAGE APENAS USADO EM JS (https://stackoverflow.com/questions/3855337/php-localstorage)
                    //FAZER SISTEMA DE COOKIES PARA ARMAZENAR VARIAVEL
                    //NO ONLOAD DO BODY FAZER
                    //onload="setTheme(<php echo localStorage.getItem('theme'); ?>);"
                    //SÓ QUE OBTER A COOKIE E PASSAR PARA A SETTHEME -->
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

            <!-- ========= Perfil ============ -->

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

        <?php }} ?>

        <script type="text/javascript">
            function myhref(reuniao){
            window.location.href = reuniao;}
        </script>

    <script src="js/index.js"></script>

</body>
</html>