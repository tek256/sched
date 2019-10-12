CREATE DATABASE sched;
USE sched;
CREATE TABLE events (
	id int NOT NULL AUTO_INCREMENT,
	name varchar(32) NOT NULL,
	sched_time datetime,
	link varchar(32),
	type_id int,
	timezone varchar(6)
);
