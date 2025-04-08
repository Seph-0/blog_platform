<?php
$server = 'localhost';
$database = 'blog_platform';
$username = 'root';
$password = '';

$db_conn = new mysqli($server, $username, $password, $database);

if ($db_conn->connect_error) {
    die("Connection failed: " . $db_conn->connect_error);
}
?>