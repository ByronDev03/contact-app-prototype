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

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {

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
    | Get user ID
    |--------------------------------------------------------------------------
    */

    $userId = $data['user_id'] ?? null;

    /*
    |--------------------------------------------------------------------------
    | Validate user ID exists
    |--------------------------------------------------------------------------
    */
    if (!array_key_exists('user_id', $data)) {

        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'user_id is required.'
        ]);

        exit;
    }

    $userId = $data['user_id'];


    /*
    |--------------------------------------------------------------------------
    | Validate user ID type
    |--------------------------------------------------------------------------
    */
    if (!is_string($userId)) {

        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'user_id must be a string.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Validate user ID is not empty
    |--------------------------------------------------------------------------
    */
    if (trim($userId) === '') {

        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'user_id cannot be empty.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Clean user ID
    |--------------------------------------------------------------------------
    */
    $userId = trim($userId);

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
    | Delete user
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare(
        'DELETE FROM `user`
         WHERE user_id = :user_id'
    );

    $stmt->execute([
        'user_id' => $userId
    ]);


    /*
    |--------------------------------------------------------------------------
    | Check if user was deleted
    |--------------------------------------------------------------------------
    */

    if ($stmt->rowCount() === 0) {

        http_response_code(404);

        echo json_encode([
            'success' => false,
            'message' => 'User not found.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Success response
    |--------------------------------------------------------------------------
    */

    http_response_code(200);

    echo json_encode([
        'success' => true,
        'message' => 'User deleted successfully.',
        'data' => [
            'user_id' => $userId
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
        'message' => 'Failed to delete user.'
    ]);

} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'An unexpected error occurred.'
    ]);
}