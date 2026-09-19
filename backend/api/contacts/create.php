<?php

error_reporting(E_ALL);
ini_set('display_errors', '0');

header('Content-Type: application/json');

require_once __DIR__ . '/../../config/connection.php';

/*
|--------------------------------------------------------------------------
| Validate HTTP method
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    http_response_code(405);

    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed.'
    ]);

    exit;
}

try {

    /*
    |--------------------------------------------------------------------------
    | Get JSON data
    |--------------------------------------------------------------------------
    */

    $json = file_get_contents('php://input');

    $data = json_decode(
        $json,
        true,
        512,
        JSON_THROW_ON_ERROR
    );

    /*
    |--------------------------------------------------------------------------
    | Get fields
    |--------------------------------------------------------------------------
    */

    $userId = $data['user_id'] ?? null;
    $name = $data['name'] ?? null;
    $phone = $data['phone'] ?? null;

    /*
    |--------------------------------------------------------------------------
    | Validate field types
    |--------------------------------------------------------------------------
    */

    if (
        !is_string($userId) ||
        !is_string($name) ||
        !is_string($phone)
    ) {

        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'user_id, name and phone must be strings.'
        ]);

        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Clean fields
    |--------------------------------------------------------------------------
    */

    $userId = trim($userId);
    $name = trim($name);
    $phone = trim($phone);

    /*
    |--------------------------------------------------------------------------
    | Validate required fields
    |--------------------------------------------------------------------------
    */

    if (
        $userId === '' ||
        $name === '' ||
        $phone === ''
    ) {

        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'user_id, name and phone are required.'
        ]);

        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Validate UUID format
    |--------------------------------------------------------------------------
    */

    $isValidUuid = preg_match(
        '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i',
        $userId
    );

    if (!$isValidUuid) {

        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'Invalid user_id format.'
        ]);

        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Validate name length
    |--------------------------------------------------------------------------
    */

    if (mb_strlen($name) > 80) {

        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'Name must not exceed 80 characters.'
        ]);

        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Validate phone length
    |--------------------------------------------------------------------------
    */

    if (mb_strlen($phone) > 20) {

        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'Phone must not exceed 20 characters.'
        ]);

        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Check if user exists
    |--------------------------------------------------------------------------
    */

    $userStmt = $pdo->prepare(
        'SELECT user_id
         FROM `user`
         WHERE user_id = :user_id'
    );

    $userStmt->execute([
        'user_id' => $userId
    ]);

    if (!$userStmt->fetch()) {

        http_response_code(404);

        echo json_encode([
            'success' => false,
            'message' => 'User not found.'
        ]);

        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Generate contact UUID
    |--------------------------------------------------------------------------
    */

    $contactId = sprintf(
        '%s-%s-%s-%s-%s',
        bin2hex(random_bytes(4)),
        bin2hex(random_bytes(2)),
        bin2hex(random_bytes(2)),
        bin2hex(random_bytes(2)),
        bin2hex(random_bytes(6))
    );

    /*
    |--------------------------------------------------------------------------
    | Insert contact
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare(
        'INSERT INTO `contact` (
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
        )'
    );

    $stmt->execute([
        'contact_id' => $contactId,
        'user_id' => $userId,
        'name' => $name,
        'phone' => $phone
    ]);

    /*
    |--------------------------------------------------------------------------
    | Success response
    |--------------------------------------------------------------------------
    */

    http_response_code(201);

    echo json_encode([
        'success' => true,
        'message' => 'Contact created successfully.',
        'data' => [
            'contact_id' => $contactId,
            'user_id' => $userId,
            'name' => $name,
            'phone' => $phone
        ]
    ]);

} catch (JsonException $e) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'Invalid JSON data.'
    ]);

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Database error.'
    ]);

} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'An unexpected error occurred.'
    ]);
}