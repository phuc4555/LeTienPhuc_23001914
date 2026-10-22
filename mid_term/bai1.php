<?php
$name = "Phuc";
$score = 8;
echo "Tên : " . $name .",Điểm: " . $score. ",Xếp loại: "; 
if ($score >=8) {
    echo "Giỏi";
} else if ($score >=6.5 && $score <8) {
    echo "Khá";
} else if ($score >=5 && $score  < 6.5) {
    echo "Trung bình";
} else {
    echo "Yếu";
}





?>