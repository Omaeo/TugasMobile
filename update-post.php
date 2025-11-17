<?php
include 'db.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

//  Handle preflight OPTIONS request for Axios
//if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
 //   http_response_code(200);
 //   exit();
//}

$data = json_decode(file_get_contents("php://input"), true);

$idpost = $data['idpost'] ?? '';
$judul = $data['judul'] ?? '';
$deskripsi = $data['deskripsi'] ?? '';

if ($idpost && $judul && $deskripsi) {
    $stmt = $conn->prepare("UPDATE tb_post SET judul=?, deskripsi=? WHERE idpost=?");
    $stmt->bind_param("ssi", $judul, $deskripsi, $idpost);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Post updated"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update post"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid data"]);
}

$conn->close();
?>
