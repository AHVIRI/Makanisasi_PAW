<?php

$storagePath = '/tmp/storage';

$directories = [
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/testing',
    $storagePath . '/framework/views',
    $storagePath . '/app/public',
    $storagePath . '/logs',
    $storagePath . '/bootstrap/cache',
];

foreach ($directories as $directory) {
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }
}

// Ensure VERCEL environment variable is set for bootstrap/app.php
$_ENV['VERCEL'] = 1;
$_SERVER['VERCEL'] = 1;

require __DIR__ . '/../public/index.php';
