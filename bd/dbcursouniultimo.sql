-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-07-2024 a las 00:51:22
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbcursouni`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoriax`
--

CREATE TABLE `categoriax` (
  `idcategoriax` int(11) NOT NULL,
  `nomx` varchar(100) NOT NULL,
  `descx` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoriax`
--

INSERT INTO `categoriax` (`idcategoriax`, `nomx`, `descx`) VALUES
(1, 'GEOTECNIA', NULL),
(2, 'ESTRUCTURAS', NULL),
(3, 'hola', ''),
(4, 'junior', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursox`
--

CREATE TABLE `cursox` (
  `idcursox` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `docentex` text NOT NULL,
  `celularx` int(9) NOT NULL,
  `estadox` tinyint(4) NOT NULL,
  `idcategoriax` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cursox`
--

INSERT INTO `cursox` (`idcursox`, `nombre`, `docentex`, `celularx`, `estadox`, `idcategoriax`) VALUES
(2, 'estructuras metalicas', 'morales tarazona', 458796589, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `idempleado` int(11) NOT NULL,
  `apenom` varchar(200) NOT NULL,
  `cargo` varchar(45) NOT NULL,
  `idusux` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestax`
--

CREATE TABLE `encuestax` (
  `idencuestax` int(11) NOT NULL,
  `titulox` varchar(255) NOT NULL,
  `descripx` text DEFAULT NULL,
  `f_creacion` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacionx`
--

CREATE TABLE `notificacionx` (
  `idnotificacionx` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `leido` tinyint(4) DEFAULT 0,
  `fec` timestamp NULL DEFAULT current_timestamp(),
  `idusux` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `notificacionx`
--

INSERT INTO `notificacionx` (`idnotificacionx`, `titulo`, `mensaje`, `leido`, `fec`, `idusux`) VALUES
(5, 'este esto una prueba', 'como es posible este error', 1, '2024-07-10 22:48:28', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opcionx`
--

CREATE TABLE `opcionx` (
  `idopcionx` int(11) NOT NULL,
  `texto_opcionx` text NOT NULL,
  `idpreguntax` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntax`
--

CREATE TABLE `preguntax` (
  `idpreguntax` int(11) NOT NULL,
  `texto_pregunta` text NOT NULL,
  `tipo_pregunta` enum('multiple_choice','single_choice','text') NOT NULL,
  `idencuestax` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursox`
--

CREATE TABLE `recursox` (
  `idrecursox` int(11) NOT NULL,
  `nom_recu` varchar(150) NOT NULL,
  `recurso` text NOT NULL,
  `f_regis` timestamp NULL DEFAULT current_timestamp(),
  `icono` text DEFAULT NULL,
  `idtipo_recursox` int(11) NOT NULL,
  `idtemax` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `recursox`
--

INSERT INTO `recursox` (`idrecursox`, `nom_recu`, `recurso`, `f_regis`, `icono`, `idtipo_recursox`, `idtemax`) VALUES
(1, 'prueba1', 'dbcursouni_1720533134.png', '2024-07-09 13:52:14', 'icon-fotos-48.png', 2, 3),
(2, 'construyendo 1 2 34', 'dbcursouni_1720538580.png', '2024-07-09 15:23:00', 'icon-libro-50.png', 1, 3),
(3, 'holaaaa', 'dbcursouni_1720549711.png', '2024-07-09 18:28:32', 'icon-fotos-48.png', 2, 3),
(4, 'recojo', 'dbcursouni_1720554447.png', '2024-07-09 19:47:27', 'icon-vídeo-50.png', 2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestax`
--

CREATE TABLE `respuestax` (
  `idrespuestax` int(11) NOT NULL,
  `texto_respuesta` text DEFAULT NULL,
  `f_respuesta` timestamp NULL DEFAULT current_timestamp(),
  `idpreguntax` int(11) NOT NULL,
  `idusux` int(11) NOT NULL,
  `idopcionx` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sliderx`
--

CREATE TABLE `sliderx` (
  `idsliderx` int(11) NOT NULL,
  `imagen` text NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sugerenciax`
--

CREATE TABLE `sugerenciax` (
  `idsugerenciax` int(11) NOT NULL,
  `descx` text NOT NULL,
  `f_registro` timestamp NULL DEFAULT current_timestamp(),
  `estado_segu` tinyint(1) NOT NULL,
  `idusux` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sugerenciax`
--

INSERT INTO `sugerenciax` (`idsugerenciax`, `descx`, `f_registro`, `estado_segu`, `idusux`) VALUES
(1, 'mejorar las imagenes mostradas', '2024-07-09 22:02:01', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temax`
--

CREATE TABLE `temax` (
  `idtemax` int(11) NOT NULL,
  `temx` text NOT NULL,
  `estadox` tinyint(4) NOT NULL,
  `idcursox` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `temax`
--

INSERT INTO `temax` (`idtemax`, `temx`, `estadox`, `idcursox`) VALUES
(3, 'CONSTRUCCION DE PISOS', 1, 2),
(4, 'CONTRUYENDO EDIFICIOS', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_recursox`
--

CREATE TABLE `tipo_recursox` (
  `idtipo_recursox` int(11) NOT NULL,
  `tipox` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_recursox`
--

INSERT INTO `tipo_recursox` (`idtipo_recursox`, `tipox`) VALUES
(1, 'LIBROS'),
(2, 'VIDEOS'),
(3, 'RESUMENES'),
(4, 'INFOGRAFÍAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariox`
--

CREATE TABLE `usuariox` (
  `idusuariox` int(11) NOT NULL,
  `dnix` char(8) NOT NULL,
  `apelx` varchar(80) NOT NULL,
  `nomx` varchar(80) NOT NULL,
  `unix` varchar(200) NOT NULL,
  `facux` varchar(200) NOT NULL,
  `escux` varchar(200) NOT NULL,
  `celx` char(9) NOT NULL,
  `dirx` varchar(150) DEFAULT NULL,
  `emailx` varchar(80) NOT NULL,
  `fotox` text DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT current_timestamp(),
  `idusux` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuariox`
--

INSERT INTO `usuariox` (`idusuariox`, `dnix`, `apelx`, `nomx`, `unix`, `facux`, `escux`, `celx`, `dirx`, `emailx`, `fotox`, `fecha`, `idusux`) VALUES
(1, '12345678', 'junior', 'junior', 'junior', 'junior', 'junior', '123456789', '', 'junior@junior.com', NULL, '2024-07-01 19:04:14', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usux`
--

CREATE TABLE `usux` (
  `idusux` int(11) NOT NULL,
  `usux` varchar(120) NOT NULL,
  `clvx` varchar(150) NOT NULL,
  `estadox` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usux`
--

INSERT INTO `usux` (`idusux`, `usux`, `clvx`, `estadox`) VALUES
(1, 'junior', '123456', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viewx`
--

CREATE TABLE `viewx` (
  `idviewx` int(11) NOT NULL,
  `view_date` timestamp NULL DEFAULT current_timestamp(),
  `user_ip` text DEFAULT NULL,
  `idrecursox` int(11) NOT NULL,
  `idusux` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoriax`
--
ALTER TABLE `categoriax`
  ADD PRIMARY KEY (`idcategoriax`);

--
-- Indices de la tabla `cursox`
--
ALTER TABLE `cursox`
  ADD PRIMARY KEY (`idcursox`),
  ADD KEY `categoriax1` (`idcategoriax`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`idempleado`),
  ADD KEY `usux5` (`idusux`);

--
-- Indices de la tabla `encuestax`
--
ALTER TABLE `encuestax`
  ADD PRIMARY KEY (`idencuestax`);

--
-- Indices de la tabla `notificacionx`
--
ALTER TABLE `notificacionx`
  ADD PRIMARY KEY (`idnotificacionx`),
  ADD KEY `usux4` (`idusux`);

--
-- Indices de la tabla `opcionx`
--
ALTER TABLE `opcionx`
  ADD PRIMARY KEY (`idopcionx`),
  ADD KEY `preguntax1` (`idpreguntax`);

--
-- Indices de la tabla `preguntax`
--
ALTER TABLE `preguntax`
  ADD PRIMARY KEY (`idpreguntax`),
  ADD KEY `encuestax1` (`idencuestax`);

--
-- Indices de la tabla `recursox`
--
ALTER TABLE `recursox`
  ADD PRIMARY KEY (`idrecursox`),
  ADD KEY `tipo_recursox` (`idtipo_recursox`),
  ADD KEY `temax1` (`idtemax`);

--
-- Indices de la tabla `respuestax`
--
ALTER TABLE `respuestax`
  ADD PRIMARY KEY (`idrespuestax`),
  ADD KEY `preguntax2` (`idpreguntax`),
  ADD KEY `usux2` (`idusux`),
  ADD KEY `opcionx1` (`idopcionx`);

--
-- Indices de la tabla `sliderx`
--
ALTER TABLE `sliderx`
  ADD PRIMARY KEY (`idsliderx`);

--
-- Indices de la tabla `sugerenciax`
--
ALTER TABLE `sugerenciax`
  ADD PRIMARY KEY (`idsugerenciax`),
  ADD KEY `usux3` (`idusux`);

--
-- Indices de la tabla `temax`
--
ALTER TABLE `temax`
  ADD PRIMARY KEY (`idtemax`),
  ADD KEY `cursox1` (`idcursox`);

--
-- Indices de la tabla `tipo_recursox`
--
ALTER TABLE `tipo_recursox`
  ADD PRIMARY KEY (`idtipo_recursox`);

--
-- Indices de la tabla `usuariox`
--
ALTER TABLE `usuariox`
  ADD PRIMARY KEY (`idusuariox`),
  ADD KEY `usux6` (`idusux`);

--
-- Indices de la tabla `usux`
--
ALTER TABLE `usux`
  ADD PRIMARY KEY (`idusux`);

--
-- Indices de la tabla `viewx`
--
ALTER TABLE `viewx`
  ADD PRIMARY KEY (`idviewx`),
  ADD KEY `recursox1` (`idrecursox`),
  ADD KEY `usux1` (`idusux`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoriax`
--
ALTER TABLE `categoriax`
  MODIFY `idcategoriax` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cursox`
--
ALTER TABLE `cursox`
  MODIFY `idcursox` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `idempleado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `encuestax`
--
ALTER TABLE `encuestax`
  MODIFY `idencuestax` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificacionx`
--
ALTER TABLE `notificacionx`
  MODIFY `idnotificacionx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `opcionx`
--
ALTER TABLE `opcionx`
  MODIFY `idopcionx` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `preguntax`
--
ALTER TABLE `preguntax`
  MODIFY `idpreguntax` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recursox`
--
ALTER TABLE `recursox`
  MODIFY `idrecursox` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `sliderx`
--
ALTER TABLE `sliderx`
  MODIFY `idsliderx` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sugerenciax`
--
ALTER TABLE `sugerenciax`
  MODIFY `idsugerenciax` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `temax`
--
ALTER TABLE `temax`
  MODIFY `idtemax` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_recursox`
--
ALTER TABLE `tipo_recursox`
  MODIFY `idtipo_recursox` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuariox`
--
ALTER TABLE `usuariox`
  MODIFY `idusuariox` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usux`
--
ALTER TABLE `usux`
  MODIFY `idusux` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `viewx`
--
ALTER TABLE `viewx`
  MODIFY `idviewx` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cursox`
--
ALTER TABLE `cursox`
  ADD CONSTRAINT `categoriax1` FOREIGN KEY (`idcategoriax`) REFERENCES `categoriax` (`idcategoriax`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `usux5` FOREIGN KEY (`idusux`) REFERENCES `usux` (`idusux`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `notificacionx`
--
ALTER TABLE `notificacionx`
  ADD CONSTRAINT `usux4` FOREIGN KEY (`idusux`) REFERENCES `usux` (`idusux`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `opcionx`
--
ALTER TABLE `opcionx`
  ADD CONSTRAINT `preguntax1` FOREIGN KEY (`idpreguntax`) REFERENCES `preguntax` (`idpreguntax`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `preguntax`
--
ALTER TABLE `preguntax`
  ADD CONSTRAINT `encuestax1` FOREIGN KEY (`idencuestax`) REFERENCES `encuestax` (`idencuestax`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `recursox`
--
ALTER TABLE `recursox`
  ADD CONSTRAINT `temax1` FOREIGN KEY (`idtemax`) REFERENCES `temax` (`idtemax`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tipo_recursox` FOREIGN KEY (`idtipo_recursox`) REFERENCES `tipo_recursox` (`idtipo_recursox`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `respuestax`
--
ALTER TABLE `respuestax`
  ADD CONSTRAINT `opcionx1` FOREIGN KEY (`idopcionx`) REFERENCES `opcionx` (`idopcionx`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `preguntax2` FOREIGN KEY (`idpreguntax`) REFERENCES `preguntax` (`idpreguntax`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usux2` FOREIGN KEY (`idusux`) REFERENCES `usux` (`idusux`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sugerenciax`
--
ALTER TABLE `sugerenciax`
  ADD CONSTRAINT `usux3` FOREIGN KEY (`idusux`) REFERENCES `usux` (`idusux`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `temax`
--
ALTER TABLE `temax`
  ADD CONSTRAINT `cursox1` FOREIGN KEY (`idcursox`) REFERENCES `cursox` (`idcursox`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuariox`
--
ALTER TABLE `usuariox`
  ADD CONSTRAINT `usux6` FOREIGN KEY (`idusux`) REFERENCES `usux` (`idusux`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `viewx`
--
ALTER TABLE `viewx`
  ADD CONSTRAINT `recursox1` FOREIGN KEY (`idrecursox`) REFERENCES `recursox` (`idrecursox`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usux1` FOREIGN KEY (`idusux`) REFERENCES `usux` (`idusux`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
