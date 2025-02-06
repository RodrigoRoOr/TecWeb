<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <title>Practica 4</title>
</head>
<body>
    <h2>Ejercicio 5</h2>
    <p>Ingrese su edad y seleccione su sexo.</p>

    <form action="http://localhost/tecweb/practica1/p06/src/post5.php" method="POST">
        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" min="1" required>
        <br><br>

        <label>Sexo:</label>
        <input type="radio" id="femenino" name="sexo" value="femenino" required>
        <label for="femenino">Femenino</label>

        <input type="radio" id="masculino" name="sexo" value="masculino">
        <label for="masculino">Masculino</label>
        <br><br>

        <button type="submit">Enviar</button>
    </form>
</body>
</html>
