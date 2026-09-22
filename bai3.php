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
function findBestStudent($student) {
    $max_score = 0;
    $stu = NULL;
    foreach($student as $s) {
        if ($max_score < $s['score']) {
            $max_score = $s['score'];
            $stu = $s;
        }
    }
    return $stu;
}
function findWorstStudent($student) {
    $min_score = $student[0]['score'];
    $stu = $student[0];
    foreach($student as $s) {
        if ($min_score > $s['score']) {
            $min_score = $s['score'];
            $stu = $s;
        }
    }
    return $stu;
}
function countPassedStudents($students) {
    $count = 0;
    foreach($students as $s) {
        if ($s['score'] >= 5) {
            $count +=1;
        }
    } 
    return $count;
}
function findStudentByName($students,$name) {
    foreach($students as $s) {
        if ($s['name'] == $name) {
            return $s;
        }
    }
    return NULL;
}
function printStudent($student) {
    return "Name:" .$student['name']. ",age: " .$student['age']. ",score: ".$student['score'] ."\n"; 
}
echo "Best student: ". printStudent(findBestStudent($students));
echo "Worst student: " .printStudent(findWorstStudent($students));
echo "Number passed student:" .countPassedStudents($students)."\n";
$name = "Nguyen Van An";
echo "Student has name  " . $name ."is :". printStudent(findStudentByName($students,$name)) ;
?>