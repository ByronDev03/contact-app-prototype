<?php

header('Content-Type: application/json');

require_once __DIR__ . '/../../config/connection.php';

try {
    // Obtener los datos enviados en formato JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Validar campos requeridos
    if (
        empty($data['user_id']) ||
        empty($data['name']) ||
        empty($data['phone'])
    ) {
        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'User ID, name and phone are required.'
        ]);

        exit;
    }

    $userId = trim($data['user_id']);
    $name = trim($data['name']);
    $phone = trim($data['phone']);

    // Generar UUID para el contacto
    $contactId = sprintf(
        '%s-%s-%s-%s-%s',
        bin2hex(random_bytes(4)),
        bin2hex(random_bytes(2)),
        bin2hex(random_bytes(2)),
        bin2hex(random_bytes(2)),
        bin2hex(random_bytes(6))
    );

    // Insertar contacto
    $sql = "
        INSERT INTO contact (
            contact_id,
            user_id,
            name,
            phone
        )
        VALUES (
            :contact_id,
            :user_id,
            :name,
            :phone
        )
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':contact_id' => $contactId,
        ':user_id' => $userId,
        ':name' => $name,
        ':phone' => $phone
    ]);

    // Respuesta exitosa
    http_response_code(201);

    echo json_encode([
        'success' => true,
        'message' => 'Contact created successfully!',
        'data' => [
            'contact_id' => $contactId,
            'user_id' => $userId,
            'name' => $name,
            'phone' => $phone
        ]
    ]);

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Database error.'
    ]);
}