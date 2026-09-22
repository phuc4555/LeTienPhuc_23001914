<?php
class Student {
    private $name;
    private $age;
    private $score;

    public function Student($name,$age,$score) {
        $this->name = $name;
        $this -> age = $age;
        $this -> score = $score;
    }
    public function getRank() {
        if ($this -> score  >=8) {
            return "Giỏi";
        } else if($this -> score >=6.5) {
            return "Khá";
        } else if ($this -> score >=5) {
            return "Trung bình";
        } else {
            return "Yếu";
        }
    }
    public function isPassed() {
        return $this-> score >=5;
    } 

    public function display() {
        return  "Tên: " .$this -> name ." Tuổi-  " . $this-> age . "Điểm" .$this -> score;
    }
}
$student1 = new Student("Nguyen Van An", 20, 8.5);
$student2 = new Student("Tran Thi Binh", 21, 6.5);
$student3 = new Student("Le Van Cuong", 19, 4.5);
$student4 = new Student("Pham Thi Dung", 20, 7.5);
$list_students = [$student1,$student2,$student3,$student4];
foreach ($list_students as $student){
    echo $student -> diplay() . "\n";
}
$max_score = 0;
foreach($list_students as $student) {
    if ($max_score  < $student->score) {
        $max_score = $student -> score;
    }
}
echo "Max score: " . $max_score;
$num_passed = 0;
foreach($list_students as $student) {
    if ($student -> isPassed()) {
        $num_passed ++;
    } 
}
echo "Num passed: " . $num_passed;
$avg = 0;
foreach ($list_students as $student) {
    $avg += $student -> score;
}
echo "Average: " . $avg;
?>