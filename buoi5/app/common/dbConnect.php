<?php 
$host = "localhost";
$dbname = "shopping_cart";
$username = "root";
$password = "";
$charset = "utf8";

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$option = [
    PDO:: ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO:: ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO:: ATTR_EMULATE_PREPARES => false,
];

try{
    $pdo = new PDO($dsn,$username,$password,$option);
} catch (PDOException $e) {
    die("Lỗi kết nối Database: " . $e -> getMessage());
}
?>