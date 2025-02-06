<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
</head>
<body>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $edad = isset($_POST["edad"]) ? intval($_POST["edad"]) : 0;
    $sexo = isset($_POST["sexo"]) ? $_POST["sexo"] : "";

    // Verificar si cumple con los requisitos
    if ($sexo == "femenino" && $edad >= 18 && $edad <= 35) {
        $mensaje = "Bienvenida, usted está en el rango de edad permitido.";
    } else {
        $mensaje = "Lo sentimos, no cumple con los requisitos.";
    }
}   
    else {
    $mensaje = "Acceso no válido.";
}
?>
    <h2>Resultado</h2>
    <p><?php echo $mensaje; ?></p>
    <a href="http://localhost/tecweb/practica1/p06/ejercicio5.php">Volver</a>
</body>
</html>