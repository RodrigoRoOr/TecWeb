<?php
//  Conexión a la base de datos (ajusta estos valores con los tuyos)
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "cybertricks";

$conn = new mysqli($servername, $username, $password, $dbname);

//  Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

//  Recoger los datos del formulario (asegúrate de SANITIZAR y VALIDAR los datos)
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena']; //  ¡¡¡PELIGRO: NO HACER ESTO EN PRODUCCIÓN!!!
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$fecha = $_POST['fecha'];

//  Sanitizar los datos (ejemplo básico, ¡mejora esto!)
$correo = filter_var($correo, FILTER_SANITIZE_EMAIL);
$nombre = htmlspecialchars($nombre);
$apellido = htmlspecialchars($apellido);

//  Validar el correo (ejemplo básico, ¡mejora esto!)
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo "Correo inválido";
    exit();
}

//  ¡¡¡ELIMINAMOS EL HASHING DE LA CONTRASEÑA!!!

//  Preparar la consulta SQL
$sql = "INSERT INTO usuarios (correo, contrasena, nombre, apellido, fecha) 
        VALUES ('$correo', '$contrasena', '$nombre', '$apellido', '$fecha')";

if ($conn->query($sql) === TRUE) {
    echo "Registro exitoso";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>