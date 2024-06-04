DROP DATABASE IF EXISTS `SquishFactory`;

CREATE DATABASE `SquishFactory`;

USE SquishFactory;

CREATE TABLE `Mellows`
(
    ProductID MEDIUMINT   NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    Name      VARCHAR(60) NULL,
    Price     MEDIUMINT   NULL,
    Custom    BOOL        NOT NULL DEFAULT 1,
    Filepath  TEXT        NOT NULL UNIQUE
);

CREATE TABLE `Accessories`
(
    AccessoryID MEDIUMINT   NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    Name        VARCHAR(60) NOT NULL,
    Price       MEDIUMINT   NOT NULL,
    Filepath    TEXT        NOT NULL UNIQUE
);

CREATE TABLE `Users`
(
    UserID         MEDIUMINT    NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
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
    AdminID  MEDIUMINT   NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(60) NOT NULL,
    Password TEXT        NOT NULL
);

CREATE TABLE `Examples`
(
    ExampleID MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    Filepath  TEXT      NOT NULL UNIQUE,
    AdminID   MEDIUMINT NOT NULL,
    FOREIGN KEY (AdminID) REFERENCES Admins (AdminID)
);

CREATE TABLE `Coupons`
(
    CouponID   MEDIUMINT                           NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    Amount     MEDIUMINT                           NOT NULL,
    Percentage BOOL                                NOT NULL DEFAULT 0,
    Code       VARCHAR(255)                        NOT NULL UNIQUE,
    Status     ENUM ('Open', 'Closed', 'One-time') NOT NULL DEFAULT 'Open',
    AdminID    MEDIUMINT                           NOT NULL,
    FOREIGN KEY (AdminID) REFERENCES Admins (AdminID)
);

CREATE TABLE `Orders`
(
    OrderID         MEDIUMINT                                            NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    FirstName       VARCHAR(60)                                          NOT NULL,
    LastName        VARCHAR(60)                                          NOT NULL,
    BillingAddress  VARCHAR(255)                                         NOT NULL,
    ShippingAddress VARCHAR(255)                                         NOT NULL,
    Email           VARCHAR(255)                                         NOT NULL,
    Phone           VARCHAR(30)                                          NOT NULL,
    OrderDate       DATE                                                 NOT NULL,
    Status          ENUM ('Pending', 'Accepted', 'Shipped', 'Delivered') NOT NULL DEFAULT 'Pendi<input type="email" class="form-control" placeholder="Email Address">ng',
    Price           INT                                                  NOT NULL,
    ProductID       MEDIUMINT                                            NOT NULL,
    AccessoryID     MEDIUMINT                                            NULL,
    UserID          MEDIUMINT                                            NULL,
    CouponID        MEDIUMINT                                            NULL,
    FOREIGN KEY (ProductID) REFERENCES Mellows (ProductID),
    FOREIGN KEY (AccessoryID) REFERENCES Accessories (AccessoryID),
    FOREIGN KEY (UserID) REFERENCES Users (UserID),
    FOREIGN KEY (CouponID) REFERENCES Coupons (CouponID)
);

CREATE TABLE `Cart`
(
    CartID    MEDIUMINT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    Amount    INT       NOT NULL DEFAULT 1,
    UserID    MEDIUMINT NOT NULL,
    ProductID MEDIUMINT NOT NULL,
    FOREIGN KEY (ProductID) REFERENCES Mellows (ProductID),
    FOREIGN KEY (UserID) REFERENCES Users (UserID)
);