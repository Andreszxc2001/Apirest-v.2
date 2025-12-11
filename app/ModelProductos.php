<?php
//Inclucion de conexion a base de datos
include_once __DIR__ . "/../config/db.php";

class ModelProductos {

    //Constructor de la clase
    private $conn;
    
    public function __construct(){
        $database = new Database();
        $this->conn = $database->conectar();
    }


    //*************************************************** */
    //Funcion insertar producto
    //*************************************************** */
    public function insertar($array){

        $sql = "INSERT INTO productos(
                            nombre,
                            descripcion,
                            precio,
                            stock 
                        ) VALUES (
                            :nombre,
                            :descripcion,
                            :precio,
                            :stock
                            )";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':nombre' => $array['nombre'],
            ':descripcion' => $array['descripcion'],
            ':precio' => $array['precio'],
            ':stock' => $array['stock']
        ]);
    }

    //*************************************************** */
    //Funcion actualizar producto
    //*************************************************** */
    public function actualizar($array){

        $sql = "UPDATE productos SET 
                            nombre = :nombre,
                            descripcion = :descripcion,
                            precio = :precio,
                            stock = :stock
                        WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':nombre' => $array['nombre'],
            ':descripcion' => $array['descripcion'],
            ':precio' => $array['precio'],
            ':stock' => $array['stock'],
            ':id' => $array['id']
        ]);
    }

    //*************************************************** */
    //Funcion eliminar producto
    //*************************************************** */
    public function eliminar($id){

        $sql = "DELETE FROM productos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
    }


    //*************************************************** */
    //Funcion obtener todos los productos
    //*************************************************** */
    public function obtenerTodos(){
        $sql = "SELECT * 
                FROM productos";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //*************************************************** */
    //Funcion obtener producto por ID
    //*************************************************** */
    public function obtenerPorId($id){
        $sql = "SELECT * 
                FROM productos 
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}