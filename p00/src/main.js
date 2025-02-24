
function getDatos()
{
    var nombre = prompt("Nombre: ", "");

    var edad = prompt("Edad: ", 0);

    var div1 = document.getElementById('nombre');
    div1.innerHTML = '<h3> Nombre: '+nombre+'</h3>';

    var div2 = document.getElementById('edad');
    div2.innerHTML = '<h3> Edad: '+edad+'</h3>';
}

//Ejercicio 1
function mostrarMensaje() 
{
    document.write('Hola Mundo');
}
//Ejercicio 2
function mostrarDatos() 
{
    var nombre = 'Juan';
    var edad = 10;
    var altura = 1.92;
    var casado = false;

    var salida = nombre + '<br>' + edad + '<br>' + altura + '<br>' + casado;
    document.getElementById("MD").innerHTML = salida;
}
//Ejercicio 3
function solicitarDatos() {
    var nombre = prompt('Ingresa tu nombre:', '');
    var edad = prompt('Ingresa tu edad:', '');

    if (nombre && edad) {
        var mensaje = 'Hola ' + nombre + ', así que tienes ' + edad + ' años.';
        document.getElementById("SD").innerHTML = mensaje;
    } else {
        document.getElementById("SD").innerHTML = 'Por favor, ingresa todos los datos.';
    }
}

//Ejercicio 4
function calcularOperaciones() {
    var valor1 = prompt('Introducir primer número:', '');
    var valor2 = prompt('Introducir segundo número:', '');

    if (!isNaN(valor1) && !isNaN(valor2) && valor1 !== '' && valor2 !== '') {
        var suma = parseInt(valor1) + parseInt(valor2);
        var producto = parseInt(valor1) * parseInt(valor2);

        var mensaje = 'La suma es ' + suma + '<br>' + 'El producto es ' + producto;
        document.getElementById("CO").innerHTML = mensaje;
    } else {
        document.getElementById("CO").innerHTML = 'Por favor, ingresa valores numéricos válidos.';
    }
}

//Ejercicio 5
function verificarAprobacion() {
    var nombre = prompt('Ingresa tu nombre:', '');
    var nota = prompt('Ingresa tu nota:', '');

    if (!isNaN(nota) && nota !== '') {
        nota = parseFloat(nota); // Convertir a número

        if (nota >= 4) {
            document.getElementById("VA").innerHTML = nombre + ' está aprobado con un ' + nota;
        } else {
            document.getElementById("VA").innerHTML = nombre + ' no ha aprobado con un ' + nota;
        }
    } else {
        document.getElementById("VA").innerHTML = 'Por favor, ingresa una nota válida.';
    }
}

//Ejercicio 6 
function encontrarMayor() {
    var num1 = prompt('Ingresa el primer número:', '');
    var num2 = prompt('Ingresa el segundo número:', '');

    if (!isNaN(num1) && !isNaN(num2) && num1 !== '' && num2 !== '') {
        num1 = parseInt(num1);
        num2 = parseInt(num2);

        if (num1 > num2) {
            document.getElementById("EM").innerHTML = 'El mayor es ' + num1;
        } else if (num2 > num1) {
            document.getElementById("EM").innerHTML = 'El mayor es ' + num2;
        } else {
            document.getElementById("EM").innerHTML = 'Ambos números son iguales.';
        }
    } else {
        document.getElementById("EM").innerHTML = 'Por favor, ingresa valores numéricos válidos.';
    }
}

//Ejercicio 7
function calcularPromedio() {
    var nota1 = prompt('Ingresa 1ra. nota:', '');
    var nota2 = prompt('Ingresa 2da. nota:', '');
    var nota3 = prompt('Ingresa 3ra. nota:', '');

    if (!isNaN(nota1) && !isNaN(nota2) && !isNaN(nota3) && nota1 !== '' && nota2 !== '' && nota3 !== '') {
        nota1 = parseInt(nota1);
        nota2 = parseInt(nota2);
        nota3 = parseInt(nota3);

        var pro = (nota1 + nota2 + nota3) / 3;
        var mensaje = '';

        if (pro >= 7) {
            mensaje = 'Aprobado';
        } else if (pro >= 4) {
            mensaje = 'Regular';
        } else {
            mensaje = 'Reprobado';
        }

        document.getElementById("CP").innerHTML = 'Promedio: ' + pro.toFixed(2) + ' - ' + mensaje;
    } else {
        document.getElementById("CP").innerHTML = 'Por favor, ingresa valores numéricos válidos.';
    }
}

//Ejercicio 8
function convertirNumeroATexto() {
    var valor = prompt('Ingresar un valor comprendido entre 1 y 5:', '');

    // Verificamos que el valor sea un número válido
    if (!isNaN(valor) && valor !== '') {
        valor = parseInt(valor);
        var mensaje = '';

        switch (valor) {
            case 1:
                mensaje = 'Uno';
                break;
            case 2:
                mensaje = 'Dos';
                break;
            case 3:
                mensaje = 'Tres';
                break;
            case 4:
                mensaje = 'Cuatro';
                break;
            case 5:
                mensaje = 'Cinco';
                break;
            default:
                mensaje = 'Debe ingresar un valor comprendido entre 1 y 5.';
        }

        document.getElementById("CN").innerHTML = mensaje;
    } else {
        document.getElementById("CN").innerHTML = 'Por favor, ingresa un número válido.';
    }
}

//Ejercicio 9
function cambiarColorFondo() {
    var col = prompt('Ingresa el color con que quieres pintar el fondo de la ventana (rojo, verde, azul):', '').toLowerCase();

    switch (col) {
        case 'rojo':
            document.body.style.backgroundColor = '#ff0000';
            break;
        case 'verde':
            document.body.style.backgroundColor = '#00ff00';
            break;
        case 'azul':
            document.body.style.backgroundColor = '#0000ff';
            break;
        default:
            alert('Por favor, ingresa uno de los colores válidos: rojo, verde o azul.');
    }
}

//Ejercicio 10
function mostrarNumeros() {
    var resultado = '';

    var x = 1;
    while (x <= 100) {
        resultado += x + '<br>';
        x++;
    }
    document.getElementById("MN").innerHTML = resultado;
}

//Ejercicio 11
function calcularSuma() {
    var suma = 0;
    var x = 1;

    while (x <= 5) {
        var valor = prompt('Ingresa el valor:', '');

        if (!isNaN(valor) && valor !== '') {
            suma += parseInt(valor);
            x++;
        } else {
            alert('Por favor, ingresa un número válido.');
        }
    }

    document.getElementById("CS").innerHTML = "La suma de los valores es " + suma;
}

//Ejercicio 12
function contarDigitos() {
    var resultado = '';

    do {
        var valor = prompt('Ingresa un valor entre 0 y 999:', '');

        if (!isNaN(valor) && valor !== '') {
            valor = parseInt(valor);

            if (valor === 0) break; // Termina el bucle si el usuario ingresa 0

            resultado += 'El valor ' + valor + ' tiene ';

            if (valor < 10) {
                resultado += '1 dígito';
            } else if (valor < 100) {
                resultado += '2 dígitos';
            } else {
                resultado += '3 dígitos';
            }

            resultado += '<br>';
        } else {
            alert('Por favor, ingresa un número válido entre 0 y 999.');
        }
    } while (valor !== 0);

    document.getElementById("CD").innerHTML = resultado;
}
//Ejercicio 13
function mostrarNumeros2() {
    var resultado = '';

    for (var f = 1; f <= 10; f++) {
        resultado += f + " ";
    }

    document.getElementById("MosNum").innerHTML = resultado;
}

//Ejercicio 14
function mostrarMensajes() {
    var mensajes = 'Cuidado<br>Ingresa tu documento correctamente<br>';
    var resultado = '';
    for (var i = 0; i < 3; i++) {
        resultado += mensajes;
    }

    document.getElementById("MosMen").innerHTML = resultado;
}

//Ejercicio 15
function mostrarMensaje() {
    var mensaje = 'Cuidado<br>Ingresa tu documento correctamente<br>';
    document.getElementById("MosMen2").innerHTML += mensaje;
}

mostrarMensaje();
mostrarMensaje();
mostrarMensaje();

//Ejercicio 16
function mostrarRango(x1, x2) {
    var resultado = '';
    for (var inicio = x1; inicio <= x2; inicio++) {
        resultado += inicio + ' ';
    }
    document.getElementById("MR").innerHTML = resultado;
}
var valor1 = prompt('Ingresa el valor inferior:', '');
valor1 = parseInt(valor1);
var valor2 = prompt('Ingresa el valor superior:', '');
valor2 = parseInt(valor2);
mostrarRango(valor1, valor2);

//Ejercicio 17
function convertirCastellano(x) {
    if (x == 1) return "uno";
    else if (x == 2) return "dos";
    else if (x == 3) return "tres";
    else if (x == 4) return "cuatro";
    else if (x == 5) return "cinco";
    else return "valor incorrecto";
}

var valor = prompt("Ingresa un valor entre 1 y 5", "");
valor = parseInt(valor);
var r = convertirCastellano(valor);
document.getElementById("CC").innerHTML = r;

//Ejercicio 18
function convertirCastellano2(x) {
    switch (x) {
        case 1: return "uno";
        case 2: return "dos";
        case 3: return "tres";
        case 4: return "cuatro";
        case 5: return "cinco";
        default: return "valor incorrecto";
    }
}
var valor = prompt("Ingresa un valor entre 1 y 5", "");
valor = parseInt(valor);
var r = convertirCastellano(valor);
document.getElementById("CC2").innerHTML = r;


