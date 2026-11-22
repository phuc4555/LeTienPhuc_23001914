<?php 
$host='localhost';
$dbname='w5';
$username='root';
$password='';
$charset='utf8';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$option = [
    PDO:: ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO:: ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO:: ATTR_EMULATE_PREPARES => false,
];

try{
    $pdo = new PDO($dsn,$username,$password,$option);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['success'=> false,'message'=> 'Lỗi kết nối CSDL: '. $e-> getMessage()]);
    exit;
}





?>