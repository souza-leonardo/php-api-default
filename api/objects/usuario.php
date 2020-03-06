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
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        $this->nome = $row['nome'];
        $this->cpf = $row['cpf'];
        $this->username = $row['username'];
        $this->created_at = $row['created_at'];
    }

    public function update()
    {
        $query = "UPDATE $this->tableName SET nome = :nome, cpf = :cpf, username = :username, password = :password WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->cpf = htmlspecialchars(strip_tags($this->cpf));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':cpf', $this->cpf);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM $this->tableName WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function search($keywords)
    {
        $query = "SELECT * FROM $this->tableName WHERE nome LIKE ? OR cpf LIKE ? OR username LIKE ? ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);

        //sanitize
        $keywords = htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);

        $stmt->execute();

        return $stmt;
    }

    public function readPaging($fromRecordNum, $recordsPerPage)
    {
        $query = "SELECT * FROM $this->tableName ORDER BY created_at DESC LIMIT ?, ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $fromRecordNum, PDO::PARAM_INT);
        $stmt->bindParam(2, $recordsPerPage, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
    }

    public function count()
    {
        $query = "SELECT COUNT(*) AS total_rows FROM $this->tableName";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }

    public function cpfExists()
    {
        $query = "SELECT * FROM $this->tableName WHERE cpf = ? LIMIT 0, 1";

        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->cpf = htmlspecialchars(strip_tags($this->cpf));

        $stmt->bindParam(1, $this->cpf);
        $stmt->execute();

        $num = $stmt->rowCount();
        if ($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->nome = $row['nome'];
            $this->cpf = $row['cpf'];
            $this->username = $row['username'];
            $this->password = $row['password'];

            return true;
        }

        return false;
    }
}