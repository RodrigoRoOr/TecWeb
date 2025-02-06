<?php

$Vehiculos = [
    "ABC1234" => [
        "Auto" => ["Marca" => "Toyota", "Modelo" => 2020, "Tipo" => "sedan"],
        "Propietario" => ["Nombre" => "Juan Pérez", "Ciudad" => "CDMX", "Dirección" => "Av. Reforma 123"]
    ],
    "XYZ5678" => [
        "Auto" => ["Marca" => "Honda", "Modelo" => 2018, "Tipo" => "hatchback"],
        "Propietario" => ["Nombre" => "Ana López", "Ciudad" => "Guadalajara", "Dirección" => "Calle Morelos 456"]
    ],
    "LMN9101" => [
        "Auto" => ["Marca" => "Ford", "Modelo" => 2021, "Tipo" => "camioneta"],
        "Propietario" => ["Nombre" => "Carlos Ramírez", "Ciudad" => "Monterrey", "Dirección" => "Av. Hidalgo 789"]
    ],
    "DEF2345" => [
        "Auto" => ["Marca" => "Chevrolet", "Modelo" => 2019, "Tipo" => "sedan"],
        "Propietario" => ["Nombre" => "Elena Torres", "Ciudad" => "Puebla", "Dirección" => "Calle Juárez 321"]
    ],
    "GHI6789" => [
        "Auto" => ["Marca" => "Mazda", "Modelo" => 2022, "Tipo" => "hatchback"],
        "Propietario" => ["Nombre" => "Raúl Márquez", "Ciudad" => "Tijuana", "Dirección" => "Blvd. Agua Caliente 654"]
    ],
    "JKL3456" => [
        "Auto" => ["Marca" => "Nissan", "Modelo" => 2017, "Tipo" => "camioneta"],
        "Propietario" => ["Nombre" => "Mariana Suárez", "Ciudad" => "Mérida", "Dirección" => "Av. Colón 987"]
    ],
    "MNO7890" => [
        "Auto" => ["Marca" => "Volkswagen", "Modelo" => 2020, "Tipo" => "sedan"],
        "Propietario" => ["Nombre" => "Daniel Gómez", "Ciudad" => "León", "Dirección" => "Blvd. López Mateos 234"]
    ],
    "PQR1234" => [
        "Auto" => ["Marca" => "Hyundai", "Modelo" => 2015, "Tipo" => "hatchback"],
        "Propietario" => ["Nombre" => "Sofía Hernández", "Ciudad" => "Querétaro", "Dirección" => "Calle Independencia 456"]
    ],
    "STU5678" => [
        "Auto" => ["Marca" => "Jeep", "Modelo" => 2021, "Tipo" => "camioneta"],
        "Propietario" => ["Nombre" => "Fernando López", "Ciudad" => "Chihuahua", "Dirección" => "Av. Tecnológico 789"]
    ],
    "VWX3456" => [
        "Auto" => ["Marca" => "KIA", "Modelo" => 2019, "Tipo" => "sedan"],
        "Propietario" => ["Nombre" => "Gabriela Silva", "Ciudad" => "Toluca", "Dirección" => "Paseo Colón 101"]
    ],
    "YZA6789" => [
        "Auto" => ["Marca" => "BMW", "Modelo" => 2023, "Tipo" => "hatchback"],
        "Propietario" => ["Nombre" => "Roberto Castillo", "Ciudad" => "Cancún", "Dirección" => "Blvd. Kukulcán 303"]
    ],
    "BCD7891" => [
        "Auto" => ["Marca" => "Mercedes-Benz", "Modelo" => 2018, "Tipo" => "sedan"],
        "Propietario" => ["Nombre" => "Andrea Morales", "Ciudad" => "San Luis Potosí", "Dirección" => "Calle Hidalgo 909"]
    ],
    "EFG4567" => [
        "Auto" => ["Marca" => "Renault", "Modelo" => 2016, "Tipo" => "hatchback"],
        "Propietario" => ["Nombre" => "José Rodríguez", "Ciudad" => "Veracruz", "Dirección" => "Av. Costa Verde 556"]
    ],
    "HIJ6783" => [
        "Auto" => ["Marca" => "Peugeot", "Modelo" => 2017, "Tipo" => "camioneta"],
        "Propietario" => ["Nombre" => "Valeria Muñoz", "Ciudad" => "Aguascalientes", "Dirección" => "Calle Madero 302"]
    ],
    "KLM2348" => [
        "Auto" => ["Marca" => "Subaru", "Modelo" => 2021, "Tipo" => "sedan"],
        "Propietario" => ["Nombre" => "Pablo Fernández", "Ciudad" => "Saltillo", "Dirección" => "Blvd. Nazario 505"]
    ],
    "NOP4590" => [
        "Auto" => ["Marca" => "Mitsubishi", "Modelo" => 2019, "Tipo" => "hatchback"],
        "Propietario" => ["Nombre" => "Diana Escobar", "Ciudad" => "Morelia", "Dirección" => "Calle Valladolid 808"]
    ],
    "QRS6782" => [
        "Auto" => ["Marca" => "Tesla", "Modelo" => 2022, "Tipo" => "sedan"],
        "Propietario" => ["Nombre" => "Luis Navarro", "Ciudad" => "Tampico", "Dirección" => "Av. Hidalgo 112"]
    ]
];

// Inicializar la variable de mensaje
$mensaje = "";

// Verifica si hay una consulta por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $consulta = $_POST["consulta"];

    if ($consulta == "uno") {
        $matricula = strtoupper(trim($_POST["matricula"])); // Convertir a mayúsculas

        if (isset($Vehiculos[$matricula])) {
            $auto = $Vehiculos[$matricula];
            $mensaje = "<h3>Detalles del Vehículo</h3>";
            $mensaje .= "<p><strong>Matrícula:</strong> $matricula</p>";
            $mensaje .= "<p><strong>Marca:</strong> " . $auto["Auto"]["Marca"] . "</p>";
            $mensaje .= "<p><strong>Modelo:</strong> " . $auto["Auto"]["Modelo"] . "</p>";
            $mensaje .= "<p><strong>Tipo:</strong> " . $auto["Auto"]["Tipo"] . "</p>";
            $mensaje .= "<p><strong>Propietario:</strong> " . $auto["Propietario"]["Nombre"] . "</p>";
            $mensaje .= "<p><strong>Ciudad:</strong> " . $auto["Propietario"]["Ciudad"] . "</p>";
            $mensaje .= "<p><strong>Dirección:</strong> " . $auto["Propietario"]["Dirección"] . "</p>";
        } else {
            $mensaje = "<p style='color:red;'>No se encontró la matrícula ingresada.</p>";
        }
    } elseif ($consulta == "todos") {
        $mensaje = "<h3>Todos los Autos Registrados</h3>";
        foreach ($Vehiculos as $matricula => $auto) {
            $mensaje .= "<p><strong>Matrícula:</strong> $matricula</p>";
            $mensaje .= "<p><strong>Marca:</strong> " . $auto["Auto"]["Marca"] . "</p>";
            $mensaje .= "<p><strong>Modelo:</strong> " . $auto["Auto"]["Modelo"] . "</p>";
            $mensaje .= "<p><strong>Tipo:</strong> " . $auto["Auto"]["Tipo"] . "</p>";
            $mensaje .= "<p><strong>Propietario:</strong> " . $auto["Propietario"]["Nombre"] . "</p>";
            $mensaje .= "<p><strong>Ciudad:</strong> " . $auto["Propietario"]["Ciudad"] . "</p>";
            $mensaje .= "<p><strong>Dirección:</strong> " . $auto["Propietario"]["Dirección"] . "</p>";
            $mensaje .= "<hr>";
        }
    }
}
?>