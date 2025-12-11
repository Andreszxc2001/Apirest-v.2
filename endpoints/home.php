<?php
/**
 * home.php
 * Página principal después del login
 * Muestra el menú de gestión de productos
 */

header("Content-Type: application/json; charset=UTF-8");

$respuesta = [
    "mensaje" => "Bienvenido al sistema de gestión de productos",
    "menu" => "Panel de Administración de Productos",
    
    "endpoints_productos" => [

        [
            "accion" => "Insertar nuevo producto",
            "metodo" => "POST",
            "url" => "/APIREST/endpoints/produc/insertar.php",
            "descripcion" => "Crea un nuevo producto. Requiere: nombre, descripcion, precio, stock",
            "ejemplo_body" => [
                "nombre" => "Producto ejemplo",
                "descripcion" => "Descripción del producto",
                "precio" => 100.00,
                "stock" => 50
            ]
        ],
        [
            "accion" => "Listar todos los productos",
            "metodo" => "GET",
            "url" => "/APIREST/endpoints/produc/listar.php",
            "descripcion" => "Obtiene el listado completo de productos disponibles"
        ],
    
        [
            "accion" => "Actualizar producto",
            "metodo" => "POST",
            "url" => "/APIREST/endpoints/produc/actualizar.php",
            "descripcion" => "Actualiza un producto existente. Requiere: id, nombre, precio, stock",
            "ejemplo_body" => [
                
                "id" => 1,
                "nombre" => "Producto actualizado",
                "descripcion" => "Nueva descripción",
                "precio" => 150.00,
                "stock" => 30
            ]
        ],
        [
            "accion" => "Eliminar producto (POST)",
            "metodo" => "POST",
            "url" => "/APIREST/endpoints/produc/eliminar.php",
            "descripcion" => "Elimina un producto por su ID",
            "ejemplo_body" => [
                "id" => 1
            ]
        ]
    ],
    
    "notas" => [
        "Los métodos POST requieren enviar datos en formato JSON",
        "Los métodos GET pueden llamarse directamente desde el navegador",
        "Todos los endpoints devuelven respuestas en formato JSON"
    ],
    
    "estado" => "Sistema activo ✅"
];

echo json_encode($respuesta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
