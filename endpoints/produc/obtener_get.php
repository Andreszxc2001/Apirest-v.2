<?php
//*************************************************** */
//Configuracion para obtener un producto por ID via GET
//*************************************************** */

//Encabezados obligatorios en las APIS en formatos JSON
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");


//Inclucion del modelo de productos
include_once "../../app/ModelProductos.php";

//Inicializacion de instancias
$modelProductos = new ModelProductos();


//Obtener ID de la URL
$id = isset($_GET['id']) ? $_GET['id'] : null;


//Validacion de datos recibidos
if (empty($id)) {
    
    //Manejo de errores de validacion
    http_response_code(400);
    echo json_encode(["mensaje" => "Falta el ID del producto."]);
    exit;
    
}

    
try {
    //*************************************************** */
    //Obtener producto por ID
    //*************************************************** */
    $producto = $modelProductos->obtenerPorId($id);

    if ($producto) {
        http_response_code(200);
        echo json_encode($producto, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(404);
        echo json_encode(["mensaje" => "Producto no encontrado."]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>
