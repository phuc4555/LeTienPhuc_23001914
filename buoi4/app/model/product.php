<?php

require_once __DIR__ . '\..\common\dbConnect.php';

function getAllProducts(){
    global $pdo;
    try{
        $sql = "SELECT * FROM  products ORDER BY  id DESC";
        $stmt = $pdo -> query($sql);
        return $stmt -> fetchAll();
    }catch(PDOException $e) {
        die("Lỗi lấy danh sách sản phẩm:" . $e->getMessage());
    }
}

function getProductById($id){
    global $pdo;
    try{
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute(['id' => $id]);
        return $stmt -> fetch();
    } catch(PDOException $e) {
        die("Lỗi lấy thông tin sản phẩm: ". $e -> getMessage());
    } 
}
function addProduct($name,$price,$quantity){
    global $pdo;
    try {
        $sql = "INSERT INTO products (name,price,quantity)
        VALUES (:name,:price,:quantity)";
        $stmt = $pdo -> prepare($sql);
        return $stmt -> execute([
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
        ]);
    } catch (PDOException $e) {
        die ("Lỗi thêm sản phẩm: " . $e-> getMessage());
    }
}
function updateProduct($id,$name,$price,$quantity) {
    global $pdo;
    try {
        $sql = "UPDATE products
        SET name = :name,price = :price,quantity = :quantity WHERE id =:id";
        $stmt = $pdo ->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity
        ]);
    }catch(PDOException $e) {
        die("Lỗi cập nhật sản phẩm: " . $e -> getMessage());
    }
}
function deleteProduct($id) {
    global $pdo;
    try {
        $sql = "DELETE FROM products WHERE id =: id";
        $stmt = $pdo-> prepare($sql);
        return $stmt -> execute(['id' => $id]);
    } catch(PDOException $e) {
        die ("Lỗi xóa sản phẩm: " .$e ->getMessage());
    }
}

?>