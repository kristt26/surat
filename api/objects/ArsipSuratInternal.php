<?php
class ArsipSuratInternal
{
    private $conn;
    private $table_name="arsip_surat_internal";
    public $idarsip_surat;
    public $nomor_surat;
    public $lampiran;
    public $tujuan;
    public $pengirim;
    public $tg_surat;
    public $berkas;
    public $idkategori_surat;
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

    public function readByTujuan()
    {
        $query = "SELECT * FROM ".$this->table_name." WHERE tujuan=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->tujuan);
        $stmt->execute();
        return $stmt;
    }

    public function readByPengirim()
    {
        $query = "SELECT * FROM ".$this->table_name." WHERE pengirim=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->pengirim);
        $stmt->execute();
        return $stmt;
    }

    public function create()
    {
        $query = "INSERT INTO ".$this->table_name." SET nomor_surat=?, lampiran=?, tujuan=?, pengirim=?, tg_surat=?, berkas=?, idkategori_surat=?, status=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->nomor_surat);
        $stmt->bindParam(2, $this->lampiran);
        $stmt->bindParam(3, $this->tujuan);
        $stmt->bindParam(4, $this->pengirim);
        $stmt->bindParam(5, $this->tg_surat);
        $stmt->bindParam(6, $this->berkas);
        $stmt->bindParam(7, $this->idkategori_surat);
        $stmt->bindParam(8, $this->status);

        if($stmt->execute()){
            $this->idarsip_surat= $this->conn->lastInsertId();
            return true;
        }else
        {
            return false;
        }
    }

    public function update()
    {
        $query = "UPDATE ".$this->table_name." SET nomor_surat=?, lampiran=?, tujuan=?, pengirim=?, tg_surat=?, berkas=?, idkategori_surat=?, status=? where idarsip_surat=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->nomor_surat);
        $stmt->bindParam(2, $this->lampiran);
        $stmt->bindParam(3, $this->tujuan);
        $stmt->bindParam(4, $this->pengirim);
        $stmt->bindParam(5, $this->tg_surat);
        $stmt->bindParam(6, $this->berkas);
        $stmt->bindParam(7, $this->idkategori_surat);
        $stmt->bindParam(8, $this->status);
        $stmt->bindParam(9, $this->idarsip_surat);

        if($stmt->execute()){
            return true;
        }else
        {
            return false;
        }
    }

    public function delete()
    {
        $query = "DELETE FROM ".$this->table_name." WHERE idarsip_surat=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idarsip_surat);

        if($stmt->execute()){
            return true;
        }else
        {
            return false;
        }
    }
}

?>