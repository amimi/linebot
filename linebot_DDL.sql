DROP DATABASE IF EXISTS `linebot`;

CREATE DATABASE `linebot`;
USE `linebot`;

-- 友達テーブル作成
DROP TABLE IF EXISTS `friends`;
CREATE TABLE `friends` (
	`id`					INT NOT NULL AUTO_INCREMENT		COMMENT 'ID',
	`mid`					varchar(126)					COMMENT 'MID',
	`name`					varchar(126)					COMMENT '名前',
	`image`					varchar(126)					COMMENT 'プロフィール画像',
	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='権限マスタ';

