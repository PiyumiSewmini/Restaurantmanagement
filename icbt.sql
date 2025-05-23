-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2024 at 09:16 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `icbt`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `id` int(11) NOT NULL,
  `cart_id` varchar(255) NOT NULL,
  `food_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_cart`
--

INSERT INTO `tbl_cart` (`id`, `cart_id`, `food_id`, `quantity`, `price`, `created_at`) VALUES
(48, '664044996cf71', 7, 1, '2.00', '2024-05-12 04:24:57');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_food`
--

CREATE TABLE `tbl_food` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_food`
--

INSERT INTO `tbl_food` (`id`, `name`, `category`, `description`, `price`, `image_url`) VALUES
(1, 'Chicken Tikka Masala', 'Main Course', 'Delicious chicken curry with spices', '1.99', 'post-11.jpg'),
(2, 'Vegetable Biryani', 'Main Course', 'Flavorful rice dish with vegetables', '10.99', 'vegetable_biryani.jpg'),
(3, 'Paneer Butter Masala', 'Main Course', 'Creamy cottage cheese curry', '11.99', 'paneer_butter_masala.jpg'),
(4, 'Garlic Naan', 'Bread', 'Tasty Indian bread with garlic flavor', '3.99', 'garlic_naan.jpg'),
(5, 'Mango Lassi', 'Beverage', 'Refreshing yogurt-based drink with mango flavor', '5.99', 'mango_lassi.jpg'),
(6, 'Gulab Jamun', 'Dessert', 'Sweet and syrupy Indian dessert', '4.99', 'gulab_jamun.jpg'),
(7, 'Samosa', 'Appetizer', 'Crispy pastry filled with spiced potatoes', '2.99', 'samosa.jpg'),
(8, 'Chicken Biryani', 'Main Course', 'Fragrant rice dish with tender chicken pieces', '13.99', 'chicken_biryani.jpg'),
(9, 'Mutton Rogan Josh', 'Main Course', 'Spicy lamb curry cooked with aromatic spices', '15.99', 'mutton_rogan_josh.jpg'),
(10, 'Dal Tadka', 'Side Dish', 'Lentil curry with a tempered spice flavor', '8.99', 'dal_tadka.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `order_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `food_id` varchar(500) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `date_ordered` date NOT NULL,
  `time_ordered` time NOT NULL,
  `stts` varchar(30) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`order_id`, `username`, `food_id`, `quantity`, `price`, `date_ordered`, `time_ordered`, `stts`) VALUES
(34, 'Hari_shockings', '2', 1, '10.99', '2024-05-11', '03:54:48', 'Pending'),
(36, 'Hari_shockings', '1,7', 2, '26.00', '2024-05-12', '02:10:14', 'Pending'),
(37, 'Hari_shockings', '3', 3, '33.00', '2024-05-12', '02:14:37', 'Pending'),
(39, 'Hari_shockings', '2', 99, '1088.01', '2024-05-12', '06:18:31', 'Pending'),
(40, 'Hari_shockings', '8,7', 3, '47.00', '2024-05-12', '09:49:26', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `email`, `phone`, `address`, `password`) VALUES
(12, 'Hari_shockings', 'haritheguy21@gmail.com', '0703044997', '138/3 Ginthupitiya Street Colombo, Srilanka', 'hari');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_food`
--
ALTER TABLE `tbl_food`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tbl_food`
--
ALTER TABLE `tbl_food`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
