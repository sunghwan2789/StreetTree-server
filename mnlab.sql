SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

DROP DATABASE IF EXISTS `mnlab`;
CREATE DATABASE IF NOT EXISTS `mnlab` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `mnlab`;

CREATE TABLE `fields` (
  `field_name` text NOT NULL COMMENT '현장명',
  `region_code` varchar(50) NOT NULL COMMENT '지역코드',
  `client_name` int(11) NOT NULL,
  `survery_at` text NOT NULL,
  `user_name` varchar(80) NOT NULL,
  `user_seq` int(10) UNSIGNED NOT NULL,
  `field_seq` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `surveys` (
  `survey_seq` int(10) UNSIGNED NOT NULL,
  `survey_number` int(10) UNSIGNED NOT NULL,
  `plate_name` text NOT NULL COMMENT '보호판?',
  `tree_number` text,
  `is_installed` tinyint(1) NOT NULL,
  `points` text NOT NULL,
  `picture` longblob NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `field_seq` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `users` (
  `id` varchar(50) NOT NULL,
  `pw` varchar(90) NOT NULL,
  `name` varchar(30) NOT NULL,
  `user_seq` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `fields`
  ADD PRIMARY KEY (`field_seq`),
  ADD KEY `user_seq` (`user_seq`);

ALTER TABLE `surveys`
  ADD PRIMARY KEY (`survey_seq`),
  ADD KEY `field_seq` (`field_seq`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_seq`),
  ADD UNIQUE KEY `id` (`id`);


ALTER TABLE `fields`
  MODIFY `field_seq` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `surveys`
  MODIFY `survey_seq` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `user_seq` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;


ALTER TABLE `fields`
  ADD CONSTRAINT `fields_ibfk_1` FOREIGN KEY (`user_seq`) REFERENCES `users` (`user_seq`);

ALTER TABLE `surveys`
  ADD CONSTRAINT `surveys_ibfk_1` FOREIGN KEY (`field_seq`) REFERENCES `fields` (`field_seq`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
