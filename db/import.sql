DROP DATABASE IF EXISTS `SquishFactory`;

CREATE DATABASE `SquishFactory`;

USE SquishFactory;

CREATE TABLE `Mellows`
(
    ProductID MEDIUMINT   NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Name      VARCHAR(60) NOT NULL,
    Price     MEDIUMINT   NOT NULL,
    Custom    BOOL        NOT NULL DEFAULT 1,
    Filepath  TEXT        NOT NULL
);

CREATE TABLE `Accessories`
(
    AccessoryID MEDIUMINT   NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Name        VARCHAR(60) NOT NULL,
    Price       MEDIUMINT   NOT NULL,
    Filepath    TEXT        NOT NULL
);

CREATE TABLE `Users`
(
    UserID         MEDIUMINT    NOT NULL AUTO_INCREMENT PRIMARY KEY,
    FirstName      VARCHAR(60)  NOT NULL,
    LastName       VARCHAR(60)  NOT NULL,
    BillingAddress VARCHAR(255) NULL,
    Phone          VARCHAR(30)  NULL,
    Email          VARCHAR(60)  NOT NULL,
    Username       VARCHAR(60)  NOT NULL,
    Password       TEXT         NOT NULL
);

CREATE TABLE `Admins`
(
    AdminID  MEDIUMINT   NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(60) NOT NULL,
    Password TEXT        NOT NULL
);

CREATE TABLE `Examples`
(
    ExampleID MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Filepath  TEXT,
    AdminID   MEDIUMINT NOT NULL,
    FOREIGN KEY (AdminID) REFERENCES Admins (AdminID)
);

CREATE TABLE `Orders`
(
    OrderID         MEDIUMINT                                            NOT NULL AUTO_INCREMENT PRIMARY KEY,
    FirstName       VARCHAR(60)                                          NOT NULL,
    LastName        VARCHAR(60)                                          NOT NULL,
    BillingAddress  VARCHAR(255)                                         NOT NULL,
    ShippingAddress VARCHAR(255)                                         NOT NULL,
    Email           VARCHAR(255)                                         NOT NULL,
    Phone           VARCHAR(30)                                          NOT NULL,
    OrderDate       DATE                                                 NOT NULL,
    Status          ENUM ('Pending', 'Accepted', 'Shipped', 'Delivered') NOT NULL,
    ProductID       MEDIUMINT                                            NOT NULL,
    AccessoryID     MEDIUMINT                                            NULL,
    UserID          MEDIUMINT                                            NULL,
    FOREIGN KEY (ProductID) REFERENCES Mellows (ProductID),
    FOREIGN KEY (AccessoryID) REFERENCES Accessories (AccessoryID),
    FOREIGN KEY (UserID) REFERENCES Users (UserID)
);