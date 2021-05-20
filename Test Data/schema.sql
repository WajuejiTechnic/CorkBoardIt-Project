-- CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password';
CREATE USER IF NOT EXISTS gatechUser@localhost IDENTIFIED BY 'gatech123';

DROP DATABASE IF EXISTS `cs6400_fall2018_team123`;
SET default_storage_engine=InnoDB;
SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE DATABASE IF NOT EXISTS cs6400_fall2018_team123
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;

USE cs6400_fall2018_team123;


GRANT SELECT, INSERT, UPDATE, DELETE, FILE ON *.* TO 'gatechUser'@'localhost';
GRANT ALL PRIVILEGES ON `gatechuser`.* TO 'gatechUser'@'localhost';
GRANT ALL PRIVILEGES ON `cs6400_fall2018_team123`.* TO 'gatechUser'@'localhost';
FLUSH PRIVILEGES;

-- Tables

CREATE TABLE `User` (
	email varchar(64) NOT NULL,
	pin varchar(4) NOT NULL,
	first_name varchar(64) NOT NULL,
	last_name varchar(64) NOT NULL,
	PRIMARY KEY (email)
);

CREATE TABLE Category (
    name varchar(64) NOT NULL,
    PRIMARY KEY (name)
);

CREATE TABLE CorkBoard (
	id int NOT NULL AUTO_INCREMENT,
	email varchar(64) NOT NULL,
	title varchar(64) NOT NULL,
	date_time datetime NOT NULL,
	password varchar(64) DEFAULT NULL,
	name varchar(64) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE PushPin (
	id int NOT NULL AUTO_INCREMENT,
	c_id int NOT NULL,
	url varchar(128) NOT NULL,
	date_time datetime NOT NULL,
	description varchar(256) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE Follows (
	email varchar(64) NOT NULL,
	f_email varchar(64) NOT NULL,
	PRIMARY KEY (email,f_email)
);

CREATE TABLE Watches (
	u_email varchar(64) NOT NULL,
	c_id int NOT NULL,
	PRIMARY KEY (u_email, c_id)
);

CREATE TABLE Comment (
	u_email varchar(64) NOT NULL,
	p_id int NOT NULL,
	date_time datetime NOT NULL,
	text varchar(256) NOT NULL,
	PRIMARY KEY (u_email, p_id, date_time)
);

CREATE TABLE Tag (
	p_id int NOT NULL,
	name varchar(32) NOT NULL,
	PRIMARY KEY (p_id, name)
);

CREATE TABLE Likes (
	u_email varchar(64) NOT NULL,
	p_id int NOT NULL,
	PRIMARY KEY (u_email, p_id)
);

-- Constraints   Foreign Keys: FK_ChildTable_childColumn_ParentTable_parentColumn

ALTER TABLE CorkBoard
	ADD CONSTRAINT fk_CorkBoard_email_User_email FOREIGN KEY (email) REFERENCES `User` (email) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT fk_CorkBoard_name_Category_name FOREIGN KEY (name) REFERENCES Category (name);

ALTER TABLE PushPin
	ADD CONSTRAINT fk_PushPin_email_Corkboard_email FOREIGN KEY (c_id) REFERENCES CorkBoard (id) ON DELETE CASCADE ON UPDATE CASCADE;
	
ALTER TABLE Follows
	ADD CONSTRAINT fk_Follows_email_User_email FOREIGN KEY (email) REFERENCES `User` (email) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT fk_Follows_femail_User_email FOREIGN KEY (f_email) REFERENCES `User` (email) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE Watches
	ADD CONSTRAINT fk_Watches_uemail_User_email FOREIGN KEY (u_email) REFERENCES `User` (email) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT fk_Watches_key_Corkboard_key FOREIGN KEY (c_id) REFERENCES CorkBoard (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE Comment
	ADD CONSTRAINT fk_Comment_uemail_User_email FOREIGN KEY (u_email) REFERENCES `User` (email) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT fk_Comment_key_PushPin_key FOREIGN KEY (p_id) REFERENCES PushPin (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE Tag
	ADD CONSTRAINT fk_Tag_datetime_PushPin_datetime FOREIGN KEY (p_id) REFERENCES PushPin (id) ON DELETE CASCADE ON UPDATE CASCADE;
	
ALTER TABLE Likes
	ADD CONSTRAINT fk_Likes_uemail_User_email FOREIGN KEY (u_email) REFERENCES `User` (email) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT fk_Likes_key_PushPin_key FOREIGN KEY (p_id) REFERENCES PushPin (id) ON DELETE CASCADE ON UPDATE CASCADE;
