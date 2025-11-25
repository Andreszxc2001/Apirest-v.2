<?php
//*************************************************** */
//Configuracion de registro de usuarios
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
    //Verificar si el usuario ya existe
    //*************************************************** */
    $userExiste = $modelUser->verificar($data["usuario"], "");

    if ($userExiste) {
        http_response_code(409);
        echo json_encode(["mensaje" => "El usuario ya está registrado."]);
        exit;
    }

    //*************************************************** */
    //Insertar nuevo usuario usando el modelo
    //*************************************************** */
    $modelUser->insertar($data);

    http_response_code(201);
    echo json_encode(["mensaje" => "Usuario registrado correctamente."]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>
