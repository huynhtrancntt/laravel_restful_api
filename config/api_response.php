<?php

return [
    'success_response' => [
        'success' => true,
        'message' => 'Operation successful.',
        'data' => [],
    ],

    'error_response' => [
        'success' => false,
        'message' => 'Operation failed.',
        'data' => [],
    ],

    'pagination_response' => [
        'success' => true,
        'message' => 'Data retrieved successfully.',
        'data' => [],
        'pagination' => [
            'total' => 0,
            'per_page' => 0,
            'current_page' => 0,
            'last_page' => 0,
        ],
    ],
];
