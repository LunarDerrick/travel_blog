-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2023 at 04:46 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `traveldb`
--
CREATE DATABASE IF NOT EXISTS `traveldb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `traveldb`;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `userid` int(128) NOT NULL,
  `postid` int(128) NOT NULL,
  `commenttime` bigint(20) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`userid`, `postid`, `commenttime`, `comment`) VALUES
(151567889, 20, 0, 'I visited Stonehenge and although the site was impressive, I was disappointed with the limited access and the crowd. It felt a bit rushed and I wish there were more information boards explaining the history. Overall, an okay experience.'),
(151567889, 21, 0, 'I found the public transportation in Seoul to be quite confusing. The subway system was difficult to navigate, and the lack of English signage made it even more challenging. Additionally, the crowded buses during peak hours were uncomfortable. It took away from the overall travel experience.'),
(151567889, 22, 0, 'My visit to Tokyo was a mixed experience. The city\'s vibrant energy and modern attractions were captivating, but I found the high prices and crowded streets to be overwhelming. The cultural sites, such as Meiji Shrine, offered a more serene escape. Overall, a diverse destination with some drawbacks.'),
(573006510, 20, 0, 'The hotel I stayed at in Manchester was decent. The room was clean and comfortable, but the service was a bit slow. The location was convenient, but the noise from the nearby street was a bit bothersome. It was an average stay, nothing extraordinary'),
(573006510, 21, 0, 'The shopping in Myeongdong was decent, but I found it to be too crowded for my liking. The streets were packed with people, and it was challenging to navigate through the crowds. Additionally, some of the shops were repetitive, offering similar products. An average shopping experience.'),
(573006510, 22, 0, 'Hiroshima was a thought-provoking destination. The Peace Memorial Park and Museum were powerful reminders of the city\'s history. The only reason I\'m giving it 4 stars instead of 5 is that some parts of the museum were crowded, limiting the viewing experience. A significant historical site to visit.'),
(2147483647, 20, 0, 'The city of Bath stole our hearts! The Roman Baths were fascinating, and the Georgian architecture was stunning. The city\'s compact size made it easy to explore on foot, and the abundance of charming tea rooms added to the experience. A must-visit destination!'),
(2147483647, 21, 0, 'The street food in Busan was delicious and diverse. The flavors were tantalizing, and the bustling food stalls added to the vibrant atmosphere. The only reason I\'m not giving it a perfect score is that some vendors lacked seating areas, making it difficult to enjoy the food comfortably.'),
(2147483647, 22, 0, 'Kyoto was an absolute delight! The city\'s traditional charm and rich cultural heritage were evident in every corner. The temples, such as Kiyomizu-dera and Fushimi Inari, were stunning. The geisha district of Gion offered a glimpse into a bygone era. A must-visit for cultural immersion!');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postid` int(128) NOT NULL,
  `userid` int(128) NOT NULL,
  `title` varchar(255) NOT NULL,
  `caption` mediumtext NOT NULL,
  `content` longtext NOT NULL,
  `location` text NOT NULL,
  `continent` varchar(20) NOT NULL,
  `image` text NOT NULL,
  `tag` text NOT NULL,
  `createdtime` bigint(20) NOT NULL,
  `viewcount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='"Post database"';

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postid`, `userid`, `title`, `caption`, `content`, `location`, `continent`, `image`, `tag`, `createdtime`, `viewcount`) VALUES
(19, 151567889, 'New Zealand and its Railcar', 'Top country to visit. Must see.', 'New Zealand is known for its stunning _natural landscapes_, and one of the best ways to see them is by railcar. The country\'s rail system offers a unique way to travel, allowing visitors to take in the beauty of the countryside while also enjoying a comfortable and relaxing ride.\r\n\r\n#### **My journey there**\r\n\r\nMy journey through New Zealand began in Auckland, the country\'s largest city. From there, I hopped on the Northern Explorer, a train that takes passengers on a scenic journey through the heart of the North Island. The train was comfortable and well-appointed, with large windows that offered stunning views of the surrounding countryside.\r\n\r\nAs we made our way south, the scenery changed from lush forests to rolling hills, and eventually to the rugged coastline. Along the way, we passed through small towns and villages, each with its own unique charm and character. I particularly enjoyed the stop in the town of National Park, which is located near the Tongariro National Park. The scenery here was simply breathtaking, with snow-capped mountains and crystal-clear lakes stretching as far as the eye could see.\r\n\r\n#### **Second day**\r\n\r\nAfter a night in National Park, I continued south on the train to Wellington, the capital of New Zealand. This leg of the journey was equally scenic, with the train winding its way through the mountains and along the coast. The train was equipped with comfortable seating and a dining car, where I was able to enjoy a delicious meal while taking in the stunning views.\r\n\r\n#### **My thoughts**\r\n\r\nOverall, my experience traveling through New Zealand on a railcar was unforgettable. The scenery was stunning, the train was comfortable and well-appointed, and the people I met along the way were friendly and welcoming. I would highly recommend this mode of travel to anyone looking to explore the natural beauty of New Zealand in a unique and memorable way.', 'New Zealand', 'Europe', 'uploads/f542793d2fbd3436b90abd6e92730bf0ab832298.jpg', 'New Zealand,happy,visit,railcar', 1686752018960, 0),
(20, 151567889, 'The UK Travel Guide -- by locals', 'Bus and building of the UK', 'UK content', 'United Kingdom', 'Europe', 'image\\united_kingdom.jpg', 'UK', 0, 0),
(21, 151567889, 'Let\'s go to Korea next year?', 'Witness where your idol lives!', 'Korea content', 'Korea', 'Asia', 'image\\korea.jpg', 'Korea', 0, 0),
(22, 151567889, 'Japan', 'Good place to visit! Lots of fun places to go.', 'Japan content', 'Japan', 'Japan', 'image\\japan.jpg', 'Japan', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `userid` int(32) NOT NULL,
  `postid` int(128) NOT NULL,
  `rating` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`userid`, `postid`, `rating`) VALUES
(151567889, 20, 3),
(151567889, 21, 4),
(151567889, 22, 5),
(573006510, 20, 2),
(573006510, 21, 3),
(573006510, 22, 4),
(2147483647, 20, 3),
(2147483647, 21, 4),
(2147483647, 22, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(128) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profilepic` varchar(255) DEFAULT NULL,
  `profileintro` longtext DEFAULT NULL,
  `realname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telno` varchar(16) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='User information';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `password`, `profilepic`, `profileintro`, `realname`, `email`, `telno`, `token`) VALUES
(151567889, 'test', '$2y$12$fjGir6yr2LtvY.6p/QmauODakN89ZhBR8.UelDNbT1/ZqUKMJqNYy', NULL, NULL, 'Tester', 'test@gmail.com', NULL, NULL),
(573006510, 'test2', '$2y$12$ksHGI7zzfMyxvlR61N90xezemN5fvQoDoC2xY99WagSaaZl19zvJu', NULL, NULL, 'Test2', 'test@gmail.co', NULL, NULL),
(2147483647, 'test3', '$2y$12$uSaw8pg6UXH7HpQsXmTxDegi6L1YrdzZ2vFiAIJt4QUHNp.v69lw.', NULL, NULL, 'Test3', 'abc@xyz.co', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`userid`,`postid`,`commenttime`) USING BTREE,
  ADD KEY `postid_comments` (`postid`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postid`),
  ADD KEY `username` (`userid`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`userid`,`postid`),
  ADD KEY `postid_rating` (`postid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postid` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `postid_comments` FOREIGN KEY (`postid`) REFERENCES `posts` (`postid`) ON DELETE CASCADE,
  ADD CONSTRAINT `userid_comments` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `username` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `postid_rating` FOREIGN KEY (`postid`) REFERENCES `posts` (`postid`) ON DELETE CASCADE,
  ADD CONSTRAINT `userid_rating` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
