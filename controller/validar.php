<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de inicio de sesión
    $username = $_POST['loginUsername'];
    $password = $_POST['loginPassword'];

    // Conexión a la base de datos (ajusta los datos según tu configuración)
    $servername = "localhost";
    $username_db = "root";
    $password_db = "";
    $database = "miempresa";

    // Crear conexión
    $conn = new mysqli($servername, $username_db, $password_db, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Escapar los datos del formulario para evitar inyección SQL (aunque se recomienda utilizar sentencias preparadas)
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // Consulta SQL para verificar el usuario y contraseña
    $sql = "SELECT * FROM tb_usuarios WHERE NomUser = '$username' AND Passwd = '$password'";
    $result = $conn->query($sql);

    if ($result === false) {
        // Manejo de errores en la consulta SQL
        echo json_encode(array('success' => 0, 'error' => $conn->error));
    } elseif ($result->num_rows > 0) {
        // Usuario encontrado, iniciar sesión y redirigir
        $row = $result->fetch_assoc();
        $_SESSION['login'] = "true";
        $_SESSION['nomusuario'] = $username;
        
        // Redirigir a una página de éxito o enviar una respuesta JSON de éxito
        echo json_encode(array('success' => 1));
    } else {
        // No se encontró el usuario o la contraseña no coincidió
        //echo json_encode(array('success' => 0, 'error' => 'Usuario o contraseña incorrectos'));
    }

    // Cerrar conexión
    $conn->close();
}
?>
