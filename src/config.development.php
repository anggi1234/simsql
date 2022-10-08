<?php

/**
 * PHPMaker 2021 configuration file (Development)
 */

return [
    "Databases" => [
        "DB" => ["id" => "DB", "type" => "MSSQL", "qs" => "[", "qe" => "]", "host" => "localhost", "port" => null, "user" => "sa", "password" => "Sapito123", "dbname" => "SIMRS"],
        "RSUD_BESEMAH_VCLAIM_V111" => ["id" => "SIMRS", "type" => "MSSQL", "qs" => "[", "qe" => "]", "host" => "localhost", "port" => "50201", "user" => "sa", "password" => "Sapito123", "dbname" => "SIMRS"]
    ],
    "SMTP" => [
        "PHPMAILER_MAILER" => "smtp", // PHPMailer mailer
        "SERVER" => "localhost", // SMTP server
        "SERVER_PORT" => 25, // SMTP server port
        "SECURE_OPTION" => "",
        "SERVER_USERNAME" => "", // SMTP server user name
        "SERVER_PASSWORD" => "", // SMTP server password
    ],
    "JWT" => [
        "SECRET_KEY" => "yncGmULx8PzPpWzT", // API Secret Key
        "ALGORITHM" => "HS512", // API Algorithm
        "AUTH_HEADER" => "X-Authorization", // API Auth Header (Note: The "Authorization" header is removed by IIS, use "X-Authorization" instead.)
        "NOT_BEFORE_TIME" => 0, // API access time before login
        "EXPIRE_TIME" => 600 // API expire time
    ]
];
