<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

header('Content-Type: application/json');

require_once __DIR__ . '/../../config/connection.php';

try {

    $data = json_decode(file_get_contents('php://input'), true);

    $contactId = $data['contact_id'] ?? null;
    $name = $data['name'] ?? null;
    $phone = $data['phone'] ?? null;

    if (!$contactId || !$name || !$phone) {

        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'contact_id, name and phone are required.'
        ]);

        exit;
    }

    $stmt = $pdo->prepare(
        "UPDATE contact
         SET name = :name,
             phone = :phone,
             updated_at = CURRENT_TIMESTAMP
         WHERE contact_id = :contact_id"
    );

    $stmt->execute([
        'contact_id' => $contactId,
        'name' => $name,
        'phone' => $phone
    ]);

    if ($stmt->rowCount() === 0) {

        http_response_code(404);

        echo json_encode([
            'success' => false,
            'message' => 'Contact not found.'
        ]);

        exit;
    }

    $stmt = $pdo->prepare(
        "SELECT contact_id, user_id, name, phone, created_at, updated_at
         FROM contact
         WHERE contact_id = :contact_id"
    );

    $stmt->execute([
        'contact_id' => $contactId
    ]);

    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

    http_response_code(200);

    echo json_encode([
        'success' => true,
        'message' => 'Contact updated successfully!',
        'data' => $contact
    ]);

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Failed to update contact.'
    ]);
}