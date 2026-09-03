<?php

error_reporting(E_ALL);

ini_set('display_errors', '1');

header('Content-Type: application/json');

require_once __DIR__ . '/../../config/connection.php';


/*
|--------------------------------------------------------------------------
| Validate HTTP method
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {

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

    $data = json_decode(file_get_contents('php://input'), true);


    /*
    |--------------------------------------------------------------------------
    | Validate JSON
    |--------------------------------------------------------------------------
    */

    if ($data === null) {

        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'Invalid JSON data.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Get and clean data
    |--------------------------------------------------------------------------
    */

    $userId = trim($data['user_id'] ?? '');
    $name = trim($data['name'] ?? '');
    $email = trim($data['email'] ?? '');


    /*
    |--------------------------------------------------------------------------
    | Validate required fields
    |--------------------------------------------------------------------------
    */

    if (!$userId || !$name || !$email) {

        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'user_id, name and email are required.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Validate name length
    |--------------------------------------------------------------------------
    */

    if (strlen($name) > 80) {

        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'Name cannot exceed 80 characters.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Validate email format
    |--------------------------------------------------------------------------
    */

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'Invalid email format.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Check if user exists
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare(
        'SELECT user_id
         FROM `user`
         WHERE user_id = :user_id'
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


    /*
    |--------------------------------------------------------------------------
    | Check if email belongs to another user
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare(
        'SELECT user_id
         FROM `user`
         WHERE email = :email
         AND user_id != :user_id'
    );

    $stmt->execute([
        'email' => $email,
        'user_id' => $userId
    ]);


    if ($stmt->fetch(PDO::FETCH_ASSOC)) {

        http_response_code(409);

        echo json_encode([
            'success' => false,
            'message' => 'Email already exists.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Update user
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare(
        'UPDATE `user`
         SET name = :name,
             email = :email
         WHERE user_id = :user_id'
    );

    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'user_id' => $userId
    ]);


    /*
    |--------------------------------------------------------------------------
    | Get updated user
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare(
        'SELECT user_id, name, email, created_at
         FROM `user`
         WHERE user_id = :user_id'
    );

    $stmt->execute([
        'user_id' => $userId
    ]);

    $updatedUser = $stmt->fetch(PDO::FETCH_ASSOC);


    /*
    |--------------------------------------------------------------------------
    | Success response
    |--------------------------------------------------------------------------
    */

    http_response_code(200);

    echo json_encode([
        'success' => true,
        'message' => 'User updated successfully!',
        'data' => $updatedUser
    ]);

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Failed to update user.'
    ]);
}