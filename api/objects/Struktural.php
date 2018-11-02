<?php
class Struktural
{
    private $conn;
    private $table_name="struktural";
    public $idstruktural;
    public $nm_struktural;

    public function __construct($db) 
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = "SELECT * FROM ".$this->table_name."";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne()
    {
        $query = "SELECT * FROM ".$this->table_name." WHERE idstruktural=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idstruktural);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->nm_struktural = $row['nm_struktural'];
    }

    public function create()
    {
        $query = "INSERT INTO ".$this->table_name." SET nm_struktural=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->nm_struktural);

        if($stmt->execute()){
            $this->idstruktural= $this->conn->lastInsertId();
            return true;
        }else
        {
            return false;
        }
    }

    public function update()
    {
        $query = "UPDATE ".$this->table_name." SET nm_struktural=? WHERE idstruktural=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->nm_struktural);
        $stmt->bindParam(2, $this->idstruktural);

        if($stmt->execute()){
            return true;
        }else
        {
            return false;
        }
    }

    public function delete()
    {
        $query = "DELETE FROM ".$this->table_name." WHERE idstruktural=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idstruktural);

        if($stmt->execute()){
            return true;
        }else
        {
            return false;
        }
    }
}

?>