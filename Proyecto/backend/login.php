<?php
//  Conexión a la base de datos (ajusta con tus valores)
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "cybertricks";

$conn = new mysqli($servername, $username, $password, $dbname);

//  Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

//  Recoger los datos del formulario (¡SANITIZAR!)
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

//  Sanitizar el correo
$correo = filter_var($correo, FILTER_SANITIZE_EMAIL);

//  Validar el correo
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo "Correo inválido";
    exit();
}

//  Consulta para obtener el usuario por correo
$sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    //  ¡¡¡PELIGRO!!!  ¡¡¡NO HAGAS ESTO EN PRODUCCIÓN!!!
    //  En producción, usa password_verify() para comparar el hash almacenado con la contraseña ingresada.
    if ($contrasena == $row['contrasena']) {
        echo "Inicio de sesión exitoso";
        //  Aquí podrías iniciar una sesión (session_start() y almacenar datos del usuario)
    } else {
        echo "Contraseña incorrecta";
    }
} else {
    echo "Usuario no encontrado";
}

$conn->close();
?>