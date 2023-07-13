<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "pap2";

$conn = mysqli_connect($hostname, $username, $password, $database) or die("Database connection failed");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tarefaId = isset($_POST['tarefaId']) ? $_POST['tarefaId'] : null;
$editedDescTarefa = isset($_POST['desc_tarefa']) ? $_POST['desc_tarefa'] : null;
$editedDataTarefa = isset($_POST['data_tarefa']) ? $_POST['data_tarefa'] : null;

if ($tarefaId !== null && $editedDescTarefa !== null && $editedDataTarefa !== null) {
    $editedDescTarefa = mysqli_real_escape_string($conn, $editedDescTarefa);
    $editedDataTarefa = mysqli_real_escape_string($conn, $editedDataTarefa);

    // Verifique se os campos foram preenchidos
    if (!empty($editedDescTarefa) && !empty($editedDataTarefa)) {
        // Execute a lógica de atualização dos campos no banco de dados
        $sql = "UPDATE tarefas SET desc_tarefa = '$editedDescTarefa', data_tarefa = '$editedDataTarefa' WHERE id_tarefa = $tarefaId";

        if (mysqli_query($conn, $sql)) {
            // Os dados foram atualizados com sucesso na base de dados
            echo "Dados atualizados com sucesso!";
        } else {
            // Ocorreu um erro ao atualizar os dados na base de dados
            echo "Erro ao atualizar as informações da tarefa: " . mysqli_error($conn);
        }
    }
}   

$conn->close();
?>
