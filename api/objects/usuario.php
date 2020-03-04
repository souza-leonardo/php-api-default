<?php

class Usuario
{
    private $conn;
    private $tableName = 'usuarios';

    public $id;
    public $nome;
    public $username;
    public $password;
    public $cpf;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = "SELECT * FROM usuarios ORDER BY nome";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function create()
    {
        $query = "INSERT INTO $this->tableName SET nome=:nome, cpf=:cpf, username=:username, password=:password, created_at=:created_at";

        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->cpf = htmlspecialchars(strip_tags($this->cpf));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->created_at = htmlspecialchars(strip_tags($this->created_at));

        //bind values
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":cpf", $this->cpf);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":created_at", $this->created_at);

        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    public function readOne()
    {
        $query = "SELECT * FROM $this->tableName WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
    }
}