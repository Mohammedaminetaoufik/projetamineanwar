CREATE TABLE users (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(200),
    Email VARCHAR(200),
    Age INT,
    tele VARCHAR(10),
    active BOOLEAN DEFAULT false, 
    Password VARCHAR(200)
);


-- CREATE TABLE `users` (
  -- `user_id` int(11) NOT NULL,
  -- `first_name` varchar(200) NOT NULL,
  -- `last_name` varchar(255) NOT NULL,
  -- `email` varchar(255) NOT NULL,
  -- `password` varchar(150) NOT NULL,
  -- `contact_no` varchar(10) NOT NULL,
  -- `registered_at` date NOT NULL DEFAULT current_timestamp(),
  -- `isAdmin` int(11) NOT NULL DEFAULT 0,
  -- `user_address` varchar(255) NOT NULL
-- ) ;






CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `variation_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ;



CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(150) NOT NULL
) ;





CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `delivered_to` varchar(150) NOT NULL,
  `phone_no` varchar(10) NOT NULL,
  `deliver_address` varchar(255) NOT NULL,
  `pay_method` varchar(50) NOT NULL,
  `pay_status` int(11) NOT NULL,
  `order_status` int(11) NOT NULL DEFAULT 0,
  `order_date` date NOT NULL DEFAULT current_timestamp()
) ;


CREATE TABLE `order_details` (
  `detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `variation_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ;



CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_desc` text NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `uploaded_date` date NOT NULL DEFAULT current_timestamp()
) ;





CREATE TABLE `product_size_variation` (
  `variation_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `quantity_in_stock` int(11) NOT NULL
) ;



CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `review_desc` text NOT NULL
) ;





CREATE TABLE `sizes` (
  `size_id` int(11) NOT NULL,
  `size_name` varchar(100) NOT NULL
) ;







CREATE TABLE `wishlist` (
  `wish_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ;


ALTER TABLE 'cart'
  ADD PRIMARY KEY ('cart_id'),
  ADD UNIQUE KEY 'uc_cart' ('user_id', 'variation_id'),
  ADD KEY 'variation_id' ('variation_id'),
  ADD FOREIGN KEY ('user_id') REFERENCES users(Id);


ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);


ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);


ALTER TABLE `order_details`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `variation_id` (`variation_id`);


ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);


ALTER TABLE `product_size_variation`
  ADD PRIMARY KEY (`variation_id`),
  ADD UNIQUE KEY `uc_ps` (`product_id`,`size_id`);


ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);


ALTER TABLE `sizes`
  ADD PRIMARY KEY (`size_id`);


ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);


ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wish_id`),
  ADD UNIQUE KEY `uc_wish` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);




ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;


ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `order_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;


ALTER TABLE `product_size_variation`
  MODIFY `variation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;


ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `sizes`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `wishlist`
  MODIFY `wish_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;


ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`variation_id`) REFERENCES `product_size_variation` (`variation_id`);


ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);


ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`variation_id`) REFERENCES `product_size_variation` (`variation_id`);


ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);


ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);


ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);
COMMIT;


