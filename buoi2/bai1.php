<?php 
class CartItem {
    public $name;
    public $price;
    public $quantity;
    public function __construct($name, $price,$quantity) {
        $this -> name = $name;
        $this -> price = $price;
        $this -> quantity = $quantity;
    }
    public function getTotal() {
        return $this -> price * $this -> quantity;
    }
}
class ShoppingCart {
    private $items = [];
    public function addItem($item) {
        $this-> items[] = $item;
    }
    public function removeItem($name) {
        $vi_tri = null;
        for ($i = 0; $i < count($this-> items);$i++) {
            if ($this-> items[$i] -> name == $name ) {
                $vi_tri = $i;
            }
        }
        if ( $vi_tri === null) {
            echo "Khong tim thay " . $name;
        } else {
            unset($this-> items[$vi_tri]);
            $this-> items = array_values($this-> items);
        }
    }
    public function calculateTotal() {
        if ($this-> items === null) return 0;
        $score = 0;
        foreach($this-> items as $item) {
            $score += $item -> getTotal();
        }
        return $score;
    }
    public function displayCart() {
        $unit_prices = [];
        foreach($this ->items as $item) {
           echo "ten: ".  $item ->name,", don gia: " .$item ->price.", so luong: ". $item ->quantity.", thanh tien: " . $item -> getTotal() ."\n" ;
        }
        echo "Tong tien: ". $this -> calculateTotal() . "\n";
    }

}
$shoppingCart = new ShoppingCart();
$cartItem1 = new CartItem("A",1000,50);
$cartItem2 = new CartItem("B", 2000,60);
$cartItem3 = new CartItem("C",1500, 40);
$cartItem4 = new CartItem("D", 4500, 20);
$shoppingCart -> addItem($cartItem1);
$shoppingCart -> addItem($cartItem2);
$shoppingCart -> addItem($cartItem3);
$shoppingCart -> addItem($cartItem4);
$shoppingCart ->displayCart();
echo "Tong tien: ". $shoppingCart -> calculateTotal() . "\n";
$shoppingCart-> removeItem("C");
$shoppingCart -> displayCart();
?>