SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
CREATE DATABASE IF NOT EXISTS `aulasphp` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `aulasphp`;

DROP TABLE IF EXISTS `tb_categorys`;
CREATE TABLE `tb_categorys` (
  `cat_id` int(11) NOT NULL,
  `cat_title` varchar(250) NOT NULL,
  `cat_name` varchar(250) NOT NULL,
  `cat_desc` varchar(250) DEFAULT NULL,
  `cat_parent` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tb_categorys` (`cat_id`, `cat_title`, `cat_name`, `cat_desc`, `cat_parent`) VALUES
(1, 'Notícias', 'noticias', 'Categoria genérica para teste', 0),
(2, 'Tecnologia', 'tecnologia', 'Noticias de técnologia em geral', 1);

DROP TABLE IF EXISTS `tb_posts`;
CREATE TABLE `tb_posts` (
  `post_id` int(11) NOT NULL,
  `post_title` varchar(250) NOT NULL,
  `post_name` varchar(250) NOT NULL,
  `post_image` varchar(250) NOT NULL,
  `post_author` varchar(250) NOT NULL,
  `post_text` text NOT NULL,
  `post_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `cat_id` int(11) DEFAULT NULL,
  `post_status` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tb_posts` (`post_id`, `post_title`, `post_name`, `post_image`, `post_author`, `post_text`, `post_date`, `cat_id`, `post_status`) VALUES
(1, 'Primeiro post', 'primeiro_post', '', 'Bruno Marques', '<h2>Subtítulo</h2>\n<p>Texto da postagem...</p>', '2018-10-24 09:55:04', 1, 1),
(2, 'Introdução ao banco de dados MySql', 'introducao-ao-banco-de-dados-mysql', '/uploads/2018/10/24/introducao-ao-banco-de-dados-mysql.jpg', 'Bruno Marques', '<p>\r\n\r\nMussum Ipsum, cacilds vidis litro abertis. A ordem dos tratores não altera o pão duris. Copo furadis é disculpa de bebadis, arcu quam euismod magna. Mauris nec dolor in eros commodo tempor. Aenean aliquam molestie leo, vitae iaculis nisl. Não sou faixa preta cumpadi, sou preto inteiris, inteiris.\r\n\r\n<br></p>', '2018-10-24 14:58:46', 2, 1);

DROP TABLE IF EXISTS `tb_users`;
CREATE TABLE `tb_users` (
  `id_user` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  `email` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tb_users` (`id_user`, `login`, `password`, `name`, `level`, `email`) VALUES
(1, 'bruno', '$2y$10$ulHPdOzgsxMszEW69R8ZpOK1soyNXdpP1erY6pxWO80I1jC7aLPhS', 'Bruno Marques', 1, 'bruno_s_marques@hotmail.com'),
(12, 'samuca', '$2y$10$tRfCggShr5sfpv3tBZYjreqgTGsdF6RV3lUxfIU.az4xAQBtCBGsC', 'Samuel', 1, 'samucarj@gmail.com');


ALTER TABLE `tb_categorys`
  ADD PRIMARY KEY (`cat_id`);

ALTER TABLE `tb_posts`
  ADD PRIMARY KEY (`post_id`);

ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id_user`);


ALTER TABLE `tb_categorys`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `tb_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `tb_users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;
