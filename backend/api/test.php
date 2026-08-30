<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/../config/connection.php';

try {

    // Generar UUID para el usuario
    $userId = bin2hex(random_bytes(16));
    $userId = substr(
        $userId,
        0, 8
    ) . '-' .
    substr($userId, 8, 4) . '-' .
    substr($userId, 12, 4) . '-' .
    substr($userId, 16, 4) . '-' .
    substr($userId, 20, 12);

    // Datos del usuario
    $name = 'Test User';
    $email = 'test@example.com';
    $password = password_hash('Test1234', PASSWORD_DEFAULT);

    // Insertar usuario
    $userSql = "
        INSERT INTO user (user_id, name, email, password)
        VALUES (:user_id, :name, :email, :password)
    ";

    $userStmt = $pdo->prepare($userSql);

    $userStmt->execute([
        ':user_id' => $userId,
        ':name' => $name,
        ':email' => $email,
        ':password' => $password
    ]);

    // Generar UUID para el contacto
    $contactId = bin2hex(random_bytes(16));
    $contactId = substr($contactId, 0, 8) . '-' .
                 substr($contactId, 8, 4) . '-' .
                 substr($contactId, 12, 4) . '-' .
                 substr($contactId, 16, 4) . '-' .
                 substr($contactId, 20, 12);

    // Datos del contacto
    $contactName = 'Byron';
    $phone = '7351234567';

    // Insertar contacto
    $contactSql = "
        INSERT INTO contact (contact_id, user_id, name, phone)
        VALUES (:contact_id, :user_id, :name, :phone)
    ";

    $contactStmt = $pdo->prepare($contactSql);

    $contactStmt->execute([
        ':contact_id' => $contactId,
        ':user_id' => $userId,
        ':name' => $contactName,
        ':phone' => $phone
    ]);

    echo "User and contact created successfully!";

} catch (PDOException $e) {

    die("Database error: " . $e->getMessage());
}