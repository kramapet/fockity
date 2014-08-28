drop table if exists `entity`;
create table `property` (
	`id` int unsigned not null auto_increment,
	`entity` char(50) not null,
	`property` char(50) not null,
	unique (`entity`, `property`),
	key (`entity`),
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

drop table if exists `reference`;
create table `reference` (
	`source_id` int unsigned not null,
	`target_id` int unsigned not null,
	foreign key (`source_id`) references `record` (`id`),
	foreign key (`target_id`) references `record` (`id`),
	primary key (`source_id`, `target_id`)
)engine=innodb;
