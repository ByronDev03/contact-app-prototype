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

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
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
    | Get user ID
    |--------------------------------------------------------------------------
    */

    $userId = $_GET['user_id'] ?? null;

    /*
    |--------------------------------------------------------------------------
    | Validate user ID type
    |--------------------------------------------------------------------------
    */

    if ($userId !== null && !is_string($userId)) {
        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => 'user_id must be a string.'
        ]);

        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Get all contacts
    |--------------------------------------------------------------------------
    */

    if ($userId === null) {

        $stmt = $pdo->query(
            'SELECT
                contact_id,
                user_id,
                name,
                phone,
                created_at,
                updated_at
             FROM contact
             ORDER BY created_at DESC'
        );

    } else {

        /*
        |--------------------------------------------------------------------------
        | Clean user ID
        |--------------------------------------------------------------------------
        */

        $userId = trim($userId);

        /*
        |--------------------------------------------------------------------------
        | Validate required value
        |--------------------------------------------------------------------------
        */

        if ($userId === '') {
            http_response_code(400);

            echo json_encode([
                'success' => false,
                'message' => 'user_id cannot be empty.'
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
        | Get contacts by user ID
        |--------------------------------------------------------------------------
        */

        $stmt = $pdo->prepare(
            'SELECT
                contact_id,
                user_id,
                name,
                phone,
                created_at,
                updated_at
             FROM contact
             WHERE user_id = :user_id
             ORDER BY created_at DESC'
        );

        $stmt->execute([
            'user_id' => $userId
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Get contacts
    |--------------------------------------------------------------------------
    */

    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /*
    |--------------------------------------------------------------------------
    | Success response
    |--------------------------------------------------------------------------
    */

    http_response_code(200);

    echo json_encode([
        'success' => true,
        'data' => $contacts
    ]);

} catch (PDOException $e) {

    /*
    |--------------------------------------------------------------------------
    | Database error
    |--------------------------------------------------------------------------
    */

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Failed to retrieve contacts.'
    ]);

} catch (Throwable $e) {

    /*
    |--------------------------------------------------------------------------
    | Unexpected error
    |--------------------------------------------------------------------------
    */

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'An unexpected error occurred.'
    ]);
}