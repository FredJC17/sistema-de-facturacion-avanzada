-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-12-2025 a las 10:55:59
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Volcado de datos para la tabla `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"sisfacturacion\",\"table\":\"tipo_articulo\"},{\"db\":\"sisfacturacion\",\"table\":\"cliente\"},{\"db\":\"sisfacturacion\",\"table\":\"users\"}]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Volcado de datos para la tabla `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2025-12-29 09:54:31', '{\"Console\\/Mode\":\"collapse\",\"lang\":\"es\"}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indices de la tabla `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indices de la tabla `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indices de la tabla `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indices de la tabla `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indices de la tabla `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indices de la tabla `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indices de la tabla `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indices de la tabla `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indices de la tabla `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indices de la tabla `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indices de la tabla `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indices de la tabla `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indices de la tabla `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Base de datos: `sisfacturacion`
--
CREATE DATABASE IF NOT EXISTS `sisfacturacion` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sisfacturacion`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE `articulo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(40) NOT NULL,
  `precio_venta` int(11) NOT NULL,
  `precio_costo` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `cod_proveedor` bigint(20) UNSIGNED NOT NULL,
  `cod_tipo_articulo` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `articulo`
--

INSERT INTO `articulo` (`id`, `descripcion`, `precio_venta`, `precio_costo`, `stock`, `estado`, `cod_proveedor`, `cod_tipo_articulo`, `created_at`, `updated_at`) VALUES
(1, 'Laptop HP 15\"', 2500, 2000, 10, 'activo', 1, 1, '2025-12-28 04:37:54', '2025-12-29 04:00:53'),
(2, 'Mouse Inalámbrico Logitech', 50, 35, 1, 'activo', 1, 1, '2025-12-28 04:37:54', '2025-12-29 04:55:05'),
(3, 'Teclado Mecánico RGB', 150, 100, 38, 'activo', 1, 1, '2025-12-28 04:37:54', '2025-12-29 03:02:25'),
(4, 'Mouse L154 inalambrico', 42, 35, 60, 'activo', 2, 1, '2025-12-28 23:14:41', '2025-12-29 03:09:06'),
(5, 'Proteína Whey Gold Standard 2 lb', 160, 120, 15, 'activo', 2, 5, '2025-12-29 03:11:11', '2025-12-29 03:34:12'),
(6, 'mouse', 160, 120, 4, 'activo', 1, 1, '2025-12-29 04:05:18', '2025-12-29 04:05:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE `ciudad` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo_ciudad` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`id`, `codigo_ciudad`, `nombre`, `estado`, `created_at`, `updated_at`) VALUES
(1, 1, 'Lima', 'activo', '2025-12-28 04:37:53', '2025-12-28 04:37:53'),
(2, 2, 'Arequipa', 'activo', '2025-12-28 04:37:53', '2025-12-28 04:37:53'),
(3, 3, 'Cusco', 'activo', '2025-12-28 04:37:53', '2025-12-28 04:37:53'),
(4, 4, 'Trujillo', 'activo', '2025-12-28 04:37:53', '2025-12-28 04:37:53'),
(5, 5, 'Chiclayo', 'activo', '2025-12-28 04:37:53', '2025-12-28 04:37:53'),
(6, 6, 'Piura', 'activo', '2025-12-28 04:37:53', '2025-12-28 04:37:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `documento` varchar(15) NOT NULL,
  `cod_tipo_documento` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `direccion` varchar(20) DEFAULT NULL,
  `cod_ciudad` bigint(20) UNSIGNED NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `rol` enum('administrator','client') NOT NULL DEFAULT 'client',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `documento`, `cod_tipo_documento`, `nombre`, `apellido`, `direccion`, `cod_ciudad`, `telefono`, `email`, `password`, `estado`, `rol`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '12345678', 1, 'Admin', 'Sistema', 'Av. Principal 123', 1, '999888777', 'admin@sistema.com', '$2y$12$XArsZM606GNr.1Wgf0h7me9R6lyvbTSF/vi96KHDmbxD34ptlnJHi', 'activo', 'administrator', NULL, '2025-12-28 04:37:54', '2025-12-28 04:37:54'),
(3, '60793627', 1, 'Jhosimar Fred', 'Panta Cuadros', 'Ulrich Neisser 106', 2, '993030428', 'cuadrosjf16@gmail.com', '$2y$12$EIwvNFd2eCFkBYyXW7cvXuq0Wc6pYSqnT3VSvKcWYlqhLTPHpI9iG', 'activo', 'administrator', NULL, '2025-12-28 06:58:23', '2025-12-29 04:29:06'),
(4, '78459562', 1, 'Carlos', 'Pérez', 'Calle Los Olivos 456', 1, '987654321', 'mamm@gmail.com', '$2y$12$StbnwNTUhNezwqGIgJN7ieNxSUNd5MGCt1LLxHsvHzeZqstIDJgKS', 'activo', 'client', NULL, '2025-12-28 23:20:19', '2025-12-29 04:32:02'),
(5, '91524845', 1, 'Fabricio', 'Mollehuanca', 'Av. caracas 206', 2, '978451622', 'fabricioroberth12@gmail.com', '$2y$12$pdGfwRdRWdolm54dTDRbUuRs8uu79FFcCzGJgblh2R5J5PJSx/ISm', 'activo', 'administrator', NULL, '2025-12-29 02:14:44', '2025-12-29 02:35:40'),
(6, '78459215', 1, 'Jair', 'Carpio', 'Av. Dolores S/N', 2, '987854154', 'jairgarpioleon@gmail.com', '$2y$12$ikJQWS/CDYAifJEYak3G9eyi3hR18nNjTSMUg.twI1E073/a/ap6i', 'activo', 'administrator', NULL, '2025-12-29 02:35:07', '2025-12-29 02:35:07'),
(7, '78451262', 1, 'Elizabeth', 'Paco', 'Calle Colon S/N', 2, '984512622', 'elizabethdpl229@gmail.com', '$2y$12$IH1z0s1UyOz7Npe5cGrKDedsBhxsgkc9Pb4kSi.0B8NP8ouKadApe', 'activo', 'administrator', NULL, '2025-12-29 02:37:26', '2025-12-29 02:37:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cod_articulo` bigint(20) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) DEFAULT NULL,
  `fecha_compra` date NOT NULL,
  `comprobante_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id`, `cod_articulo`, `cantidad`, `precio_compra`, `precio_venta`, `fecha_compra`, `comprobante_path`, `created_at`, `updated_at`) VALUES
(1, 3, 5, 100.00, 150.00, '2025-12-28', 'comprobantes/eanI2VN8RPels6RiTzbNdRyORjvKjZ0eQacScsuK.pdf', '2025-12-29 01:20:19', '2025-12-29 01:20:19'),
(2, 3, 10, 100.00, 150.00, '2025-12-28', NULL, '2025-12-28 23:15:21', '2025-12-28 23:15:21'),
(3, 4, 10, 35.00, 42.00, '2025-12-28', NULL, '2025-12-28 23:15:28', '2025-12-28 23:15:28'),
(4, 1, 1, 2000.00, 2500.00, '2025-12-28', 'comprobantes/8j61xoSdRaTnlE4Fjz9LxplymKRQecf9V8paAwW3.pdf', '2025-12-29 01:36:03', '2025-12-29 01:36:03'),
(5, 1, 3, 2000.00, 2500.00, '2025-12-28', 'comprobantes/b5I2m9nwe9APxwiQqDvABJdgZkDxZpVaHvWT2XRH.pdf', '2025-12-29 01:42:48', '2025-12-29 01:42:48'),
(6, 1, 1, 2000.00, 2500.00, '2025-12-28', 'comprobantes/PqKcBuHmU1oaGDhxVgYetPqiEO2m6EgqJeNDPZOr.pdf', '2025-12-29 01:43:21', '2025-12-29 01:43:21'),
(7, 1, 10, 2000.00, 2500.00, '2025-12-28', 'comprobantes/sGQ1nqpCllsQDUfICrINPfTH7xHF4akyFIkCJ3v1.pdf', '2025-12-29 03:34:33', '2025-12-29 03:34:33'),
(8, 1, 1, 2000.00, 2500.00, '2025-12-28', 'comprobantes/hdV4CF4MskR9whbbV74BQlCEKeLLwxr97ryygtk8.pdf', '2025-12-29 03:34:58', '2025-12-29 03:34:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuraciones`
--

CREATE TABLE `configuraciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cod_usuario` bigint(20) UNSIGNED NOT NULL,
  `tema` enum('claro','oscuro') NOT NULL DEFAULT 'claro',
  `idioma` varchar(5) NOT NULL DEFAULT 'es',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `configuraciones`
--

INSERT INTO `configuraciones` (`id`, `cod_usuario`, `tema`, `idioma`, `created_at`, `updated_at`) VALUES
(1, 3, 'oscuro', 'es', '2025-12-28 08:59:04', '2025-12-29 03:31:42'),
(2, 1, 'oscuro', 'es', '2025-12-28 20:10:56', '2025-12-28 23:57:58'),
(4, 5, 'claro', 'es', '2025-12-29 02:34:07', '2025-12-29 02:36:14'),
(5, 6, 'oscuro', 'es', '2025-12-29 02:36:46', '2025-12-29 02:36:46'),
(6, 7, 'claro', 'es', '2025-12-29 04:15:16', '2025-12-29 05:05:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura`
--

CREATE TABLE `detalle_factura` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cod_factura` bigint(20) UNSIGNED NOT NULL,
  `cod_articulo` bigint(20) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_factura`
--

INSERT INTO `detalle_factura` (`id`, `cod_factura`, `cod_articulo`, `cantidad`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 4, 10000.00, '2025-12-28 20:13:33', '2025-12-28 20:13:33'),
(3, 3, 1, 1, 2500.00, '2025-12-29 03:12:15', '2025-12-29 03:12:15'),
(4, 4, 1, 1, 2500.00, '2025-12-29 03:12:16', '2025-12-29 03:12:16'),
(5, 5, 1, 1, 2500.00, '2025-12-29 03:12:17', '2025-12-29 03:12:17'),
(6, 6, 1, 1, 2500.00, '2025-12-29 03:12:17', '2025-12-29 03:12:17'),
(7, 7, 1, 1, 2500.00, '2025-12-29 03:12:18', '2025-12-29 03:12:18'),
(8, 8, 1, 1, 2500.00, '2025-12-29 03:12:19', '2025-12-29 03:12:19'),
(9, 9, 1, 1, 2500.00, '2025-12-29 03:12:19', '2025-12-29 03:12:19'),
(10, 10, 1, 1, 2500.00, '2025-12-29 03:12:20', '2025-12-29 03:12:20'),
(11, 11, 1, 1, 2500.00, '2025-12-29 03:12:20', '2025-12-29 03:12:20'),
(12, 12, 1, 1, 2500.00, '2025-12-29 03:12:21', '2025-12-29 03:12:21'),
(13, 13, 1, 1, 2500.00, '2025-12-29 03:12:23', '2025-12-29 03:12:23'),
(14, 14, 1, 1, 2500.00, '2025-12-29 03:12:30', '2025-12-29 03:12:30'),
(15, 15, 1, 1, 2500.00, '2025-12-29 03:12:31', '2025-12-29 03:12:31'),
(16, 16, 1, 1, 2500.00, '2025-12-29 03:12:31', '2025-12-29 03:12:31'),
(17, 17, 1, 2, 5000.00, '2025-12-29 03:58:24', '2025-12-29 03:58:24'),
(18, 18, 1, 2, 5000.00, '2025-12-29 03:58:26', '2025-12-29 03:58:26'),
(19, 19, 2, 1, 50.00, '2025-12-29 04:50:45', '2025-12-29 04:50:45'),
(20, 20, 2, 1, 50.00, '2025-12-29 04:50:46', '2025-12-29 04:50:46'),
(21, 21, 2, 1, 50.00, '2025-12-29 04:50:47', '2025-12-29 04:50:47'),
(22, 22, 2, 1, 50.00, '2025-12-29 04:50:47', '2025-12-29 04:50:47'),
(23, 23, 2, 1, 50.00, '2025-12-29 04:50:48', '2025-12-29 04:50:48'),
(24, 24, 2, 1, 50.00, '2025-12-29 04:50:49', '2025-12-29 04:50:49'),
(25, 25, 2, 1, 50.00, '2025-12-29 04:50:49', '2025-12-29 04:50:49'),
(26, 26, 2, 1, 50.00, '2025-12-29 04:50:50', '2025-12-29 04:50:50'),
(27, 27, 2, 1, 50.00, '2025-12-29 04:50:53', '2025-12-29 04:50:53'),
(28, 28, 2, 1, 50.00, '2025-12-29 04:50:55', '2025-12-29 04:50:55'),
(29, 29, 2, 1, 50.00, '2025-12-29 04:50:56', '2025-12-29 04:50:56'),
(30, 30, 2, 1, 50.00, '2025-12-29 04:50:56', '2025-12-29 04:50:56'),
(31, 31, 2, 1, 50.00, '2025-12-29 04:50:58', '2025-12-29 04:50:58'),
(32, 32, 2, 1, 50.00, '2025-12-29 04:50:58', '2025-12-29 04:50:58'),
(33, 33, 2, 1, 50.00, '2025-12-29 04:50:59', '2025-12-29 04:50:59'),
(34, 34, 2, 1, 50.00, '2025-12-29 04:51:00', '2025-12-29 04:51:00'),
(35, 35, 2, 1, 50.00, '2025-12-29 04:51:00', '2025-12-29 04:51:00'),
(36, 36, 2, 1, 50.00, '2025-12-29 04:51:01', '2025-12-29 04:51:01'),
(37, 37, 2, 1, 50.00, '2025-12-29 04:51:03', '2025-12-29 04:51:03'),
(38, 38, 2, 1, 50.00, '2025-12-29 04:51:06', '2025-12-29 04:51:06'),
(39, 39, 2, 1, 50.00, '2025-12-29 04:51:07', '2025-12-29 04:51:07'),
(40, 40, 2, 1, 50.00, '2025-12-29 04:51:09', '2025-12-29 04:51:09'),
(41, 41, 2, 1, 50.00, '2025-12-29 04:51:10', '2025-12-29 04:51:10'),
(42, 42, 2, 1, 50.00, '2025-12-29 04:51:11', '2025-12-29 04:51:11'),
(43, 43, 2, 1, 50.00, '2025-12-29 04:51:12', '2025-12-29 04:51:12'),
(44, 44, 2, 1, 50.00, '2025-12-29 04:51:13', '2025-12-29 04:51:13'),
(45, 45, 2, 1, 50.00, '2025-12-29 04:51:14', '2025-12-29 04:51:14'),
(46, 46, 2, 1, 50.00, '2025-12-29 04:51:14', '2025-12-29 04:51:14'),
(47, 47, 2, 1, 50.00, '2025-12-29 04:51:15', '2025-12-29 04:51:15'),
(48, 48, 2, 1, 50.00, '2025-12-29 04:51:15', '2025-12-29 04:51:15'),
(49, 49, 2, 1, 50.00, '2025-12-29 04:51:19', '2025-12-29 04:51:19'),
(50, 50, 2, 1, 50.00, '2025-12-29 04:51:20', '2025-12-29 04:51:20'),
(51, 51, 2, 1, 50.00, '2025-12-29 04:51:21', '2025-12-29 04:51:21'),
(52, 52, 2, 1, 50.00, '2025-12-29 04:51:21', '2025-12-29 04:51:21'),
(53, 53, 2, 1, 50.00, '2025-12-29 04:51:21', '2025-12-29 04:51:21'),
(54, 54, 2, 1, 50.00, '2025-12-29 04:51:23', '2025-12-29 04:51:23'),
(55, 55, 2, 1, 50.00, '2025-12-29 04:51:25', '2025-12-29 04:51:25'),
(56, 56, 2, 1, 50.00, '2025-12-29 04:51:26', '2025-12-29 04:51:26'),
(57, 57, 2, 1, 50.00, '2025-12-29 04:51:26', '2025-12-29 04:51:26'),
(58, 58, 2, 1, 50.00, '2025-12-29 04:51:27', '2025-12-29 04:51:27'),
(59, 59, 2, 1, 50.00, '2025-12-29 04:51:27', '2025-12-29 04:51:27'),
(60, 60, 2, 1, 50.00, '2025-12-29 04:51:28', '2025-12-29 04:51:28'),
(61, 61, 2, 1, 50.00, '2025-12-29 04:51:28', '2025-12-29 04:51:28'),
(62, 62, 2, 1, 50.00, '2025-12-29 04:51:29', '2025-12-29 04:51:29'),
(63, 63, 2, 1, 50.00, '2025-12-29 04:51:30', '2025-12-29 04:51:30'),
(64, 64, 2, 1, 50.00, '2025-12-29 04:51:30', '2025-12-29 04:51:30'),
(65, 65, 2, 1, 50.00, '2025-12-29 04:51:30', '2025-12-29 04:51:30'),
(66, 66, 2, 1, 50.00, '2025-12-29 04:51:31', '2025-12-29 04:51:31'),
(67, 67, 2, 1, 50.00, '2025-12-29 04:51:31', '2025-12-29 04:51:31'),
(68, 68, 2, 1, 50.00, '2025-12-29 04:51:32', '2025-12-29 04:51:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devolucion`
--

CREATE TABLE `devolucion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cod_detallefactura` bigint(20) UNSIGNED NOT NULL,
  `motivo` varchar(40) NOT NULL,
  `fecha_devolucion` varchar(15) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `devolucion`
--

INSERT INTO `devolucion` (`id`, `cod_detallefactura`, `motivo`, `fecha_devolucion`, `cantidad`, `created_at`, `updated_at`, `estado`) VALUES
(1, 1, 'muy lenta', '2025-12-28', 3, '2025-12-29 01:55:14', '2025-12-29 01:55:14', 'activo'),
(2, 16, 'ikik', '2025-12-28', 1, '2025-12-29 03:44:37', '2025-12-29 03:44:37', 'activo'),
(3, 18, 'sfddcvfs', '2025-12-28', 1, '2025-12-29 04:00:51', '2025-12-29 04:00:51', 'activo'),
(4, 18, 'sfddcvfs', '2025-12-28', 1, '2025-12-29 04:00:53', '2025-12-29 04:00:53', 'activo'),
(5, 66, 'sdsssd', '2025-12-28', 1, '2025-12-29 04:55:05', '2025-12-29 04:55:05', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nro_factura` varchar(20) NOT NULL,
  `cod_cliente` bigint(20) UNSIGNED NOT NULL,
  `fecha_emision` varchar(15) NOT NULL,
  `fecha_facturacion` varchar(15) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `igv` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_factura` decimal(10,2) NOT NULL DEFAULT 0.00,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id`, `nro_factura`, `cod_cliente`, `fecha_emision`, `fecha_facturacion`, `subtotal`, `igv`, `total_factura`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'FAC-00000001', 3, '2025-12-28', '2025-12-28', 10000.00, 1800.00, 11800.00, 'activo', '2025-12-28 20:13:33', '2025-12-28 20:13:33'),
(3, 'FAC-00000003', 1, '2025-12-28', '2025-12-28', 2500.00, 450.00, 2950.00, 'activo', '2025-12-29 03:12:15', '2025-12-29 03:12:15'),
(4, 'FAC-00000004', 1, '2025-12-28', '2025-12-28', 2500.00, 450.00, 2950.00, 'activo', '2025-12-29 03:12:16', '2025-12-29 03:12:16'),
(5, 'FAC-00000005', 1, '2025-12-28', '2025-12-28', 2500.00, 450.00, 2950.00, 'activo', '2025-12-29 03:12:17', '2025-12-29 03:12:17'),
(6, 'FAC-00000006', 1, '2025-12-28', '2025-12-28', 2500.00, 450.00, 2950.00, 'activo', '2025-12-29 03:12:17', '2025-12-29 03:12:17'),
(7, 'FAC-00000007', 1, '2025-12-28', '2025-12-28', 2500.00, 450.00, 2950.00, 'activo', '2025-12-29 03:12:18', '2025-12-29 03:12:18'),
(8, 'FAC-00000008', 1, '2025-12-28', '2025-12-28', 2500.00, 450.00, 2950.00, 'activo', '2025-12-29 03:12:19', '2025-12-29 03:12:19'),
(9, 'FAC-00000009', 1, '2025-12-28', '2025-12-28', 2500.00, 450.00, 2950.00, 'activo', '2025-12-29 03:12:19', '2025-12-29 03:12:19'),
(10, 'FAC-00000010', 1, '2025-12-28', '2025-12-28', 2500.00, 450.00, 2950.00, 'activo', '2025-12-29 03:12:20', '2025-12-29 03:12:20'),
(11, 'FAC-00000011', 1, '2025-12-28', '2025-12-28', 2500.00, 450.00, 2950.00, 'activo', '2025-12-29 03:12:20', '2025-12-29 03:12:20'),
(12, 'FAC-00000012', 1, '2025-12-28', '2025-12-28', 2500.00, 450.00, 2950.00, 'activo', '2025-12-29 03:12:21', '2025-12-29 03:12:21'),
(13, 'FAC-00000013', 1, '2025-12-28', '2025-12-28', 2500.00, 450.00, 2950.00, 'activo', '2025-12-29 03:12:23', '2025-12-29 03:12:23'),
(14, 'FAC-00000014', 1, '2025-12-28', '2025-12-28', 2500.00, 450.00, 2950.00, 'activo', '2025-12-29 03:12:30', '2025-12-29 03:12:30'),
(15, 'FAC-00000015', 1, '2025-12-28', '2025-12-28', 2500.00, 450.00, 2950.00, 'activo', '2025-12-29 03:12:31', '2025-12-29 03:12:31'),
(16, 'FAC-00000016', 1, '2025-12-28', '2025-12-28', 2500.00, 450.00, 2950.00, 'activo', '2025-12-29 03:12:31', '2025-12-29 03:12:31'),
(17, 'FAC-00000017', 3, '2025-12-28', '2025-12-28', 5000.00, 900.00, 5900.00, 'activo', '2025-12-29 03:58:24', '2025-12-29 03:58:24'),
(18, 'FAC-00000018', 3, '2025-12-28', '2025-12-28', 5000.00, 900.00, 5900.00, 'activo', '2025-12-29 03:58:26', '2025-12-29 03:58:26'),
(19, 'FAC-00000019', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:50:45', '2025-12-29 04:50:45'),
(20, 'FAC-00000020', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:50:46', '2025-12-29 04:50:46'),
(21, 'FAC-00000021', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:50:46', '2025-12-29 04:50:46'),
(22, 'FAC-00000022', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:50:47', '2025-12-29 04:50:47'),
(23, 'FAC-00000023', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:50:48', '2025-12-29 04:50:48'),
(24, 'FAC-00000024', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:50:49', '2025-12-29 04:50:49'),
(25, 'FAC-00000025', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:50:49', '2025-12-29 04:50:49'),
(26, 'FAC-00000026', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:50:50', '2025-12-29 04:50:50'),
(27, 'FAC-00000027', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:50:53', '2025-12-29 04:50:53'),
(28, 'FAC-00000028', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:50:55', '2025-12-29 04:50:55'),
(29, 'FAC-00000029', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:50:56', '2025-12-29 04:50:56'),
(30, 'FAC-00000030', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:50:56', '2025-12-29 04:50:56'),
(31, 'FAC-00000031', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:50:58', '2025-12-29 04:50:58'),
(32, 'FAC-00000032', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:50:58', '2025-12-29 04:50:58'),
(33, 'FAC-00000033', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:50:59', '2025-12-29 04:50:59'),
(34, 'FAC-00000034', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:00', '2025-12-29 04:51:00'),
(35, 'FAC-00000035', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:00', '2025-12-29 04:51:00'),
(36, 'FAC-00000036', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:01', '2025-12-29 04:51:01'),
(37, 'FAC-00000037', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:03', '2025-12-29 04:51:03'),
(38, 'FAC-00000038', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:05', '2025-12-29 04:51:05'),
(39, 'FAC-00000039', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:07', '2025-12-29 04:51:07'),
(40, 'FAC-00000040', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:09', '2025-12-29 04:51:09'),
(41, 'FAC-00000041', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:10', '2025-12-29 04:51:10'),
(42, 'FAC-00000042', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:10', '2025-12-29 04:51:10'),
(43, 'FAC-00000043', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:11', '2025-12-29 04:51:11'),
(44, 'FAC-00000044', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:13', '2025-12-29 04:51:13'),
(45, 'FAC-00000045', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:13', '2025-12-29 04:51:13'),
(46, 'FAC-00000046', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:14', '2025-12-29 04:51:14'),
(47, 'FAC-00000047', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:15', '2025-12-29 04:51:15'),
(48, 'FAC-00000048', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:15', '2025-12-29 04:51:15'),
(49, 'FAC-00000049', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:19', '2025-12-29 04:51:19'),
(50, 'FAC-00000050', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:20', '2025-12-29 04:51:20'),
(51, 'FAC-00000051', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:21', '2025-12-29 04:51:21'),
(52, 'FAC-00000052', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:21', '2025-12-29 04:51:21'),
(53, 'FAC-00000053', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:21', '2025-12-29 04:51:21'),
(54, 'FAC-00000054', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:23', '2025-12-29 04:51:23'),
(55, 'FAC-00000055', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:25', '2025-12-29 04:51:25'),
(56, 'FAC-00000056', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:26', '2025-12-29 04:51:26'),
(57, 'FAC-00000057', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:26', '2025-12-29 04:51:26'),
(58, 'FAC-00000058', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:27', '2025-12-29 04:51:27'),
(59, 'FAC-00000059', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:27', '2025-12-29 04:51:27'),
(60, 'FAC-00000060', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:28', '2025-12-29 04:51:28'),
(61, 'FAC-00000061', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:28', '2025-12-29 04:51:28'),
(62, 'FAC-00000062', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:29', '2025-12-29 04:51:29'),
(63, 'FAC-00000063', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:30', '2025-12-29 04:51:30'),
(64, 'FAC-00000064', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:30', '2025-12-29 04:51:30'),
(65, 'FAC-00000065', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:30', '2025-12-29 04:51:30'),
(66, 'FAC-00000066', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:31', '2025-12-29 04:51:31'),
(67, 'FAC-00000067', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:31', '2025-12-29 04:51:31'),
(68, 'FAC-00000068', 1, '2025-12-28', '2025-12-28', 50.00, 9.00, 59.00, 'activo', '2025-12-29 04:51:32', '2025-12-29 04:51:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forma_de_pago`
--

CREATE TABLE `forma_de_pago` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion_formapago` varchar(20) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `forma_de_pago`
--

INSERT INTO `forma_de_pago` (`id`, `descripcion_formapago`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Efectivo', 'activo', '2025-12-28 04:37:53', '2025-12-28 04:37:53'),
(2, 'Tarjeta', 'activo', '2025-12-28 04:37:53', '2025-12-28 04:37:53'),
(3, 'Transferencia', 'activo', '2025-12-28 04:37:53', '2025-12-28 04:37:53'),
(4, 'Yape/Plin', 'activo', '2025-12-28 04:37:53', '2025-12-28 04:37:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_12_04_000001_create_tipo_documento_table', 1),
(5, '2024_12_04_000002_create_ciudad_table', 1),
(6, '2024_12_04_000003_create_cliente_table', 1),
(7, '2024_12_04_000004_create_proveedor_table', 1),
(8, '2024_12_04_000005_create_tipo_articulo_table', 1),
(9, '2024_12_04_000006_create_articulo_table', 1),
(10, '2024_12_04_000007_create_forma_de_pago_table', 1),
(11, '2024_12_04_000008_create_factura_table', 1),
(12, '2024_12_04_000009_create_detalle_factura_table', 1),
(13, '2024_12_04_000010_create_devolucion_table', 1),
(14, '2025_01_01_000001_agregar_estado_a_tablas', 2),
(15, '2025_01_01_000002_agregar_subtotal_igv_facturas', 2),
(16, '2025_01_01_000003_crear_tabla_configuraciones', 2),
(17, '2025_12_28_015354_create_password_reset_tokens_table', 3),
(18, '2025_12_28_183404_create_compras_table', 3),
(19, '2025_01_01_000003_add_cascade_to_facturas', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nro_documento` varchar(20) NOT NULL,
  `cod_tipo_documento` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `cod_ciudad` bigint(20) UNSIGNED NOT NULL,
  `direccion` varchar(20) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id`, `nro_documento`, `cod_tipo_documento`, `nombre`, `apellido`, `cod_ciudad`, `direccion`, `telefono`, `estado`, `created_at`, `updated_at`) VALUES
(1, '20123456789', 2, 'Distribuidora', 'Tech SAC', 1, 'Av. Industrial 100', '014567890', 'activo', '2025-12-28 04:37:54', '2025-12-28 04:37:54'),
(2, '20987654321', 2, 'Comercial', 'Perú EIRL', 2, 'Jr. Comercio 200', '054123456', 'activo', '2025-12-28 04:37:54', '2025-12-28 04:37:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('bHI6wN1thPDF3P1vDFaNA18RlbK8QPDHRhAnDBtG', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOGdCQjQyV2NKRldRZWl6Mjg2U2Rrb05xWUEzbXJ1NDNHTUtUd1phdSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjI6Imh0dHA6Ly9wcmVmYXRvcnktdW5yZXNvbHV0ZWx5LWRvbWluaWsubmdyb2stZnJlZS5kZXYvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1766981358),
('EbsIaLecZAo23nxyoe6FU5fCCOSHdm9IBYr7hTHH', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicTJZcmE0UDZDUUNIQm9STEU5cGZUaFd4VG9DS09jMHRzZmxMeDdGTiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1766998060),
('gIHAx8VR0ApLCEmIvbmsQ4xFQwhQWjDIE3s3VSfk', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiU0pWdDJNZkVCcUd2YXUzdG12RWtLTVZKV1h6MEh0NUQ1Sk5sTTFtMSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1766982774),
('RBf1sxjl5hVO4d7b0hf6DamtLZzMpn6PcQAvBhfv', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:95.0) Gecko/20100101 Firefox/95.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVFdyc09WdDBTaW9lYXJMNjB3MG9qMENuRUc4UUk2TzhQUjd0OEViSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjI6Imh0dHA6Ly9wcmVmYXRvcnktdW5yZXNvbHV0ZWx5LWRvbWluaWsubmdyb2stZnJlZS5kZXYvYXJ0aWN1bG9zIjtzOjU6InJvdXRlIjtzOjE1OiJhcnRpY3Vsb3MuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O30=', 1766977974),
('RXVQNLBH8p9aqXzBgaeR9ZEtjkcSD0b4Cqbh9MSU', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVG15OGJoWUtuR0NQQzVic24yRUpnUU14Tno2enRsQnNIeURqUmlPTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjQ6Imh0dHA6Ly9wcmVmYXRvcnktdW5yZXNvbHV0ZWx5LWRvbWluaWsubmdyb2stZnJlZS5kZXYvcHJvdmVlZG9yZXMiO3M6NToicm91dGUiO3M6MTc6InByb3ZlZWRvcmVzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Njt9', 1766984338),
('src99vUGNbWlQHYMTh5e8bRzjVjqtZqSZCr4gycH', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTUQ2VVJ2RHh2NE1USlRURGl3Mml3NmhBcGZBVERMOE5HTlRvYVhyYyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjE6Imh0dHA6Ly9wcmVmYXRvcnktdW5yZXNvbHV0ZWx5LWRvbWluaWsubmdyb2stZnJlZS5kZXYvcmVwb3J0ZXMiO3M6NToicm91dGUiO3M6MTQ6InJlcG9ydGVzLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Nzt9', 1766984739);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_articulo`
--

CREATE TABLE `tipo_articulo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion_articulo` varchar(20) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_articulo`
--

INSERT INTO `tipo_articulo` (`id`, `descripcion_articulo`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Electrónica', 'activo', '2025-12-28 04:37:53', '2025-12-28 04:37:53'),
(2, 'Ropa', 'activo', '2025-12-28 04:37:53', '2025-12-28 04:37:53'),
(3, 'Alimentos', 'activo', '2025-12-28 04:37:53', '2025-12-28 04:37:53'),
(4, 'Hogar', 'activo', '2025-12-28 04:37:53', '2025-12-28 04:37:53'),
(5, 'Deportes', 'activo', '2025-12-28 04:37:53', '2025-12-28 04:37:53'),
(6, 'Videojuegos', 'activo', '2025-12-29 02:51:23', '2025-12-29 02:58:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(20) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'DNI', 'activo', '2025-12-28 04:37:53', '2025-12-28 04:37:53'),
(2, 'RUC', 'activo', '2025-12-28 04:37:53', '2025-12-28 04:37:53'),
(3, 'Pasaporte', 'activo', '2025-12-28 04:37:53', '2025-12-28 04:37:53'),
(4, 'Carnet Extranjeria', 'activo', '2025-12-28 04:37:53', '2025-12-28 04:37:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `articulo_cod_proveedor_foreign` (`cod_proveedor`),
  ADD KEY `articulo_cod_tipo_articulo_foreign` (`cod_tipo_articulo`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cliente_documento_unique` (`documento`),
  ADD UNIQUE KEY `cliente_email_unique` (`email`),
  ADD KEY `cliente_cod_tipo_documento_foreign` (`cod_tipo_documento`),
  ADD KEY `cliente_cod_ciudad_foreign` (`cod_ciudad`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compra_cod_articulo_foreign` (`cod_articulo`);

--
-- Indices de la tabla `configuraciones`
--
ALTER TABLE `configuraciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `configuraciones_cod_usuario_unique` (`cod_usuario`);

--
-- Indices de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_factura_cod_factura_foreign` (`cod_factura`),
  ADD KEY `detalle_factura_cod_articulo_foreign` (`cod_articulo`);

--
-- Indices de la tabla `devolucion`
--
ALTER TABLE `devolucion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `devolucion_cod_detallefactura_foreign` (`cod_detallefactura`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `factura_nro_factura_unique` (`nro_factura`),
  ADD KEY `factura_cod_cliente_foreign` (`cod_cliente`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `forma_de_pago`
--
ALTER TABLE `forma_de_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proveedor_cod_tipo_documento_foreign` (`cod_tipo_documento`),
  ADD KEY `proveedor_cod_ciudad_foreign` (`cod_ciudad`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `tipo_articulo`
--
ALTER TABLE `tipo_articulo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulo`
--
ALTER TABLE `articulo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `configuraciones`
--
ALTER TABLE `configuraciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `devolucion`
--
ALTER TABLE `devolucion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `forma_de_pago`
--
ALTER TABLE `forma_de_pago`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_articulo`
--
ALTER TABLE `tipo_articulo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD CONSTRAINT `articulo_cod_proveedor_foreign` FOREIGN KEY (`cod_proveedor`) REFERENCES `proveedor` (`id`),
  ADD CONSTRAINT `articulo_cod_tipo_articulo_foreign` FOREIGN KEY (`cod_tipo_articulo`) REFERENCES `tipo_articulo` (`id`);

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_cod_ciudad_foreign` FOREIGN KEY (`cod_ciudad`) REFERENCES `ciudad` (`id`),
  ADD CONSTRAINT `cliente_cod_tipo_documento_foreign` FOREIGN KEY (`cod_tipo_documento`) REFERENCES `tipo_documento` (`id`);

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_cod_articulo_foreign` FOREIGN KEY (`cod_articulo`) REFERENCES `articulo` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `configuraciones`
--
ALTER TABLE `configuraciones`
  ADD CONSTRAINT `configuraciones_cod_usuario_foreign` FOREIGN KEY (`cod_usuario`) REFERENCES `cliente` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD CONSTRAINT `detalle_factura_cod_articulo_foreign` FOREIGN KEY (`cod_articulo`) REFERENCES `articulo` (`id`),
  ADD CONSTRAINT `detalle_factura_cod_factura_foreign` FOREIGN KEY (`cod_factura`) REFERENCES `factura` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `devolucion`
--
ALTER TABLE `devolucion`
  ADD CONSTRAINT `devolucion_cod_detallefactura_foreign` FOREIGN KEY (`cod_detallefactura`) REFERENCES `detalle_factura` (`id`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_cod_cliente_foreign` FOREIGN KEY (`cod_cliente`) REFERENCES `cliente` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `proveedor_cod_ciudad_foreign` FOREIGN KEY (`cod_ciudad`) REFERENCES `ciudad` (`id`),
  ADD CONSTRAINT `proveedor_cod_tipo_documento_foreign` FOREIGN KEY (`cod_tipo_documento`) REFERENCES `tipo_documento` (`id`);
--
-- Base de datos: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
