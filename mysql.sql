-- create table member
create table member (
	mb_no int(11) not null AUTO_INCREMENT,
	mb_id varchar(20) not null  default '',
	mb_password varchar(255) not null default '',
	mb_name varchar(255) not null default '',
	mb_email varchar(255) not null default '',
	mb_gender varchar(255) not null default '',
	mb_job varchar(255) not null default '',
	mb_language varchar(255) not null default '',
	mb_ip varchar(255) not null default '',
	mb_email_certify datetime not null,
	mb_email_certify2 varchar(255) not null default '',
	mb_datetime datetime not null,
	mb_modify_datetime datetime not null,
	space varchar(20) not null default '',
	primary key (mb_no),
	UNIQUE index mb_id (mb_id),
	key mb_datetime (mb_datetime)
	);

CREATE TABLE memo (
	me_id int(11) NOT NULL AUTO_INCREMENT,
	me_recv_mb_id varchar(20) NOT NULL DEFAULT '',
	me_send_mb_id varchar(20) NOT NULL DEFAULT '',
	me_send_datetime datetime NOT NULL ,
	me_read_datetime datetime NOT NULL ,
	me_memo text NOT NULL,
	PRIMARY KEY (me_id),
	KEY me_recv_mb_id (me_recv_mb_id)
);