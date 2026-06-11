--Code to create the 'products' table
CREATE TABLE products (
    id INT PRIMARY KEY,
    name VARCHAR(50),
    price decimal(10, 2),
    stock INT,
    image VARCHAR(50));

--Code to insert product
insert into products VALUES
(101, "Phone", 30000, 30, "images/phone.jpg"),
(102, "Laptop", 65000, 100, "images/laptop.jpg"),
(103, "Mouse", 1000, 20, "images/mouse.jpg");