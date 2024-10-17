<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("location: ../index.php"); // Cambia la ruta si es necesario
}

include('../conexion.php'); // Asegúrate de que esta línea incluya la conexión a tu base de datos
$con = conectaDB();

if (isset($_GET['idp'])) { // Verifica si se ha pasado el ID del producto
    $id = $_GET['idp'];

    // Ejecuta la consulta para eliminar el producto
    $sql = "DELETE FROM tb_productos WHERE idPro = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id); // Vincula el parámetro ID

    if ($stmt->execute()) {
        // Redirecciona a dashboard.php después de eliminar
        header("Location: ../dashboard.php"); // Cambia la ruta si es necesario
        exit();
    } else {
        echo "Error al eliminar el producto.";
    }

    $stmt->close(); // Cierra la declaración
}
$con->close(); // Cierra la conexión
?>

