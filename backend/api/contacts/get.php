<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/../../config/connection.php';

header('Content-Type: application/json');

try {

    $userId = $_GET['user_id'] ?? null;

    if ($userId) {

        $stmt = $pdo->prepare(
            "SELECT contact_id, user_id, name, phone, created_at, updated_at
             FROM contact
             WHERE user_id = :user_id
             ORDER BY created_at DESC"
        );

        $stmt->execute([
            'user_id' => $userId
        ]);

    } else {

        $stmt = $pdo->query(
            "SELECT contact_id, user_id, name, phone, created_at, updated_at
             FROM contact
             ORDER BY created_at DESC"
        );
    }

    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    http_response_code(200);

    echo json_encode([
        'success' => true,
        'data' => $contacts
    ]);

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Failed to retrieve contacts.'
    ]);
}