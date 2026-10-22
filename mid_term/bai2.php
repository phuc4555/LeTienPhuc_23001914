<?php
$danh_sach_san_pham = [5000,6000,10000,20000,50000];

function calculateTotal($danh_sach_san_pham) {
    $score = 0;
    foreach ($danh_sach_san_pham as $sp) {
        $score += $sp;
    }
    return $score;
}
function findMaxPrice($danh_sach_san_pham) {
    $score = 0;
    foreach($danh_sach_san_pham as $sp) {
        if ($score < $sp) {
            $score = $sp;
        }
    }
    return $score;
}
echo "Tổng sản phẩm: " . calculateTotal($danh_sach_san_pham) ."\n";
echo "Giá sản phẩm cao nhất: ". findMaxPrice($danh_sach_san_pham);


?>