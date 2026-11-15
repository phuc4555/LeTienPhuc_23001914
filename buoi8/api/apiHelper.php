<?php

    // File: api/apiHelper.php

    // Nap file nay o dau moi endpoint API

    // 1. Bao cho client biet ket qua tra ve la JSON, ma UTF-8

    header("Content-Type: application/json; charset=utf-8");

    // 2. CORS - cho phep frontend o origin khac goi vao

    // (buoi 9 Vue chay o cong 5173, PHP chay o cong 80 -> khac origin)

    header("Access-Control-Allow-Origin: http://localhost:5173");

    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

    header("Access-Control-Allow-Headers: Content-Type, Authorization");

    header("Access-Control-Allow-Credentials: true");

    // 3. Trinh duyet gui request OPTIONS "tham do" truoc khi gui PUT/DELETE

    if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {

        http_response_code(204);

    exit();

    }

    /*

    * Tra ve JSON kem status code roi ket thuc

    */

    function traVeJson($duLieu, $statusCode = 200) {

    http_response_code($statusCode);

    echo json_encode($duLieu, JSON_UNESCAPED_UNICODE);

    exit();

    }

    // Tra ve loi theo dinh dang thong nhat

    function traVeLoi($thongBao, $statusCode = 400) {

    traVeJson(["success" => false, "message" => $thongBao], $statusCode);

    }

    // Tra ve thanh cong theo dinh dang thong nhat

    function traVeThanhCong($duLieu = null, $thongBao = "OK", $statusCode = 200) {

    traVeJson(["success" => true, "message" => $thongBao, "data" => $duLieu], $statusCode);

    }

    // Doc du lieu JSON client gui len trong than request

    function docJsonDauVao() {

    $noiDung = file_get_contents("php://input");

    $duLieu = json_decode($noiDung, true);

    return is_array($duLieu) ? $duLieu : [];

    }

?>