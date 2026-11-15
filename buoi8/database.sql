CREATE TABLE products(
    id INT PRIMARY KEY AUTO_INCREMENT ,
    name VARCHAR(100) UNIQUE,
    price INT CHECK(price >0),
    stock INT CHECK(stock >=0)
);


INSERT INTO products (name,price,stock) VALUES ('Bút bi' ,5.000 ,20);
INSERT INTO products (name,price,stock) VALUES ('Vở ô ly', 12.000, 15);
INSERT INTO products (name,price,stock) VALUES ('Thước kẻ', 8.000, 0);
