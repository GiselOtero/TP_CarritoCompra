-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-12-2022 a las 03:19:42
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `carritocompras`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `idcompra` bigint(20) NOT NULL,
  `cofecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `idusuario` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`idcompra`, `cofecha`, `idusuario`) VALUES
(1, '2022-11-20 20:16:55', 1),
(2, '0000-00-00 00:00:00', 12),
(3, '0000-00-00 00:00:00', 10),
(4, '0000-00-00 00:00:00', 13),
(7, '2022-12-04 10:05:12', 12),
(9, '2022-12-04 10:24:54', 12),
(10, '2022-12-04 11:00:38', 12),
(11, '2022-12-04 11:01:12', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraestado`
--

CREATE TABLE `compraestado` (
  `idcompraestado` bigint(20) UNSIGNED NOT NULL,
  `idcompra` bigint(11) NOT NULL,
  `idcompraestadotipo` int(11) NOT NULL,
  `cefechaini` timestamp NOT NULL DEFAULT current_timestamp(),
  `cefechafin` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compraestado`
--

INSERT INTO `compraestado` (`idcompraestado`, `idcompra`, `idcompraestadotipo`, `cefechaini`, `cefechafin`) VALUES
(12, 1, 5, '2022-11-21 09:58:20', '0000-00-00 00:00:00'),
(13, 2, 5, '2022-11-30 10:37:26', '2022-12-01 09:50:30'),
(15, 2, 4, '2022-12-01 09:50:30', '0000-00-00 00:00:00'),
(17, 7, 5, '2022-12-04 10:05:12', '2022-12-05 04:01:14'),
(22, 7, 1, '2022-12-05 04:01:14', '2022-12-05 04:51:29'),
(24, 7, 2, '2022-12-05 04:51:29', '2022-12-05 05:13:03'),
(25, 7, 3, '2022-12-05 05:13:03', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraestadotipo`
--

CREATE TABLE `compraestadotipo` (
  `idcompraestadotipo` int(11) NOT NULL,
  `cetdescripcion` varchar(50) NOT NULL,
  `cetdetalle` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compraestadotipo`
--

INSERT INTO `compraestadotipo` (`idcompraestadotipo`, `cetdescripcion`, `cetdetalle`) VALUES
(1, 'iniciada', 'cuando el usuario : cliente inicia la compra de uno o mas productos del carrito'),
(2, 'aceptada', 'cuando el usuario administrador da ingreso a uno de las compras en estado = 1 '),
(3, 'enviada', 'cuando el usuario administrador envia a uno de las compras en estado =2 '),
(4, 'cancelada', 'un usuario administrador podra cancelar una compra en cualquier estado y un usuario cliente solo en estado=1 '),
(5, 'pendiente', 'cuando el usuario recien esta ingresando productos al carrito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraitem`
--

CREATE TABLE `compraitem` (
  `idcompraitem` bigint(20) UNSIGNED NOT NULL,
  `idproducto` bigint(20) NOT NULL,
  `idcompra` bigint(20) NOT NULL,
  `cicantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compraitem`
--

INSERT INTO `compraitem` (`idcompraitem`, `idproducto`, `idcompra`, `cicantidad`) VALUES
(1, 10, 1, 1),
(6, 11, 2, 1),
(7, 9, 2, 1),
(8, 2, 2, 1),
(10, 4, 2, 1),
(11, 8, 2, 1),
(14, 11, 7, 1),
(21, 8, 7, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `idmenu` bigint(20) NOT NULL,
  `menombre` varchar(50) NOT NULL COMMENT 'Nombre del item del menu',
  `medescripcion` varchar(124) NOT NULL COMMENT 'Descripcion mas detallada del item del menu',
  `idpadre` bigint(20) DEFAULT NULL COMMENT 'Referencia al id del menu que es subitem',
  `medeshabilitado` timestamp NULL DEFAULT current_timestamp() COMMENT 'Fecha en la que el menu fue deshabilitado por ultima vez'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`idmenu`, `menombre`, `medescripcion`, `idpadre`, `medeshabilitado`) VALUES
(1, 'usuario', 'kkkkk', NULL, NULL),
(2, 'producto', 'kkkkk', NULL, NULL),
(3, 'carrito', 'kkkkk', NULL, NULL),
(4, 'nuevoproducto', 'kkkkk', NULL, NULL),
(5, 'ver Producto', 'Producto/verProductos.php', NULL, NULL),
(12, 'lista Productos', 'Producto/listarProductos.php', NULL, '0000-00-00 00:00:00'),
(13, 'ver Lista Carrito', 'Carrito/verListaCarrito.php', NULL, '0000-00-00 00:00:00'),
(14, 'Listado de Compras', 'ProductoDeposito/listadosCompras.php', NULL, '0000-00-00 00:00:00'),
(15, 'Lista de Usuarios', 'Usuario/ListarUsuarios.php', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menurol`
--

CREATE TABLE `menurol` (
  `idmenu` bigint(20) NOT NULL,
  `idrol` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menurol`
--

INSERT INTO `menurol` (`idmenu`, `idrol`) VALUES
(5, 3),
(12, 2),
(13, 3),
(14, 1),
(14, 2),
(15, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idproducto` bigint(20) NOT NULL,
  `pronombre` varchar(100) NOT NULL,
  `prodetalle` varchar(512) NOT NULL,
  `procantstock` int(11) NOT NULL,
  `proprecio` float(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idproducto`, `pronombre`, `prodetalle`, `procantstock`, `proprecio`) VALUES
(1, 'Smart TV Telefuken 32', 'Televisor LED de 32', 3, 65959.99),
(2, 'Smart TV Full HD Samsung 43\"', 'El Smart TV Samsung UN43T5300A cuenta con una pantalla de visualización widescreen (16:9) con resolución Full HD (1920 x 1080 píxeles) que brinda una gran calidad de imagen y contraste.', 3, 80567.78),
(3, ' Smart TV 4K UHD LG 43\" ', 'Viví imágenes 4K más reales, con finos detalles y colores más vivos, a través de las pantallas LG que ofrecen cuatro veces más resolución que los Fulll HD', 3, 83434.00),
(4, 'Celular Samsung Galaxy S20 FE 5G 128GB Azul', 'Con una batería de 4500mAh, el smartphone tiene la energía que requiere para durar todo el día', 3, 159999.00),
(5, 'Celular Samsung Galaxy A33 128GB Negro', 'Cuenta con una batería de 5000 mAh recargable con cable USB C, capaz de brindar la energía necesaria para que transmitas, compartas contenido, juegues', 3, 100567.99),
(6, 'Celular Motorola Edge 30 128GB Gris', 'La potencia del procesador Snapdragon 778G+ optimiza el desempeño de todo lo que más te gusta, ya sean los juegos o videos que grabás', 3, 119999.00),
(7, 'Notebook Acer 15,6\" Ryzen 5 12GB 1TB Aspire 3 A315-23-R3JN', 'Su procesador AMD Ryzen 5 3500U y su memoria RAM de 12GB se complementan para ofrecer un mayor rendimiento', 3, 169999.00),
(8, 'Notebook Dell Inspiron 15.6\" 256GB 8GB 3511-R6DCW', 'Gracias a su memoria RAM de 8GB y su SSD de 256GB, obtendrás el mejor rendimiento mientras logras mantener tu productividad al máximo', 3, 159999.00),
(9, 'MacBook Pro 16\" Apple M1 Max chip 10 core CPU/32 GPU 1TB SSD Silver', 'Modelo: Macbook Pro 16\", Capacidad del disco rígido: 1 TB Capacidad del SSD: 1 TB Resolución de la pantalla: 3456 x 2234 a 254 pix', 1, 1800089.00),
(10, 'Monitor Philips 24\" 241V8L/77', 'Philips ofrece una pantalla VA que entrega imágenes asombrosas con un amplio ángulo de visión. Cuenta con tecnología SmartContrast para obtener increíbles detalles en negro y SmartImage para optimizar la configuración de imagen', 3, 46999.00),
(11, 'Monitor FHD Noblex 22 MK22X7100', 'Esta pantalla optimizada incorpora un bisel delgado en los tres lados para disfrutar de una experiencia visual inmersiva', 3, 51799.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` bigint(20) NOT NULL,
  `rodescripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `rodescripcion`) VALUES
(1, 'administrador'),
(2, 'deposito'),
(3, 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` bigint(20) NOT NULL,
  `usnombre` varchar(50) NOT NULL,
  `uspass` varchar(150) NOT NULL,
  `usmail` varchar(50) NOT NULL,
  `usdeshabilitado` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `usnombre`, `uspass`, `usmail`, `usdeshabilitado`) VALUES
(1, 'azul23', '25d55ad283aa400af464c76d713c07ad', 'azul1999@correo', NULL),
(2, 'matiG', '2440b66dbe6ea06cd619682cac692b88', 'matiasGuzman@correo', '2022-11-14 09:58:25'),
(3, 'emilyVal', '0abcba6bdc4f558493de86b8d3e19c84', 'emilyvalencia22@correo', NULL),
(4, 'adrian98', '71c8a07ab6c82dd2a881bce24d681933', 'adrian1998@correo', NULL),
(5, 'burgos', 'c06bd9e1750862c4bc8202377b050c83', 'burgos@correo', '0000-00-00 00:00:00'),
(6, 'renataR', '12cbdca828cb6cf766ce84a9bb13c9d6', 'renataRodrigez@correo', NULL),
(7, 'luciano', '125ea2d07849a7f3b796572b0310fc7c', 'luciano@correo', '0000-00-00 00:00:00'),
(10, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'admin@correo', '0000-00-00 00:00:00'),
(11, 'deposito', '81dc9bdb52d04dc20036dbd8313ed055', 'deposito@correo', '0000-00-00 00:00:00'),
(12, 'cliente', '81dc9bdb52d04dc20036dbd8313ed055', 'cliente@correo', '0000-00-00 00:00:00'),
(13, 'adminCliente', '81dc9bdb52d04dc20036dbd8313ed055', 'adminCliente@correo', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariorol`
--

CREATE TABLE `usuariorol` (
  `idusuario` bigint(20) NOT NULL,
  `idrol` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuariorol`
--

INSERT INTO `usuariorol` (`idusuario`, `idrol`) VALUES
(1, 1),
(2, 3),
(3, 2),
(4, 1),
(5, 2),
(6, 3),
(7, 3),
(10, 1),
(11, 2),
(12, 3),
(13, 1),
(13, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idcompra`),
  ADD UNIQUE KEY `idcompra` (`idcompra`),
  ADD KEY `fkcompra_1` (`idusuario`);

--
-- Indices de la tabla `compraestado`
--
ALTER TABLE `compraestado`
  ADD PRIMARY KEY (`idcompraestado`),
  ADD UNIQUE KEY `idcompraestado` (`idcompraestado`),
  ADD KEY `fkcompraestado_1` (`idcompra`),
  ADD KEY `fkcompraestado_2` (`idcompraestadotipo`);

--
-- Indices de la tabla `compraestadotipo`
--
ALTER TABLE `compraestadotipo`
  ADD PRIMARY KEY (`idcompraestadotipo`);

--
-- Indices de la tabla `compraitem`
--
ALTER TABLE `compraitem`
  ADD PRIMARY KEY (`idcompraitem`),
  ADD UNIQUE KEY `idcompraitem` (`idcompraitem`),
  ADD KEY `fkcompraitem_1` (`idcompra`),
  ADD KEY `fkcompraitem_2` (`idproducto`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`idmenu`),
  ADD UNIQUE KEY `idmenu` (`idmenu`),
  ADD KEY `fkmenu_1` (`idpadre`);

--
-- Indices de la tabla `menurol`
--
ALTER TABLE `menurol`
  ADD PRIMARY KEY (`idmenu`,`idrol`),
  ADD KEY `fkmenurol_2` (`idrol`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`),
  ADD UNIQUE KEY `idproducto` (`idproducto`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`),
  ADD UNIQUE KEY `idrol` (`idrol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `usuariorol`
--
ALTER TABLE `usuariorol`
  ADD PRIMARY KEY (`idusuario`,`idrol`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idrol` (`idrol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `idcompra` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `compraestado`
--
ALTER TABLE `compraestado`
  MODIFY `idcompraestado` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `compraitem`
--
ALTER TABLE `compraitem`
  MODIFY `idcompraitem` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `idmenu` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fkcompra_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `compraestado`
--
ALTER TABLE `compraestado`
  ADD CONSTRAINT `fkcompraestado_1` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcompraestado_2` FOREIGN KEY (`idcompraestadotipo`) REFERENCES `compraestadotipo` (`idcompraestadotipo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `compraitem`
--
ALTER TABLE `compraitem`
  ADD CONSTRAINT `fkcompraitem_1` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcompraitem_2` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fkmenu_1` FOREIGN KEY (`idpadre`) REFERENCES `menu` (`idmenu`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `menurol`
--
ALTER TABLE `menurol`
  ADD CONSTRAINT `fkmenurol_1` FOREIGN KEY (`idmenu`) REFERENCES `menu` (`idmenu`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkmenurol_2` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuariorol`
--
ALTER TABLE `usuariorol`
  ADD CONSTRAINT `fkmovimiento_1` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuariorol_ibfk_2` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
