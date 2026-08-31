<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

header('Content-Type: application/json');

require_once __DIR__ . '/../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    http_response_code(405);

    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed.'
    ]);

    exit;
}

try {

    // Obtener los datos enviados en formato JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Validar que el JSON sea válido
    if ($data === null) {

        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'Invalid JSON data.'
        ]);

        exit;
    }

    // Obtener y limpiar los datos
    $name = trim($data['name'] ?? '');
    $email = trim($data['email'] ?? '');
    $password = $data['password'] ?? '';

    // Validar campos obligatorios
    if (!$name || !$email || !$password) {

        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'Name, email and password are required.'
        ]);

        exit;
    }

    // Validar longitud del nombre
    if (strlen($name) > 80) {

        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'Name cannot exceed 80 characters.'
        ]);

        exit;
    }

    // Validar formato del email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'Invalid email format.'
        ]);

        exit;
    }

    // Validar longitud de la contraseña
    if (strlen($password) < 6) {

        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'Password must be at least 6 characters long.'
        ]);

        exit;
    }

    // Verificar si el email ya existe
    $stmt = $pdo->prepare(
        'SELECT user_id
         FROM `user`
         WHERE email = :email'
    );

    $stmt->execute([
        ':email' => $email
    ]);

    if ($stmt->fetch(PDO::FETCH_ASSOC)) {

        http_response_code(409);

        echo json_encode([
            'success' => false,
            'message' => 'Email already exists.'
        ]);

        exit;
    }

    // Generar UUID para el usuario
    $userId = sprintf(
        '%s-%s-%s-%s-%s',
        bin2hex(random_bytes(4)),
        bin2hex(random_bytes(2)),
        bin2hex(random_bytes(2)),
        bin2hex(random_bytes(2)),
        bin2hex(random_bytes(6))
    );

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