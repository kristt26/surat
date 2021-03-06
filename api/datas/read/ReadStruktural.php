<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../objects/Struktural.php';

$database = new Database();
$db = $database->getConnection();

$struktural = new Struktural($db);

$stmt = $struktural->read();
$num = $stmt->rowCount();

if($num>0)
{
    $Datas= array("records"=>array());
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);
        $item=array(
            "idstruktural" => $idstruktural,
            "nm_struktural" => $nm_struktural
        );
 
        array_push($Datas["records"], $item);
    }
    http_response_code(200);
    echo json_encode($Datas);
}else
{
    http_response_code(404);
    echo json_encode(
        array("message" => "No Struktural found")
    );
}
?>