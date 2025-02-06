<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 6</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Escribir programa para comprobar si un número es un múltiplo de 5 y 7</p>
    <?php
    require_once __DIR__ . '/src/funciones.php'; //Incluir al archivo

        if(isset($_GET['numero']))
        {
            esMultiploDe5y7($_GET['numero']);
        }
    ?>

    <h2>Ejercicio 2</h2>
    <p>Crea un programa para la generación repetitiva de 3 números aleatorios hasta obtener una
        secuencia compuesta por par, impar, par. 
        Estos números deben almacenarse en una matriz de Mx3, donde M es el número de filas y
        3 el número de columnas. Al final muestra el número de iteraciones y la cantidad de
        números generados:
    </p>
    <?php
     require_once __DIR__ . '/src/funciones.php'; //Incluir al archivo

        $resultado = SecuenciaParImparPar();
        $matriz = $resultado['matriz'];
        $iteraciones = $resultado['iteraciones'];
        $cantidadNumeros = $resultado['cantidadNumeros'];

        echo "<h3>Resultados:</h3>";
        echo "<p>Total de números generados: <strong>$cantidadNumeros</strong> en <strong>$iteraciones</strong> iteraciones.</p>";
        echo "<h3>Matriz Generada:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Número 1</th><th>Número 2</th><th>Número 3</th></tr>";
        foreach ($matriz as $fila) {
            echo "<tr><td>{$fila[0]}</td><td>{$fila[1]}</td><td>{$fila[2]}</td></tr>";
        }
            echo "</table>";
    ?>
    <h2>Ejercicio 3</h2>
    <p>Utiliza un ciclo while y Do while para encontrar el primer número entero obtenido aleatoriamente,
        pero que además sea múltiplo de un número dado.</p>
    <?php
    require_once __DIR__ . '/src/funciones.php'; //Incluir al archivo
        echo "<h3>Resultados:</h3>";
        if(isset($_GET['n']))
        {
            encontrarMultiploWhile($_GET['n']);

        }
    ?>
    <?php
    require_once __DIR__ . '/src/funciones.php'; //Incluir al archivo
        if(isset($_GET['n']))
        {
            encontrarMultiploDoWhile($_GET['n']);
        }
    ?>
    <h2>Ejercicio 4</h2>
    <p>Crear un arreglo cuyos índices van de 97 a 122 y cuyos valores son las letras de la a
        a la z. Usa la función chr(n) que devuelve el caracter cuyo código ASCII es n para poner
        el valor en cada índice.</p>

    <?php
        require_once __DIR__ . '/src/funciones.php';
            echo "<h3>Resultados:</h3>";
            ArregloLetras();
    ?>


    <h2>Ejemplo de POST</h2>
    <form action="http://localhost/tecweb/practica1/p06/index.php" method="post">
        Name: <input type="text" name="name"><br>
        E-mail: <input type="text" name="email"><br>
        <input type="submit">
    </form>
    <br>
    <?php
        if(isset($_POST["name"]) && isset($_POST["email"]))
        {
            echo $_POST["name"];
            echo '<br>';
            echo $_POST["email"];
        }
    ?>
</body>
</html>