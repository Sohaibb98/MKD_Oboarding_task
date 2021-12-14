CREATE DATABASE `mkd_shoppingcart` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

CREATE TABLE `order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `total` int(10) unsigned zerofill DEFAULT NULL,
  `stripe_id` varchar(45) DEFAULT NULL,
  `status` binary(1) NOT NULL DEFAULT 'p',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL,
  `price` float unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



Truncate products;



INSERT INTO products (title, description, image, price)
VALUES('Gloves','Winter gloves', 'C:/gloves.png',200);

INSERT INTO products (title, description, image, price)
VALUES('Shirt','Awesome full sleeves Cotton T shirts', 'https://i.imgur.com/1GrakTl.jpg',750.35);

INSERT INTO products (title, description, image, price)
VALUES('Pant','Purple Jeans Pant', 'https://i.imgur.com/1GrakTl.jpg',450.55);

Select * from products;