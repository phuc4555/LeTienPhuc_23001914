<?php  
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');


    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        http_response_code(200);
        exit;
    }

    function sendResponse(int $statusCode,array $payload) :void {
        http_response_code($statusCode);
        echo json_encode($payload,JSON_UNESCAPED_UNICODE);
        exit;
    }

    $host = 'localhost';
    $db  = 'week5';
    $user = 'root';
    $pass = '';
    $charset = 'utf8';  

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE   => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES  => false,
    ];


    try {
        $pdo = new PDO($dsn,$user,$pass,$options);
    }catch(PDOException $e) {
        sendResponse(500,[
            'success' => false,
            'message' => 'Lỗi kết nối cơ sở dữ liệu.'
        ]);
    }

    function validateProductInput(?array $input): array {
    if (!is_array($input)) {
        return ['valid' => false, 'message' => 'Dữ liệu gửi lên phải ở định dạng JSON hợp lệ.'];
    }

    if (!isset($input['name'], $input['price'], $input['stock'])) {
        return ['valid' => false, 'message' => 'Thiếu các trường bắt buộc (name, price, stock).'];
    }

    if (!is_string($input['name'])) {
        return ['valid' => false, 'message' => 'Tên sản phẩm phải là chuỗi ký tự.'];
    }

    // Bỏ khoảng trắng hai đầu và kiểm tra độ dài từ 1 đến 100 ký tự (hỗ trợ tiếng Việt có dấu)
    $name = trim($input['name']);
    $nameLength = mb_strlen($name, 'UTF-8');
    if ($nameLength < 1 || $nameLength > 100) {
        return ['valid' => false, 'message' => 'Tên sản phẩm sau khi bỏ khoảng trắng phải có từ 1 đến 100 ký tự.'];
    }

    // Kiểm tra đơn giá là số nguyên lớn hơn 0 (từ chối chuỗi, số thực, boolean)
    $price = $input['price'];
    if (!is_int($price) || $price <= 0) {
        return ['valid' => false, 'message' => 'Đơn giá phải là số nguyên lớn hơn 0.'];
    }

    // Kiểm tra tồn kho là số nguyên không âm
    $stock = $input['stock'];
    if (!is_int($stock) || $stock < 0) {
        return ['valid' => false, 'message' => 'Số lượng tồn kho phải là số nguyên không âm (>= 0).'];
    }

    return [
        'valid' => true,
        'data' => [
            'name'  => $name,
            'price' => $price,
            'stock' => $stock
        ]
    ];
    }
    function getValidatedId(): int {
    if (!isset($_GET['id']) || filter_var($_GET['id'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) === false) {
        sendResponse(400, [
            'success' => false,
            'message' => 'Tham số id trên URL không hợp lệ.'
        ]);
    }
    return (int) $_GET['id'];
    }

    $method = $_SERVER["REQUEST_METHOD"];
    $id = isset($_GET["id"]) ? (int)$_GET['id']:0;
    switch($method){
        case "GET":
            $stmt = $pdo->query('SELECT id,name,price,stock FROM products ORDER BY id DESC');
            $products = $stmt->fetchAll();
            sendResponse(200,[
                'success' => true,
                'data' => $products
            ]);
            break;
        case "POST":
            $rawBody = file_get_contents('php://input');
            $input = json_decode($rawBody, true);

            $validation = validateProductInput($input);
            if (!$validation['valid']) {
                sendResponse(400, [
                    'success' => false,
                    'message' => $validation['message']
                ]);
            }

            $data = $validation['data'];
            $stmt = $pdo->prepare('INSERT INTO products (name, price, stock) VALUES (:name, :price, :stock)');
            $stmt->execute([
                ':name'  => $data['name'],
                ':price' => $data['price'],
                ':stock' => $data['stock']
            ]);

            $newId = (int) $pdo->lastInsertId();
            sendResponse(201, [
                'success' => true,
                'message' => 'Thêm sản phẩm thành công.',
                'data'    => [
                    'id'    => $newId,
                    'name'  => $data['name'],
                    'price' => $data['price'],
                    'stock' => $data['stock']
                ]
            ]);
            break;
        case "PUT":
            $id = getValidatedId();
            
            $checkStmt = $pdo->prepare('SELECT id FROM products WHERE id = :id');
            $checkStmt->execute([':id' => $id]);
            if (!$checkStmt->fetch()) {
                sendResponse(404,[
                    'success' => false,
                    'message' => 'Không tìm thấy sản phẩm cần cập nhật.'
                ]);
            }
            $rawBody = file_get_contents('php://input');
            $input = json_decode($rawBody,true);

            $validation = validateProductInput($input);
            if (!$validation['valid']) {
                sendResponse(400,[
                    'success' =>false,
                    'message' => $validation['message']
                ]);
            }
            $data = $validation['data'];
            $stmt = $pdo->prepare('UPDATE products SET name = :name,price = :price,stock = :stock WHERE id = :id');
            $stmt->execute([
                ':name' => $data['name'],
                ':price' => $data['price'],
                ':stock' => $data['stock'],
                ':id' => $id
            ]);
            sendResponse(200,[
                'success' => true,
                'message' => 'Cập nhật sản phẩm thành công.',
                'data'    => [
                'id'    => $id,
                'name'  => $data['name'],
                'price' => $data['price'],
                'stock' => $data['stock']
                ]
            ]);
            break;
        case "DELETE":
            $id = getValidatedId();
            $stmt = $pdo-> prepare('DELETE FROM products WHERE id = :id');
            $stmt->execute([':id' => $id]);
            if ($stmt ->rowCount() ===0) {
                sendResponse(404,[
                    'success' =>false,
                    'message' => 'Không tìm thấy sản phẩm cần xóa.'
                ]);
            }
            sendResponse(200,[
                'success' => true,
                'message' =>  'Xóa sản phẩm thành công.'
            ]);
            break;
        default:
            sendResponse(405,[
                'success' => false,
                'message' =>  'Phương thức HTTP không được hỗ trợ.'
            ]);
            break;
    }

?>