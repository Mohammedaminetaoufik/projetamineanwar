
CREATE TABLE users (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(200),
    Email VARCHAR(200),
    Age INT,
    tele VARCHAR(10),
    active BOOLEAN DEFAULT false, 
    Password VARCHAR(200)
) ENGINE=InnoDB;


CREATE TABLE cart (
    cart_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT, 
    price INT,
    UNIQUE KEY uc_cart (user_id),
    KEY variation_id (variation_id),
    FOREIGN KEY (user_id) REFERENCES users(Id)
) ENGINE=InnoDB;


CREATE TABLE category (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(150) NOT NULL
) ENGINE=InnoDB;


CREATE TABLE orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    delivered_to VARCHAR(150) NOT NULL,
    phone_no VARCHAR(10) NOT NULL,
    deliver_address VARCHAR(255) NOT NULL,
    pay_method VARCHAR(50) NOT NULL,
    pay_status INT NOT NULL,
    order_status INT NOT NULL DEFAULT 0,
    order_date DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(Id)
) ENGINE=InnoDB;


CREATE TABLE order_details (
    detail_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    quantity INT,
    price INT,
    FOREIGN KEY (order_id) REFERENCES orders(order_id)
) ENGINE=InnoDB;


CREATE TABLE product (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    product_name VARCHAR(200) NOT NULL,
    product_desc TEXT NOT NULL,
    product_image VARCHAR(255) NOT NULL,
    price INT NOT NULL,
    quantity INT NOT NULL,
    category_id INT NOT NULL,
    uploaded_date DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES category(category_id)
) ENGINE=InnoDB;





CREATE TABLE review (
    review_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    product_id INT,
    review_desc TEXT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(Id),
    FOREIGN KEY (product_id) REFERENCES product(product_id)
) ENGINE=InnoDB;





CREATE TABLE wishlist (
    wish_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    product_id INT,
    UNIQUE KEY uc_wish (user_id, product_id),
    KEY product_id (product_id),
    FOREIGN KEY (user_id) REFERENCES users(Id),
    FOREIGN KEY (product_id) REFERENCES product(product_id)
) ENGINE=InnoDB;
