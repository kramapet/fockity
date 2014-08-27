drop table if exists `entity`;
create table `entity` (
	`id` int unsigned not null auto_increment,
	`name` char(50) not null,
	primary key (`id`)
)engine=innodb;

drop table if exists `property`;
create table `property` (
	`id` int unsigned not null auto_increment,
	`entity_id` int unsigned not null,
	`name` char(25) not null,
	foreign key (`entity_id`) references `entity` (`id`),
	unique (`id`, `entity_id`),
	primary key (`id`)
)engine=innodb;

drop table if exists `value`;
create table `value` (
	`id` int unsigned not null auto_increment,
	`property_id` int unsigned not null,
	`data` text default null,
	foreign key (`property_id`) references `property` (`id`),
	primary key (`id`)
)engine=innodb;

drop table if exists `record`;
create table `record` (
	`id` int unsigned not null auto_increment,
	`value_id` int unsigned not null,
	foreign key (`value_id`) references `value` (`id`),
	primary key (`id`, `value_id`)
)engine=innodb;
