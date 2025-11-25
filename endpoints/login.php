<?php
//*************************************************** */
//Configuracion de inicio de sesión de usuarios
//*************************************************** */

//Encabezados obligatorios en las APIS en formatos JSON
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");


//Inclucion del modelo de usuario
include_once "../app/ModelUser.php";

//Inicializacion de instancias
$modelUser = new ModelUser();


//Obtener peticiones JSON
$data = json_decode(file_get_contents("php://input"), true);


//Validacion de datos recibidos
if (empty($data["usuario"]) || empty($data["contrasena"])) {
    
    //Manejo de errores de validacion
    http_response_code(400);
    echo json_encode(["mensaje" => "Faltan datos requeridos."]);
    exit;
    
}

try {
    //*************************************************** */
    //Verificar credenciales del usuario
    //*************************************************** */
    $user = $modelUser->verificar($data["usuario"], $data["contrasena"]);

    if ($user) {
        http_response_code(200);
        echo json_encode(["mensaje" => "Autenticación satisfactoria."]);
    } else {
        http_response_code(401);
        echo json_encode(["mensaje" => "Error en la autenticación."]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>
