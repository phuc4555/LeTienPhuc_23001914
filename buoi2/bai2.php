<?php
class Movie {
    public $id;
    public $title;
    public $price;
    public $totalSeats;
    public $availableSeats;

    public function __construct($id,$title,$price,$totalSeats) {
        $this -> id = $id;
        $this -> title = $title;
        $this -> price = $price;
        $this -> totalSeats = $totalSeats;
        $this -> availableSeats = $totalSeats;
    }
    public function bookTicket($quantity) {
        if ($quantity < 0) {
            echo "Quantity must be > 0 \n";
            return;
        }
        if ($quantity > $this ->availableSeats) {
            echo "Quantity must be > available seats \n";
            return;
        }
        $this -> availableSeats -= $quantity;
    }
    public function cancelTicket($quantity) {
        if ($quantity < 0){
            echo "Quantity must be > 0 \n";
            return;
        }
        if ($quantity > $this ->totalSeats - $this -> availableSeats) {
            echo "Quantity must be > sold ticket \n";
            return;
        }
        $this ->availableSeats += $quantity;
    }
    public function getSoldSeats() {
        return $this -> totalSeats - $this -> availableSeats;
    }
    public function getRevenue() {
        return $this -> getSoldSeats() * $this -> price;
    }
    public function displayInfo() {
        echo "Ma xem phim: " . $this -> id . ", ten phim: " . $this -> title . ", gia ve: ". $this->price . ", tong so ghe: ". $this -> totalSeats . ", so ghe con lai: " . $this -> availableSeats .",so ve da ban: ". $this->getSoldSeats().",doanh thu: ".$this -> getRevenue(). "\n";
    }
}
function findMovieById($movies,$id) {
    if ($movies == null) return null;
    foreach($movies as $movie) {
        if ($movie -> id == $id) return $movie;
    }
    return null;
}   
function getTotalRevenue($movies) {
    if ($movies == null) return 0;
    $total_score = 0;
    foreach($movies as $movie) {
        $total_score += $movie -> getRevenue();
    }
    return $total_score;
}
function getBestSellingMovie($movies) {
    if ($movies == null) return null;
    $best_movie = null;
    $best_total_seats = 0;
    foreach($movies as $movie) {
        if ($movie -> getSoldSeats() > $best_total_seats) {
            $best_total_seats = $movie -> getSoldSeats();
            $best_movie = $movie;
        }
    }
    return $best_movie;
}
$movie1 = new Movie(1,"Avengers",100000,100);
$movie2 = new Movie(2,"Avatar",120000,80);
$movie3 = new Movie(3,"Batman", 90000,120);
$list_movies= [];
if (getBestSellingMovie($list_movies) ==null) {
    echo "Khong ton tai phim ban chay nhat \n";
} else{
getBestSellingMovie($list_movies) -> displayInfo();
}
$list_movies = [$movie1,$movie2,$movie3];
$list_movies[0] -> bookTicket(20);
$list_movies[1] -> bookTicket(30);
$list_movies[1] -> bookTicket(1000);
$list_movies[2] -> bookTicket(-2);
$list_movies[0] -> cancelTicket(10);
$list_movies[2] -> cancelTicket(-5);
$list_movies[2] -> cancelTicket(1000000);
foreach($list_movies as $movie) {
    $movie -> displayInfo();
}
if (findMovieById($list_movies,-1) == null) {
    echo "Khong ton tai phim co id nay \n";
} else {
findMovieById($list_movies,-1)->displayInfo();
}
echo "Tong doanh thu: ". getTotalRevenue($list_movies) ."\n";
echo "Phim co ve ban ra nhieu nhat: ";
if (getBestSellingMovie($list_movies) ==null) {
    echo "Khong ton tai phim ban chay nhat \n";
} else{
getBestSellingMovie($list_movies) -> displayInfo();
}?>