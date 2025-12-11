<?php
//*************************************************** */
//Configuracion de listado de productos
//*************************************************** */

//Encabezados obligatorios en las APIS en formatos JSON
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");


//Inclucion del modelo de productos
include_once "../../app/ModelProductos.php";

//Inicializacion de instancias
$modelProductos = new ModelProductos();

    
try {
    //*************************************************** */
    //Obtener todos los productos
    //*************************************************** */
    $productos = $modelProductos->obtenerTodos();

    if (count($productos) > 0) {
        //*************************************************** */
        //Agregar acciones disponibles a cada producto
        //*************************************************** */
        $productosConAcciones = array_map(function($producto) {
            return [
                "producto" => $producto,
                "acciones" => [
                    "obtener" => [
                        "metodo" => "GET",
                        "url" => "http://localhost/APIREST/endpoints/produc/obtener_get.php?id=" . $producto["id"]
                    ],
                    "actualizar" => [
                        "metodo" => "POST",
                        "url" => "/APIREST/endpoints/produc/actualizar.php",
                        "body" => [
                            "id" => $producto["id"],
                            "nombre" => $producto["nombre"],
                            "descripcion" => $producto["descripcion"],
                            "precio" => $producto["precio"],
                            "stock" => $producto["stock"]
                        ]
                    ],
                    "eliminar" => [
                        "metodo" => "GET",
                        "url" => "http://localhost/APIREST/endpoints/produc/eliminar_get.php?id=" . $producto["id"]
                    ]
                ]
            ];
        }, $productos);

        http_response_code(200);
        echo json_encode($productosConAcciones, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(404);
        echo json_encode(["mensaje" => "No hay productos registrados."]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>
