-- https://www.phpmyadmin.net/

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `usuarios` (
  `codusuario` int(11) NOT NULL,
  `idusuario` varchar(30) NOT NULL,
  `senhausuario` varchar(30) NOT NULL,
  `nomeusuario` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `usuarios` (`codusuario`, `idusuario`, `senhausuario`, `nomeusuario`, `email`) VALUES
(1, 'maro17', '123321741', 'Marcio Rocha', 'marro@hotmail.com'),
(2, 'peido123', '321123963', 'Gica Piqueno', 'piquinim@outlook.com');

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`codusuario`),
  ADD UNIQUE KEY `idusuario` (`idusuario`);

ALTER TABLE `usuarios`
  MODIFY `codusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;
