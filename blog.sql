-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 02, 2024 at 07:36 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `description`) VALUES
(1, 'Food', 'This is food category'),
(2, 'Uncategorized', 'This is uncategorised section'),
(7, 'Gaming', 'this is gaming category'),
(8, 'Movies', 'Movies category'),
(9, 'Science &amp; Technology', 'This is Science &amp; Technology category'),
(10, 'Travel', 'this is travel category'),
(12, 'Music ', 'This is music category');

-- --------------------------------------------------------

--
-- Table structure for table `momopay`
--

DROP TABLE IF EXISTS `momopay`;
CREATE TABLE IF NOT EXISTS `momopay` (
  `id_momo` int NOT NULL AUTO_INCREMENT,
  `partner_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_order` int NOT NULL,
  `amount` varchar(50) NOT NULL,
  `order_info` varchar(100) NOT NULL,
  `order_type` varchar(50) NOT NULL,
  `id_trans` int NOT NULL,
  `pay_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id_momo`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `momopay`
--

INSERT INTO `momopay` (`id_momo`, `partner_code`, `id_order`, `amount`, `order_info`, `order_type`, `id_trans`, `pay_type`) VALUES
(1, 'MOMOBKUN20180529', 1733117497, '100000', 'Thanh toán qua ATM MoMo', 'momo_wallet', 2147483647, 'napas'),
(2, 'MOMOBKUN20180529', 1733117497, '100000', 'Thanh toán qua ATM MoMo', 'momo_wallet', 2147483647, 'napas');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` int UNSIGNED DEFAULT NULL,
  `author_id` int UNSIGNED NOT NULL,
  `is_featured` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_blog_category` (`category_id`),
  KEY `FK_blog_author` (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `body`, `thumbnail`, `date_time`, `category_id`, `author_id`, `is_featured`) VALUES
(21, 'Super Mario: The Timeless Classic', 'Super Mario is an iconic character and one of the most beloved video game franchises of all time. Created by Nintendo&#039;s Shigeru Miyamoto, the game was first released in 1985 and has since become a cultural phenomenon. Its popularity has endured for almost four decades, and it continues to captivate audiences of all ages.\r\n\r\nThe game&#039;s protagonist, Mario, is a plumber who embarks on a quest to rescue Princess Toadstool from the evil Bowser. Along the way, he must navigate through a series of obstacles and enemies, collecting coins and power-ups to help him on his journey. The game&#039;s simple yet challenging gameplay has made it a favorite among gamers of all ages.\r\n\r\nOne of the game&#039;s defining features is its colorful and vibrant world, which is filled with memorable characters and locations. From the Mushroom Kingdom to Bowser&#039;s Castle, each level is distinct and offers unique challenges. The game&#039;s soundtrack is also iconic, with catchy tunes that are instantly recognizable to anyone who has played the game.\r\n\r\nSuper Mario&#039;s success can be attributed to its accessibility and universal appeal. The game is easy to pick up and play, but it also offers a level of challenge that keeps players engaged. The character of Mario himself is also a major factor in the game&#039;s popularity. With his signature red hat and mustache, he has become one of the most recognizable figures in pop culture.\r\n\r\nOver the years, Super Mario has spawned numerous sequels and spin-offs, including Super Mario Bros. 2, Super Mario Bros. 3, Super Mario World, and Super Mario 64. Each game has introduced new elements and mechanics while still maintaining the core gameplay that made the original so successful.\r\n\r\nIn addition to its impact on the video game industry, Super Mario has also had a significant cultural impact. The character has appeared in countless forms of media, including cartoons, movies, and even theme parks. The game&#039;s influence can be seen in everything from fashion to music, and it has inspired countless other video games over the years.\r\n\r\nIn conclusion, Super Mario is a timeless classic that has earned its place in the pantheon of video game greats. Its simple yet challenging gameplay, vibrant world, and iconic characters have captured the hearts of gamers around the world. It&#039;s hard to imagine a world without Super Mario, and we can only hope that the franchise will continue to delight and inspire new generations of gamers for many years to come.', '1677835502blog102.jpg', '2023-03-03 09:25:02', 7, 5, 0),
(22, 'AI Robots: The Current State of Progress', 'Artificial Intelligence (AI) has come a long way in recent years, and nowhere is this more evident than in the field of robotics. Advances in machine learning and computer vision have enabled robots to perform increasingly complex tasks, from manufacturing and assembly to healthcare and hospitality. In this blog post, we&#039;ll take a look at some of the current progress in AI robots and explore the potential applications of this technology.\r\n\r\n    Manufacturing and Assembly\r\n\r\nOne of the most well-established applications of AI robots is in manufacturing and assembly. Robots can perform repetitive tasks with speed and precision, improving efficiency and reducing errors. AI-powered robots can also adapt to changes in the production line, making them more versatile than traditional industrial robots.\r\n\r\n    Healthcare\r\n\r\nAI robots are also making inroads in the healthcare industry. Robots can assist doctors and nurses in a variety of tasks, from patient monitoring to surgery. They can also help patients with mobility issues, providing assistance with tasks such as getting out of bed or moving around the hospital.\r\n\r\n    Hospitality\r\n\r\nAnother area where AI robots are making an impact is in hospitality. Robots can be used to greet guests, provide information about the hotel, and even deliver room service. They can also perform housekeeping tasks, such as cleaning and restocking rooms.\r\n\r\n    Agriculture\r\n\r\nAI robots are also being used in agriculture, where they can perform tasks such as planting and harvesting crops. They can also be used to monitor crop health and identify areas that require attention.\r\n\r\n    Education\r\n\r\nAI robots are also being used in education. Robots can be used to provide personalized learning experiences for students, adapting to their individual needs and preferences. They can also be used to teach coding and other STEM subjects.\r\n\r\nIn conclusion, AI robots have come a long way in recent years, and their potential applications are vast. From manufacturing and assembly to healthcare and hospitality, robots are already making an impact in a variety of industries. As machine learning and computer vision continue to advance, we can expect to see even more sophisticated AI robots in the years to come, helping to improve efficiency, safety, and quality of life for people around the world.', '1677835638blog15.jpg', '2023-03-03 09:27:18', 8, 6, 0),
(23, 'Advancements in VR: The Future of Immersive Gaming', 'One of the most popular and well-known applications of VR is in gaming. VR games provide a highly immersive experience, transporting players to a virtual world where they can interact with their surroundings in a way that traditional video games can&#039;t match. Here are some ways that VR is advancing the gaming industry:\r\n\r\n    Immersive gameplay\r\n\r\nVR gaming provides players with a level of immersion that traditional games cannot match. With VR, players can be fully immersed in a virtual world and interact with it in a way that feels natural. They can use their hands to pick up objects, explore new environments, and experience gameplay that is unlike anything else.\r\n\r\n    Unique game mechanics\r\n\r\nVR gaming allows for unique game mechanics that can&#039;t be replicated in traditional video games. For example, in Beat Saber, players use motion controllers to slash and dodge incoming blocks to the beat of a song. The sense of physically moving to dodge obstacles or interacting with objects in a virtual world creates an incredibly unique gaming experience.\r\n\r\n    Realistic environments\r\n\r\nVR allows game developers to create highly detailed and realistic environments, immersing players in a world that feels alive. The use of 3D audio and realistic lighting adds to the sense of immersion, creating an experience that feels like a real-world environment.\r\n\r\n    Multiplayer capabilities\r\n\r\nVR gaming also has the potential to revolutionize multiplayer gaming. VR headsets allow for full-body tracking, meaning that players can interact with each other in a virtual space. This opens up possibilities for multiplayer experiences that feel like real-life interactions.\r\n\r\n    New ways to tell stories\r\n\r\nVR also provides new ways to tell stories. For example, games like The Walking Dead: Saints &amp; Sinners use VR to create a highly immersive narrative experience. By placing players in a virtual world, they can become fully invested in the story, interacting with the environment and characters in a way that traditional games can&#039;t replicate.\r\n\r\nIn conclusion, VR is advancing the gaming industry by providing players with a highly immersive and unique experience. With the continued development of hardware and software, we can expect to see even more exciting VR games in the future.', '1677835859blog20.jpg', '2023-03-03 09:30:59', 7, 7, 0),
(24, 'Takoyaki: A Delicious Japanese Street Food', 'Takoyaki is a popular Japanese street food that has become increasingly popular around the world. These savory balls of batter are typically filled with diced octopus and other ingredients, and are cooked on a special griddle until golden brown. In this blog post, we&#039;ll explore the history and ingredients of takoyaki, and explain how to make this delicious snack at home.\r\n\r\nHistory of Takoyaki\r\n\r\nTakoyaki originated in Osaka, Japan in the 1930s. A street vendor named Tomekichi Endo created the dish by combining bits of octopus and other ingredients with batter and cooking them in a specialized iron griddle. The dish quickly became popular, and today takoyaki is sold in food stalls and restaurants all over Japan.\r\n\r\nIngredients of Takoyaki\r\n\r\nTakoyaki is typically made with a batter consisting of flour, eggs, dashi (Japanese fish stock), and water. Other ingredients that can be added to the batter include green onion, pickled ginger, and tenkasu (tempura scraps). The filling of the takoyaki is usually diced octopus, but other seafood or meat can also be used.\r\n\r\nMaking Takoyaki at Home\r\n\r\nMaking takoyaki at home requires a special takoyaki griddle, which can be purchased at Japanese specialty stores or online. Here is a basic recipe for making takoyaki at home:\r\n\r\nIngredients:\r\n\r\n    1 cup flour\r\n    1 egg\r\n    1 tsp. baking powder\r\n    1 tsp. soy sauce\r\n    1 tsp. sugar\r\n    1 1/2 cups dashi (Japanese fish stock)\r\n    1/2 cup diced octopus\r\n    1/4 cup chopped green onion\r\n    1/4 cup tenkasu (tempura scraps)\r\n    Takoyaki sauce\r\n    Mayonnaise\r\n    Aonori (dried seaweed flakes)\r\n    Katsuobushi (dried bonito flakes)\r\n\r\nInstructions:\r\n\r\n    In a bowl, whisk together the flour, egg, baking powder, soy sauce, and sugar.\r\n    Slowly add the dashi, whisking until the batter is smooth.\r\n    Heat the takoyaki griddle over medium-high heat, and lightly oil the molds.\r\n    Fill each mold with batter until it is about 80% full.\r\n    Add a few pieces of diced octopus, green onion, and tenkasu to each mold.\r\n    Use a skewer to flip the takoyaki as it cooks, until it is golden brown on all sides.\r\n    Remove the takoyaki from the griddle, and top with takoyaki sauce, mayonnaise, aonori, and katsuobushi.\r\n\r\nIn conclusion, takoyaki is a delicious Japanese street food that has become a favorite of people all around the world. While it may seem intimidating to make at home, with a little practice and a takoyaki griddle, anyone can enjoy this savory snack in the comfort of their own home.\r\n', '1677836026blog13.jpg', '2023-03-03 09:33:46', 1, 8, 0),
(25, 'Artificial Intelligence and Chess', 'Artificial Intelligence and Chess: A Match Made in Heaven\r\n\r\nArtificial intelligence (AI) has made significant strides in the past few decades and has been increasingly utilized in various fields, including gaming. One game that has been a favorite among AI researchers is chess, due to its complexity and the challenge it presents.\r\n\r\nChess is a board game played between two players, where each player has 16 pieces that can move in different ways to attack and defend. The goal of the game is to checkmate the opponent&#039;s king, which means to put it in a position where it is under attack and cannot escape capture. There are over 10^120 possible moves in chess, making it impossible for humans to calculate all possible moves and outcomes.\r\n\r\nAI has been able to defeat some of the best human chess players in the world, including Garry Kasparov and Magnus Carlsen. This has been achieved through the development of various AI algorithms, such as deep learning, reinforcement learning, and genetic algorithms. These algorithms have been used to train neural networks to evaluate the board state and make optimal moves.\r\n\r\nOne notable AI algorithm is AlphaZero, developed by Google&#039;s DeepMind. AlphaZero is a self-taught AI system that learned to play chess, shogi, and Go through self-play. AlphaZero&#039;s approach is based on Monte Carlo tree search and neural networks, which allows it to evaluate the board state and search for the best moves. AlphaZero was able to defeat the world&#039;s strongest chess engines in a 100-game match, winning 28 games and drawing 72.\r\n\r\nAI has also been used to analyze chess games and provide insights into the game. Chess.com&#039;s analysis tool, powered by Stockfish (an open-source chess engine), uses AI to analyze games and provide feedback on the best moves and strategies.\r\n\r\nAI has revolutionized the game of chess, providing a new level of insight and understanding into the game. It has also opened up new possibilities for the development of AI systems that can learn to play other complex games and solve complex problems. Chess remains an important testbed for AI research and development, and the future looks bright for the continued integration of AI into the game.', '1678235660blog17.jpg', '2023-03-08 00:34:20', 9, 9, 0),
(26, 'Exploring the World: A Journey', 'There&#039;s something magical about watching the sun set on the horizon, and taking the time to appreciate the beauty of nature. From the vibrant colors to the peaceful atmosphere, it&#039;s a moment that can leave a lasting impression. That&#039;s why we&#039;re taking you on a virtual journey around the world to experience some of the most stunning sunsets from different locations.\r\n\r\nWe begin our journey in Bali, Indonesia, where the sunsets over the ocean are truly breathtaking. With a perfect view of the sun setting behind the rolling waves, it&#039;s no wonder Bali is often referred to as the &quot;Island of the Gods&quot;. As the sky turns from bright orange to deep purple, it&#039;s easy to feel a sense of peace and awe.\r\n\r\nNext, we move on to Tokyo, Japan, where the sunset over the city skyline is a beautiful contrast to the busy streets below. From the top of a skyscraper, the sun seems to melt into the buildings, creating a surreal and almost otherworldly scene. As the sky turns from pink to orange to red, the cityscape transforms into a beautiful painting.\r\n\r\nIn Santorini, Greece, the sunset over the caldera is a sight that many consider to be one of the most beautiful in the world. The combination of the white-washed buildings and the deep blue sea creates a perfect backdrop for the sun to set against. As the sky turns from yellow to pink to purple, the caldera takes on a whole new level of beauty.\r\n\r\nWe end our journey in the American Southwest, where the sunsets over the desert are unlike anything else. The way the sun illuminates the red rock formations of Sedona, Arizona or the Grand Canyon, creates a striking contrast that has to be seen to be believed. As the sky turns from orange to red to deep blue, the landscape seems to come alive.\r\n\r\nFrom Bali to Tokyo, Santorini to the American Southwest, the world is full of stunning sunsets that leave a lasting impression. Whether you&#039;re able to witness these sights in person or just through pictures, take a moment to appreciate the beauty and wonder of nature.\r\n', '1678235943blog7.jpg', '2023-03-08 00:39:03', 1, 8, 0),
(27, ' Loy Krathong: A Celebration of Water and Light', 'Loy Krathong is an ancient and beloved festival in Thailand that celebrates the importance of water and light in our lives. From the floating of krathongs down the river to the release of paper lanterns into the sky, this festival is a magical experience that brings people together to honor the goddess of water and let go of negative emotions.\r\n\r\nIn this festival, participants make offerings of krathongs, small baskets made of banana leaves, that are filled with flowers, candles, and incense. The krathongs are then released onto the water and floated away, symbolizing the release of negativity and the letting go of worries. Along with the krathongs, paper lanterns are released into the sky, creating a beautiful and mesmerizing sight that represents the hope for good luck and a bright future.\r\n\r\nThe history of Loy Krathong can be traced back to the Sukhothai period over 700 years ago, and it has since become a significant festival in Thailand. It&#039;s a time for people to come together, celebrate, and give thanks for the abundance of water that&#039;s so important to life in the country. Loy Krathong is also an opportunity to taste traditional foods, watch cultural performances, and take part in beauty contests, fireworks displays, and boat races.\r\n\r\nLoy Krathong is truly a celebration of water and light, and it&#039;s a beautiful and meaningful experience that should not be missed. Whether you&#039;re a local or a visitor, this festival is a chance to connect with the community, show gratitude, and experience the beauty of Thailand&#039;s waterways. So, if you&#039;re ever in Thailand during the full moon of the twelfth lunar month, join in on this unforgettable celebration of water and light.', '1678236380blog18.jpg', '2023-03-08 00:46:20', 10, 10, 0),
(29, 'Bionic Arms: The Future', 'Bionic arms are one of the most exciting and promising developments in the field of prosthetics. These high-tech devices are designed to replace missing or damaged limbs, providing amputees with greater mobility and independence than ever before.\r\n\r\nBionic arms work by using sensors that detect muscle movements in the remaining portion of the amputee&#039;s limb. These sensors send signals to a small computer processor located inside the prosthetic arm. The computer then translates these signals into movements of the bionic arm, allowing the user to control the arm with their mind.\r\n\r\nOne of the key advantages of bionic arms is that they offer a greater range of motion than traditional prosthetics. With a bionic arm, amputees can perform a wide variety of tasks that were previously impossible, such as holding and manipulating delicate objects or reaching for items on high shelves.\r\n\r\nIn addition, bionic arms are designed to be more comfortable and user-friendly than traditional prosthetics. They are typically made from lightweight materials that are easy to wear for extended periods of time. Many bionic arms also feature advanced cooling systems that prevent overheating, making them much more comfortable to wear in warm weather.\r\n\r\nPerhaps the most exciting aspect of bionic arms is their potential for future development. As technology continues to advance, bionic arms are likely to become even more advanced and capable. We may one day see bionic arms that are fully integrated with the nervous system, providing users with even greater control and flexibility.\r\n\r\nIn conclusion, bionic arms represent a significant advancement in the field of prosthetics. These high-tech devices offer amputees greater mobility and independence than ever before, and they are designed to be comfortable, user-friendly, and highly capable. As technology continues to evolve, bionic arms are likely to become even more advanced and capable, offering even greater benefits to those who rely on them.\r\n', '1678237466blog2.jpg', '2023-03-08 01:04:26', 1, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `full_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `full_name`, `username`, `email`, `password`, `avatar`, `is_admin`) VALUES
(5, 'Joe', 'Doel', 'Joe Doel', 'Joe', 'admin@gmail.com', '$2y$10$HmLylBfWfOsig0j3CRwhBOlvMMkBInPdLiMALmIT3RWFNnOx4QrE.', '1677834448avatar15.jpg', 1),
(6, 'Jo', 'Doe', 'Jo Doe', 'Joel', 'joemon@gmail.com', '$2y$10$HmLylBfWfOsig0j3CRwhBOlvMMkBInPdLiMALmIT3RWFNnOx4QrE.', '1677835117avatar7.jpg', 0),
(7, 'Gogo', 'PowerRangers', 'Gogo PowerRangers', 'GogoPoweRangers', 'gogopowerrangers@gmail.com', '$2y$10$1rNxyIx3VXbH1RbGkqFWne6j21ksd1JCJHqD4uZZmsrWYgA1IQ6bq', '1677835680avatar3.jpg', 0),
(8, 'Ernest', 'Achiever', 'Ernest Achiever', 'Ernest', 'ernes@gmail.com', '$2y$10$8Uio8tlnKrPzKFbxvBmVueb3Dr7oyuRD0kmqGlvIGZPkuFgAdk79W', '1677835925avatar1.jpg', 0),
(9, 'Aster', 'Kennedy ', 'Aster Kennedy ', 'asterkennedy', 'asterkennedy@gmail.com', '$2y$10$1VrsN/8gppd5pwurNZwX9.3Fg00LJaFt/kNNB0o1yCSe2ladshMbK', '1678235515avatar9.jpg', 0),
(10, 'Jane', 'Supper', 'Jane Supper', 'notjane', 'not@jane.com', '$2y$10$pmLtiVTcC38W5ai07O2K6uRucCU59TE9JpUmIQuNloGhqJqzACeJC', '1678236024avatar4.jpg', 0),
(12, 'James', 'Moriarty', 'James Moriarty', 'jamesmoriarty@123', 'jamesmoriarty@gmail.com', '$2y$10$PrVXNnS1uODK13PtYY7uUeNK3MRbh37xitF8dzfXB.Gax7cdEi8WG', '1678249230avatar13.jpg', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `FK_blog_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_blog_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
