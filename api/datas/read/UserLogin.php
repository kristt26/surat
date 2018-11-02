<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../../config/database.php';
include_once '../../objects/Pengguna.php';
include_once '../../objects/Struktural.php';
include_once '../../objects/Pejabat.php';
$database = new Database();
$db = $database->getConnection();
$pengguna = new Pengguna($db);
$struktural = new Struktural($db);
$pejabat = new Pejabat($db);
$data=json_decode(file_get_contents("php://input"));

$pengguna->username = $data->username;
$pengguna->password = md5($data->password);
$stmt = $pengguna->login();
$row = $stmt->rowCount();

if($row>0)
{
    $pejabat->idpengguna = $pengguna->idpengguna;
    $pejabat->status = "true";
    $pejabat->readByPengguna();
    $struktural->idstruktural = $pejabat->idstruktural;
    $struktural->readOne();
    session_start();
    $_SESSION["nama_pengguna"] = $pengguna->nama_pengguna;
    $_SESSION["email"] = $pengguna->email;
    $_SESSION["nm_struktural"] = $struktural->nm_struktural;
    $_SESSION["idpengguna"] = $pengguna->idpengguna;
    $_SESSION["idpejabat"]=$pejabat->idpejabat;
    $_SESSION["idstruktural"]=$struktural->idstruktural;
    $_SESSION["akses"]=$pengguna->akses;
    echo json_encode(array("Session" => $_SESSION));
}else {
    echo json_encode(array("message" => "Username dan Password Salah!"));
}

?>