<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 3</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar,  $_7var,  myvar,  $myvar,  $var7,  $_element1, $house*5</p>
    <?php
        //AQUI VA MI CÓDIGO PHP
        $_myvar;
        $_7var;
        //myvar;       // Inválida
        $myvar;
        $var7;
        $_element1;
        //$house*5;     // Invalida
        
        echo '<h4>Respuesta:</h4>';   
    
        echo '<ul>';
        echo '<li>$_myvar es válida porque inicia con guión bajo.</li>';
        echo '<li>$_7var es válida porque inicia con guión bajo.</li>';
        echo '<li>myvar es inválida porque no tiene el signo de dolar ($).</li>';
        echo '<li>$myvar es válida porque inicia con una letra.</li>';
        echo '<li>$var7 es válida porque inicia con una letra.</li>';
        echo '<li>$_element1 es válida porque inicia con guión bajo.</li>';
        echo '<li>$house*5 es inválida porque el símbolo * no está permitido.</li>';
        echo '</ul>';
    ?>
    <h2>Ejercicio 2</h2>
    <p>Proporcionar los valores de $a, $b, $c como sigue:</p>
    <?php
        //Aqui van las variables
        $a= "ManejadorSQL";
        $b= 'MySQL';
        $c= &$a;
        //Aqui se muestra el contenido de cada variable
        echo '<ul>';
        echo "<li>$a, <br></li>";
        echo "<li>$b, <br></li>";
        echo "<li>$c, <br></li>";
        echo " <br>";
        //Se van a agregar las siguientes asignaciones
        $a= "Php server";
        $b= &$a;
        //Se vuelve a mostrar el contenido de cada uno
        echo "<li>$a, <br></li>";
        echo "<li>$b, <br></li>";
        echo "<li>$c, <br> <br></li>";
        echo '</ul>';
        echo '<h4>Respuesta:</h4>';  
        echo "El motivo del cual en el segundo bloque se escribe php server es porque el valor de b y c son apuntadores de a"
    ?>
    <h2>Ejercicio 3</h2>
    <p>Muestra el contenido de cada variable inmediatamente después de cada asignación,
        verificar la evolución del tipo de estas variables (imprime todos los componentes de los
        arreglo):
    </p>
    <?php
        //Variables
        $a = "PHP5";
        echo "<li>$a, <br></li>";
        $z[] = &$a;
        foreach ($z as $z1){
        echo "<li>$z1, <br></li>";}
        $b = "5a version de PHP";
        echo "<li>$b, <br></li>";
        @$c = $b*10;
        echo "<li>$c, <br></li>";
        $a .= $b;
        echo "<li>$a, <br></li>";
        @$b *= $c;
        echo "<li>$b, <br></li>";
        $z[0] = "MySQL";
        foreach ($z as $z1){
        echo "<li>$z1, <br></li>";}
    ?>
</body>
</html>