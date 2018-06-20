DROP DATABASE IF EXISTS `bilderdb`;
CREATE DATABASE IF NOT EXISTS `bilderdb`
  DEFAULT CHARACTER SET utf8
  COLLATE utf8_german2_ci;

USE bilderdb;

CREATE TABLE ROLE (
  RID         INT PRIMARY KEY,
  ROLE        VARCHAR(50),
  DESCRIPTION VARCHAR(100)
);

CREATE TABLE USER (
  UID       INT PRIMARY KEY AUTO_INCREMENT,
  EMAIL     VARCHAR(50),
  FIRSTNAME VARCHAR(50),
  SURENAME  VARCHAR(50),
  PASSWORD  VARCHAR(60),
  ROLE      INT,
  FOREIGN KEY (ROLE) REFERENCES ROLE(RID)
);

CREATE TABLE PICTURE (
  PID         INT PRIMARY KEY AUTO_INCREMENT,
  PICTURE     VARCHAR(100),
  THUMB       varchar(100),
  TITLE       VARCHAR(50),
  DESCRIPTION VARCHAR(100),
  GID         INT
);

CREATE TABLE GALLERIE (
  GID INT PRIMARY KEY AUTO_INCREMENT,
  NAME VARCHAR (50),
  UID INT,
  DESCRIPTION VARCHAR (10000),
  FOREIGN KEY (UID) REFERENCES USER(UID) on delete CASCADE
);

CREATE TABLE TAGS (
  TID         INT PRIMARY KEY AUTO_INCREMENT,
  TAG         VARCHAR(50),
  DESCRIPTION VARCHAR(100)
);

CREATE TABLE TAG_PICTURE(
  TPID        INT PRIMARY KEY AUTO_INCREMENT,
  TID         INT,
  PID         INT,
  FOREIGN KEY (TID) REFERENCES TAGS(TID),
  FOREIGN KEY (PID) REFERENCES PICTURE(PID) on delete CASCADE
);

CREATE TABLE FREIGABE(
  GUID INT PRIMARY KEY AUTO_INCREMENT,
  GID INT,
  UID INT,
  FREIGABE int, -- Wenn freigabe = 1 dann ist sie für alle freigegeben;
  FOREIGN KEY (GID) REFERENCES GALLERIE(GID) on delete CASCADE,
  FOREIGN KEY (UID) REFERENCES USER(UID) on delete CASCADE
);

INSERT INTO ROLE VALUES (1, "Admin", "Admin");
INSERT INTO ROLE VALUES (2, "User", "Wenn der Benutzer Registriert und Eingeloggt ist.");

INSERT INTO USER (UID,EMAIL,FIRSTNAME,SURENAME,PASSWORD,ROLE) VALUES (1, "admin@gmail.com", "Admin", "Root", "$2y$10$ZW8lhRjDakWqODqVFDYHL.0X0aMkQh5POs.d5TcKuIcLwEYVqmHAa", 1);
INSERT INTO USER (UID,EMAIL,FIRSTNAME,SURENAME,PASSWORD,ROLE) VALUES (2, "admin@gmail.ch", "Admin", "Root", "$2y$10$ZW8lhRjDakWqODqVFDYHL.0X0aMkQh5POs.d5TcKuIcLwEYVqmHAa", 1);
INSERT INTO USER VALUES (3, "user@gmail.com", "User", "Fritz", "9f8a2389a20ca0752aa9e95093515517e90e194c", 2);