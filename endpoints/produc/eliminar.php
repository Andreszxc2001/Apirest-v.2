<?php
//*************************************************** */
//Configuracion de eliminacion de productos
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
if (empty($data["id"])) {
    
    //Manejo de errores de validacion
    http_response_code(400);
    echo json_encode(["mensaje" => "Falta el ID del producto a eliminar."]);
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
    //Guardar datos del producto antes de eliminar
    //*************************************************** */
    $productoEliminado = $productoExiste;

    //*************************************************** */
    //Eliminar producto usando el modelo
    //*************************************************** */
    $modelProductos->eliminar($data["id"]);

    http_response_code(200);
    echo json_encode([
        "mensaje" => "Producto eliminado correctamente.",
        "producto_eliminado" => $productoEliminado
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>