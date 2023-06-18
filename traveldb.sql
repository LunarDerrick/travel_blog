-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2023 at 05:58 PM
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
(123456789, 19, 1687095941714, 'I agree with him, this is my best experience yet!'),
(123456789, 22, 1687096041551, 'This makes me want to learn Japanese and immerse myself more into the Japan culture!'),
(151567889, 19, 1687093576359, 'You are right, the sight is awesome!'),
(151567889, 20, 0, 'I visited Stonehenge and although the site was impressive, I was disappointed with the limited access and the crowd. It felt a bit rushed and I wish there were more information boards explaining the history. Overall, an okay experience.'),
(151567889, 21, 0, 'I found the public transportation in Seoul to be quite confusing. The subway system was difficult to navigate, and the lack of English signage made it even more challenging. Additionally, the crowded buses during peak hours were uncomfortable. It took away from the overall travel experience.'),
(151567889, 22, 0, 'My visit to Tokyo was a mixed experience. The city\'s vibrant energy and modern attractions were captivating, but I found the high prices and crowded streets to be overwhelming. The cultural sites, such as Meiji Shrine, offered a more serene escape. Overall, a diverse destination with some drawbacks.'),
(234567891, 19, 1687098111163, 'Bet you guys didn\'t check out the kiwi bird. You\'re missing out a lot if you didn\'t visit the zoo here!'),
(234567891, 20, 1687097997676, 'It\'s a cool place, like actually cold kind of cool. It\'s fun as well!'),
(234567891, 21, 1687097872845, 'I’m like TT, just like TT\nireon nae mam moreugo neomuhae neomuhae\nI’m like TT, just like TT\nTell me that you’d be my baby'),
(234567891, 22, 1687097717613, 'I want to visit Kinkaku-ji and the Honnō-ji and the Sensō-ji! So many places to go, so little of time ;-;'),
(234567891, 23, 1687097586796, 'It\'s too hot here, be prepared to sweat a lot!'),
(345678912, 19, 1687099670566, 'I have a great time here, I made a great bargain too!'),
(345678912, 20, 1687099532924, 'It takes courage to spend here, pound sterlings aren\'t cheap FYI, but if you save too much, where\'s the fun in travelling?'),
(345678912, 21, 1687099418343, 'The bbq were too difficult to resist! Trust me, save all your money to order bbqs.'),
(345678912, 22, 1687099257076, 'My wallet almost got emptied out after my first few days, better save big before you ventured this honey trap!'),
(345678912, 23, 1687099195868, 'Expenses here are super cheap, I can eat 3 people worth of food with the same price I bought in my hometown~'),
(345678912, 24, 1687099104214, 'It\'s very affordable to travel here, I felt like a king spending here'),
(573006510, 19, 1687093693277, 'I know right? I want to go to New Zealand again!'),
(573006510, 20, 0, 'The hotel I stayed at in Manchester was decent. The room was clean and comfortable, but the service was a bit slow. The location was convenient, but the noise from the nearby street was a bit bothersome. It was an average stay, nothing extraordinary'),
(573006510, 21, 0, 'The shopping in Myeongdong was decent, but I found it to be too crowded for my liking. The streets were packed with people, and it was challenging to navigate through the crowds. Additionally, some of the shops were repetitive, offering similar products. An average shopping experience.'),
(573006510, 22, 0, 'Hiroshima was a thought-provoking destination. The Peace Memorial Park and Museum were powerful reminders of the city\'s history. The only reason I\'m giving it 4 stars instead of 5 is that some parts of the museum were crowded, limiting the viewing experience. A significant historical site to visit.'),
(2147483647, 20, 0, 'The city of Bath stole our hearts! The Roman Baths were fascinating, and the Georgian architecture was stunning. The city\'s compact size made it easy to explore on foot, and the abundance of charming tea rooms added to the experience. A must-visit destination!'),
(2147483647, 21, 0, 'The street food in Busan was delicious and diverse. The flavors were tantalizing, and the bustling food stalls added to the vibrant atmosphere. The only reason I\'m not giving it a perfect score is that some vendors lacked seating areas, making it difficult to enjoy the food comfortably.'),
(2147483647, 22, 0, 'Kyoto was an absolute delight! The city\'s traditional charm and rich cultural heritage were evident in every corner. The temples, such as Kiyomizu-dera and Fushimi Inari, were stunning. The geisha district of Gion offered a glimpse into a bygone era. A must-visit for cultural immersion!');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telno` varchar(16) NOT NULL,
  `message` text NOT NULL,
  `userid` int(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(19, 151567889, 'New Zealand and its Railcar', 'Top country to visit. Must see.', 'New Zealand is known for its stunning _natural landscapes_, and one of the best ways to see them is by railcar. The country\'s rail system offers a unique way to travel, allowing visitors to take in the beauty of the countryside while also enjoying a comfortable and relaxing ride.\r\n\r\n#### **My journey there**\r\n\r\nMy journey through New Zealand began in Auckland, the country\'s largest city. From there, I hopped on the Northern Explorer, a train that takes passengers on a scenic journey through the heart of the North Island. The train was comfortable and well-appointed, with large windows that offered stunning views of the surrounding countryside.\r\n\r\nAs we made our way south, the scenery changed from lush forests to rolling hills, and eventually to the rugged coastline. Along the way, we passed through small towns and villages, each with its own unique charm and character. I particularly enjoyed the stop in the town of National Park, which is located near the Tongariro National Park. The scenery here was simply breathtaking, with snow-capped mountains and crystal-clear lakes stretching as far as the eye could see.\r\n\r\n#### **Second day**\r\n\r\nAfter a night in National Park, I continued south on the train to Wellington, the capital of New Zealand. This leg of the journey was equally scenic, with the train winding its way through the mountains and along the coast. The train was equipped with comfortable seating and a dining car, where I was able to enjoy a delicious meal while taking in the stunning views.\r\n\r\n#### **My thoughts**\r\n\r\nOverall, my experience traveling through New Zealand on a railcar was unforgettable. The scenery was stunning, the train was comfortable and well-appointed, and the people I met along the way were friendly and welcoming. I would highly recommend this mode of travel to anyone looking to explore the natural beauty of New Zealand in a unique and memorable way.', 'New Zealand', 'Europe', 'uploads/f542793d2fbd3436b90abd6e92730bf0ab832298.jpg', 'New Zealand,happy,visit,railcar', 1686752018960, 8),
(20, 151567889, 'The UK Travel Guide -- by locals', 'Bus and building of the UK', 'Mysterious and compelling, Stonehenge is England\'s most iconic ancient site. People have been drawn to this myth-laden ring of boulders for more than 5000 years, and we still don\'t know quite why it was built. Just what were ancient Britons playing at when they hauled these giant stones into place all those millennia ago? Stonehenge, on Salisbury Plain near Amesbury, is a monumental, undeniably mind-boggling achievement.', 'United Kingdom', 'Europe', 'uploads/50681fb22f2eb30f638bd478de4b1b10ae409387aa80ca8a49757103131eddfa.jpg', 'UK', 1686752018960, 8),
(21, 151567889, 'Let\'s go to Korea next year?', 'Witness where your idol lives!', 'Going up the Namsan Tower in Seoul is one of the top things to do in South Korea for many travelers.\r\n\r\nYou do have to do quite a bit of hiking before you reach the lifts that take you up to the top of the tower.\r\n\r\nWhen you reach the top you will see an area full of locks! They are locks of love and thousands of people have left a lock for their loved ones up there.\r\n\r\nThere’s a separate lift that will take you even further up the tower where you can have a fancy dinner overlooking the entire city at the revolving restaurant. It’s beautiful! The restaurant is not cheap as you can imagine, but if it fits your budget it’s well worth it. ', 'Korea', 'Asia', 'uploads/2d880b230b47ae446abdaed6ecef966f7c104c180ca82a686446c9f85f843243.jpg', 'Korea', 1686752018960, 8),
(22, 151567889, 'Japan', 'Good place to visit! Lots of fun places to go.', 'Soaking in a remote onsen while the snow falls around you is one of the most magical experiences you can have in Japan, and makes braving the cold all the more worthwhile. It’s one of our favorite things about winter in Japan.\r\n\r\nCombined with a stay in a traditional ryokan (Japanese-style inn), and you have all the makings of an unforgettable trip. For more ryokan inspiration, see our Luxury Ryokans & the Japanese Countryside sample trip.', 'Japan', 'Japan', 'uploads/4fee7990f63a47786f13d807c71a990e1caaa9aaace0d40993fa5893b854acd3.jpg', 'Japan', 1686752018960, 8),
(23, 123456789, 'Sawadeekap Thailand!', 'Enjoy your tropical holidays here!', 'One of the most recommended things to do on your Bangkok holiday is visiting the Floating Markets. Have a delightful experience of sailing to one of the floating markets near Bangkok in those charming boats where you can shop local fruits and souvenirs and feast upon authentic Thai cuisine in one of the floating restaurants in the market. Taling Chan and Khlong Lat Mayom are two of the floating markets within Bangkok city limits.', 'Thailand', 'Asia', 'uploads/3f86f9d97f5a02861c52777fa5cf32836f0ba9f1.jpg', 'Thailand', 1687096753740, 5),
(24, 234567891, 'Expect the Unexpected Indonesia', 'explore the beauty Indonesia has to offer!', 'I do not know if you\'ve had the opportunity to dive, but believe me: it\'s an otherworldly experience. I am not the most experienced diver, but I have done dives in Thailand, Fiji, Australia and several other countries. However, it was on the island of [**alor**](https://www.indonesia.travel/gb/en/destinations/bali-nusa-tenggara/alor-island) that I found my favorite diving spot. The Anemone Valley is simply the location with the highest concentration of anemones, and consequently clown fish. No words to describe!', 'Indonesia', 'Asia', 'uploads/77fb1917192c2eba4d06d68dc0d21819c0f9ccdc.jpg', 'Indonesia', 1687098298551, 2),
(25, 345678912, 'Egypt: The Golden Dunes', 'Top 8 Unsolved Mysteries', 'The [pyramids](https://www.touristegypt.com/giza-pyramids/) are at the top of everyone’s bucket list, but exploring the plateau on horseback is really something else. Horses have been a large part of Egyptian life since around 1700 BC, and were traditionally used for chariots. Additionally, they were viewed as an expression of power and romance. Visiting on horseback means uninterrupted peace. With a clear view of the pyramids and tourists miles from sight, there’s no better way to soak up Egypt. Consider this excursion before or after your [Best of Ancient Cairo Tour](https://www.touristegypt.com/tours/best-of-ancient-cairo-tour/).', 'Egypt', 'Africa', 'uploads/84c4f0b2da532a16d3dd823b9cd9e7c1941b31b6.jpg', 'Egypt', 1687099931839, 1);

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
(123456789, 20, 3),
(123456789, 21, 4),
(123456789, 22, 5),
(123456789, 23, 3),
(151567889, 20, 3),
(151567889, 21, 4),
(151567889, 22, 5),
(234567891, 20, 3),
(234567891, 21, 3),
(234567891, 22, 5),
(234567891, 23, 1),
(345678912, 20, 3),
(345678912, 21, 4),
(345678912, 22, 4),
(345678912, 23, 4),
(345678912, 24, 5),
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
(123456789, 'derrick_phang', '$2a$12$NLvUlEh8KBjXhy770j.oAOjWqiI14HC4aM/ZExCXrY6XEvM220hD.', 'uploads/a321df2d5e905638a47176c5d418afe6078ca6ac.jpg', 'a coder and a traveler.', 'Phang', 'phang@email.com', '019-8765432', NULL),
(151567889, 'test', '$2y$12$fjGir6yr2LtvY.6p/QmauODakN89ZhBR8.UelDNbT1/ZqUKMJqNYy', 'uploads/cb56752477cae6405f85b131872c60d21b967c6a.jpg', NULL, 'Tester', 'test@gmail.com', NULL, NULL),
(234567891, 'bryan_phang', '$2a$12$/cN0FHpgebsidiF4xk.oYO.j4H600GqCh5xPOLUv1VUxJAiDLtS2y', 'uploads/aaec5a8dfdcc991b6f7be67860fb291a4d61c4b6.jpg', 'happy-go-lucky, sunshine everywhere~', 'Bryan', 'bryan@email.com', '013-4567892', NULL),
(345678912, 'alvinOK', '$2a$12$fO5QlUPelySIa1nzWbpki.BfCdLFg12Uxlfbo4oZhbzCSZJIDeSTq', 'uploads/1c50961a70ef249034fd5a65a6bc73fca7148309.png', 'Now you see me, now you don\'t.', 'Alvin', 'alvin@email.com', '014-5678923', NULL),
(573006510, 'test2', '$2y$12$ksHGI7zzfMyxvlR61N90xezemN5fvQoDoC2xY99WagSaaZl19zvJu', NULL, NULL, 'Test2', 'test@gmail.co', NULL, NULL),
(2147483647, 'test3', '$2y$12$uSaw8pg6UXH7HpQsXmTxDegi6L1YrdzZ2vFiAIJt4QUHNp.v69lw.', 'uploads/e5ad2c3df87061a3f41aae84e2343dfc84d34be6.jpg', 'I like to travel around the world during my holidays!', 'Test3', 'abc@xyz.co', '012-3456789', NULL);

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
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postid` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
