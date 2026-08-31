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

$contactId = $data['contact_id'] ?? null;

if (!$contactId) {
    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'contact_id is required.'
    ]);

    exit;
}

try {
    $stmt = $pdo->prepare(
        'DELETE FROM contact WHERE contact_id = :contact_id'
    );

    $stmt->execute([
        'contact_id' => $contactId
    ]);

    if ($stmt->rowCount() === 0) {
        http_response_code(404);

        echo json_encode([
            'success' => false,
            'message' => 'Contact not found.'
        ]);

        exit;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Contact deleted successfully.',
        'data' => [
            'contact_id' => $contactId
        ]
    ]);

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Failed to delete contact.'
    ]);
}