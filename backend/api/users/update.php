<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

header("Content-Type: application/json");

require_once __DIR__ . '/../../config/connection.php';

if ($_SERVER["REQUEST_METHOD"] !== "PUT") {
    http_response_code(405);

    echo json_encode([
        "success" => false,
        "message" => "Method not allowed."
    ]);

    exit;
}

$input = json_decode(file_get_contents("php://input"), true);

$userId = $input["user_id"] ?? null;
$name = $input["name"] ?? null;
$email = $input["email"] ?? null;

if (!$userId || !$name || !$email) {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" => "user_id, name and email are required."
    ]);

    exit;
}

try {

    $stmt = $pdo->prepare(
        "UPDATE user
         SET name = :name,
             email = :email
         WHERE user_id = :user_id"
    );

    $stmt->execute([
        "user_id" => $userId,
        "name" => $name,
        "email" => $email
    ]);

    if ($stmt->rowCount() === 0) {
        http_response_code(404);

        echo json_encode([
            "success" => false,
            "message" => "User not found."
        ]);

        exit;
    }

    $stmt = $pdo->prepare(
        "SELECT user_id, name, email, created_at
        FROM user
        WHERE user_id = :user_id"
    );

    $stmt->execute([
        "user_id" => $userId
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC); 

    http_response_code(200);

    echo json_encode([
        "success" => true,
        "message" => "User updated successfully!",
        "data" => $user
    ]);

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Failed to update user."
    ]);

    exit;
}