<?php
    define('APP_DOMAIN','localhost');
    define('APP_BASE_URL','http://localhost/');
    define('APP_BASE_PATH','C:/Users/dgonzalez/Desktop/NIA-Framework/');
    define('APP_SESSION_NAME','ControlHorari_SESSID');
    define('APP_SESSION_TIME',7200);

    // Database configuration
    define('DB_DSN','mysql:host=localhost;port=5306;dbname=controlhorari;charset=utf8');
    define('DB_USER','root');
    define('DB_PASS','');
    define('DB_DATASET_TYPE',DB_DATASET_HARDCODED);

    // SMTP server configuration
    $smtpConfig = [
        'host' => 'smtp.example.com',
        'port' => 587,
        'security' => 'tls',
        'username' => 'noreply@example.com',
        'password' => '',
        'from' => 'noreply@example.com',
        'fromName' => 'My App'
    ];

    // Application environment (development, staging, production, etc.)
    $appEnv = 'development';
