/* Insert Test Users */
INSERT INTO `makersite`.`User` (`user_id`, `user_name`, `user_nickname`, `user_password`, `user_hashed_password`, `user_experience`) VALUES ('1', 'keller1', 'Keller F', '1234', '1234', '0');
INSERT INTO `makersite`.`User` (`user_id`, `user_name`, `user_nickname`, `user_password`, `user_hashed_password`, `user_experience`) VALUES ('2', 'ethan2', 'Ethan W', '1234', '1234', '0');
INSERT INTO `makersite`.`User` (`user_id`, `user_name`, `user_nickname`, `user_password`, `user_hashed_password`, `user_experience`) VALUES ('3', 'seth3', 'Seth B', '1234', '1234', '0');

/* Insert Test Sessions */
INSERT INTO `makersite`.`Session` (`session_id`, `session_name`, `session_description`) VALUES ('1', 'GMS Coding and Game Desgin', 'GMS afterschool Coding and Game Desgin');
INSERT INTO `makersite`.`Session` (`session_id`, `session_name`, `session_description`) VALUES ('2', 'REC Gamemaker Junior', 'REC Gamemaker Junior program');

/* Insert Users Into Sessions */
INSERT INTO `makersite`.`User_Session` (`user_id`, `session_id`, `user_session_permission`, `session_join_date`) VALUES ('1', '1', 'admin', '2007-04-30 13:10:02.047');
INSERT INTO `makersite`.`User_Session` (`user_id`, `session_id`, `user_session_permission`, `session_join_date`) VALUES ('2', '1', 'user', '2007-04-30 13:10:02.047');
INSERT INTO `makersite`.`User_Session` (`user_id`, `session_id`, `user_session_permission`, `session_join_date`) VALUES ('3', '1', 'user', '2007-04-30 13:10:02.047');

/* Insert Test Categories */
INSERT INTO `makersite`.`Category` (`category_id`, `category_name`, `category_description`, `session_id`) VALUES ('1', 'Scratch', 'Make games using block coding.', '1');
INSERT INTO `makersite`.`Category` (`category_id`, `category_name`, `category_description`, `session_id`) VALUES ('2', 'Scripting', 'Complete small projects and challenges in teams using Coffee Script and Python', '1');
INSERT INTO `makersite`.`Category` (`category_id`, `category_name`, `category_description`, `session_id`) VALUES ('3', 'Web Dev', 'Learn web development and build projects and websites', '1');
INSERT INTO `makersite`.`Category` (`category_id`, `category_name`, `category_description`, `session_id`) VALUES ('4', 'Game Development', 'Use Gamemaker Stuidos 2 to create 2D games', '1');

/* Insert Test Ranks */
INSERT INTO `makersite`.`Rank_Table` (`rank_id`, `rank_name`, `session_id`, `rank_experience`, `rank_path`) VALUES ('1', 'Bronze', '1', '10', '/');
INSERT INTO `makersite`.`Rank_Table` (`rank_id`, `rank_name`, `session_id`, `rank_experience`, `rank_path`) VALUES ('2', 'Silver', '1', '20', '/');
INSERT INTO `makersite`.`Rank_Table` (`rank_id`, `rank_name`, `session_id`, `rank_experience`, `rank_path`) VALUES ('3', 'Gold', '1', '30', '/');
INSERT INTO `makersite`.`Rank_Table` (`rank_id`, `rank_name`, `session_id`, `rank_experience`, `rank_path`) VALUES ('4', 'Expert', '1', '40', '/');
INSERT INTO `makersite`.`Rank_Table` (`rank_id`, `rank_name`, `session_id`, `rank_experience`, `rank_path`) VALUES ('5', 'Master', '1', '50', '/');

/* Insert Test Badges */
INSERT INTO `makersite`.`Badge` (`badge_id`, `badge_name`, `badge_description`, `category_id`, `badge_experience`, `badge_order`) VALUES ('1', 'Scratch Level 1', 'CS First projects', '1', '10', '1');
INSERT INTO `makersite`.`Badge` (`badge_id`, `badge_name`, `badge_description`, `category_id`, `badge_experience`, `badge_order`) VALUES ('2', 'Scratch Level 2', 'things', '1', '10', '2');
INSERT INTO `makersite`.`Badge` (`badge_id`, `badge_name`, `badge_description`, `category_id`, `badge_experience`, `badge_order`) VALUES ('3', 'Scratch Level 3', 'things', '1', '10', '3');
INSERT INTO `makersite`.`Badge` (`badge_id`, `badge_name`, `badge_description`, `category_id`, `badge_experience`, `badge_order`) VALUES ('4', 'Coffee 1', 'things', '2', '10', '1');
INSERT INTO `makersite`.`Badge` (`badge_id`, `badge_name`, `badge_description`, `category_id`, `badge_experience`, `badge_order`) VALUES ('5', 'Coffee 2', 'things', '2', '10', '2');
INSERT INTO `makersite`.`Badge` (`badge_id`, `badge_name`, `badge_description`, `category_id`, `badge_experience`, `badge_order`) VALUES ('6', 'Coffee 3', 'things', '2', '10', '3');
INSERT INTO `makersite`.`Badge` (`badge_id`, `badge_name`, `badge_description`, `category_id`, `badge_experience`, `badge_order`) VALUES ('7', 'Web Dev 1', 'things', '3', '10', '1');
INSERT INTO `makersite`.`Badge` (`badge_id`, `badge_name`, `badge_description`, `category_id`, `badge_experience`, `badge_order`) VALUES ('8', 'Web Dev 2', 'things', '3', '10', '2');
INSERT INTO `makersite`.`Badge` (`badge_id`, `badge_name`, `badge_description`, `category_id`, `badge_experience`, `badge_order`) VALUES ('9', 'Web Dev 3', 'things', '3', '10', '3');
INSERT INTO `makersite`.`Badge` (`badge_id`, `badge_name`, `badge_description`, `category_id`, `badge_experience`, `badge_order`) VALUES ('10', 'Games 1', 'things', '4', '10', '1');

/* Set Badge Prereqs */
UPDATE `makersite`.`Badge` SET `badge_prereq_id` = '1' WHERE (`badge_id` = '2');
UPDATE `makersite`.`Badge` SET `badge_prereq_id` = '2' WHERE (`badge_id` = '3');
UPDATE `makersite`.`Badge` SET `badge_prereq_id` = '4' WHERE (`badge_id` = '5');
UPDATE `makersite`.`Badge` SET `badge_prereq_id` = '5' WHERE (`badge_id` = '6');
UPDATE `makersite`.`Badge` SET `badge_prereq_id` = '7' WHERE (`badge_id` = '8');
UPDATE `makersite`.`Badge` SET `badge_prereq_id` = '8' WHERE (`badge_id` = '9');

/* Give Badges to Users */
INSERT INTO `makersite`.`User_Badge` (`user_id`, `badge_id`, `user_badge_date`) VALUES ('1', '1', '2007-04-30 13:10:02.047');
INSERT INTO `makersite`.`User_Badge` (`user_id`, `badge_id`, `user_badge_date`) VALUES ('2', '1', '2007-04-30 13:10:02.047');
INSERT INTO `makersite`.`User_Badge` (`user_id`, `badge_id`, `user_badge_date`) VALUES ('3', '1', '2007-04-30 13:10:02.047');
INSERT INTO `makersite`.`User_Badge` (`user_id`, `badge_id`, `user_badge_date`) VALUES ('1', '2', '2007-04-30 13:10:02.047');
INSERT INTO `makersite`.`User_Badge` (`user_id`, `badge_id`, `user_badge_date`) VALUES ('1', '3', '2007-04-30 13:10:02.047');
INSERT INTO `makersite`.`User_Badge` (`user_id`, `badge_id`, `user_badge_date`) VALUES ('1', '4', '2007-04-30 13:10:02.047');
INSERT INTO `makersite`.`User_Badge` (`user_id`, `badge_id`, `user_badge_date`) VALUES ('1', '7', '2007-04-30 13:10:02.047');

/* Insert Test Req */
INSERT INTO `makersite`.`Req` (`req_id`, `badge_id`, `req_name`, `req_text`, `req_order`, `req_link`) VALUES ('1', '1', 'Req 1', 'stuff', '1', '/');
INSERT INTO `makersite`.`Req` (`req_id`, `badge_id`, `req_name`, `req_text`, `req_order`, `req_link`) VALUES ('2', '1', 'Req 2', 'stuff', '2', '/');
INSERT INTO `makersite`.`Req` (`req_id`, `badge_id`, `req_name`, `req_text`, `req_order`, `req_link`) VALUES ('3', '1', 'Req 3', 'stuff', '3', '/');
INSERT INTO `makersite`.`Req` (`req_id`, `badge_id`, `req_name`, `req_text`, `req_order`, `req_link`) VALUES ('4', '1', 'Req 4', 'stuff', '4', '/');
INSERT INTO `makersite`.`Req` (`req_id`, `badge_id`, `req_name`, `req_text`, `req_order`, `req_link`) VALUES ('5', '1', 'Req 5', 'stuff', '5', '/');
INSERT INTO `makersite`.`Req` (`req_id`, `badge_id`, `req_name`, `req_text`, `req_order`, `req_link`) VALUES ('6', '1', 'Req 6', 'stuff', '6', '/');
INSERT INTO `makersite`.`Req` (`req_id`, `badge_id`, `req_name`, `req_text`, `req_order`, `req_link`) VALUES ('7', '1', 'Req 7', 'stuff', '7', '/');

/* Complete Requirements */
INSERT INTO `makersite`.`User_Req` (`user_id`, `req_id`, `user_badge_date`) VALUES ('1', '1', '2007-04-30 13:10:02.047');
INSERT INTO `makersite`.`User_Req` (`user_id`, `req_id`, `user_badge_date`) VALUES ('1', '2', '2007-04-30 13:10:02.047');
INSERT INTO `makersite`.`User_Req` (`user_id`, `req_id`, `user_badge_date`) VALUES ('1', '3', '2007-04-30 13:10:02.047');
INSERT INTO `makersite`.`User_Req` (`user_id`, `req_id`, `user_badge_date`) VALUES ('1', '4', '2007-04-30 13:10:02.047');
INSERT INTO `makersite`.`User_Req` (`user_id`, `req_id`, `user_badge_date`) VALUES ('1', '5', '2007-04-30 13:10:02.047');

