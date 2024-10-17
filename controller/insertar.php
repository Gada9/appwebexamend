<?php
include('../conexion.php'); // Ajusta la ruta según sea necesario

$con = conectaDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $existencia = $_POST['existencia'];

    $sql = "INSERT INTO tb_productos (Nombre, Precio, Ext) VALUES ('$nombre', '$precio', '$existencia')";
    
    if (mysqli_query($con, $sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($con)]);
    }
}

mysqli_close($con);
?>
