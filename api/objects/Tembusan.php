<?php
class Tembusan
{
    private $conn;
    private $table_name="tembusan";
    public $idtembusan;
    public $idarsip_surat;
    public $idpejabat;

    public function __construct($db) 
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = "SELECT * FROM ".$this->table_name." WHERE idarsip_surat=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idarsip_surat);
        $stmt->execute();
        return $stmt;
    }

    public function create()
    {
        $query = "INSERT INTO ".$this->table_name." SET idarsip_surat=?, idpejabat=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idarsip_surat);
        $stmt->bindParam(2, $this->idpejabat);

        if($stmt->execute()){
            $this->idtembusan= $this->conn->lastInsertId();
            return true;
        }else
        {
            return false;
        }
    }

    public function update()
    {
        $query = "UPDATE ".$this->table_name." SET idarsip_surat=?, idpejabat=? WHERE idtembusan=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idarsip_surat);
        $stmt->bindParam(2, $this->idpejabat);
        $stmt->bindParam(3, $this->idtembusan);

        if($stmt->execute()){
            return true;
        }else
        {
            return false;
        }
    }

    public function delete()
    {
        $query = "DELETE FROM ".$this->table_name." WHERE idtembusan=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idtembusan);

        if($stmt->execute()){
            return true;
        }else
        {
            return false;
        }
    }
}

?>