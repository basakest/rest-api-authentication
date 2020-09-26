<?php

class Database
{
    private $host = '127.0.0.1';
    private $db_name = 'api_db2';
    private $username = 'root';
    private $password = '201916ab';
    public $conn;

    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
        return $this->conn;
    }
}