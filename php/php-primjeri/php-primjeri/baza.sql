-- phpMyAdmin: kartica "SQL" -> zalijepi sve -> "Go" / "Kreni".

CREATE DATABASE IF NOT EXISTS skola
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE skola;

CREATE TABLE IF NOT EXISTS ucenici (
  id     INT AUTO_INCREMENT PRIMARY KEY,
  ime    VARCHAR(50)  NOT NULL,
  email  VARCHAR(100) NOT NULL,
  upisan TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
);
