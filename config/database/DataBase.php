<?php
class DataBase
{
    private $host = 'LAPTOP-0GVT7Q7J';
    private $port = '1433';
    private $user = 'LAPTOP-0GVT7Q7J\56956';
    private $password = '';
    private $db = 'test';
    private $conn;

    public function conectar()
    {
        try {
            //dblib:charset=UTF-8;host=$this->host;dbname=$this->db","sa", "Espex.2018
            $this->conn = new pdo(
                                "dblib:charset=UTF-8;
                                host=$this->host;
                                port=$this->port;
                                dbname=$this->db;
                                charset:utf8",
                                "$this->user",
                                "$this->password",
                                array(
                                    PDO::ATTR_ERRMODE,
                                    PDO::ERRMODE_EXCEPTION
                                )
                                );
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
        return $this->conn;
    }

    public function desconectar()
    {
        return $this->conn = null;
    }
}