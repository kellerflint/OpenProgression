CREATE TABLE User
(
    user_id int NOT NULL AUTO_INCREMENT,
    user_name varchar(255) NOT NULL UNIQUE,
    user_nickname varchar(255) NOT NULL,
    user_password varchar(255) NOT NULL,
    user_hashed_password varchar(255) NOT NULL,
    user_experience int NOT NULL,

    PRIMARY KEY (user_id)
);

CREATE TABLE Session
(
    session_id int NOT NULL AUTO_INCREMENT,
    session_name varchar(255) NOT NULL,
    session_description varchar(5000),

    PRIMARY KEY (session_id)
);

CREATE TABLE User_Session 
(
    user_id int,
    session_id int,
    user_session_permission varchar(255) NOT NULL,
    session_join_date datetime NOT NULL,

    PRIMARY KEY (user_id, session_id),
    FOREIGN KEY (user_id) REFERENCES User (user_id) ON UPDATE CASCADE,
    FOREIGN KEY (session_id) REFERENCES Session (session_id) ON UPDATE CASCADE
);

CREATE TABLE Category
(
    category_id int NOT NULL AUTO_INCREMENT,
    category_name varchar(255) NOT NULL,
    category_description varchar(5000),
    session_id int,

    PRIMARY KEY (category_id),
    FOREIGN KEY (session_id) REFERENCES Session (session_id) ON UPDATE CASCADE
);

/* Can't use word Rank for some reason*/
CREATE TABLE Rank_Table
(
    rank_id int NOT NULL AUTO_INCREMENT,
    rank_name varchar(255) NOT NULL,
    session_id int NOT NULL,
    rank_experience int NOT NULL,
    rank_path varchar(255) NOT NULL,

    PRIMARY KEY (rank_id),
    FOREIGN KEY (session_id) REFERENCES Session (session_id) ON UPDATE CASCADE
);

CREATE TABLE Badge
(
    badge_id int NOT NULL AUTO_INCREMENT,
    badge_name varchar(255) NOT NULL,
    badge_description varchar(5000),
    badge_prereq_id int,
    category_id int,
    badge_experience int NOT NULL,
    badge_order int NOT NULL,

    PRIMARY KEY (badge_id),
    FOREIGN KEY (category_id) REFERENCES Category (category_id) ON UPDATE CASCADE,
    FOREIGN KEY (badge_prereq_id) REFERENCES Badge (badge_id) ON UPDATE CASCADE

);

CREATE TABLE User_Badge
(
    user_id int,
    badge_id int,
    user_badge_date datetime NOT NULL,

    PRIMARY KEY (user_id, badge_id),
    FOREIGN KEY (user_id) REFERENCES User (user_id) ON UPDATE CASCADE,
    FOREIGN KEY (badge_id) REFERENCES Badge (badge_id) ON UPDATE CASCADE
);

CREATE TABLE Req
(
    req_id int NOT NULL AUTO_INCREMENT,
    badge_id int,
    req_name varchar(255) NOT NULL,
    req_text varchar(5000) NOT NULL,
    req_order int NOT NULL,
    req_link varchar(255),

    PRIMARY KEY (req_id),
    FOREIGN KEY (badge_id) REFERENCES Badge (badge_id) ON UPDATE CASCADE
);

CREATE TABLE User_Req
(
    user_id int,
    req_id int,
    user_badge_date datetime NOT NULL,

    PRIMARY KEY (user_id, req_id),
    FOREIGN KEY (user_id) REFERENCES User (user_id) ON UPDATE CASCADE,
    FOREIGN KEY (req_id) REFERENCES Req (req_id) ON UPDATE CASCADE
);