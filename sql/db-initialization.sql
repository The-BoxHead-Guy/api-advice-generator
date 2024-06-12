DROP DATABASE IF EXISTS pieces_of_advices;

CREATE DATABASE pieces_of_advices;

USE pieces_of_advices;

DROP TABLE IF EXISTS list_of_advices;

-- Create the table where pieces of advice are going to be stored 
CREATE TABLE list_of_advices (
	advice_id INT NOT NULL AUTO_INCREMENT,
    advice_text VARCHAR(255) NOT NULL UNIQUE,
    PRIMARY KEY (advice_id)
);

-- Drops table 'users' if exists.
DROP TABLE IF EXISTS users;

-- Create table for users signup
CREATE TABLE users (
	id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    pwd LONGTEXT NOT NULL,
    
    PRIMARY KEY (id)
);