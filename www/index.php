<?php

try {
    echo 'Current PHP version: ' . phpversion();
    echo '<br />';
    $host = 'mysql';
    $user = 'root';
    $pass = 'root';
    $name = 'database';
    $dsn = "mysql:host=$host;dbname=$name;charset=utf8";
    $conn = new PDO($dsn, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($conn->connect_error) {
        echo 'Database connection failed: ' . $conn->connect_error;
        echo '<br />';
    } else {
        echo 'Database connected successfully';
        echo '<br />';
    }
} catch (\Throwable $t) {
    echo 'Error: ' . $t->getMessage();
    echo '<br />';
}

