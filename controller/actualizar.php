<?php
include('../conexion.php'); // Ajusta la ruta según sea necesario
$con = conectaDB();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $existencia = $_POST['existencia'];

    $sql = "UPDATE tb_productos SET Nombre='$nombre', Precio='$precio', Ext='$existencia' WHERE idPro='$id'";

    if (mysqli_query($con, $sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>

