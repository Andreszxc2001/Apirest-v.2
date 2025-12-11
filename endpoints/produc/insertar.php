<?php
//*************************************************** */
//Configuracion de inserción de productos
//*************************************************** */

//Encabezados obligatorios en las APIS en formatos JSON
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");


//Inclucion del modelo de productos
include_once "../../app/ModelProductos.php";

//Inicializacion de instancias
$modelProductos = new ModelProductos();


//Obtener peticiones JSON
$data = json_decode(file_get_contents("php://input"), true);


//Validacion de datos recibidos
if (empty($data["nombre"]) || empty($data["precio"]) || empty($data["stock"])) {
    
    //Manejo de errores de validacion
    http_response_code(400);
    echo json_encode(["mensaje" => "Faltan datos requeridos (nombre,descripcion, precio, stock).
    
    ejemplo: {
        'nombre': 'Producto A',
        'descripcion': 'Descripcion del producto A',
        'precio': 100.50,
        'stock': 20
    }"]);
    
    exit;
    
}

    
try {
    //*************************************************** */
    //Insertar nuevo producto usando el modelo
    //*************************************************** */
    $modelProductos->insertar($data);

    http_response_code(201);
    echo json_encode(["mensaje" => "Producto registrado correctamente."]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>