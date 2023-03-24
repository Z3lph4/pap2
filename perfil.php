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
                    <h2>Gest<span class="clogo">EMP</span></h2>
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
                <p>Hey, <b>Daniel</b></p>
                <small class="text-muted">Admin</small>
            </div>
            <div class="profile-photo">
                <img src="./img/profile-1.jpg">
            </div>
            </div>
        </div>
        <!-- END OF TOP -->
        <div class="recent-updates">
            <h2>Recent Updates</h2>
            <div class="updates">
                <div class="update">
                    <div class="profile-photo">
                        <img src="./img/profile-2.jpg">
                    </div>
                <div class="message">
                    <p><b>Mike Tyson</b> received his order of
                    Night lion tech GPS drone.</p>
                    <small class="text-muted">2 Minutes Ago</small>
                </div>
            </div>
            <div class="update">
                    <div class="profile-photo">
                        <img src="./img/profile-3.jpg">
                    </div>
                <div class="message">
                    <p><b>Mike Tyson</b> received his order of
                    Night lion tech GPS drone.</p>
                    <small class="text-muted">2 Minutes Ago</small>
                </div>
            </div>
            <div class="update">
                    <div class="profile-photo">
                        <img src="./img/profile-4.jpg">
                    </div>
                <div class="message">
                    <p><b>Mike Tyson</b> received his order of
                    Night lion tech GPS drone.</p>
                    <small class="text-muted">2 Minutes Ago</small>
                </div>
            </div>
            </div>
        </div>
        <!--------------------- END OF RECENT UPDATES ------------------->
        <div class="sales-analytics">
            <h2>Sales Analytics</h2>
        <div class="item online">
            <div class="icon">
                <span class="material-icons-sharp">shopping_cart</span>
            </div>
        <div class="right">
            <div class="info">
                <h3>ONLINE ORDERS</h3>
                <small class="text-muted">Last 24 Hours</small>
            </div>
                <h5 class="success">+39%</h5>
                <h3>3849</h3>
            </div>
        </div>

        <div class="item offline">
            <div class="icon">
                <span class="material-icons-sharp">local_mall</span>
            </div>
        <div class="right">
            <div class="info">
                <h3>OFFLINE ORDERS</h3>
                <small class="text-muted">Last 24 Hours</small>
            </div>
                <h5 class="danger">-17%</h5>
                <h3>1100</h3>
            </div>
        </div>

        <div class="item customers">
            <div class="icon">
                <span class="material-icons-sharp">person</span>
            </div>
        <div class="right">
            <div class="info">
                <h3>NEW CUSTOMERS</h3>
                <small class="text-muted">Last 24 Hours</small>
            </div>
                <h5 class="success">+25%</h5>
                <h3>849</h3>
            </div>
        </div>
            <div class="item add-product">
                <div>
                    <span class="material-icons-sharp">add</span>
                <h3>Add Product</h3>
            </div>
        </div>
    </div>
    </div>
    </div>

    <script src="js/index.js"></script>

</body>
</html>