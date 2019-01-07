<?php
return [
    'createBrand' => [
        'type' => 2,
        'description' => 'Create a brand',
    ],
    'updateBrand' => [
        'type' => 2,
        'description' => 'Update brand',
    ],
    'author' => [
        'type' => 1,
        'children' => [
            'createBrand',
        ],
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'updateBrand',
            'author',
        ],
    ],
];
