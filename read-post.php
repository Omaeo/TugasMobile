<?php
include 'db.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");


if (isset($_GET['idpost'])) {
    //  Return single post
    $idpost = intval($_GET['idpost']);
    $stmt = $conn->prepare("SELECT * FROM tb_post WHERE idpost = ?");
    $stmt->bind_param("i", $idpost);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();

    if ($post) {
        http_response_code(200);
        echo json_encode($post);
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Post not found"]);
    }

    $stmt->close();
} else {
    //  Return all posts
    $query = "SELECT * FROM tb_post ORDER BY idpost DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($data);
    } else {
        http_response_code(404);
        echo json_encode([]);
    }

    $stmt->close();
}

$conn->close();
?>
