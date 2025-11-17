<?php
include 'db.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");


$data = json_decode(file_get_contents("php://input"), true);

$idpost = $data['idpost'] ?? '';

if ($idpost) {
    $stmt = $conn->prepare("DELETE FROM tb_post WHERE idpost=?");
    $stmt->bind_param("i", $idpost);
    $stmt->execute();
    echo json_encode(["success" => true, "message" => "Post deleted"]);
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Missing ID"]);
}

$conn->close();
?>
