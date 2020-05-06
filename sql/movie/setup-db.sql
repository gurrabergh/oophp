--
-- Setup for the article:
-- https://dbwebb.se/kunskap/kom-igang-med-php-pdo-och-mysql
--

--
-- Create the database with a test user
--
CREATE DATABASE IF NOT EXISTS oophp;
CREATE USER IF NOT EXISTS 'user'@'%'
IDENTIFIED
WITH mysql_native_password -- Only MySQL > 8.0.4
BY 'pass'
;
-- ge användaren alla rättigheter på 'eshop'
GRANT ALL PRIVILEGES
    ON eshop.*
    TO 'user'@'%'
;
USE oophp;
