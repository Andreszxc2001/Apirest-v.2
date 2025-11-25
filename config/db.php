<?php
//conexion a base de datos mediante la clase Database
class Database {
    private $host = "localhost";
    private $db_name = "db_test";
    private $username = "root";
    private $password = "";
    private $conn;


    //funcion para interactuar con la conexiona base de datos
    public function conectar() {
        
        //empleamos try catch para manejar errores de conexion
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
            return $this->conn;


        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => "Error en la conexión: " . $e->getMessage()]);
            exit;
        }

    }
}
?>
