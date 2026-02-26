<?php
namespace App\config;

use PDO;
use PDOException;

class Database
{
    private $host;
    private $db_name;
    private $username;
    private $password;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->db_name = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASS'];
    }

    private $conn = null;

    public function connect()
    {
        if ($this->conn === null) {
            try {
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                error_log("Connection error: " . $e->getMessage());
                die("Database connection failed. Please try again later.");
            }
        }

        return $this->conn;
    }

    // Insert function 
    public function insert($table, $data){
        try{
            $columns = implode(',', array_keys($data));
            $placeholders = implode(',', array_fill(0, count($data), '?'));
            $stmt = $this->connect()->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");
            return $stmt->execute(array_values($data));
        }catch (PDOException $e) {
            error_log("Database insert error: " . $e->getMessage());
            return false;
        }
    }

    // SelectOne function
    public function selectOne($table, $data){
        try{
            $columns = implode(' = ? OR ', array_keys($data)) . ' = ?';
            $stmt = $this->connect()->prepare("SELECT * FROM $table WHERE $columns LIMIT 1");
            $stmt->execute(array_values($data));
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $e) {
            error_log("Database select error: " . $e->getMessage());
            return false;
        }
    }

    // Update function
    public function update($table, $data, $where){
        try{
            $set = implode(' = ? , ', array_keys($data)). ' = ?';
            $whereClause = implode(' = ? ', array_keys($where)). ' = ?';
            $stmt = $this->connect()->prepare("UPDATE $table SET $set WHERE $whereClause");
            return $stmt->execute(array_merge(array_values($data), array_values($where)));
        }catch (PDOException $e) {
            error_log("Database update error: " . $e->getMessage());
            return false;
        }
    }

    
}