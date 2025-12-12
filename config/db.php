<?php
//conexion a base de datos mediante la clase Database
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;
    private $conn;


    //funcion para interactuar con la conexiona base de datos
    public function conectar() {
        
        $this->host = $_ENV['DB_HOST'];
        $this->db_name = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->port = $_ENV['DB_PORT'];
        
        //empleamos try catch para manejar errores de conexion
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};port={$this->port};dbname={$this->db_name}",
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
