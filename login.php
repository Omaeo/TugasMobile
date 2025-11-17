<?php
require __DIR__ . '/vendor/autoload.php';
use Firebase\JWT\JWT;

include 'db.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

if (!$username || !$password) {
    echo json_encode(["success" => false, "message" => "Username and password required"]);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM tb_login WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if ($password === $user['password']) { 
        $payload = [
            "iss" => "http://localhost",
            "aud" => "http://localhost",
            "iat" => time(),
            "exp" => time() + 60, 
            "data" => [
                "username" => $user['username']
            ]
        ];

        $secret_key = "MY_SUPER_DUPER_UBER_SECRET_KEY"; //deffinetly not refferencing to Battle Cats and any other games correlated to PONOS Corporation, ahem.
        $jwt = JWT::encode($payload, $secret_key, 'HS256');

        echo json_encode(["success" => true, "token" => $jwt]);
    } else {
        echo json_encode(["success" => false, "message" => "Aww? Something's Wrong~ , Boohoo."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "You don't exist."]);
}
?>
