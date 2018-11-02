<?php
class KategoriSurat
{
    private $conn;
    private $table_name="kategori_surat";
    public $idkategori_surat;
    public $nama_kategori;
    public $keterangan;

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
        $query = "SELECT * FROM ".$this->table_name." WHERE idkategori_surat=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idkategori_surat);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->nama_kategori = $row['nama_kategori'];
    }

    public function create()
    {
        $query = "INSERT INTO ".$this->table_name." SET nama_kategori=?, keterangan=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->nama_kategori);
        $stmt->bindParam(2, $this->keterangan);

        if($stmt->execute()){
            $this->idkategori_surat= $this->conn->lastInsertId();
            return true;
        }else
        {
            return false;
        }
    }

    public function update()
    {
        $query = "UPDATE ".$this->table_name." SET nama_kategori=?, keterangan=? WHERE idkategori_surat=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->nama_kategori);
        $stmt->bindParam(2, $this->keterangan);
        $stmt->bindParam(3, $this->idkategori_surat);

        if($stmt->execute()){
            return true;
        }else
        {
            return false;
        }
    }

    public function delete()
    {
        $query = "DELETE FROM ".$this->table_name." WHERE idkategori_surat=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idkategori_surat);

        if($stmt->execute()){
            return true;
        }else
        {
            return false;
        }
    }
}

?>