
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
    <title>Práctica 3</title>
</head>
<body>
   
    <h2>Ejercicio 1</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar, $_7var, myvar, $myvar, $var7, $_element1, $house*5</p>
    
    <?php
    echo '<h4>Respuesta:</h4>';
    echo '<ul>
        <li>$_myvar es válida porque inicia con guión bajo.</li>
        <li>$_7var es válida porque inicia con guión bajo.</li>
        <li>myvar es inválida porque no tiene el signo de dólar ($).</li>
        <li>$myvar es válida porque inicia con una letra.</li>
        <li>$var7 es válida porque inicia con una letra.</li>
        <li>$_element1 es válida porque inicia con guión bajo.</li>
        <li>$house*5 es inválida porque el símbolo * no está permitido.</li>
    </ul>';
    ?>
    
    <h2>Ejercicio 2</h2>
    <p>Proporcionar los valores de $a, $b, $c como sigue:</p>
    <?php
    $a = "ManejadorSQL";
    $b = 'MySQL';
    $c = &$a;
    
    echo '<p>' . htmlspecialchars($a) . ',<br />' . htmlspecialchars($b) . ',<br />' . htmlspecialchars($c) . ',<br /></p>';
    
    $a = "Php server";
    $b = &$a;
    
    echo '<p>' . htmlspecialchars($a) . ',<br />' . htmlspecialchars($b) . ',<br />' . htmlspecialchars($c) . ',<br /></p>';
    
    echo '<h4>Respuesta:</h4>';
    echo '<p>El motivo por el cual en el segundo bloque se escribe "Php server" es porque el valor de $b y $c son referencias a $a.</p>';
    
    unset($a, $b, $c);
    ?>
    
    <h2>Ejercicio 3</h2>
    <p>Muestra el contenido de cada variable inmediatamente después de cada asignación:</p>
    <?php
    $a = "PHP5";
    echo '<p>' . htmlspecialchars($a) . ',<br /></p>';
    
    $z[] = &$a;
    echo '<pre>'; print_r($z); echo '</pre>';
    unset($z);
    
    $b = "5a version de PHP";
    echo '<p>' . htmlspecialchars($b) . ',<br /></p>';
    
    @$c = $b * 10;
    echo '<p>' . htmlspecialchars($c) . ',<br /></p>';
    
    $a .= $b;
    echo '<p>' . htmlspecialchars($a) . ',<br /></p>';
    
    @$b *= $c;
    echo '<p>' . htmlspecialchars($b) . ',<br /></p>';
    
    $z[0] = "MySQL";
    echo '<pre>'; print_r($z); echo '</pre>';
    ?>
    
    <h2>Ejercicio 4</h2>
    <p>Lee y muestra los valores de las variables anteriores con $GLOBALS:</p>
    <?php
    echo '<h4>Respuesta:</h4>';
    echo '<pre>'; var_dump($GLOBALS['a'], $GLOBALS['b'], $GLOBALS['c'], $GLOBALS['z']); echo '</pre>';
    unset($a, $b, $c, $z);
    ?>
    
    <h2>Ejercicio 5</h2>
    <p>Dar el valor de las variables $a, $b, $c:</p>
    <?php
    $a = "7 personas";
    $b = (integer) $a;
    $a = "9E3";
    $c = (double) $a;
    
    echo '<h4>Respuesta:</h4>';
    echo '<p>' . htmlspecialchars($a) . '<br />' . htmlspecialchars($b) . '<br />' . htmlspecialchars($c) . '</p>';
    unset($a, $b, $c);
    ?>
    
    <h2>Ejercicio 6</h2>
    <p>Comprobar el valor booleano de las variables $a, $b, $c, $d, $e y $f:</p>
    <?php
    $a = "0";
    $b = "TRUE";
    $c = FALSE;
    $d = ($a OR $b);
    $e = ($a AND $c);
    $f = ($a XOR $b);
    
    echo '<h4>Respuesta:</h4>';
    echo '<pre>'; var_dump($a, $b, $c, $d, $e, $f); echo '</pre>';
    
    echo '<p>Valores utilizando echo:</p>';
    echo '<p>a: ' . htmlspecialchars($a) . '<br />';
    echo 'b: ' . htmlspecialchars($b) . '<br />';
    echo 'c: ' . var_export($c, true) . '<br />';
    echo 'd: ' . var_export($d, true) . '<br />';
    echo 'e: ' . var_export($e, true) . '<br />';
    echo 'f: ' . var_export($f, true) . '</p>';
    ?>
    
    <h2>Ejercicio 7</h2>
    <p>Usando la variable predefinida $_SERVER, determina la versión de Apache y PHP, el sistema operativo del servidor y el idioma del navegador:</p>
    <?php
    $apache_version = $_SERVER['SERVER_SOFTWARE']; 
    $php_version = phpversion(); 
    $server_os = PHP_OS;
    $browser_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    
    echo '<h4>Respuesta:</h4>';
    echo '<p>Versión de Apache y PHP: ' . htmlspecialchars($apache_version) . ', ' . htmlspecialchars($php_version) . '<br />';
    echo 'Sistema operativo del servidor: ' . htmlspecialchars($server_os) . '<br />';
    echo 'Idioma del navegador: ' . htmlspecialchars($browser_language) . '</p>';
    ?>

    <p>
        <a href="https://validator.w3.org/markup/check?uri=referer"><img
        src="https://www.w3.org/Icons/valid-xhtml11" alt="Valid XHTML 1.1" height="31" width="88" /></a>
    </p>
</body>
</html>
