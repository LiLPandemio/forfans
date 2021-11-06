# Host: localhost  (Version 5.5.5-10.6.4-MariaDB)
# Date: 2021-11-06 13:18:55
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "post"
#

DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `id_foto` int(11) NOT NULL AUTO_INCREMENT,
  `video` varchar(2048) DEFAULT NULL,
  `texto` varchar(2048) DEFAULT NULL,
  `historia` varchar(2048) DEFAULT NULL,
  `publicaciones` varchar(2048) DEFAULT NULL,
  `id_publicador` int(11) NOT NULL,
  PRIMARY KEY (`id_foto`),
  KEY `id_publicador` (`id_publicador`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`id_publicador`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

#
# Structure for table "usuarios"
#

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id_usuarios` int(11) NOT NULL AUTO_INCREMENT,
  `correo` varchar(250) NOT NULL,
  `contraseña` varchar(70) NOT NULL,
  `genero` int(11) NOT NULL,
  `fecha_de_inicio` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_de_la_ultima_conexion` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nombre` varchar(30) NOT NULL,
  `apellidos` varchar(200) NOT NULL,
  `cumple` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_usuarios`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

#
# Structure for table "mensajes"
#

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE `mensajes` (
  `id_mensaje` int(11) NOT NULL,
  `id_emisor` int(11) NOT NULL,
  `id_receptor` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `contenido_media` varchar(2048) NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_mensaje`),
  KEY `id_emisor` (`id_emisor`,`id_receptor`),
  KEY `id_receptor` (`id_receptor`),
  CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`id_emisor`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`id_receptor`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
