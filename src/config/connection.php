<?php
$host = 'db';
$user = 'user';
$password = 'user_password';
$database = 'medconsultas';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}