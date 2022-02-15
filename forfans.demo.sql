-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 15, 2022 at 04:31 PM
-- Server version: 10.6.4-MariaDB
-- PHP Version: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forfans`
--

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

CREATE TABLE `genders` (
  `gender_id` int(11) NOT NULL,
  `gender_langkey` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`gender_id`, `gender_langkey`) VALUES
(2, 'female'),
(9, 'fluid'),
(12, 'fluido_cis_m'),
(10, 'fluid_cis_f'),
(11, 'fluid_cis_m'),
(1, 'male'),
(3, 'transgender'),
(7, 'transgender_ftm'),
(5, 'transgender_mtf'),
(4, 'transsexual'),
(8, 'transsexual_ftm'),
(6, 'transsexual_mtf');

-- --------------------------------------------------------

--
-- Table structure for table `mensajes`
--

CREATE TABLE `mensajes` (
  `id_mensaje` int(11) NOT NULL,
  `id_emisor` int(11) NOT NULL,
  `id_receptor` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `contenido_media` varchar(2048) NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `for_id` int(11) DEFAULT NULL,
  `post_text` varchar(2400) DEFAULT NULL,
  `is_nsfw` tinyint(1) NOT NULL DEFAULT 0,
  `post_img_array` varchar(2400) DEFAULT NULL,
  `post_video_array` varchar(2400) DEFAULT NULL,
  `post_file_array` varchar(2400) DEFAULT NULL,
  `post_audio_array` varchar(2400) DEFAULT NULL,
  `post_gif_array` varchar(1024) DEFAULT NULL,
  `for_fans` tinyint(1) NOT NULL DEFAULT 0,
  `for_everyone` tinyint(1) NOT NULL DEFAULT 1,
  `post_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `post_donations` decimal(10,2) NOT NULL DEFAULT 0.00,
  `post_removed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `for_id`, `post_text`, `is_nsfw`, `post_img_array`, `post_video_array`, `post_file_array`, `post_audio_array`, `post_gif_array`, `for_fans`, `for_everyone`, `post_time`, `post_donations`, `post_removed`) VALUES
(1, 1, 2, 'Esta es la primera publicacion!', 0, '[\"https://cataas.com/cat/says/Post1\",\"https://cataas.com/cat/says/WoW\"]', NULL, NULL, NULL, NULL, 0, 1, '2022-01-26 16:18:01', '5.00', 0),
(2, 2, 1, 'Esta es la segunda publicacion!', 0, '[\"https://cataas.com/cat/says/Post2\",\"https://cataas.com/cat/says/LMAO\"]', NULL, NULL, NULL, NULL, 0, 1, '2022-01-26 16:18:28', '5.00', 0),
(3, 1, NULL, 'Setting up this shit lmao', 0, NULL, NULL, NULL, NULL, NULL, 0, 1, '2022-01-27 18:07:35', '233.00', 0),
(4, 1, NULL, 'Jijijija', 0, NULL, NULL, NULL, NULL, NULL, 0, 1, '2022-02-08 15:40:54', '0.00', 0),
(5, 1, 3, 'LY :P', 0, NULL, NULL, NULL, NULL, NULL, 0, 1, '2022-02-08 16:10:43', '0.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `relationships`
--

CREATE TABLE `relationships` (
  `rel_id` int(11) NOT NULL,
  `user_related` int(11) NOT NULL,
  `relation type` varchar(200) NOT NULL,
  `related_to` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `relationships`
--

INSERT INTO `relationships` (`rel_id`, `user_related`, `relation type`, `related_to`) VALUES
(1, 2, 'follow', 1),
(2, 3, 'follow', 1),
(3, 1, 'follow', 3);

-- --------------------------------------------------------

--
-- Table structure for table `sexual_orientations`
--

CREATE TABLE `sexual_orientations` (
  `id` int(11) NOT NULL,
  `langkey` varchar(20) NOT NULL,
  `css-cone-flag` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `sexual_orientations`
--

INSERT INTO `sexual_orientations` (`id`, `langkey`, `css-cone-flag`) VALUES
(1, 'heterosexual', 'conic-gradient(black, white, black, white, black, white, black);'),
(2, 'homosexual', 'conic-gradient(red, orange, yellow, lime, blue, red);'),
(3, 'bisexual', 'conic-gradient(pink, purple, blue, pink);'),
(4, 'pansexual', 'conic-gradient(pink, yellow, cyan, pink);'),
(5, 'transexual', 'conic-gradient(pink, blue, pink, blue, pink, blue, pink);');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `token_id` int(11) NOT NULL,
  `ip_issued` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `token` varchar(520) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`token_id`, `ip_issued`, `timestamp`, `token`, `user_id`) VALUES
(1, 'localhost', '2021-11-10 15:41:31', 'TOKEN_MANUAL', 1),
(74, '37.133.114.182', '2021-12-14 16:11:27', 'afa68251edfc6d273d48a4adb7c6db1c5d05c7c144b0123cb40b0991953b1ece95d043e5dcaf773ce836578fe7f6d603e35e60c213850b1d1a93a4f', 1),
(75, '37.133.114.182', '2021-12-20 16:10:41', 'f22b333e553a1651ba046fff17af4c1ce5a924ba1581593fde0f768cb6de1256554c0acb729adf50d47dbcadff2e663078969f6e576a5bbe83e03730', 1),
(76, '37.133.114.182', '2021-12-27 09:46:46', 'cbd2f1314749d70f676e41c23e738f1c5b9f32d942da74419576d96343d50775fa94d1aa560912cc6248f3088bb5dfba1cd14abe5d3c17b195931d90', 1),
(78, '90.167.86.229', '2022-01-11 15:09:45', '25bd7ebb5a2aa71e4a5430e378613914e50058c8e9c9c877313d5345371f9bb7eafe14955cacf16d870620f9eda6d922bf4b00346009b51b3f8af1c6', 1),
(79, '90.167.86.229', '2022-01-11 15:25:37', '6a43f1e7717f7a93a8676e239858586c33612835b4f33c77726df564d04391343658842fd51b6737fc9d5d15d86b92c08635df9fbf97b0fc17e41e16', 1),
(80, '37.133.114.182', '2022-01-17 16:25:39', 'dd96229d7c9287a4aaefe45f785fd3fdd9768daf5a5f7de69c03cf42dfd6fdbccabfe3f28be851b1f9ade5ae3afd3f911b741bdda410c3324fa14431', 1),
(81, '90.167.87.47', '2022-01-18 14:51:55', '93cbf08ba741c389139ae81bed74259779c4c500842cd78e537bf3ca818a6b7d772b24ab74a13c99477594c5a98af9e94544806275e2b72dd54b6b36', 1),
(84, '185.124.31.156', '2022-01-20 17:11:20', '4752963e275bd093a9b9b27f46eb5a16eb92832851078a01d72da88324e55ac6380a0f3addf5a80d0215497bd1d70512fc5f56c8f6a9d281f4d4ecd2', 1),
(86, '37.133.114.182', '2022-01-20 17:16:59', 'fed619c4e42ba285478b47ce84947f6e95728e1955f40008727c74ac5fd08a12569aec81bbea2a23dd493c87b0f37741242e9ebbb8f8f454526a3697', 1),
(98, '2.136.29.100', '2022-01-27 15:46:05', '04bb0eedfcc9815b9317038e6f6c6ec6b60977b364f6af081b9fc50df8bb21ac940e7c5c795e60fa92bb47b44fb0488d3850fbc436742ba20b73f7dd', 1),
(99, '37.133.114.182', '2022-01-27 17:16:00', 'fc5f9f28b6a32567e4d8b2da7e341972b8b49e5b8259a77da3ecc35621179cb797963d363a9df28cf99d47cfa9c4bdd6890ebc45a570993db1d3717c', 1),
(100, '2.136.29.100', '2022-01-27 17:44:14', '165f7e1a8d431d97abf34e10a83dcf9b1d0d944ae93138228b94ddb672f04aa7c6570a4a5a676358fe48466e9bc14c7780f458994ef51bbb875023f0', 1),
(101, '37.133.114.182', '2022-01-28 15:07:38', 'ff830018beff39db656fecc1c728dfc731531af3228a9087343abcce5444adf29fb4bcccd3b216862cdec1fb3675161510f4d15d6bbf90c3e2655ddc', 1),
(103, '37.133.114.182', '2022-01-31 10:53:02', '5e34c2a8c812e95762214d9621bbf34944871f983a08501ead9c2400c5bd2532158a3ee8631f4826f7fdb3126817372b731790efec0d2648ebdd37b6', 1),
(109, '37.133.114.182', '2022-02-03 17:55:12', 'b3877c8feff1272ce8ddf3aeca4ff8577c2e782486f55243b4b1a48709433b929a4fdb4c2e7d772fc6a0d8699d108851ad970abeb75fa3f2a5bcfedd', 1),
(110, '37.133.114.182', '2022-02-04 15:51:55', '6b556be2d19d8e137aba8658363ca9fff9618d4351e192d80aa284b5762bc96b6dbf424ef9526a9d07f696ba0040d229d4356f5e3ac5f10f68a90a6e', 1),
(113, '139.47.37.13', '2022-02-09 12:13:03', '5aa67c94a2019bef1dd100d07dc4c2cfff6a740b7c735b5e67bec66b6719b29d1752cc4cc1e4a87e52bc31b814f1da13a32cadf4a5dccb2db2b53bb8', 1),
(114, '37.133.114.182', '2022-02-09 14:59:12', 'd55a00ab16908a2d8e2397fe5fb40ba8e5a2b93dc0fd656f250c8225f97c7e91baa1490a3b36376ba05d982d48c5ecb9eca6c4e6dadd92ebf75fb3b3', 1),
(115, '37.133.114.182', '2022-02-09 14:59:12', 'cf61420e35af8f62d715b92d1b40c603a49e49cfb881035635fde746b3a7e4a37dd4f48bb294ecbac93464da2e95298d9c161fbb6cf5dc1523ae55f2', 1),
(116, '37.133.114.182', '2022-02-09 14:59:12', '11c6430d13031cd8b95433149ae92fa242d54277d475d0464b430deee57c6376dc50420f6aacb2405e177267936c6f244df7b3240e39adea8aa96bcb', 1),
(117, '37.133.114.182', '2022-02-09 14:59:12', '1e9009094353b51f3906d670df09af7dc86058c48dddd42af6ab1114cb817dfd6543ca4c01fc132de036e35d84ad9b350ff6e0028c8f52077e69426b', 1),
(118, '37.133.114.182', '2022-02-09 19:17:19', 'e1f1c27661f5662d0310d5569384c391a3d1b5f163e95672814311c840b1c682459bf59b48b78ce498cc8a0714acf8dd85ff2f19edcf7b434456ce26', 1),
(119, '37.133.114.182', '2022-02-09 19:17:20', '05a06666d22e1875b9f4b362d8b767f93cafef1a830c34a73bcb9a2526323df02f9fce0c95e371dcf2c86b14826270f67457773f1dcea9a33ba18a51', 1),
(120, '37.133.114.182', '2022-02-11 17:27:42', '96796deffb2cfa19ba28fbcc5683b7be74f48cc4378219ab003e48682d2f4cea039b22a58f0364ce006783a5267e8484662a956857f2aa91f3320002', 1),
(122, '37.133.114.182', '2022-02-14 14:19:12', 'bf0df5cea686f29ce3669e4f321eacc85e2c5ac522e6e21b086535bbfd08aba5906bdb747102cd262cf37e8e9aa05fe4c479ea68c5ffb6d0d8e459be', 1),
(123, '90.167.87.223', '2022-02-14 16:30:18', '75f890fffd414d84894c71f2ddd8cc9c5262a5bd36c972a21c540e8216311f29f9941bc989ca06a4c6d462c3744c61f54a889aa2f692f056038968e8', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuarios` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `correo` varchar(250) NOT NULL,
  `profile_picture_rpath` varchar(255) NOT NULL,
  `cover_picture_rpath` varchar(1024) NOT NULL DEFAULT 'upload/pictures/default-cover.jpg',
  `contraseña` varchar(70) NOT NULL,
  `gender_langkey` varchar(50) NOT NULL,
  `sexual_orientations_id` int(11) NOT NULL,
  `fecha_de_inicio` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_de_la_ultima_conexion` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nombre` varchar(30) NOT NULL,
  `apellidos` varchar(200) NOT NULL,
  `displayName` varchar(18) NOT NULL,
  `cumple` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `default_theme_variable` varchar(28) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id_usuarios`, `username`, `correo`, `profile_picture_rpath`, `cover_picture_rpath`, `contraseña`, `gender_langkey`, `sexual_orientations_id`, `fecha_de_inicio`, `fecha_de_la_ultima_conexion`, `nombre`, `apellidos`, `displayName`, `cumple`, `default_theme_variable`) VALUES
(1, 'admin', 'admin@societyplus.net', 'upload/pictures/admin_pfp.jpg', 'upload/pictures/default-cover.jpg', '$2y$10$9hZoJU0EYwE6YDulK4oPTOjXsT9HyPTaCjWhx7JILkOqIFeCXp2QO', '', 2, '2022-02-14 16:41:40', '0000-00-00 00:00:00', 'Mark', 'Moreno', 'LiLPandemio', '2003-03-24 12:20:22', NULL),
(2, 'brmepa20', 'brmepa20@bemen3.cat', 'upload/pictures/default_pfp.jpg', 'upload/pictures/default-cover.jpg', '$2y$10$9hZoJU0EYwE6YDulK4oPTOjXsT9HyPTaCjWhx7JILkOqIFeCXp2QO', '', 1, '2022-02-14 16:41:30', '0000-00-00 00:00:00', 'Bryan', 'medrano pacheco', 'Bryan', '2003-06-09 14:18:01', NULL),
(3, 'issx_nce', 'isabelchavarrias10@gmail.com', 'upload/pictures/default_pfp.jpg', 'upload/pictures/default-cover.jpg', '$2y$10$9hZoJU0EYwE6YDulK4oPTOjXsT9HyPTaCjWhx7JILkOqIFeCXp2QO', '', 2, '2022-02-14 16:41:42', '0000-00-00 00:00:00', 'Isabel', 'Chavarrias Mitrovic', '', '2002-09-10 10:36:02', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`gender_id`),
  ADD UNIQUE KEY `gender_langkey` (`gender_langkey`);

--
-- Indexes for table `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id_mensaje`),
  ADD KEY `id_emisor` (`id_emisor`,`id_receptor`),
  ADD KEY `id_receptor` (`id_receptor`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`,`for_id`),
  ADD KEY `for_id` (`for_id`);

--
-- Indexes for table `relationships`
--
ALTER TABLE `relationships`
  ADD PRIMARY KEY (`rel_id`),
  ADD KEY `user_related` (`user_related`,`related_to`),
  ADD KEY `related_to` (`related_to`);

--
-- Indexes for table `sexual_orientations`
--
ALTER TABLE `sexual_orientations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`token_id`),
  ADD KEY `Usuario` (`user_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuarios`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `genders`
--
ALTER TABLE `genders`
  MODIFY `gender_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `relationships`
--
ALTER TABLE `relationships`
  MODIFY `rel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sexual_orientations`
--
ALTER TABLE `sexual_orientations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`id_emisor`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`id_receptor`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`for_id`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `relationships`
--
ALTER TABLE `relationships`
  ADD CONSTRAINT `relationships_ibfk_1` FOREIGN KEY (`user_related`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relationships_ibfk_2` FOREIGN KEY (`related_to`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
