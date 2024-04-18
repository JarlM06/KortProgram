CREATE DATABASE IF NOT EXISTS Kortstokker;
USE Kortstokker;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username varchar(255) NOT NULL,
    password varchar(255) NOT NULL
);