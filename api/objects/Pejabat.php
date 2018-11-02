<?php
class Pejabat
{
    private $conn;
    private $table_name="pejabat";
    public $idpejabat;
    public $idpengguna;
    public $idstruktural;
    public $status;

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
        return $stmt;
    }

    public function readByPengguna()
    {
        $query = "SELECT * FROM ".$this->table_name." WHERE idpengguna=? and status=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idpengguna);
        $stmt->bindParam(2, $this->status);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->idpejabat = $row['idpejabat'];
        $this->idstruktural = $row['idstruktural'];
        return $stmt;
    }

    public function readById()
    {
        $query = "SELECT * FROM ".$this->table_name." WHERE idpejabat=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idpejabat);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->idpengguna = $row['idpengguna'];
        $this->idstruktural = $row['idstruktural'];
    }

    public function create()
    {
        $query = "INSERT INTO ".$this->table_name." SET idpengguna=?, idstruktural=?, status=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idpengguna);
        $stmt->bindParam(2, $this->idstruktural);
        $stmt->bindParam(3, $this->status);

        if($stmt->execute()){
            $this->idpejabat= $this->conn->lastInsertId();
            return true;
        }else
        {
            return false;
        }
    }

    public function update()
    {
        $query = "UPDATE ".$this->table_name." SET status=? WHERE idstruktural=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->status);
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
        $query = "DELETE FROM ".$this->table_name." WHERE idpejabat=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idpejabat);

        if($stmt->execute()){
            return true;
        }else
        {
            return false;
        }
    }
}

?>