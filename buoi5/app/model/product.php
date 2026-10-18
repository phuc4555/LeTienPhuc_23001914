<?php
require_once __DIR__ .'\..\common\dbConnect.php';
function getAllProducts() {
    global $pdo;
    try {
        $sql = "SELECT * FROM products ORDER BY id DESC";
        $stmt = $pdo -> query($sql);
        return $stmt -> fetchAll();
    } catch (PDOException $e) {
        die("Lỗi lấy danh sách sản phẩm:". $e -> getMessage() );
    }
}

function getProductById($id) {
    global $pdo;
    try {
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute(['id' => $id]);
        return $stmt -> fetch();
    } catch(PDOException $e) {
        die("Lỗi lấy thông tin sản phẩm: ".$e -> getMessage());
    }
}
function addProduct($name ,$price,$quantity) {
    global $pdo;
    try {
        $sql = "INSERT INTO products(name,price,quantity) VALUES (:name,:price,:quantity)";
        $stmt =$pdo -> prepare($sql);
        $stmt -> execute([
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
        ]);
        return true;

    }catch (PDOException $e) {
        die ("Lỗi thêm sản phẩm: " . $e -> getMessage());
    }
}
function updateProduct($id,$name,$price,$quantity) {
    global $pdo;
    try {
        $sql = "UPDATE products SET name = :name,price = :price,quantity =:quantity WHERE id =:id";
        $stmt = $pdo ->prepare($sql);
        return $stmt -> execute ([
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity
        ]);
    }catch(PDOException $e) {
        die("Lỗi cập nhật sản phẩm: " . $e -> getMessage());
    };
}
function deleteProductById($id) {
    global $pdo;
    try {
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $pdo -> prepare($sql);
        return $stmt -> execute(['id' => $id]);
    }catch (PDOException $e) {
        die("Lỗi xóa sản phẩm: " . $e -> getMessage());
    }
}
// Hàm kiểm tra username đã tồn tại chưa
function checkUsernameExists($username) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    return $stmt->fetch() ? true : false;
}

// Hàm đăng ký user mới
function registerUser($username, $password) {
    global $pdo;
    try {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        return $stmt->execute([
            ':username' => $username,
            ':password' => $hashed_password
        ]);
    } catch (PDOException $e) {
        return false;
    }
}

// Hàm lấy thông tin user bằng username để đăng nhập
function getUserByUsername($username) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


?>