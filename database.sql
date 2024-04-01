-- Create the Movies database if it doesn't exist
CREATE DATABASE IF NOT EXISTS Movies;

-- Use the Movies database
USE Movies;

-- Create the movies table
CREATE TABLE IF NOT EXISTS movies (
  id INT AUTO_INCREMENT PRIMARY KEY,
  Title VARCHAR(255),
  Year INT,
  Format VARCHAR(50),
  Actors VARCHAR(255)
);
