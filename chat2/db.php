<?php
session_start();

try {
    $db = new PDO(
        "mysql:host=localhost;port=3308;dbname=chat2;charset=utf8mb4",
        "root",
        ""
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
