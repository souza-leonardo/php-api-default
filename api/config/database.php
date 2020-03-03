<?php

class Database
{
    private $host = '';
    private $dbName = '';
    private $username = '';
    private $password = '';

    public $conn;

    /**
     *  retorna uma conexão com o servidor
     */
    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->dbName,
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}