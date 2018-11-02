<?php
class ArsipSuratMasuk
{
    private $conn;
    private $table_name="arsip_surat_masuk";
    public $idarsip_surat;
    public $nomor_surat;
    public $lampiran;
    public $tujuan;
    public $pengirim;
    public $tg_surat;
    public $berkas;
    public $idkategori_surat;
    public $idpejabat;
    public $status;

    public function __construct($db) 
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO ".$this->table_name." SET nomor_surat=?, lampiran=?, tujuan=?, pengirim=?, tg_surat=?, berkas=?, idkategori_surat=?, idpejabat=?, status=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->nomor_surat);
        $stmt->bindParam(2, $this->lampiran);
        $stmt->bindParam(3, $this->tujuan);
        $stmt->bindParam(4, $this->pengirim);
        $stmt->bindParam(5, $this->tg_surat);
        $stmt->bindParam(6, $this->berkas);
        $stmt->bindParam(7, $this->idkategori_surat);
        $stmt->bindParam(8, $this->idpejabat);
        $stmt->bindParam(9, $this->status);

        if($stmt->execute()){
            $this->idarsip_surat= $conn->lastInsertId();
            return true;
        }else
        {
            return false;
        }
    }

    public function update()
    {
        $query = "UPDATE ".$this->table_name." SET nomor_surat=?, lampiran=?, tujuan=?, pengirim=?, tg_surat=?, berkas=?, idkategori_surat=?, idpejabat=?, status=? where idarsip_surat=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->nomor_surat);
        $stmt->bindParam(2, $this->lampiran);
        $stmt->bindParam(3, $this->tujuan);
        $stmt->bindParam(4, $this->pengirim);
        $stmt->bindParam(5, $this->tg_surat);
        $stmt->bindParam(6, $this->berkas);
        $stmt->bindParam(7, $this->idkategori_surat);
        $stmt->bindParam(8, $this->status);
        $stmt->bindParam(9, $this->idpejabat);
        $stmt->bindParam(10, $this->idarsip_surat);

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