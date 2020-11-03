-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2020 at 01:38 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecom_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(1, 'Romance'),
(2, 'Mystery'),
(5, 'Paint');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_amount` float NOT NULL,
  `order_transaction` varchar(255) NOT NULL,
  `order_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_amount`, `order_transaction`, `order_status`) VALUES
(1, 90, '12345678', 'Completed'),
(2, 255, '123456780123', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `product_price` float NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_description` text NOT NULL,
  `short_desc` text NOT NULL,
  `product_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_category_id`, `product_price`, `product_quantity`, `product_description`, `short_desc`, `product_image`) VALUES
(2, 'Hobbit', 3, 200, 2, 'The Hobbit is a tale of high adventure, undertaken by a company of dwarves in search of dragon-guarded gold. A reluctant partner in this perilous quest is Bilbo Baggins, a comfort-loving unambitious hobbit, who surprises even himself by his resourcefulness and skill as a burglar.\r\n\r\nEncounters with trolls, goblins, dwarves, elves and giant spiders, conversations with the dragon, Smaug, and a rather unwilling presence at the Battle of Five Armies are just some of the adventures that befall Bilbo.\r\n\r\nBilbo Baggins has taken his place among the ranks of the immortals of children’s fiction. Written by Professor Tolkien for his own children, The Hobbit met with instant critical acclaim when published.', 'The Hobbit is a tale of high adventure, undertaken by a company of dwarves in search of dragon-guarded gold. A reluctant partner in this perilous quest is Bilbo Baggins, a comfort-loving unambitious hobbit, who surprises even himself by his resourcefulness and skill as a burglar.', 'hobbit.jpg'),
(3, 'The Red House Mystery ', 2, 300, 5, 'This is probably one of the top classics of \"golden age\" detective fiction. Anyone who\'s read any mystery novels at all will be familiar with the tropes -- an English country house in the first half of the twentieth century, a locked room, a dead body, an amateur sleuth, a helpful sidekick, and all the rest.\r\n\r\nIt\'s a clever story, ingenious enough in its way, and an iconic example of Agatha Christie / Dorothy Sayers -type murder mysteries. If you\'ve read more than a few of those kinds of books, you might find this one a little predictable, but it\'s fun despite that.\r\n\r\nIt\'s particularly of note, however, because Raymond Chandler wrote about it extensively in his essay \"The Simple Art of Murder.\" After praising it as \"an agreeable book, light, amusing in the Punch style, written with a deceptive smoothness that is not as easy as it looks,\" he proceeds to take it sharply to task for its essential lack of realism. This book -- which Chandler admired to an extent -- was what he saw as the iconic example of what was wrong with the detective fiction of his day, and to which novels like \"The Big Sleep\" or \"The Long Goodbye\", with their hard-boiled, hard-hitting gumshoes and gritty realism, were a direct response.\r\n\r\nSo this book\'s worth reading not just because it\'s \"an agreeable book, light, [and] amusing in the Punch style\", but also because reading it will give a deepened appreciation for the later, more realistic detective fiction of writers like Hammett and Chandler.', 'This is probably one of the top classics of \"golden age\" detective fiction. Anyone who\'s read any mystery novels at all will be familiar with the tropes -- an English country house in the first half of the twentieth century, a locked room, a dead body, an amateur sleuth, a helpful sidekick, and all the rest.', 'the red house mystery.jpg'),
(12, 'Book 3', 0, 0, 0, '', '', 'product-1.jpg'),
(13, 'Book4', 2, 100, 3, 'Nice Book', 'good book', 'product-6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_price` float NOT NULL,
  `product_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `product_id`, `order_id`, `product_title`, `product_price`, `product_quantity`) VALUES
(1, 1, 8, 'Book 1', 24.99, 1),
(5, 2, 9, 'Hobbit', 200, 1),
(6, 1, 10, 'Night over water', 100, 1);

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE `slides` (
  `slide_id` int(11) NOT NULL,
  `slide_title` varchar(255) NOT NULL,
  `slide_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- Error reading data for table ecom_db.slides: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `ecom_db`.`slides`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `user_photo`) VALUES
(1, 'riyanka', 'riyanka@gmail.com', '139', ''),
(3, 'kushal', 'kushal@gmail.com', '214', 'Mount Rundle.jpg'),
(4, 'Ayush', 'aryanlekhadia953@gmail.com', '911', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`slide_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `slides`
--
ALTER TABLE `slides`
  MODIFY `slide_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
