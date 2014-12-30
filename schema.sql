create database if not exists `fockity_dbunit`;
use fockity_dbunit;

drop table if exists `entity`;
create table `entity` (
	`id` int(10) not null auto_increment,
	`name` char(25) not null,
	unique (`name`),
	primary key (`id`)
)engine=innodb;

drop table if exists `property`;
create table `property` (
	`id` int(10) not null auto_increment,
	`entity_id` int(10) not null,
	`name` char(25) not null,
	`type` char(3) not null,
	unique (`entity_id`, `name`),
	-- foreign key (`entity_id`) references `entity` (`id`),
	primary key (`id`)
)engine=innodb;

drop table if exists `record`;
create table `record` (
	`id` int(10) not null auto_increment,
	`entity_id` int(10) not null,
	-- foreign key (`entity_id`) references `entity` (`id`),
	primary key (`id`)
)engine=innodb;


drop table if exists `value`;
create table `value` (
	`id` int(10) not null auto_increment,
	`property_id` int(10) not null,
	`record_id` int(10) not null,
	`value` text not null,
	-- foreign key (`property_id`) references `property` (`id`),
	-- foreign key (`record_id`) references `record` (`id`),
	primary key (`id`)
)engine=innodb;

drop table if exists `link`;
create table `link` (
	`id` int(10) not null auto_increment,
	`value_id` int(10) not null,
	`left` int(10) not null,
	`right` int(10) not null,
	-- foreign key (`value_id`) references `value` (`id`),
	key `link_left` (`left`),
	key `link_right` (`right`),
	primary key (`id`)
)engine=innodb;
