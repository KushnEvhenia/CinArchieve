-- Create the Movies database if it doesn't exist with UTF-8 encoding
CREATE DATABASE IF NOT EXISTS Movies CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the Movies database
USE Movies;

-- Create the movies table with UTF-8 encoding
CREATE TABLE IF NOT EXISTS movies (
  id INT AUTO_INCREMENT PRIMARY KEY,
  Title VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  Year INT,
  Format VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  Actors VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

