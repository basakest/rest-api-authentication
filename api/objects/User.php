<?php

class User
{
    private $conn;
    private $table_name = 'users';

    public $firstname;
    public $lastname;
    public $email;
    public $password;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function create()
    {
        $query = "insert into {$this->table_name}(firstname, lastname, email, password)     values (:firstname, :lastname, :email, :password)";
        $stmt = $this->conn->prepare($query);
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $stmt->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $this->password, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function emailExists()
    {
        $query = "select * from {$this->table_name} where email = :email limit 1";
        $stmt = $this->conn->prepare($query);
        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num > 0) {
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $res['id'];
            $this->firstname = $res['firstname'];
            $this->lastname = $res['lastname'];
            $this->password = $res['password'];
            return true;
        } else {
            return false;
        }
    }
}