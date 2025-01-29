<?php
// database.php

// Database connection settings
$host = 'localhost';
$db_name = 'egs';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch users
function fetchUsers($conn)
{
    $stmt = $conn->query("SELECT user_id, full_name, email, created_at FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch products
function fetchProducts($conn)
{
    $stmt = $conn->query("SELECT item_id, item_name, price, stock FROM items");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch appointments
function fetchAppointments($conn)
{
    $stmt = $conn->query("SELECT appointment_id, user_id, name, email, phone, preferred_date, preferred_time, service, status, created_at, updated_at FROM appointments");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch messages
function fetchMessages($conn)
{
    $stmt = $conn->query("SELECT name, email, contact, message, date FROM messages");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
