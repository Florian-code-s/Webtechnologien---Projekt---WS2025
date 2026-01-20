-- create database if not exists
CREATE DATABASE IF NOT EXISTS `create_styling_skills`;

-- create low privilege database user
GRANT USAGE ON *.* TO `create_styling_skills`@`localhost` IDENTIFIED BY PASSWORD '*8103401B65F972C4679A8710C0625D9F3F4D4460';
GRANT SELECT, INSERT, UPDATE, DELETE ON `create\_styling\_skills`.* TO `create_styling_skills`@`localhost`;

-- drop and create table user
-- DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
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

-- drop and create table lessons
-- DROP TABLE IF EXISTS `lessons`;
CREATE TABLE IF NOT EXISTS `lessons` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- drop and create table exercises
-- DROP TABLE IF EXISTS `exercises`;
CREATE TABLE IF NOT EXISTS `exercises` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `box_html` varchar(1000) NOT NULL,
  `info_text` varchar(1000) NOT NULL,
  `hint_link` varchar(255) NULL,
  `correct_answer` varchar(255) NOT NULL,
  `fk_id_lessons` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`fk_id_lessons`) REFERENCES `lessons`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- drop and create table user_lesson_progress
-- DROP TABLE IF EXISTS `user_lesson_progress`;
CREATE TABLE IF NOT EXISTS `user_lesson_progress` (
  `user_id` bigint(20) NOT NULL,
  `lesson_id` bigint(20) NOT NULL,

  `status` ENUM('not_started','in_progress','completed') NOT NULL DEFAULT 'not_started',
  `progress_percent` TINYINT UNSIGNED NOT NULL DEFAULT 0,

  -- speichert den aktuellen Zustand der Lektion als JSON-String
  `state_json` TEXT NULL,

  `started_at` DATETIME NULL,
  `completed_at` DATETIME NULL,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  PRIMARY KEY (`user_id`, `lesson_id`),
  CONSTRAINT `fk_ulp_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `fk_ulp_lesson` FOREIGN KEY (`lesson_id`) REFERENCES `lessons`(`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- insert initial lesson data
USE create_styling_skills;

INSERT INTO lessons (title, description)
VALUES (
  'Background Color',
  'Schreibe den CSS-Code, um eine Box rot zu färben.'
);
