SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_userspasswordsrecoveries_create`$$
CREATE PROCEDURE `sp_userspasswordsrecoveries_create` (`id_user` INT, `user_ip` VARCHAR(45))  BEGIN
	
	INSERT INTO tb_userspasswordsrecoveries (id_user, user_ip)
    VALUES(id_user, user_ip);
    
    SELECT * FROM tb_userspasswordsrecoveries
    WHERE idrecovery = LAST_INSERT_ID();
    
END$$

DELIMITER ;

DROP TABLE IF EXISTS `tb_categories`;
CREATE TABLE `tb_categories` (
  `cat_id` int(11) NOT NULL,
  `cat_title` varchar(250) NOT NULL,
  `cat_name` varchar(250) NOT NULL,
  `cat_desc` varchar(250) DEFAULT NULL,
  `cat_parent` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tb_categories` (`cat_id`, `cat_title`, `cat_name`, `cat_desc`, `cat_parent`) VALUES
(1, 'Notícias', 'noticias', 'Categoria genérica para teste', 0);

DROP TABLE IF EXISTS `tb_comments`;
CREATE TABLE `tb_comments` (
  `comment_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment_user` varchar(100) NOT NULL,
  `comment_email` varchar(250) NOT NULL,
  `comment_replyto` int(11) DEFAULT NULL,
  `comment_status` tinyint(1) NOT NULL DEFAULT '0',
  `comment_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tb_posts`;
CREATE TABLE `tb_posts` (
  `post_id` int(11) NOT NULL,
  `post_title` varchar(250) NOT NULL,
  `post_name` varchar(250) NOT NULL,
  `post_image` varchar(250) NOT NULL,
  `post_author` varchar(250) NOT NULL,
  `post_text` text NOT NULL,
  `post_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `cat_id` int(11) DEFAULT NULL,
  `post_status` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tb_users`;
CREATE TABLE `tb_users` (
  `id_user` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `name` varchar(100) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  `email` varchar(250) NOT NULL,
  `user_update` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tb_users` (`id_user`, `login`, `password`, `name`, `level`, `email`, `user_update`) VALUES
(14, 'admin', '$2y$10$oQORs8nDGkQQSIXXWN6pdutO8vJqn/dOPSzfjWUZrV4zHP2ir1wNW', 'Administrador', 1, 'webmaster@seusite.com.br', '0000-00-00 00:00:00');

DROP TABLE IF EXISTS `tb_userspasswordsrecoveries`;
CREATE TABLE `tb_userspasswordsrecoveries` (
  `idrecovery` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `user_ip` varchar(45) NOT NULL,
  `dtrecovery` datetime DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `tb_categories`
  ADD PRIMARY KEY (`cat_id`);

ALTER TABLE `tb_comments`
  ADD PRIMARY KEY (`comment_id`);

ALTER TABLE `tb_posts`
  ADD PRIMARY KEY (`post_id`);

ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id_user`);

ALTER TABLE `tb_userspasswordsrecoveries`
  ADD PRIMARY KEY (`idrecovery`);


ALTER TABLE `tb_categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `tb_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tb_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tb_users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

ALTER TABLE `tb_userspasswordsrecoveries`
  MODIFY `idrecovery` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
