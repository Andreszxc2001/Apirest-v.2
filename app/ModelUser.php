<?php
//inclucion de conexion a base de datos
include_once "../config/db.php";


//definicion de la clase ModelUser
class ModelUser {
    
    //constructor de la clase
    private $conn;
    
    public function __construct(){
        $database = new Database();
        $this->conn = $database->conectar();
    }


    //*************************************************** */
    //Funcion insertar datos
    //*************************************************** */
    public function insertar($array){

        $sql = "INSERT INTO usuarios(
                            usuario,
                            contrasena 
                        ) VALUES (
                            :usuario,
                            :contrasena
                            )";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':usuario' => $array['usuario'],
            ':contrasena' => password_hash($array['contrasena'], PASSWORD_BCRYPT)
        ]);
    }


    //*************************************************** */
    //Funcion para verificar usuario
    //*************************************************** */
    public function verificar($usuario, $contrasena){

        $sql = "SELECT * 
                FROM usuarios 
                WHERE usuario = :usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':usuario' => $usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($contrasena, $user['contrasena'])) {
            return $user;
        } else {
            return false;
        }
    }

    //*************************************************** */
    //Funcion listar todos los usuarios
    //*************************************************** */
    public function listarTodos(){
        $sql = "SELECT * 
                FROM usuarios";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //*************************************************** */
    //Funcion consultar usuario por ID
    //*************************************************** */
    public function consultarPorID($id){
        $sql = "SELECT * 
                FROM usuarios 
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //*************************************************** */
    //Funcion actualizar usuario
    //*************************************************** */
    public function actualizar($array){
        $sql = "UPDATE usuarios 
                SET usuario = :usuario,
                    contrasena = :contrasena
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':usuario' => $array['usuario'],
            ':contrasena' => password_hash($array['contrasena'], PASSWORD_BCRYPT),
            ':id' => $array['id']
        ]);
    }

    //*************************************************** */
    //Funcion eliminar usuario
    //*************************************************** */
    public function eliminar($id){
        $sql = "DELETE FROM usuarios 
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
    
}
?>