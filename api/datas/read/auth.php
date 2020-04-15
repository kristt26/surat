<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../../config/database.php';
include_once '../../objects/Pengguna.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
$pengguna = new Pengguna($db);

echo json_encode(array("Session" => $pengguna->CheckSession()));
?>