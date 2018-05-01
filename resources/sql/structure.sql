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
	srcImg Varchar (80),
	PRIMARY KEY(collegeID)
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
	tStamp DATETIME,
	partyID int (9),
	partyTypeID int (2),
	postPartyID int (9),
	PRIMARY KEY(postID),
	FOREIGN KEY(partyTypeID) references partyType(partyTypeID)
) ENGINE=InnoDB;

CREATE TABLE comment(
	commentID int (12) NOT NULL AUTO_INCREMENT,
	post Varchar (3000),
	tStamp DATETIME,
	postID int (9),
	commentUserID int (9),
	PRIMARY KEY(commentID),
	FOREIGN KEY(postID) references post(postID),
	FOREIGN KEY(commentUserID) references users(userID)
) ENGINE=InnoDB;

CREATE TABLE request(
	requesterID int (9),
	requesteeID int (9),
	requesteePartyTypeID int (2),
	PRIMARY KEY(requesterID, requesteeID, requesteePartyTypeID),
	FOREIGN KEY(requesteePartyTypeID) references partyType(partyTypeID)
) ENGINE=InnoDB;

CREATE TABLE connections(
	userID int (9),
	otherID int (9),
	otherPartyTypeID int (2),
	PRIMARY KEY(userID, otherID, otherPartyTypeID),
	FOREIGN KEY(otherPartyTypeID) references partyType(partyTypeID)
) ENGINE=InnoDB;

INSERT INTO `party` (`partyID`, `partyTypeID`) VALUES ('1', '3'), ('2', '3'), ('3', '3');
INSERT INTO `college` (`collegeID`, `name`, `description`, `address`, `srcImg`) VALUES ('1', 'Miami University', 'This college is a great college for business and computer science. The typical acceptance rate is 65.4%, and it is located in Oxford, Ohio', '501 E High St, Oxford, OH 45056', 'miami.jpg'); 
INSERT INTO `college` (`collegeID`, `name`, `description`, `address`, `srcImg`) VALUES ('2', 'Ohio State University', 'This college has a great NCAA basketball team, and is well know for its Political Science department. The typical acceptance rate is 49.1%, and it is located in Columbus, Ohio', 'Columbus, OH 43210', 'ohioState.jpg');
INSERT INTO `college` (`collegeID`, `name`, `description`, `address`, `srcImg`) VALUES ('3', 'Ohio University', 'This college has a great department for studying medicine: The Heritage College of Medicine. The typical acceptance rate is 74%, and it is located in Athens, Ohio', 'Athens, OH 45701', 'ohioU.jpg');

INSERT INTO `party` (`partyID`, `partyTypeID`) VALUES ('1', '1'), ('2', '1'), ('3', '1'), ('4', '1'), ('5', '1'), ('6', '1'), ('7', '1'), ('8', '1'), ('9', '1'), ('10', '1'), ('11', '1'), ('12', '1');
INSERT INTO `party` (`partyID`, `partyTypeID`) VALUES ('1', '2'), ('2', '2'), ('3', '2'), ('4', '2');
INSERT INTO `users` (`userID`, `fName`, `lName`, `password`, `bDate`, `collegeID`, `country`, `email`) VALUES ('1', 'nick', 'kane', 'nick', '1995-07-07', 1, 'United States', 'kanena@miamioh.edu');
INSERT INTO `users` (`userID`, `fName`, `lName`, `password`, `bDate`, `collegeID`, `country`, `email`, `srcImg`) VALUES ('2', 'bob', 'jones', 'bob', '1995-12-07', '1', 'United States', 'bjones@miamioh.edu', NULL);
INSERT INTO `users` (`userID`, `fName`, `lName`, `password`, `bDate`, `collegeID`, `country`, `email`, `srcImg`) VALUES ('3', 'david', 'smith', 'david', '1996-08-17', '1', 'United States', 'dsmith@miamioh.edu', NULL);
INSERT INTO `users` (`userID`, `fName`, `lName`, `password`, `bDate`, `collegeID`, `country`, `email`, `srcImg`) VALUES ('4', 'mary', 'flone', 'mary', '1997-04-23', '1', 'United States', 'mflone@miamioh.edu', NULL);
INSERT INTO `users` (`userID`, `fName`, `lName`, `password`, `bDate`, `collegeID`, `country`, `email`, `srcImg`) VALUES ('5', 'tommy', 'jones', 'tommy', '1998-02-13', '2', 'United States', 'tjones@ohiostate.edu', NULL);
INSERT INTO `users` (`userID`, `fName`, `lName`, `password`, `bDate`, `collegeID`, `country`, `email`, `srcImg`) VALUES ('6', 'mike', 'haynes', 'mike', '1995-04-21', '2', 'United States', 'mhaynes@ohiostate.edu', NULL);
INSERT INTO `users` (`userID`, `fName`, `lName`, `password`, `bDate`, `collegeID`, `country`, `email`, `srcImg`) VALUES ('7', 'ron', 'vincent', 'ron', '1995-11-11', '2', 'United States', 'rvincent@ohiostate.edu', NULL);
INSERT INTO `users` (`userID`, `fName`, `lName`, `password`, `bDate`, `collegeID`, `country`, `email`, `srcImg`) VALUES ('8', 'luke', 'harris', 'luke', '1996-02-28', '2', 'United States', 'lharrist@ohiostate.edu', NULL);
INSERT INTO `users` (`userID`, `fName`, `lName`, `password`, `bDate`, `collegeID`, `country`, `email`, `srcImg`) VALUES ('9', 'jack', 'gould', 'jake', '1996-01-03', '3', 'United States', 'jgould@ou.edu', NULL);
INSERT INTO `users` (`userID`, `fName`, `lName`, `password`, `bDate`, `collegeID`, `country`, `email`, `srcImg`) VALUES ('10', 'robert', 'nguyen', 'robert', '1997-04-09', '3', 'United States', 'rnguyen@ohiou.edu', NULL);
INSERT INTO `users` (`userID`, `fName`, `lName`, `password`, `bDate`, `collegeID`, `country`, `email`, `srcImg`) VALUES ('11', 'ally', 'hayworth', 'ally', '1995-01-12', '3', 'United States', 'ahayworth@ohiou.edu', NULL);
INSERT INTO `users` (`userID`, `fName`, `lName`, `password`, `bDate`, `collegeID`, `country`, `email`, `srcImg`) VALUES ('12', 'amanda', 'gordon', 'amanda', '1998-05-18', '3', 'United States', 'agordon@ohiou.edu', NULL);

INSERT INTO `groups` (`groupID`, `name`, `description`, `srcImg`, `managerID`) VALUES ('1', 'Dog Enthusiasts', 'We Love talking about dogs and how to make sure the dogs we take care of are healthy and happy on college campuses', NULL, '1');
INSERT INTO `groups` (`groupID`, `name`, `description`, `srcImg`, `managerID`) VALUES ('2', 'Music Enthusiasts', 'We Love talking about music and which artists are becoming the most influential on college campuses from the modern era ', NULL, '5');
INSERT INTO `groups` (`groupID`, `name`, `description`, `srcImg`, `managerID`) VALUES ('3', 'Online Note Sharing', 'We believe that all students should have the notes they need to pass the next test. We have discussions about sharing notes in our group', NULL, '12');
INSERT INTO `groups` (`groupID`, `name`, `description`, `srcImg`, `managerID`) VALUES ('4', 'Healthy Living', 'We want all of our members to talk about how to live more healthy lives on college campuses', NULL, '3');


INSERT INTO `connections` (`userID`, `otherID`, `otherPartyTypeID`) VALUES ('1', '1', '2');
INSERT INTO `connections` (`userID`, `otherID`, `otherPartyTypeID`) VALUES ('1', '2', '2');
INSERT INTO `connections` (`userID`, `otherID`, `otherPartyTypeID`) VALUES ('1', '4', '1');
INSERT INTO `connections` (`userID`, `otherID`, `otherPartyTypeID`) VALUES ('1', '1', '3');

INSERT INTO `connections` (`userID`, `otherID`, `otherPartyTypeID`) VALUES ('6', '2', '2');
INSERT INTO `connections` (`userID`, `otherID`, `otherPartyTypeID`) VALUES ('8', '2', '2');

INSERT INTO `post` (`postID`, `post`, `tStamp`, `partyID`, `partyTypeID`, `postPartyID`) VALUES ('1', 'I am excited to have joined the group. What type of music do you guys like?', '2018-04-27', '2', '2', '3');
INSERT INTO `post` (`postID`, `post`, `tStamp`, `partyID`, `partyTypeID`, `postPartyID`) VALUES ('2', 'I\'m excited to see what comes up in this group!', '2018-04-27 07:20:17', '2', '2', '6');
INSERT INTO `post` (`postID`, `post`, `tStamp`, `partyID`, `partyTypeID`, `postPartyID`) VALUES ('3', 'This group looks awesome, I love music!', '2018-04-27 08:17:29', '2', '2', '8');
INSERT INTO `post` (`postID`, `post`, `tStamp`, `partyID`, `partyTypeID`, `postPartyID`) VALUES ('4', 'Hey man, pumped that you\'re on college book now!', '2018-04-27 08:33:19', '1', '1', '10');
INSERT INTO `post` (`postID`, `post`, `tStamp`, `partyID`, `partyTypeID`, `postPartyID`) VALUES ('5', 'Hey Nick! You should learn more about healthy living, it seems like a cool page', '2018-04-27 06:22:17', '1', '1', '4');

INSERT INTO `request` (`requesterID`, `requesteeID`, `requesteePartyTypeID`) VALUES ('2', '1', '1');
INSERT INTO `request` (`requesterID`, `requesteeID`, `requesteePartyTypeID`) VALUES ('1', '4', '2');
INSERT INTO `request` (`requesterID`, `requesteeID`, `requesteePartyTypeID`) VALUES ('6', '1', '1');
INSERT INTO `request` (`requesterID`, `requesteeID`, `requesteePartyTypeID`) VALUES ('7', '1', '1');