-- phpMyAdmin SQL Dump
-- version 4.6.4deb1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 07-04-2017 a las 12:14:25
-- Versión del servidor: 5.7.17-0ubuntu0.16.10.1
-- Versión de PHP: 7.0.15-0ubuntu0.16.10.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `Apuntes`
--

--
-- Volcado de datos para la tabla `Anio`
--

INSERT INTO `Anio` (`IdAnio`, `Anio`) VALUES
(0, '2010/2011'),
(1, '2011/2012'),
(2, '2012/2013'),
(3, '2013/2014'),
(4, '2014/2015'),
(5, '2015/2016'),
(6, '2016/2017');

--
-- Volcado de datos para la tabla `Apuntes`
--

INSERT INTO `Apuntes` (`IdApuntes`, `Titulo`, `Usuarios`, `FechaSubida`, `Tipo`, `Anio`, `Documento`, `hash`, `Comentario`, `Asignatura`) VALUES
(1, 'Cuando las cosas se ponen feas', 1, '2017-04-02 13:29:55', 0, 4, 'cuando.pdf', '', '', 0),
(2, 'Examen Parcial Inexistente', 1, '2017-04-05 14:59:09', 1, 3, 'examenparcial.pdf', '832rn0xyrqx8yfn08', 'Examen parcial del año la polka', 2),
(3, 'No es lo mismo montar un follón', 1, '2017-04-06 23:42:54', 0, 3, 'noes.pdf', '', 'Libro sobre cosas', 3),
(4, 'Electromagnetismo inutil', 1, '2017-04-06 23:43:27', 0, 3, 'no2es.pdf', '', 'Tengo cien de estos', 2);

--
-- Volcado de datos para la tabla `Asignatura`
--

INSERT INTO `Asignatura` (`IdAsignatura`, `Codigo`, `Nombre`, `Estudios`, `Curso`) VALUES
(1, 'G53', 'Termodinámica', 0, 2),
(2, 'G51', 'Electricidad y magnetismo', 0, 2),
(3, 'G55', 'Física Cuántica y Estructura de la Materia I: Fund', 0, 2);

--
-- Volcado de datos para la tabla `Curso`
--

INSERT INTO `Curso` (`IdCurso`) VALUES
(1),
(2),
(3),
(4);

--
-- Volcado de datos para la tabla `Estudios`
--

INSERT INTO `Estudios` (`IdEstudios`, `Nombre`) VALUES
(0, 'Física'),
(1, 'Matemáticas');

--
-- Volcado de datos para la tabla `Tipo`
--

INSERT INTO `Tipo` (`IdTipo`, `Nombre`) VALUES
(0, 'Apuntes'),
(1, 'Examen');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
