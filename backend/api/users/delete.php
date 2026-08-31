<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

header('Content-Type: application/json');

require_once __DIR__ . '/../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {

    http_response_code(405);

    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed.'
    ]);

    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$userId = $data['user_id'] ?? null;

if (!$userId) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'user_id is required.'
    ]);

    exit;
}

try {

    $stmt = $pdo->prepare(
        'DELETE FROM user WHERE user_id = :user_id'
    );

    $stmt->execute([
        'user_id' => $userId
    ]);

    if ($stmt->rowCount() === 0) {

        http_response_code(404);

        echo json_encode([
            'success' => false,
            'message' => 'User not found.'
        ]);

        exit;
    }

    http_response_code(200);

    echo json_encode([
        'success' => true,
        'message' => 'User deleted successfully.',
        'data' => [
            'user_id' => $userId
        ]
    ]);

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Failed to delete user.'
    ]);

    exit;
}