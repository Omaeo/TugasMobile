<?php
$conn = new mysqli("localhost", "root", "", "mobileapp");
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "DB Connection failed"]));
}
?>
