<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

header('Content-Type: application/json');

require_once __DIR__ . '/../../config/connection.php';


try {

    $userId = $_GET['user_id'] ?? null;

    if ($userId) {

        $stmt = $pdo->prepare(
            "SELECT user_id, name, email, created_at
             FROM user
             WHERE user_id = :user_id"
        );

        $stmt->execute([
            'user_id' => $userId
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {

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
            'data' => $user
        ]);

    } else {

        $stmt = $pdo->query(
            "SELECT user_id, name, email, created_at
             FROM user
             ORDER BY created_at DESC"
        );

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        http_response_code(200);

        echo json_encode([
            'success' => true,
            'data' => $users
        ]);
    }

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Failed to retrieve users.'
    ]);
}