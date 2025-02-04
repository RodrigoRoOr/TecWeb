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

        echo "$a, <br>";
        echo "$b, <br>";
        echo "$c, <br>";
        echo " <br>";
        //Se van a agregar las siguientes asignaciones
        $a= "Php server";
        $b= &$a;
        //Se vuelve a mostrar el contenido de cada uno
        echo "$a, <br>";
        echo "$b, <br>";
        echo "$c, <br> <br>";
        echo '<h4>Respuesta:</h4>';  
        echo "El motivo del cual en el segundo bloque se escribe php server es porque el valor de b y c son apuntadores de a";
        unset($a, $b, $c); //Borra las variables para que se puedan reciclar en un futuro

    ?>
    <h2>Ejercicio 3</h2>
    <p>Muestra el contenido de cada variable inmediatamente después de cada asignación,
        verificar la evolución del tipo de estas variables (imprime todos los componentes de los
        arreglo):
    </p>
    <?php
        //Variables
        $a = "PHP5";
        echo "$a, <br>";
        $z[] = &$a;
        print_r($z);
        unset($z); //Se utiliza para desvincular las variables
        echo "<br>";
        $b = "5a version de PHP";
        echo "$b, <br>";
        @$c = $b*10;
        echo "$c, <br>";
        $a .= $b;
        echo "$a, <br>";
        @$b *= $c;
        echo "$b, <br>";
        $z[0] = "MySQL";
        print_r($z);
        echo  "<br>";
        
    ?>
    <h2>Ejercicio 4</h2>
    <p>Lee y muestra los valores de las variables del ejercicio anterior, pero ahora con la ayuda de
       la matriz $GLOBALS o del modificador global de PHP. </p>
    <?php
        //Variables globales
        var_dump($GLOBALS['a']);
        echo "<br>";
        
        var_dump($GLOBALS['b']);
        echo "<br>";
        
        var_dump($GLOBALS['c']);
        echo "<br>";
        
        print_r($GLOBALS['z']);
        echo "<br>";
        unset($a, $b, $c, $z);//Borra las variables para que se puedan reciclar en un futuro
    ?>
    <h2>Ejercicio 5</h2>
    <p>Dar el valor de las variables $a, $b, $c al final del siguiente script: </p>
   <?php
        //Asignación de las variables
        $a = "7 personas";
        $b = (integer) $a;
        $a = "9E3";
        $c = (double) $a;
        //Resultados a imprimir
        echo "$a <br>";
        echo "$b <br>"; 
        echo "$c <br>";
        unset($a, $b, $c);//Borra las variables para que se puedan reciclar en un futuro
    ?>

    <h2>Ejercicio 6</h2>
    <p>Dar y comprobar el valor booleano de las variables $a, $b, $c, $d, $e y $f y muéstralas
       usando la función var_dump. Después investiga una función de PHP que permita transformar el valor booleano de $c y $e
       en uno que se pueda mostrar con un echo: 
    </p>
    <?php
        //Asugnación de las variables
        $a = "0";
        $b = "TRUE";
        $c = FALSE;
        $d = ($a OR $b);
        $e = ($a AND $c);
        $f = ($a XOR $b);

        echo "Valores utilizando var_dump: ";
        var_dump($a, $b, $c, $d, $e, $f);
        
        echo"<br><br>";
        echo "Valores utilizando echo: <br>";
        echo "a: $a <br>";
        echo "b: $b <br>"; 
        echo "c: " . var_export($c, true) . "<br>";
        echo "d: " . var_export($d, true) . "<br>";
        echo "e: " . var_export($e, true) . "<br>";
        echo "f: " . var_export($f, true) . "<br>";
    
    ?>
</body>
</html>