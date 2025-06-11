SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
-- ----------------------------------------------------------------
--
-- Database name: `star_wars`
--
-- --------------------------------------------------------
--
-- Table `characters`
--
-- ----------------------------------------------------------------
CREATE TABLE `characters` (
  `id` int(10) NOT NULL,
  `display_name` varchar(45) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `alias` varchar(45) NOT NULL,
  `description` varchar(100) NOT NULL,
  `image_1` varchar(100) NOT NULL,
  `image_2` varchar(100) NOT NULL,
  `image_3` varchar(100) NOT NULL,
  `gender` varchar(45) NOT NULL,
  `species` varchar(45) NOT NULL,
  `homeworld` varchar(45) NOT NULL,
  `birth_year` varchar(10) NOT NULL,
  `death_year` varchar(10) NOT NULL,
  `height` float DEFAULT NULL,
  `mass` int(10) DEFAULT NULL,
  `hair_color` varchar(45) NOT NULL,
  `skin_color` varchar(45) NOT NULL,
  `eye_color` varchar(45) NOT NULL,
  `portrayed_image_1` varchar(45) NOT NULL,
  `portrayed_image_2` varchar(45) NOT NULL,
  `portrayed_image_3` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- ----------------------------------------------------------------
--
-- Table index: `characters`
--
-- ----------------------------------------------------------------
ALTER TABLE `characters`
  ADD PRIMARY KEY (`id`);
-- ----------------------------------------------------------------
--
-- Auto-increment id: `characters`
--
-- ----------------------------------------------------------------
ALTER TABLE `characters`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
COMMIT;