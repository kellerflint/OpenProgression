/* Insert Test Users */
INSERT INTO `OpenProgression`.`User` (`user_id`, `user_name`, `user_nickname`, `user_password`, `user_hashed_password`, `user_access`) VALUES ('1', 'SYSTEM', 'SYSTEM', '1234', '1234', 'creator');

/* Insert Test Sessions */
INSERT INTO `OpenProgression`.`Session` (`session_id`, `session_name`, `session_description`) VALUES ('1', 'DEFAULT', 'DEFAULT');

/* Insert Users Into Sessions */
INSERT INTO `OpenProgression`.`User_Session` (`user_id`, `session_id`, `user_session_permission`, `session_join_date`) VALUES ('1', '1', 'owner', '2007-04-30 13:10:02.047');
