SELECT * FROM `cart_items`;
SELECT * FROM `cart_items` WHERE price > 100000;
SELECT * FROM `cart_items` WHERE quantity > 5;
SELECT * FROM `cart_items` ORDER BY price DESC;
UPDATE `cart_items` SET price = 50000 WHERE name  = "blouse";
UPDATE `cart_items` SET quantity  = 20 WHERE name  = "hat";
DELETE FROM `cart_items` WHERE NAME = "Jean";
SELECT ci.name AS "Ten" , ci.price AS "Gia" , ci.quantity AS "so luong" , ci.price * ci.quantity AS "thanh tien" FROM `cart_items` AS ci ;
SELECT SUM(ci.price * ci.quantity) AS "tong tien"  FROM `cart_items` AS ci;

SELECT * FROM `movies`;
SELECT * FROM `movies` WHERE price > 100;
SELECT * FROM `movies` WHERE availables_seats > 50;
SELECT * FROM `movies` ORDER BY price DESC;
UPDATE `movies` SET availables_seats = 30 WHERE title = "Mai";
DELETE FROM `movies` WHERE total_seats = 100;
SELECT m.total_seats - m.availables_seats AS "so ve da ban" FROM `movies`	 AS m;
SELECT (m.total_seats - m.availables_seats) * m.price AS "doanh thu" FROM `movies` AS m;
SELECT SUM((m.total_seats - m.availables_seats) * m.price) AS "doanh thu" FROM `movies`AS m;
SELECT * FROM `movies` AS m WHERE (m.total_seats - m.availables_seats) >=
( SELECT MAX(mv.total_seats - mv.availables_seats) FROM `movies` AS mv 
) 