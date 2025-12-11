<?php
//*************************************************** */
//Configuracion de actualizacion de productos
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
if (empty($data["id"]) || empty($data["nombre"]) || empty($data["precio"]) || empty($data["stock"])) {
    
    //Manejo de errores de validacion
    http_response_code(400);
    echo json_encode(["mensaje" => "Faltan datos requeridos (id, nombre, precio, stock)."]);
    exit;
    
}

    
try {
    //*************************************************** */
    //Verificar si el producto existe
    //*************************************************** */
    $productoExiste = $modelProductos->obtenerPorId($data["id"]);

    if (!$productoExiste) {
        http_response_code(404);
        echo json_encode(["mensaje" => "Producto no encontrado."]);
        exit;
    }

    //*************************************************** */
    //Actualizar producto usando el modelo
    //*************************************************** */
    $modelProductos->actualizar($data);

    //*************************************************** */
    //Obtener el producto actualizado
    //*************************************************** */
    $productoActualizado = $modelProductos->obtenerPorId($data["id"]);

    http_response_code(200);
    echo json_encode([
        "mensaje" => "Producto actualizado correctamente.",
        "producto" => $productoActualizado
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>