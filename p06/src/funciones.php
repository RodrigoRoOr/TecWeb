<?php
function esMultiploDe5y7($num) {
    if ($num%5==0 && $num%7==0)
    {
        echo '<h3>R= El número '.$num.' SÍ es múltiplo de 5 y 7.</h3>';
    }
    else
    {
        echo '<h3>R= El número '.$num.' NO es múltiplo de 5 y 7.</h3>';
    }
}

function SecuenciaParImparPar() {
    $matriz = [];
    $iteraciones = 0;
    $cantidadNumeros = 0;

    do {
        // Generar tres números aleatorios entre 1 y 100
        $num1 = rand(1, 1000);
        $num2 = rand(1, 1000);
        $num3 = rand(1, 1000);

        // Guardar en la matriz
        $matriz[] = [$num1, $num2, $num3];
        $iteraciones++;
        $cantidadNumeros += 3;

        // Verificar si cumplen con la secuencia Par-Impar-Par
    } while (!($num1 % 2 == 0 && $num2 % 2 != 0 && $num3 % 2 == 0));

    return [
        'matriz' => $matriz,
        'iteraciones' => $iteraciones,
        'cantidadNumeros' => $cantidadNumeros
    ];
}
?>
