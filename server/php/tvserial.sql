-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Час створення: Бер 11 2019 р., 12:08
-- Версія сервера: 8.0.13
-- Версія PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `tvserial`
--

-- --------------------------------------------------------

--
-- Структура таблиці `episode`
--

CREATE TABLE `episode` (
  `episodeId` int(10) UNSIGNED NOT NULL,
  `episodeName` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `episodeNumber` int(10) UNSIGNED NOT NULL,
  `tvShowId` int(10) UNSIGNED NOT NULL,
  `seasonId` int(10) UNSIGNED NOT NULL,
  `longDescription` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `shortDescription` varchar(255) NOT NULL,
  `featuredImage` varchar(255) NOT NULL,
  `publishDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastModifiedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `videoFragmentUrl` varchar(255) NOT NULL,
  `usersRating` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `episode`
--

INSERT INTO `episode` (`episodeId`, `episodeName`, `episodeNumber`, `tvShowId`, `seasonId`, `longDescription`, `shortDescription`, `featuredImage`, `videoFragmentUrl`, `usersRating`) VALUES
(1, 'Pilot', 1, 1, 1, 'A pair of socially awkward theoretical physicists meet their new neighbor Penny, who is their polar opposite.', 'Story by : Chuck Lorre & Bill Prady.', 'sh1s1ep1.jpg', 'https://www.youtube.com/embed/tiw1eYLr2yY', NULL),
(2, 'The Big Bran Hypothesis', 2, 1, 1, 'Penny is furious with Leonard and Sheldon when they sneak into her apartment and clean it while she is sleeping.', 'Story by : Chuck Lorre & Bill Prady.', 'sh1s1ep2.jpg', 'https://www.youtube.com/embed/sIsy8BeunYE', NULL),
(3, 'The Fuzzy Boots Corollary', 3, 1, 1, 'Leonard gets upset when he discovers that Penny is seeing a new guy, so he tries to trick her into going on a date with him.', 'Story by : Chuck Lorre.', 'sh1s1ep3.jpg', 'https://www.youtube.com/embed/AXTkfaCFQBc', NULL),
(4, 'The Luminous Fish Effect', 4, 1, 1, 'Sheldon\'s mother is called to intervene when he delves into numerous obsessions after being fired for being disrespectful to his new boss.', 'Story by : Chuck Lorre & Bill Prady.', 'sh1s1ep4.jpg', 'https://www.youtube.com/embed/XAkgjadgQ2M', NULL),
(5, 'The Hamburger Postulate', 5, 1, 1, 'Leslie seduces Leonard, but afterwards tells him that she is only interested in a one-night stand.', 'Story by : Jennifer Glickman.', 'sh1s1ep5.jpg', 'https://www.youtube.com/embed/3pquYN2xbP4', NULL),
(6, 'The Middle Earth Paradigm', 6, 1, 1, 'The guys are invited to Penny\'s Halloween party, where Leonard has yet another run-in with Penny\'s ex-boyfriend Kurt.', 'Story by : Dave Goetsch.', 'sh1s1ep6.jpg', 'https://www.youtube.com/embed/doK61yMEHg4', NULL),
(7, 'The Dumpling Paradox', 7, 1, 1, 'When Howard hooks up with Penny\'s old friend, his absence in the gang causes problems for the rest of the guys.', 'Story by : Chuck Lorre & Bill Prady.', 'sh1s1ep7.jpg', 'https://www.youtube.com/embed/7E9Lo5gB8fo', NULL),
(8, 'The Grasshopper Experiment', 8, 1, 1, 'When Raj\'s parents set him up on a blind date, he finds he can talk to women with the aid of alcohol.', 'Story by : Dave Goetsch & Steven Molaro.', 'sh1s1ep8.jpg', 'https://www.youtube.com/embed/_AK3Ab6G6Gc', NULL),
(9, 'The Cooper-Hofstadter Polarization', 9, 1, 1, 'Leonard and Sheldon\'s friendship is put to the test when Leonard wants to present a paper they co-authored at a physics convention, but Sheldon doesn\'t.', 'Story by : Bill Prady & Stephen Engel.', 'sh1s1ep9.jpg', 'https://www.youtube.com/embed/wjNNCannBwM', NULL),
(10, 'The Bad Fish Paradigm', 1, 1, 2, 'Leonard becomes concerned when his date with Penny ends abruptly and she starts blowing him off. When told the truth, Sheldon would rather move out than keep Penny\'s reasons a secret from Leonard.', 'Story by : Bill Prady.', 'sh1s2ep1.jpg', 'https://www.youtube.com/embed/YPoMFr20Tso', NULL),
(11, 'The Codpiece Topology', 2, 1, 2, 'Sheldon is annoyed when Leonard turns to Leslie for comfort after seeing Penny with another guy.', 'Story by : Chuck Lorre.', 'sh1s2ep2.jpg', 'https://www.youtube.com/embed/MY7UBjGBcMM', NULL),
(12, 'The Barbarian Sublimation', 3, 1, 2, 'Sheldon introduces Penny to online gaming, however she refuses to quit after becoming addicted.', 'Story by : Nicole Lorre.', 'sh1s2ep3.jpg', 'https://www.youtube.com/embed/GjDYiyN9Jzo', NULL),
(13, 'The Griffin Equivalency', 4, 1, 2, 'The guys struggle to cope with Raj\'s arrogance after he is featured in a People magazine article.', 'Story by : Bill Prady & Chuck Lorre.', 'sh1s2ep4.jpg', 'https://www.youtube.com/embed/KukfTCkqSaQ', NULL),
(14, 'The Euclid Alternative', 5, 1, 2, 'Sheldon annoys the gang when Leonard can\'t drive him to and from work, so they try to teach him how to drive.', 'Story by : Bill Prady & Steven Molaro.', 'sh1s2ep5.jpg', 'https://www.youtube.com/embed/-CMrC7QeLpA', NULL),
(15, 'The Cooper-Nowitzki Theorem', 6, 1, 2, 'Sheldon is flattered when a graduate student takes a shine to him, however her extreme devotion becomes too much to handle.', 'Story by : Stephen Engel & Daley Haggar.', 'sh1s2ep6.jpg', 'https://www.youtube.com/embed/LGTYWEiBLWM', NULL),
(16, 'The Panty Piñata Polarization', 7, 1, 2, 'Penny plans revenge when Sheldon bans her from his and Leonard\'s apartment, while Howard and Raj use the latest technology to try to find the house being used in \"America\'s Next Top Model.\"', 'Story by : Bill Prady & Tim Doyle.', 'sh1s2ep7.jpg', 'https://www.youtube.com/embed/w2vrDItEtCI', NULL),
(17, 'The Lizard-Spock Expansion', 8, 1, 2, 'Leonard and Howard\'s friendship is jeopardised when Leonard steals a girl from Howard.', 'Story by : Bill Prady.', 'sh1s2ep8.jpg', 'https://www.youtube.com/embed/iE-WYH10dHY', NULL),
(18, 'The Electric Can Opener Fluctuation', 1, 1, 3, 'After returning from the North Pole, a conflict among the guys sends Sheldon back to Texas and interferes with Leonard\'s reunion with Penny.', 'Story by : Steven Molaro.', 'sh1s3ep1.jpg', 'https://www.youtube.com/embed/7BlQv55bLxg', NULL),
(19, 'The Jiminy Conjecture', 2, 1, 3, 'Leonard and Penny\'s first night together goes awkwardly. Sheldon and Howard wager on the species of a cricket.', 'Story by : Jim Reynolds.', 'sh1s3ep2.jpg', 'https://www.youtube.com/embed/lqln1JTKBVY', NULL),
(20, 'The Gothowitz Deviation', 3, 1, 3, 'Sheldon attempts to covertly alter Penny\'s habits, while Howard and Raj try their luck meeting women at a Goth-style club.', 'Story by : Lee Aronsohn & Richard Rosenstock.', 'sh1s3ep3.jpg', 'https://www.youtube.com/embed/t-iGZecyFRA', NULL),
(21, 'The Pirate Solution', 4, 1, 3, 'When Raj has to find a new job or be sent back to India, Sheldon\'s solution leaves Leonard and Penny dealing with Howard as the third wheel.', 'Story by : Steve Holland.', 'sh1s3ep4.jpg', 'https://www.youtube.com/embed/gU2FxpOOxws', NULL),
(22, 'The Creepy Candy Coating Corollary', 5, 1, 3, 'Leonard is forced to ask Penny to set Howard up with one of her friends, while Sheldon seeks payback against sci-fi star Wil Wheaton.', 'Story by : Chuck Lorre & Bill Prady.', 'sh1s3ep5.jpg', 'https://www.youtube.com/embed/m1lbr_L9vNA', NULL),
(23, 'The Cornhusker Vortex', 6, 1, 3, 'Leonard tries to learn about football to fit in with Penny\'s friends. Meanwhile, a loss in a kite war threatens to end Raj and Howard\'s friendship.', 'Story by : Bill Prady & Steven Molaro.', 'sh1s3ep6.jpg', 'https://www.youtube.com/embed/Lb3yt8VeDOw', NULL),
(24, 'The Guitarist Amplification', 7, 1, 3, 'Sheldon is caught in the middle when Leonard and Penny argue about Penny\'s friend staying at her apartment.', 'Story by : Chuck Lorre & Lee Aronsohn.', 'sh1s3ep7.jpg', 'https://www.youtube.com/embed/ZR53cQWdBjE', NULL),
(25, 'The Robotic Manipulation', 1, 1, 4, 'Penny ends up tagging along on Sheldon\'s first ever date with Amy, while Howard finds an unusual use for a robotic arm.', 'Story by : Chuck Lorre & Lee Aronsohn & Dave Goetsch ', 'sh1s4ep1.jpg', 'https://www.youtube.com/embed/OmHImtcSeMM', NULL),
(26, 'Pilot', 1, 2, 5, '9-year-old Sheldon Cooper learns that having a brilliant mind doesn\'t always help growing up in Texas.', 'Story by : Chuck Lorre & Steve Molaro.', 'sh2s1ep1.jpg', 'https://www.youtube.com/embed/QExayqLRk9E', NULL),
(28, 'Rockets, Communists, and the Dewey Decimal System', 2, 2, 5, 'To appease his worried mother, Sheldon employs the techniques of a self-help book to try and make a friend.', 'Story by : Chuck Lorre & Steven Molaro.', 'sh2s1ep2.jpg', 'https://www.youtube.com/embed/DV8DpEMw4c4', NULL),
(29, 'Poker, Faith and Eggs', 3, 2, 5, 'George Sr. is rushed to the emergency room; Meemaw comes to baby-sit; the kids have an adventure getting to the hospital on their own.', 'Story by : Damir Konjicija & Dario Konjicija.', 'sh2s1ep3.jpg', 'https://www.youtube.com/embed/ZhRvlGeGGI8', NULL),
(30, 'A Therapist, a Comic Book, and a Breakfast Sausage', 4, 2, 5, 'Sheldon fears solid food after choking on a sausage; Sheldon discovers his first comic book.', 'Story by : Chuck Lorre & Steven Molaro.', 'sh2s1ep4.jpg', 'https://www.youtube.com/embed/DxxpnNSKLJs', NULL),
(31, 'A Solar Calculator, a Game Ball, and a Cheerleader\'s Bosom', 5, 2, 5, 'Sheldon struggles with newfound popularity after utilizing statistics to help the football team. Georgie feels sidelined by Sheldon\'s Popularity.', 'Story by : Chuck Lorre & Steven Molaro.', 'sh2s1ep5.jpg', 'https://www.youtube.com/embed/Qns5Mztefx4', NULL),
(32, 'A Patch, a Modem, and a Zantac', 6, 2, 5, 'When Sheldon\'s suggestion on landing the rocket booster back is not taken seriously by a NASA scientist, he decides to pursue theoretical physics and works out the full details to prove his point.', 'Story by : Chuck Lorre & Steven Molaro.', 'sh2s1ep6.jpg', 'https://www.youtube.com/embed/cMBjfyN9hXA', NULL),
(33, 'A High-Pitched Buzz and Training Wheels', 1, 2, 6, 'Sheldon dismantles the refrigerator to stop an annoying hum, then gets a paper route to pay for the repairs.', 'Story by : Chuck Lorre & Steve Molaro.', 'sh2s2ep1.jpg', 'https://www.youtube.com/embed/i9TsHFma0i8', NULL),
(34, 'A Rival Prodigy and Sir Isaac Neutron', 2, 2, 6, 'Meemaw intervenes when Sheldon gets jealous of Dr. Sturgis bonding with Paige, another 10-year-old genius. In the meantime, Mary invites Paige\'s family over for a play date.', 'Story by : Chuck Lorre & Steven Molaro & David Bickel.', 'sh2s2ep2.jpg', 'https://www.youtube.com/embed/vxtk4IAJxo4', NULL),
(35, 'A Crisis of Faith and Octopus Aliens', 3, 2, 6, 'Sheldon becomes an unlikely ally when a tragedy in the community shakes Mary\'s faith', 'Story by : Chuck Lorre & David Bickel & Eric Kaplan ', 'sh2s2ep3.jpg', 'https://www.youtube.com/embed/PHKB4dQFfio', NULL),
(36, 'A Financial Secret and Fish Sauce', 4, 2, 6, 'When Sheldon\'s father asks him to keep a secret from Mary, the stress of not being honest drives him at Tam\'s for his first sleepover.', 'Story by : Chuck Lorre & David Bickel & Jeremy Howe.', 'sh2s2ep4.jpg', 'https://www.youtube.com/embed/qIaJ8Ya66V4', NULL),
(37, 'A Research Study and Czechoslovakian Wedding Pastries', 5, 2, 6, 'Dr. Sturgis recommends Sheldon and Missy for a university research study on twins, and Mary is unhappy when the test results go to Sheldon\'s head.', 'Story by : Steven Molaro & Damir Konjicija & Dario Konjicija.', 'sh2s2ep5.jpg', 'https://www.youtube.com/embed/_vqKBLNnkf4', NULL),
(38, 'Pilot', 1, 3, 7, 'India Eisely stars as Fauna Hodel, a naive girl growing up in mid-sixties Reno, Nevada, who embarks on a quest to discover who she really is. Meanwhile in Los Angeles, Jay Singletary, Chris Pine, a soldier recently returned from the Korean war, now a hack reporter, covers a gruesome murder.', 'Story by : Sam Sheridan.', 'sh3s1ep1.jpg', 'https://www.youtube.com/embed/0OqDHzMrvJU', NULL),
(39, 'Bad News', 1, 4, 8, 'Patrick learns of his father\'s passing and must travel to New York to collect his remains, whilst struggling with drug withdrawals.', 'Story by : David Nicholls.', 'sh4s1ep1.jpg', 'https://www.youtube.com/embed/oYy_lHF24T0', NULL),
(40, 'Pilot', 1, 5, 9, 'Zelda Sayre is a free-spirited and flamboyant 18-year-old woman living in Montgomery, Alabama, in the year 1918. Zelda wants a bigger and better life and she\'s on the look out for an escape route. Zelda\'s stern father, Anthony, tries to keep her flamboyance suppressed which only makes her challenge his authority. During an evening out at a going-away-dance for soldiers embarking to France to fight in World War I, Zelda meets novelist F. Scott Fitzgerald and is Zelda\'s intrigued by him quickly, but doesn\'t respond to his advances.', 'Story by : Dawn Prestwich, Nicole Yorkin.', 'sh5s1ep1.jpg', 'https://www.youtube.com/embed/hL3WZgsvnLU', NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `rating`
--

CREATE TABLE `rating` (
  `ratingId` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `tvShowId` int(10) UNSIGNED DEFAULT NULL,
  `seasonId` int(10) UNSIGNED DEFAULT NULL,
  `episodeId` int(10) UNSIGNED DEFAULT NULL,
  `ratingValue` tinyint(3) UNSIGNED NOT NULL,
  `writeDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `rating`
--

INSERT INTO `rating` (`ratingId`, `userId`, `tvShowId`, `seasonId`, `episodeId`, `ratingValue`) VALUES
(1, 4, NULL, NULL, 38, 0),
(5, 4, 4, NULL, NULL, 1),
(6, 4, NULL, 8, NULL, 1),
(7, 4, NULL, NULL, 39, 2),
(8, 4, NULL, NULL, 39, 4),
(9, 4, 3, NULL, NULL, 1),
(10, 4, NULL, 7, NULL, 2),
(11, 4, NULL, NULL, 38, 0),
(12, 4, 6, NULL, NULL, 3),
(13, 4, NULL, 10, NULL, 4),
(14, 4, 2, NULL, NULL, 5),
(15, 4, 2, NULL, NULL, 4),
(16, 4, NULL, 5, NULL, 5),
(17, 4, NULL, 5, NULL, 4),
(18, 4, NULL, 5, NULL, 5),
(19, 4, 1, NULL, NULL, 5),
(20, 4, 1, NULL, NULL, 4),
(21, 4, 1, NULL, NULL, 4),
(22, 4, 1, NULL, NULL, 4),
(23, 4, NULL, 1, NULL, 5),
(24, 4, NULL, 1, NULL, 4),
(25, 4, NULL, 2, NULL, 5),
(26, 4, NULL, 2, NULL, 4),
(27, 4, NULL, 2, NULL, 4),
(28, 4, NULL, 4, NULL, 5),
(29, 4, NULL, 3, NULL, 5),
(30, 4, NULL, 6, NULL, 5),
(31, 4, 5, NULL, NULL, 2),
(32, 4, 5, NULL, NULL, 3),
(33, 4, 5, NULL, NULL, 2),
(34, 4, NULL, 9, NULL, 3),
(35, 4, NULL, 9, NULL, 1),
(36, 4, NULL, 9, NULL, 1),
(37, 4, NULL, NULL, 37, 5),
(38, 4, NULL, NULL, 37, 4),
(39, 4, NULL, NULL, 36, 5),
(40, 4, NULL, NULL, 36, 4),
(41, 4, NULL, 3, NULL, 5),
(42, 4, NULL, NULL, 26, 5),
(43, 4, NULL, NULL, 2, 5),
(44, 4, NULL, NULL, 3, 5),
(45, 4, NULL, NULL, 3, 4),
(46, 4, NULL, NULL, 4, 5),
(47, 4, NULL, NULL, 4, 4),
(48, 4, 3, NULL, NULL, 0),
(49, 4, NULL, NULL, 38, 0),
(50, 4, NULL, 8, NULL, 2),
(51, 4, NULL, NULL, 1, 5),
(52, 4, NULL, NULL, 2, 5),
(53, 4, NULL, NULL, 3, 5),
(54, 4, NULL, NULL, 4, 4),
(55, 4, NULL, NULL, 5, 4),
(56, 4, NULL, NULL, 6, 5),
(57, 4, NULL, NULL, 7, 5),
(58, 4, NULL, NULL, 8, 5),
(59, 4, NULL, NULL, 9, 5),
(60, 4, NULL, NULL, 6, 5),
(61, 4, NULL, 1, NULL, 5),
(62, 4, NULL, NULL, 10, 5),
(63, 4, NULL, NULL, 10, 4),
(64, 4, NULL, NULL, 11, 5),
(65, 4, NULL, NULL, 12, 4),
(66, 4, NULL, NULL, 13, 5),
(67, 4, NULL, NULL, 14, 5),
(68, 4, NULL, NULL, 15, 4),
(69, 4, NULL, NULL, 16, 5),
(70, 4, NULL, NULL, 17, 5),
(71, 4, NULL, NULL, 18, 4),
(72, 4, NULL, NULL, 19, 5),
(73, 4, NULL, NULL, 20, 5),
(74, 4, NULL, NULL, 22, 5),
(75, 4, NULL, NULL, 24, 5),
(76, 4, NULL, NULL, 23, 4),
(77, 4, NULL, NULL, 21, 5),
(78, 4, NULL, NULL, 25, 5),
(79, 4, NULL, NULL, 26, 5),
(80, 4, NULL, NULL, 28, 5),
(81, 4, NULL, NULL, 29, 5),
(82, 4, NULL, NULL, 30, 5),
(83, 4, NULL, NULL, 31, 4),
(84, 4, NULL, NULL, 32, 5),
(85, 4, NULL, NULL, 33, 5),
(86, 4, NULL, NULL, 34, 5),
(87, 4, NULL, NULL, 35, 5),
(88, 4, NULL, NULL, 36, 5),
(89, 4, NULL, NULL, 37, 5),
(90, 4, NULL, NULL, 40, 3),
(91, 4, NULL, NULL, 40, 2),
(92, 4, NULL, NULL, 20, 4),
(93, 4, NULL, NULL, 20, 5),
(94, 4, NULL, NULL, 22, 1),
(95, 4, NULL, 3, NULL, 4),
(96, 4, NULL, NULL, 33, 3);

-- --------------------------------------------------------

--
-- Структура таблиці `season`
--

CREATE TABLE `season` (
  `seasonId` int(10) UNSIGNED NOT NULL,
  `seasonName` varchar(50) NOT NULL,
  `seasonNumber` tinyint(3) UNSIGNED NOT NULL,
  `tvShowId` int(10) UNSIGNED NOT NULL,
  `longDescription` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `shortDescription` varchar(50) NOT NULL,
  `featuredImage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `publishDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastModifiedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `videoFragmentUrl` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `usersRating` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `season`
--

INSERT INTO `season` (`seasonId`, `seasonName`, `seasonNumber`, `tvShowId`, `longDescription`, `shortDescription`, `featuredImage`, `videoFragmentUrl`, `usersRating`) VALUES
(1, 'Season 1', 1, 1, 'During Season One, Sheldon loses his job for insulting his new boss, finds his ego bruised by a child prodigy, becomes unable to bear being part of a lie that Leonard has told, and is always attacking the world with a relentless need to assert his supremacy. Rajesh first learns that he can talk to women, but only when he is drunk, and Penny and Leonard finally go out in the season finale. It is so far the only season not to feature John Ross Bowie as the recurring character Barry Kripke and Kevin Sussman as Stuart Bloom.', '2007-2008', NULL, NULL, NULL),
(2, 'Season 2', 2, 1, 'Season two begins to deal with character development, including Sheldon becoming more and more obsessive. Leonard and Penny\'s relationship takes a turn for the worse when they break up, but this is quickly resolved. Soon their relationship progresses into a stronger friendship than before, while Sheldon and Penny\'s friendship slowly begins. In the season finale Penny hints at her true feelings for Leonard. Howard\'s character remains similar to that of season one in his attempts to seduce women, managing to start a short-lived sexual relationship with Leslie Winkle in the second half of the season. Meanwhile, Rajesh manages to briefly apologize to Penny for what he did in \"The Griffin Equivalency\" without having consumed alcohol. Barry Kripke played by John Ross Bowie makes his first appearance In the series starting with this season, He first appears in \"The Killer Robot Instability\".', '2008-2009', NULL, NULL, NULL),
(3, 'Season 3', 3, 1, 'Penny throws herself at Leonard after he returns from three months at the North Pole, and they begin a relationship that lasts most of the season. Penny and Sheldon start a quirky friendship (though she can still annoy him). Wil Wheaton begins appearing as Sheldon\'s arch-enemy. Howard begins to date Bernadette Rostenkowski. At the end of the season, Sheldon meets Amy Farrah Fowler.', '2009-2010', NULL, NULL, NULL),
(4, 'Season 4', 4, 1, 'Penny dates a couple of guys including the dense Zack who likes the \"science dudes\", Sheldon begins a platonic relationship with Amy, Howard reconnects with Bernadette eventually asking her to marry him, Leonard begins to date Raj\'s sister Priya, Penny becomes friends with Amy and expresses regret at breaking up with Leonard.', '2010-2011', NULL, NULL, NULL),
(5, 'Season 1', 1, 2, 'Sheldon Cooper, a 9-year-old genius, begins his first day of high school in the ninth grade with his older brother, George \"Georgie\" Cooper Jr. Having shown more skills than a typical child his age, he skipped several grades. On his first day, he questions his teachers and informs students of their rule-breaking. He tries to find his place in the new school and Georgie must deal with having a much younger sibling in his class.', '2017-2018', NULL, NULL, NULL),
(6, 'Season 2', 2, 2, 'Sheldon learns that his mother is worried about his not having any friends. He therefore gets a copy of How to Win Friends and Influence People from the school library and tries its methods on various students and teachers without success. Missy recommends that he try to make friends with other people who checked out the book, since they too are looking to make friends. That also fails. He eventually meets a Vietnamese American boy named Tam who sees him with the book and they share how difficult it has been for them to make friends. As they start speaking, they realize that they also share an interest in rocketry. Sheldon\'s mother is so happy that she insists Sheldon invite Tam over for dinner and lifts the ban on Sheldon\'s model rocketry hobby. The dinner turns awkward when Sheldon\'s parents exhibit cultural insensitivity as Tam tells them the story of his life. After dinner, the boys\' launch attempt goes out of control just as FBI agents arrive to ask Sheldon why he was trying to buy uranium.', '2018-2019', NULL, NULL, NULL),
(7, 'Season 1', 1, 3, 'While a stringer journalist, Jay Singletary, takes demeaning assignments in Los Angeles, Pat, a biracial teenager in Sparks, Nevada, is taunted at school. Her alcoholic mother, Jimmie Lee, tries to protect Pat, but arouses her suspicion. Pat learns, and Jimmie Lee confirms, that she is Fauna Hodel and was given up for adoption by her birth mother. Pat contacts her biological grandfather, George Hill Hodel, who invites her to Los Angeles. Despite believing that Pat could have a better future there, Jimmie Lee calls Jay to have him renew his decades-old interest in George, which initially caused Jay\'s credibility to suffer.', '2019', NULL, '', NULL),
(8, 'Season 1', 1, 4, 'In the 1980s, wealthy Englishman Patrick Melrose attempts to overcome his addictions and demons rooted in abuse by his cruel father and negligent mother.', '2018', NULL, NULL, NULL),
(9, 'Season 1', 1, 5, 'The first season covers her marriage to the author F. Scott Fitzgerald – who had yet to become famous for his work – and the subsequent marital tensions that arose from their lifestyle full of partying and alcohol.', '2015-2017', NULL, NULL, NULL),
(10, 'Season 1', 1, 6, 'The first season will consist of ten episodes. The main role of Dr. J. Allen Hynek is played by Aidan Gillen. The series is based on the real-life Project Blue Book, a series of studies on unidentified flying objects.', '2019', '', '', NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `starrating`
--

CREATE TABLE `starrating` (
  `ratingId` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `tvShowId` int(10) UNSIGNED DEFAULT NULL,
  `seasonId` int(10) UNSIGNED DEFAULT NULL,
  `episodeId` int(10) UNSIGNED DEFAULT NULL,
  `ratingNumber` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=COMPACT;

--
-- Дамп даних таблиці `starrating`
--

INSERT INTO `starrating` (`ratingId`, `userId`, `tvShowId`, `seasonId`, `episodeId`, `ratingNumber`) VALUES
(1, 4, 0, 7, 0, 4);

-- --------------------------------------------------------

--
-- Структура таблиці `tvserialuser`
--

CREATE TABLE `tvserialuser` (
  `tvSerialUserId` int(10) UNSIGNED NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `registrationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `tvserialuser`
--

INSERT INTO `tvserialuser` (`tvSerialUserId`, `login`, `password`, `isAdmin`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1),
(2, 'us', '3d517fe6ebab7b8cfcf98db6259c8a59', 0),
(4, 'ad', '594f803b380a41396ed63dca39503542', 1);

-- --------------------------------------------------------

--
-- Структура таблиці `tvshow`
--

CREATE TABLE `tvshow` (
  `tvShowId` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `subtitle` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `startDate` date NOT NULL,
  `posterImage` varchar(255) NOT NULL,
  `longDescription` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `shortDescription` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `priority` int(10) UNSIGNED NOT NULL,
  `publishDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastModifiedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `videoFragmentUrl` varchar(255) NOT NULL,
  `usersRating` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=COMPACT;

--
-- Дамп даних таблиці `tvshow`
--

INSERT INTO `tvshow` (`tvShowId`, `title`, `subtitle`, `startDate`, `posterImage`, `longDescription`, `shortDescription`, `priority`, `videoFragmentUrl`, `usersRating`) VALUES
(1, 'The Big Bang Theory', NULL, '2007-09-24', 'The_Big_Bang_Theory.jpg', 'The show originally centered on five characters living in Pasadena, California: Leonard Hofstadter and Sheldon Cooper, both physicists at Caltech, who share an apartment; Penny, a waitress and aspiring actress who lives across the hall; and Leonard and Sheldon\'s similarly geeky and socially awkward friends and co-workers, aerospace engineer Howard Wolowitz and astrophysicist Raj Koothrappali. Over time, supporting characters have been promoted to starring roles including: physicist Leslie Winkle, neuroscientist Amy Farrah Fowler, microbiologist Bernadette Rostenkowski, and Stuart Bloom, the cash-strapped owner of the comic book store the characters often visit.', 'The Big Bang Theory is an American television sitcom created by Chuck Lorre and Bill Prady, both of whom serve as executive producers on the series, along with Steven Molaro.', 5, 'https://www.youtube.com/embed/PAm8PV47jMM', NULL),
(2, 'Young Sheldon', '', '2017-09-25', 'Young_Sheldon.jpg', 'The series is a spin-off prequel to The Big Bang Theory and begins with the character Sheldon Cooper at the age of nine, living with his family in East Texas and going to high school. Iain Armitage stars as young Sheldon, alongside Zoe Perry, Lance Barber, Montana Jordan, Raegan Revord, and Annie Potts. Jim Parsons, who portrays the adult Sheldon Cooper on The Big Bang Theory, narrates the series and serves as an executive producer.', 'Young Sheldon is an American comedy television series on CBS created by Chuck Lorre and Steven Molaro.', 5, 'https://www.youtube.com/embed/HaZckh7Og14', NULL),
(3, 'I Am the Night', '', '2019-01-27', 'I_Am_the_Night.jpg', 'The series is inspired by the book One Day She\'ll Darken: The Mysterious Beginnings of Fauna Hodel written by Fauna Hodel.', 'I Am the Night is a six-episode American limited television series created and written by Sam Sheridan, starring Chris Pine and India Eisley.', 1, 'https://www.youtube.com/embed/61zVSc-qas8', NULL),
(4, 'Patrick Melrose', NULL, '2018-05-12', 'Patrick_Melrose.jpg', 'The show is based on semi-autobiographical novels about Britain\'s upper class by Edward St Aubyn.', 'Patrick Melrose is a 2018 five-part drama miniseries starring Benedict Cumberbatch as the titular Melrose.', 1, 'https://www.youtube.com/embed/0PWSbIbM7HA', NULL),
(5, 'Z: The Beginning of Everything', NULL, '2015-11-05', 'Z_The_Beginning_of_Everything.jpg', 'It is based on Z: A Novel of Zelda Fitzgerald by Therese Anne Fowler. The series presents a fictionalized version of the life of American socialite and writer Zelda Sayre Fitzgerald (Christina Ricci) in the 1920s.', 'Z: The Beginning of Everything is an American period drama television series created by Dawn Prestwich and Nicole Yorkin for Amazon Studios.', 2, 'https://www.youtube.com/embed/wy_XypHDiBk', NULL),
(6, 'Project Blue Book', '', '2019-01-08', 'Project_Blue_Book.jpg', 'The series revolves around secret U.S. Air Force investigations into supposed UFO encounters and unexplained phenomena, undertaken by astrophysics professor—and eventual ufologist—Dr. J. Allen Hynek in the 1950s and 1960s. As he and his partner, Air Force Captain Michael Quinn, investigate sightings across the U.S., Dr. Hynek discovers that not everything can be explained by science.', 'Project Blue Book is an American historical drama television series.', 3, 'https://www.youtube.com/embed/U4EmfM9isHo', NULL);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `episode`
--
ALTER TABLE `episode`
  ADD PRIMARY KEY (`episodeId`),
  ADD KEY `episodeName` (`episodeName`),
  ADD KEY `showId` (`tvShowId`),
  ADD KEY `seasonId` (`seasonId`);

--
-- Індекси таблиці `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`ratingId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `tvShowId` (`tvShowId`),
  ADD KEY `seasonId` (`seasonId`),
  ADD KEY `episodeId` (`episodeId`);

--
-- Індекси таблиці `season`
--
ALTER TABLE `season`
  ADD PRIMARY KEY (`seasonId`),
  ADD KEY `seasonName` (`seasonName`),
  ADD KEY `tvShoowId` (`tvShowId`);

--
-- Індекси таблиці `starrating`
--
ALTER TABLE `starrating`
  ADD PRIMARY KEY (`ratingId`),
  ADD KEY `tvShowId` (`tvShowId`),
  ADD KEY `seasonId` (`seasonId`),
  ADD KEY `episodeId` (`episodeId`),
  ADD KEY `userId` (`userId`);

--
-- Індекси таблиці `tvserialuser`
--
ALTER TABLE `tvserialuser`
  ADD PRIMARY KEY (`tvSerialUserId`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Індекси таблиці `tvshow`
--
ALTER TABLE `tvshow`
  ADD PRIMARY KEY (`tvShowId`),
  ADD UNIQUE KEY `title` (`title`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `episode`
--
ALTER TABLE `episode`
  MODIFY `episodeId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT для таблиці `rating`
--
ALTER TABLE `rating`
  MODIFY `ratingId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT для таблиці `season`
--
ALTER TABLE `season`
  MODIFY `seasonId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблиці `starrating`
--
ALTER TABLE `starrating`
  MODIFY `ratingId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблиці `tvserialuser`
--
ALTER TABLE `tvserialuser`
  MODIFY `tvSerialUserId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблиці `tvshow`
--
ALTER TABLE `tvshow`
  MODIFY `tvShowId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `episode`
--
ALTER TABLE `episode`
  ADD CONSTRAINT `episode_ibfk_1` FOREIGN KEY (`seasonId`) REFERENCES `season` (`seasonid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `season`
--
ALTER TABLE `season`
  ADD CONSTRAINT `season_ibfk_1` FOREIGN KEY (`tvShowId`) REFERENCES `tvshow` (`tvshowid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
