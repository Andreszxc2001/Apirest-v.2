<?php
/**
 * index.php
 * Archivo principal de la API
 * Muestra información general y los endpoints disponibles
 */

header("Content-Type: application/json; charset=UTF-8");

$respuesta = [
    "proyecto" => "API de Registro e Inicio de Sesión",
    "autores" => "Arnaldo Pushaina, Elkin Granados, Juan Pablo Hernandez",
	"ADSO" => "GRUPO 5 FICHA 3070294",

	"GUIAS" => "Evidencia de desempeño: (RAP 17) GA7-220501096-AA5-EV01 diseño y desarrollo de servicios web - caso",
	"GUIAS" => "RAP17_GA7_AA5_EV02_IVO_ API",

    "descripcion" => "Servicio web REST con PHP y PDO para registrar usuarios e iniciar sesión.",
    "endpoints" => [
        [
            "metodo" => "POST",
            "url" => "/APIREST/endpoints/register.php",
            "descripcion" => "Registrar un nuevo usuario. Requiere usuario y contraseña en formato JSON."
        ],
        [
            "metodo" => "POST",
            "url" => "/APIREST/endpoints/login.php",
            "descripcion" => "Iniciar sesión con un usuario registrado."
        ]
    ],
    "estado" => "API en funcionamiento ✅"
];

echo json_encode($respuesta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
