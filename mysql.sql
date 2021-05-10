-- create database project;
create database project;
-- create table member
create table member (
	mb_no int(11) not null AUTO_INCREMENT PRIMARY KEY,
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
	UNIQUE index mb_id (mb_id),
	key mb_datetime (mb_datetime)
	);

CREATE TABLE board (
	board_no INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	member_id VARCHAR(20) NULL DEFAULT NULL COMMENT '작성자ID' COLLATE 'utf8_general_ci',
	member_name VARCHAR(20) NOT NULL COMMENT '작성자 이름' COLLATE 'utf8_general_ci',
	subject VARCHAR(50) NOT NULL COMMENT '게시글 제목' COLLATE 'utf8_general_ci',
	contents TEXT NOT NULL COMMENT '게시글 내용' COLLATE 'utf8_general_ci',
	hits INT(10) NOT NULL DEFAULT '0' COMMENT '조회수',
	reg_date DATETIME NOT NULL COMMENT '등록일'
)
COMMENT='PHP 게시판'
COLLATE='utf8_general_ci'
ENGINE=MyISAM
;


CREATE TABLE memo (
	me_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	me_recv_mb_id varchar(20) NOT NULL DEFAULT '',
	me_send_mb_id varchar(20) NOT NULL DEFAULT '',
	me_send_datetime datetime NOT NULL ,
	me_read_datetime datetime NOT NULL ,
	me_memo text NOT NULL,
	KEY me_recv_mb_id (me_recv_mb_id)
);