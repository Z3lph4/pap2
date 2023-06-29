<?php
    session_start();
    
    if (isset($_SESSION['editing'])) {
        unset($_SESSION['editing']);
    }
?>