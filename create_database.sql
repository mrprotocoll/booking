DROP DATABASE IF EXISTS bukukontak_service;

CREATE DATABASE bukukontak_service;

USE bukukontak_service;

CREATE TABLE contact
(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    phone_number VARCHAR(50)
);