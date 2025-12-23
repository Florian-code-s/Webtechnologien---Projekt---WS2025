-- create database if not exists
CREATE DATABASE IF NOT EXISTS `create_styling_skills`;

-- create low privilege database user
GRANT USAGE ON *.* TO `create_styling_skills`@`localhost` IDENTIFIED BY PASSWORD '*8103401B65F972C4679A8710C0625D9F3F4D4460';
GRANT SELECT, INSERT, UPDATE, DELETE ON `create\_styling\_skills`.* TO `create_styling_skills`@`localhost`;

-- drop and create table user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `image_path` varchar(200) NOT NULL,
  `salt` varchar(20) NOT NULL,
  `password_hash` varchar(64) NOT NULL,
  `is_admin` BOOLEAN NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_username` (`username`),
  UNIQUE KEY `unique_salt` (`salt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
