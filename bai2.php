<?php
$students = [
 [
 "name" => "Nguyen Van An",
 "age" => 20,
 "score" => 8.5
 ],
 [
 "name" => "Tran Thi Binh",
 "age" => 21,
 "score" => 6.5
 ],
 [
 "name" => "Le Van Cuong",
 "age" => 19,
 "score" => 4.5
 ],
 [
 "name" => "Pham Thi Dung",
 "age" => 20,
 "score" => 7.5
 ]
];

function calculateAverageScore($students) {
    $sum_score = 0;
    foreach($students as $s) {
        $sum_score = $sum_score + $s['score'];
    }
    echo "Điểm trung bình: " . $sum_score / count($students);
}

function getRank($score) {
    if ($score >= 8) {
        echo "Giỏi.";
    } else if ($score >= 6.5) {
        echo "Khá.";
    } else if ($score >=5) {
        echo "Trung bình";
    } else {
        echo "Yếu";
    }
}
function displayStudent($students) {
    foreach($studens as $s )  {
    echo "Tên: " .$s['name'] ." Tuổi-  " . $s['age'] . "Xếp loại-" . getRank($s['score']) ."\n";
    }
}

?>