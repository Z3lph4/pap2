<?php
include 'config.php';

session_start();

// Verifique se o botão "Editar" foi clicado
if (isset($_POST['edit'])) {
    // Defina a variável de sessão 'editing' como true
    $_SESSION['editing'] = true;
} elseif (isset($_POST['save'])) { // Verifique se o botão "Salvar" foi clicado
    // Verifique se os campos desc_user e loc_user estão definidos em $_POST
    if (isset($_POST['desc_user']) && isset($_POST['loc_user'])) {
        // Obtenha os valores enviados do formulário
        $editedDescUser = mysqli_real_escape_string($conn, $_POST['desc_user']);
        $editedLocUser = mysqli_real_escape_string($conn, $_POST['loc_user']);

        // Verifique se os campos foram preenchidos
        if (!empty($editedDescUser) && !empty($editedLocUser)) {
            // Execute a lógica de atualização dos campos no banco de dados
            $employeeId = isset($_GET['id']) ? $_GET['id'] : null;

            if ($employeeId !== null) {
                // Execute a consulta SQL de atualização
                $sql = "UPDATE users SET desc_user = '$editedDescUser', loc_user = '$editedLocUser' WHERE id_user = $employeeId";

                if (mysqli_query($conn, $sql)) {
                    // Os dados foram atualizados com sucesso na base de dados
                    // Defina a variável de sessão 'editing' como false
                    $_SESSION['editing'] = false;

                    // Redirecione para a página do perfil do funcionário atualizado
                    header("Location: perfil.php?id=$employeeId");
                    exit();
                } else {
                    // Ocorreu um erro ao atualizar os dados na base de dados
                    // Exiba uma mensagem de erro ou realize outra ação apropriada
                    echo "Erro ao atualizar as informações do funcionário: " . mysqli_error($conn);
                }
            }
        }
    }

    if (isset($_FILES["file_image"])) {

        // Obter informações sobre o arquivo
        $image_name = $_FILES["file_image"]["name"];
        $image_tmp = $_FILES["file_image"]["tmp_name"];
        
        // Ler o conteúdo do arquivo
        $image_data = file_get_contents($image_tmp);
        
        $employeeId = isset($_GET['id']) ? $_GET['id'] : null;
        
        // Preparar a consulta SQL
        $stmt = $conn->prepare("UPDATE users SET imagem = '$image_data' WHERE id_user = $employeeId");
        
        // Executar a consulta
        if ($stmt->execute()) {
            echo "Imagem enviada e salva com sucesso!";
        } else {
            echo "Erro ao salvar a imagem: " . $stmt->error;
        }
    }
} elseif (isset($_POST['cancel'])) { // Verifique se o botão "Cancelar" foi clicado
    // Defina a variável de sessão 'editing' como false
    $_SESSION['editing'] = false;

    // Redirecione de volta para a página inicial
    header("Location: perfil.php");
    exit();
}

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
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
            
            <a href="perfil.php?id=<?php echo $_SESSION['user_id']; ?>" class="active">
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
        <?php
            // Recupere o ID do funcionário da URL
                $employeeId = isset($_GET['id']) ? $_GET['id'] : null;

                if ($employeeId !== null) {
                    $sql = "SELECT * FROM users WHERE id_user = $employeeId";

                    if ($res = mysqli_query($conn, $sql)) {
                        while ($reg = mysqli_fetch_assoc($res)) {
                            $img_user = $reg['imagem'];
                        }
                    }
                }

                // Verifique se um arquivo foi enviado e faça o upload
                if (isset($_FILES['profile_image'])) {
                    $file = $_FILES['profile_image'];
                    $file_name = $file['name'];
                    $file_tmp = $file['tmp_name'];

                    // Diretório onde o arquivo será salvo
                    $upload_directory = './img/users/';

                    // Movendo o arquivo para o diretório desejado
                    move_uploaded_file($file_tmp, $upload_directory . $file_name);

                    // Atualize o caminho da imagem do usuário no banco de dados
                    $sql = "UPDATE users SET imagem = '" . $upload_directory . $file_name . "' WHERE id_user = $employeeId";
                    mysqli_query($conn, $sql);
                }

                if (isset($_POST['edit'])) {
                    $_SESSION['editing'] = true;
                }

                if (isset($_POST['save'])) {
                    unset($_SESSION['editing']);
                }

                if (isset($_POST['cancel'])) {
                    unset($_SESSION['editing']);
                }
            ?>

            <div class="wrapper">
                <div class="profile-card js-profile-card">

                    <div class="profile-card__img">
                        <img src="<?php echo $img_user; ?>" alt="profile card">
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
                <?php if (isset($_SESSION['editing']) && $_SESSION['editing'] == true): ?>
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

                        // Envie o formulário para fazer o upload da imagem
                        const form = new FormData();
                        form.append('profile_image', selectedImage);
                        fetch('?id=<?php echo $employeeId; ?>', {
                            method: 'POST',
                            body: form
                        });
                    });

                    // Dispara o clique no elemento de entrada de arquivo
                    input.click();
                <?php endif; ?>
            });
        </script>

            <div class="profile-card__cnt js-profile-cnt">
                
            <?php
                // Recupere o ID do funcionário da URL
                $employeeId = isset($_GET['id']) ? $_GET['id'] : null;

                if ($employeeId !== null) {
                    $sql = "SELECT * FROM users WHERE id_user = $employeeId";

                    if ($res = mysqli_query($conn, $sql)) {
                        while ($reg = mysqli_fetch_assoc($res)) {
                            $desc_user = $reg['desc_user'];
                            $loc_user = $reg['loc_user'];
                            $nome_user = $reg['nome_user'];
                            $img_user = $reg['imagem'];
                            ?>

                            <div class="profile-card__name"><?php echo $nome_user; ?></div>
                            <div class="profile-card__txt" <?php if (isset($_SESSION['editing']) && $_SESSION['editing'] == true) echo 'contenteditable="true"'; ?> id="desc_user">
                                <?php echo $desc_user; ?>
                            </div>
                            <div class="profile-card-loc">
                                <span class="profile-card-loc__txt" <?php if (isset($_SESSION['editing']) && $_SESSION['editing'] == true) echo 'contenteditable="true"'; ?> id="loc_user">
                                    <?php echo $loc_user; ?>
                                </span>
                            </div>

                        <?php
                        }
                    }
                }
                ?>

                <div class="profile-card-inf">
                    <?php
                    // Recupere novamente o ID do funcionário da URL
                    $employeeId = isset($_GET['id']) ? $_GET['id'] : null;

                    if ($employeeId !== null) {
                        $sql = "SELECT *, DATEDIFF(CURRENT_DATE, data_criacao) as data FROM users WHERE id_user = $employeeId";

                        if ($res = mysqli_query($conn, $sql)) {
                            while ($reg = mysqli_fetch_assoc($res)) {
                                $data = $reg['data'];
                                $rank = $reg['rank_user'];
                                ?>

                                <div class="profile-card-inf__item">
                                    <div class="profile-card-inf__title"><?php echo $data; ?></div>
                                    <div class="profile-card-inf__txt">Dias na Empresa</div>
                                </div>

                                <div class="profile-card-inf__item">
                                    <div class="profile-card-inf__title"><?php echo $rank; ?></div>
                                    <div class="profile-card-inf__txt">Cargo na Empresa</div>
                                </div>

                            <?php
                            }
                        }
                    }
                    ?>
                </div>

                <div class="profile-card-ctr">
                    <?php if (isset($_SESSION['editing']) && $_SESSION['editing'] == true): ?>
                        <form method="POST" action="">
                            <button class="profile-card__button button--blue" type="button" name="save" onclick="saveData();">Salvar</button>
                            <button class="profile-card__button button--orange" onclick="cancelEditing()">Cancelar</button>
                        </form>
                    <?php else: ?>
                        <button class="profile-card__button button--blue js-message-btn" onclick="myhref('chat.php');">Mensagem</button>
                        <?php if ($employeeId == $_SESSION['user_id']): ?>
                            <form method="POST" action="">
                                <button class="profile-card__button button--orange" type="submit" name="edit">Editar</button>
                            </form>
                        <?php else: ?>
                            <button class="profile-card__button button--orange" onclick="window.location.href = 'funcionarios.php';">Voltar</button>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

            <script>
                function cancelEditing() {
                    window.location.href = 'perfil.php?id=<?php echo $_SESSION['user_id']; ?>';
                    <?php $_SESSION['editing'] = false; ?>
                }
            </script>

                <script>
                    function saveData() {
                        var desc_user = document.getElementById('desc_user').innerText;
                        var loc_user = document.getElementById('loc_user').innerText;

                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "update_user_data.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.onreadystatechange = function() {
                            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                                window.location.href = 'perfil.php?id=<?php echo $_SESSION['user_id']; ?>'; // Redirecionar para a página de perfil atualizada
                            }
                        };
                        xhr.send("employeeId=" + <?php echo $employeeId; ?> + "&desc_user=" + encodeURIComponent(desc_user) + "&loc_user=" + encodeURIComponent(loc_user));
                    }
                </script>

            </div>
        </div>
    </div>
    <!-- Resto do seu código -->
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