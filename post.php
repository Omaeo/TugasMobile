<?php
include 'db.php';
// 1. Atur Header (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// 2 gada apa apa bang, lanjut ke 3 aja

// 3. Terima Data JSON dari Frontend
$data = json_decode(file_get_contents("php://input"), true) ?? [];

$title = isset($data['judul']) ? trim($data['judul']) : null;
$content = isset($data['deskripsi']) ? trim($data['deskripsi']) : null;

// 4. Validasi Input
if ($title === '' || $content === '') {
    http_response_code(400);
    echo json_encode([
        "message" => "Field judul, dan deskripsi wajib diisi dengan benar.",
        "success" => false
    ]);
    exit(0);
}

$query = "INSERT INTO tb_post (judul, deskripsi) VALUES (?, ?)";
$stmt = $conn->prepare($query);  

// bind parameter: s (title), s (content)
$stmt->bind_param("ss", $title, $content);

if ($stmt->execute()) {
    http_response_code(201); 
    echo json_encode(array(
        "message" => "Artikel berhasil disimpan.",
        "success" => true,
        "insert_id" => $conn->insert_id 
    ));
} else {
    http_response_code(500); 
    echo json_encode(array(
        "message" => "Error. womp womp: " . $stmt->error,
        "success" => false
    ));
}

$stmt->close();
$conn->close();
?>