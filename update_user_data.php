<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "pap2";

$conn = mysqli_connect($hostname, $username, $password, $database) or die("Database connection failed");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$employeeId = isset($_POST['employeeId']) ? $_POST['employeeId'] : null;
$desc_user = isset($_POST['desc_user']) ? $_POST['desc_user'] : null;
$loc_user = isset($_POST['loc_user']) ? $_POST['loc_user'] : null;

if ($employeeId !== null && $desc_user !== null && $loc_user !== null) {
    $sql = "UPDATE users SET desc_user = ?, loc_user = ? WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $desc_user, $loc_user, $employeeId);

    if ($stmt->execute()) {
        echo "Dados atualizados com sucesso!";
    } else {
        echo "Erro ao atualizar os dados: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>