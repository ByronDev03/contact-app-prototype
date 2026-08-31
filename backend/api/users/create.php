<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

header('Content-Type: application/json');

require_once __DIR__ . '/../../config/connection.php';

try {
    // Obtener los datos enviados en formato JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Validar que existan los campos necesarios
    if (
        empty($data['name']) ||
        empty($data['email']) ||
        empty($data['password'])
    ) {
        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'Name, email and password are required.'
        ]);

        exit;
    }

    $name = trim($data['name']);
    $email = trim($data['email']);
    $password = $data['password'];

    // Generar UUID para el usuario
    $userId = sprintf('%s-%s-%s-%s-%s', bin2hex(random_bytes(4)), bin2hex(random_bytes(2)), bin2hex(random_bytes(2)), bin2hex(random_bytes(2)), bin2hex(random_bytes(6)));

    // Hashear la contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar usuario
    $sql = "
        INSERT INTO `user` (
            user_id,
            name,
            email,
            password
        )
        VALUES (
            :user_id,
            :name,
            :email,
            :password
        )
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':user_id' => $userId,
        ':name' => $name,
        ':email' => $email,
        ':password' => $passwordHash
    ]);

    // Respuesta exitosa
    http_response_code(201);

    echo json_encode([
        'success' => true,
        'message' => 'User created successfully!',
        'data' => [
            'user_id' => $userId,
            'name' => $name,
            'email' => $email
        ]
    ]);

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Database error.'
    ]);
}