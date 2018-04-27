CREATE DATABASE collegebook;
USE collegebook;

CREATE TABLE partyType(
	partyTypeID int (9),
	partyTypeName varchar(20),
	PRIMARY KEY(partyTypeID)
) ENGINE=InnoDB;

INSERT INTO partyType VALUES(1, "user"), (2, "group"), (3, "college");

CREATE TABLE party(
	partyID int (9),
	partyTypeID int (2),
	PRIMARY KEY(partyID, partyTypeID),
	FOREIGN KEY(partyTypeID) references partyType(partyTypeID)
) ENGINE=InnoDB;

CREATE TABLE college(
	collegeID int (9) NOT NULL AUTO_INCREMENT,
	name Varchar (100),
	description Varchar (1000),
	address Varchar (200),
	PRIMARY KEY(collegeID),
	FOREIGN KEY(collegeID) references party(partyID)
) ENGINE=InnoDB;

CREATE TABLE users(
	userID int (9) NOT NULL AUTO_INCREMENT,
	fName Varchar (40),
	lName Varchar (40),
	password Varchar (40),
	bDate DATE,
	collegeID int (9),
	country Varchar (80),
	email Varchar (80),
	srcImg Varchar (80),
	PRIMARY KEY(userID),
	FOREIGN KEY(collegeID) references college(collegeID)
) ENGINE=InnoDB;

CREATE TABLE groups(
	groupID int (9) NOT NULL AUTO_INCREMENT,
	name Varchar (100),
	description Varchar (2000),
	srcImg Varchar (80),
	managerID int (9),
	PRIMARY KEY(groupID),
	FOREIGN KEY(managerID) references users(userID)
) ENGINE=InnoDB;

CREATE TABLE post(
	postID int (11) NOT NULL AUTO_INCREMENT,
	post Varchar (3000),
	tStamp DATE,
	partyID int (9),
	partyTypeID int (2),
	postPartyID int (9),
	PRIMARY KEY(postID),
	FOREIGN KEY(partyID) references party(partyID),
	FOREIGN KEY(partyTypeID) references partyType(partyTypeID),
	FOREIGN KEY(postPartyID) references party(partyID)
) ENGINE=InnoDB;

CREATE TABLE comment(
	commentID int (12) NOT NULL AUTO_INCREMENT,
	post Varchar (3000),
	tStamp DATE,
	postID int (9),
	commentUserID int (9),
	PRIMARY KEY(commentID),
	FOREIGN KEY(postID) references post(postID),
	FOREIGN KEY(commentUserID) references users(userID)
) ENGINE=InnoDB;

CREATE TABLE request(
	requesterID int (9),
	requesteeID int (9),
	PRIMARY KEY(requesterID, requesteeID),
	FOREIGN KEY(requesterID) references party(partyID),
	FOREIGN KEY(requesteeID) references party(partyID)
) ENGINE=InnoDB;

INSERT INTO `party` (`partyID`, `partyTypeID`) VALUES ('1', '3');
INSERT INTO `party` (`partyID`, `partyTypeID`) VALUES ('2', '3');
INSERT INTO `party` (`partyID`, `partyTypeID`) VALUES ('3', '3');
INSERT INTO `college` (`collegeID`, `name`, `description`, `address`) VALUES ('1', 'Miami University', 'This college is a great college for business and computer science. The typical acceptance rate is 65.4%, and it is located in Oxford, Ohio', '501 E High St, Oxford, OH 45056'); 
INSERT INTO `college` (`collegeID`, `name`, `description`, `address`) VALUES ('2', 'Ohio State University', 'This college has a great NCAA basketball team, and is well know for its Political Science department. The typical acceptance rate is 49.1%, and it is located in Columbus, Ohio', 'Columbus, OH 43210');
INSERT INTO `college` (`collegeID`, `name`, `description`, `address`) VALUES ('3', 'Ohio University', 'This college has a great department for studying medicine: The Heritage College of Medicine. The typical acceptance rate is 74%, and it is located in Athens, Ohio', 'Athens, OH 45701');

INSERT INTO `party` (`partyID`, `partyTypeID`) VALUES ('1', '1');
INSERT INTO `users` (`userID`, `fName`, `lName`, `password`, `bDate`, `collegeID`, `country`, `email`) VALUES (NULL, 'nick', 'kane', 'nick', '1995-07-07', 1, 'United States', 'kanena@miamioh.edu');


