-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-05-2025 a las 01:04:43
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
-- Base de datos: `mealmate`
--

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
-- Estructura de tabla para la tabla `ingredientes`
--

CREATE TABLE `ingredientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `tipo` enum('fruta','verdura','carne','pescado','ave','especia','lacteo','cereal','legumbre') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ingredientes`
--

INSERT INTO `ingredientes` (`id`, `nombre`, `tipo`, `created_at`, `updated_at`) VALUES
(1, 'Fruta', 'fruta', '2025-05-06 21:20:35', '2025-05-06 21:20:35'),
(2, 'Verdura', 'verdura', '2025-05-06 21:20:35', '2025-05-06 21:20:35'),
(3, 'Carne', 'carne', '2025-05-06 21:20:35', '2025-05-06 21:20:35'),
(4, 'Pescado', 'pescado', '2025-05-06 21:20:35', '2025-05-06 21:20:35'),
(5, 'Ave', 'ave', '2025-05-06 21:20:35', '2025-05-06 21:20:35'),
(6, 'Especia', 'especia', '2025-05-06 21:20:35', '2025-05-06 21:20:35'),
(7, 'Lacteo', 'lacteo', '2025-05-06 21:20:35', '2025-05-06 21:20:35'),
(8, 'Cereal', 'cereal', '2025-05-06 21:20:35', '2025-05-06 21:20:35'),
(9, 'Legumbre', 'legumbre', '2025-05-06 21:20:35', '2025-05-06 21:20:35'),
(10, 'Arroz', 'cereal', '2025-05-07 05:46:58', '2025-05-07 05:46:58'),
(11, 'Leche', 'lacteo', '2025-05-07 05:48:24', '2025-05-07 05:48:24'),
(12, 'Azucar', 'especia', '2025-05-07 05:48:24', '2025-05-07 05:48:24'),
(13, 'Canela', 'especia', '2025-05-07 05:48:24', '2025-05-07 05:48:24'),
(14, 'Limón', 'fruta', '2025-05-07 05:48:24', '2025-05-07 05:48:24'),
(15, 'Huevo', 'carne', '2025-05-07 09:23:32', '2025-05-07 09:23:32'),
(16, 'Patatas', 'verdura', '2025-05-07 09:25:56', '2025-05-07 09:25:56'),
(17, 'Pechuga', 'carne', '2025-05-07 09:27:34', '2025-05-07 09:27:34'),
(18, 'Berenjena', 'verdura', '2025-05-07 09:27:34', '2025-05-07 09:27:34'),
(19, 'Salmón', 'pescado', '2025-05-07 09:28:31', '2025-05-07 09:28:31'),
(20, 'Batata', 'verdura', '2025-05-07 09:28:31', '2025-05-07 09:28:31'),
(21, 'Cebolla', 'verdura', '2025-05-07 09:31:17', '2025-05-07 09:31:17'),
(22, 'Espinacas', 'verdura', '2025-05-07 09:31:18', '2025-05-07 09:31:18'),
(23, 'Merluza', 'pescado', '2025-05-07 09:33:05', '2025-05-07 09:33:05'),
(24, 'Brocoli', 'verdura', '2025-05-07 09:33:05', '2025-05-07 09:33:05'),
(25, 'Pimiento rojo', 'verdura', '2025-05-07 09:42:52', '2025-05-07 09:42:52'),
(26, 'Hamburguesa', 'carne', '2025-05-07 09:44:25', '2025-05-07 09:44:25'),
(27, 'Tomate', 'verdura', '2025-05-07 09:44:25', '2025-05-07 09:44:25'),
(28, 'Lechuga', 'verdura', '2025-05-07 09:53:57', '2025-05-07 09:53:57'),
(29, 'Atún', 'pescado', '2025-05-07 09:53:57', '2025-05-07 09:53:57'),
(30, 'Aguacate', 'verdura', '2025-05-07 09:53:57', '2025-05-07 09:53:57'),
(31, 'Pepino', 'verdura', '2025-05-07 09:53:57', '2025-05-07 09:53:57'),
(32, 'Champiñones', 'verdura', '2025-05-07 09:58:45', '2025-05-07 09:58:45'),
(33, 'Contramuslo', 'carne', '2025-05-07 10:00:08', '2025-05-07 10:00:08'),
(34, 'Tomates Cherry', 'verdura', '2025-05-07 10:07:52', '2025-05-07 10:07:52'),
(35, 'Nocilla', 'especia', '2025-05-07 19:50:58', '2025-05-07 19:50:58'),
(36, 'Pan de molde', 'cereal', '2025-05-07 19:50:58', '2025-05-07 19:50:58'),
(37, 'Pan pepito', 'cereal', '2025-05-07 20:44:58', '2025-05-07 20:44:58'),
(38, 'Mortadela', 'carne', '2025-05-07 20:44:58', '2025-05-07 20:44:58');

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
(4, '2025_04_17_095831_create_usuarios_table', 1),
(5, '2025_04_17_100544_create_semanas_table', 1),
(6, '2025_04_17_100831_create_recetas_table', 1),
(7, '2025_04_17_101043_create_recetas_favoritas_table', 1),
(8, '2025_04_17_101220_create_recetas_semanas_table', 1),
(9, '2025_04_17_101430_create_ingredientes_table', 1),
(10, '2025_04_17_101737_create_recetas_ingredientes_table', 1);

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
-- Estructura de tabla para la tabla `recetas`
--

CREATE TABLE `recetas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `raciones` int(11) NOT NULL,
  `n_votos` varchar(45) NOT NULL,
  `puntuacion` decimal(5,2) NOT NULL,
  `tipo_receta` enum('entrante','aperitivo','plato_principal','reposteria','cremas_y_sopas','arroces_y_pastas') NOT NULL,
  `dificultad` enum('facil','medio','avanzado') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `recetas`
--

INSERT INTO `recetas` (`id`, `usuario_id`, `nombre`, `raciones`, `n_votos`, `puntuacion`, `tipo_receta`, `dificultad`, `created_at`, `updated_at`) VALUES
(1, 2, 'Arroz con leche', 4, '1', 5.00, 'reposteria', 'facil', '2025-05-06 21:35:21', '2025-05-06 21:50:16'),
(2, 4, 'Salmón con batata', 2, '1', 3.00, 'plato_principal', 'facil', '2025-05-07 06:33:00', '2025-05-07 06:37:43'),
(3, 4, 'Crema de calabaza con huevo duro', 3, '0', 0.00, 'plato_principal', 'medio', '2025-05-07 06:36:47', '2025-05-07 06:36:47'),
(4, 4, 'Ensalada de pimientos y pollo con almendras', 2, '1', 5.00, 'plato_principal', 'medio', '2025-05-07 06:41:49', '2025-05-07 06:46:23'),
(5, 4, 'Huevos revueltos con espinacas y cebolla', 2, '1', 4.00, 'plato_principal', 'medio', '2025-05-07 06:43:09', '2025-05-07 06:46:40'),
(6, 4, 'Merluza con brócoli y cebolla', 2, '1', 0.00, 'plato_principal', 'facil', '2025-05-07 06:43:52', '2025-05-07 09:33:23'),
(7, 4, 'Contramuslos con tomate', 2, '0', 0.00, 'plato_principal', 'facil', '2025-05-07 06:44:18', '2025-05-07 10:00:08'),
(8, 4, 'Pechuga con berenjena', 2, '1', 5.00, 'plato_principal', 'medio', '2025-05-07 06:44:43', '2025-05-07 09:27:34'),
(9, 4, 'Pechuga con brócoli y champiñones', 3, '0', 0.00, 'plato_principal', 'medio', '2025-05-07 06:45:56', '2025-05-07 06:45:56'),
(10, 4, 'Tortilla de espinacas y champiñones', 2, '0', 0.00, 'plato_principal', 'medio', '2025-05-07 06:46:38', '2025-05-07 06:46:38'),
(11, 4, 'Ensalada de atun', 2, '0', 0.00, 'plato_principal', 'facil', '2025-05-07 06:47:18', '2025-05-07 06:47:18'),
(12, 4, 'Hamburguesa con tomate', 2, '0', 0.00, 'plato_principal', 'facil', '2025-05-07 06:47:48', '2025-05-07 09:44:25'),
(13, 4, 'Huevos “fritos” con verduras', 2, '0', 0.00, 'plato_principal', 'medio', '2025-05-07 06:49:58', '2025-05-07 09:23:32'),
(14, 4, 'Pechuga con escalivada', 2, '0', 0.00, 'plato_principal', 'medio', '2025-05-07 06:50:48', '2025-05-07 09:42:52'),
(15, 2, 'Sandwich de Nocilla', 2, '0', 0.00, 'reposteria', 'facil', '2025-05-07 19:50:58', '2025-05-07 19:50:58'),
(16, 2, 'Pepito de mortadela', 1, '0', 0.00, 'aperitivo', 'facil', '2025-05-07 20:44:58', '2025-05-07 20:44:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas_favoritas`
--

CREATE TABLE `recetas_favoritas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `receta_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `recetas_favoritas`
--

INSERT INTO `recetas_favoritas` (`id`, `usuario_id`, `receta_id`, `created_at`, `updated_at`) VALUES
(1, 2, 8, NULL, NULL),
(2, 2, 5, NULL, NULL),
(3, 4, 4, NULL, NULL),
(4, 4, 14, NULL, NULL),
(6, 4, 12, NULL, NULL),
(7, 4, 13, NULL, NULL),
(8, 4, 11, NULL, NULL),
(9, 4, 10, NULL, NULL),
(10, 4, 7, NULL, NULL),
(11, 4, 9, NULL, NULL),
(12, 4, 6, NULL, NULL),
(13, 4, 8, NULL, NULL),
(14, 4, 5, NULL, NULL),
(15, 4, 3, NULL, NULL),
(16, 4, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas_ingredientes`
--

CREATE TABLE `recetas_ingredientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `recetas_id` bigint(20) UNSIGNED NOT NULL,
  `ingredientes_id` bigint(20) UNSIGNED NOT NULL,
  `cantidad` double NOT NULL,
  `unidad` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `recetas_ingredientes`
--

INSERT INTO `recetas_ingredientes` (`id`, `recetas_id`, `ingredientes_id`, `cantidad`, `unidad`, `created_at`, `updated_at`) VALUES
(1, 1, 10, 400, 'gramos', NULL, NULL),
(2, 1, 11, 1, 'litro', NULL, NULL),
(3, 1, 12, 400, 'gramos', NULL, NULL),
(4, 1, 13, 1, 'rama', NULL, NULL),
(5, 1, 14, 1, 'ralladura', NULL, NULL),
(6, 13, 15, 4, 'Unidades', NULL, NULL),
(7, 13, 16, 4, 'Unidades', NULL, NULL),
(8, 8, 17, 4, 'Filetes', NULL, NULL),
(9, 8, 18, 1, 'Unidad', NULL, NULL),
(10, 2, 19, 2, 'Porciones', NULL, NULL),
(11, 2, 20, 1, 'Unidad', NULL, NULL),
(12, 5, 15, 4, 'Unidades', NULL, NULL),
(13, 5, 21, 1, 'Unidad', NULL, NULL),
(14, 5, 22, 2, 'Porciones congeladas', NULL, NULL),
(15, 6, 23, 4, 'Porciones congeladas', NULL, NULL),
(16, 6, 24, 200, 'Gramos', NULL, NULL),
(17, 6, 21, 1, 'Unidad', NULL, NULL),
(18, 14, 17, 4, 'Filetes', NULL, NULL),
(19, 14, 18, 1, 'Unidad', NULL, NULL),
(20, 14, 21, 1, 'Unidad', NULL, NULL),
(21, 14, 25, 1, 'Unidad', NULL, NULL),
(22, 12, 26, 4, 'Unidades', NULL, NULL),
(23, 12, 27, 2, 'Unidades', NULL, NULL),
(24, 11, 28, 200, 'Gramos', NULL, NULL),
(25, 11, 29, 2, 'Latas', NULL, NULL),
(26, 11, 30, 1, 'Unidad', NULL, NULL),
(27, 11, 27, 2, 'Unidad', NULL, NULL),
(28, 11, 31, 1, 'Unidad', NULL, NULL),
(29, 10, 15, 4, 'Unidades', NULL, NULL),
(30, 10, 32, 6, 'Unidades', NULL, NULL),
(31, 10, 22, 150, 'Gramos', NULL, NULL),
(32, 7, 33, 4, 'Unidad', NULL, NULL),
(33, 7, 27, 2, 'Unidades', NULL, NULL),
(34, 4, 25, 1, 'Unidad', NULL, NULL),
(35, 4, 33, 4, 'Unidades', NULL, NULL),
(36, 4, 34, 100, 'Gramos', NULL, NULL),
(37, 4, 28, 200, 'Gramos', NULL, NULL),
(38, 15, 35, 1, 'Bote', NULL, NULL),
(39, 15, 36, 4, 'Rebanadas', NULL, NULL),
(40, 16, 37, 1, 'Unidad', NULL, NULL),
(41, 16, 38, 100, 'Gramos', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas_semanas`
--

CREATE TABLE `recetas_semanas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `semana_id` bigint(20) UNSIGNED NOT NULL,
  `dia_semana` enum('lunes','martes','miercoles','jueves','viernes','sabado','domingo') NOT NULL,
  `desayuno_receta_id` bigint(20) UNSIGNED DEFAULT NULL,
  `comida_receta_id` bigint(20) UNSIGNED DEFAULT NULL,
  `merienda_receta_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cena_receta_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `recetas_semanas`
--

INSERT INTO `recetas_semanas` (`id`, `semana_id`, `dia_semana`, `desayuno_receta_id`, `comida_receta_id`, `merienda_receta_id`, `cena_receta_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'lunes', 1, NULL, 1, NULL, '2025-05-06 21:35:53', '2025-05-07 05:48:47'),
(2, 1, 'martes', NULL, NULL, NULL, NULL, '2025-05-06 21:35:53', '2025-05-06 21:35:53'),
(3, 1, 'miercoles', NULL, NULL, NULL, NULL, '2025-05-06 21:35:53', '2025-05-06 21:35:53'),
(4, 1, 'jueves', NULL, NULL, NULL, NULL, '2025-05-06 21:35:53', '2025-05-06 21:35:53'),
(5, 1, 'viernes', NULL, NULL, NULL, NULL, '2025-05-06 21:35:53', '2025-05-06 21:35:53'),
(6, 1, 'sabado', NULL, NULL, NULL, NULL, '2025-05-06 21:35:53', '2025-05-06 21:35:53'),
(7, 1, 'domingo', NULL, NULL, NULL, NULL, '2025-05-06 21:35:53', '2025-05-06 21:35:53'),
(8, 2, 'lunes', 1, NULL, 1, NULL, '2025-05-07 05:49:08', '2025-05-07 05:49:08'),
(9, 2, 'martes', NULL, NULL, NULL, NULL, '2025-05-07 05:49:08', '2025-05-07 05:49:08'),
(10, 2, 'miercoles', NULL, NULL, NULL, NULL, '2025-05-07 05:49:08', '2025-05-07 05:49:08'),
(11, 2, 'jueves', NULL, NULL, NULL, NULL, '2025-05-07 05:49:08', '2025-05-07 05:49:08'),
(12, 2, 'viernes', NULL, NULL, NULL, NULL, '2025-05-07 05:49:08', '2025-05-07 05:49:08'),
(13, 2, 'sabado', NULL, NULL, NULL, NULL, '2025-05-07 05:49:08', '2025-05-07 05:49:08'),
(14, 2, 'domingo', NULL, NULL, NULL, NULL, '2025-05-07 05:49:08', '2025-05-07 05:49:08'),
(15, 3, 'jueves', 1, NULL, 1, NULL, '2025-05-07 05:49:24', '2025-05-07 05:49:24'),
(16, 3, 'viernes', NULL, NULL, NULL, NULL, '2025-05-07 05:49:24', '2025-05-07 05:49:24'),
(17, 3, 'sabado', NULL, NULL, NULL, NULL, '2025-05-07 05:49:24', '2025-05-07 05:49:24'),
(18, 3, 'domingo', NULL, NULL, NULL, NULL, '2025-05-07 05:49:24', '2025-05-07 05:49:24'),
(19, 3, 'lunes', NULL, NULL, NULL, NULL, '2025-05-07 05:49:24', '2025-05-07 05:49:24'),
(20, 3, 'martes', NULL, NULL, NULL, NULL, '2025-05-07 05:49:24', '2025-05-07 05:49:24'),
(21, 3, 'miercoles', NULL, NULL, NULL, NULL, '2025-05-07 05:49:24', '2025-05-07 05:49:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `semanas`
--

CREATE TABLE `semanas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `inicio` date NOT NULL,
  `fin` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `semanas`
--

INSERT INTO `semanas` (`id`, `usuario_id`, `inicio`, `fin`, `created_at`, `updated_at`) VALUES
(1, 2, '2025-05-05', '2025-05-11', '2025-05-06 21:35:53', '2025-05-06 21:35:53'),
(2, 2, '2025-05-26', '2025-06-01', '2025-05-07 05:49:08', '2025-05-07 05:49:08'),
(3, 2, '2025-06-05', '2025-06-11', '2025-05-07 05:49:24', '2025-05-07 05:49:24');

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
('Q1GNSGGqHIVLk8KsSn38FaiW55IZQY4gnatKxnBJ', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRzBBSUJjZGdlVkF0UDY2a0N5WTFib2o2NUc3QlpLcGtIeDVNTXhaZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9taXMtcmVjZXRhcyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1746659063);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@mealmate.com', '$2y$12$TYXJclhur5.yvtBp9XwQTuo//88Z/I0/GiXgxyITSj83bNkrjkgEK', '2025-05-06 21:20:35', '2025-05-06 21:20:35'),
(2, 'Blasb', 'blas.broman@gmail.com', '$2y$12$3b4CEMxOrIUPB/lC/TKhcOcEl2oidduDDtpUs/7Zk/Z6.jzbf4uoS', '2025-05-06 21:33:17', '2025-05-06 21:36:29'),
(3, 'Blas', 'b@b.com', '$2y$12$AqGrpj4.18Ez4TitS9aX5.5FoSYA7vpMdinTsTx2bjhtw/eoObWeq', '2025-05-06 21:47:01', '2025-05-06 21:47:01'),
(4, 'Sandra', 'sandra.yuguero@gmail.com', '$2y$12$UXifjho43HZv.bM0JSgpHeRSJJ6x7LFf/X2wn9Cy6ayPf/QDd9lC2', '2025-05-07 06:29:36', '2025-05-07 06:29:36');

--
-- Índices para tablas volcadas
--

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
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ingredientes_nombre_unique` (`nombre`);

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
-- Indices de la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recetas_usuario_id_foreign` (`usuario_id`);

--
-- Indices de la tabla `recetas_favoritas`
--
ALTER TABLE `recetas_favoritas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recetas_favoritas_usuario_id_foreign` (`usuario_id`),
  ADD KEY `recetas_favoritas_receta_id_foreign` (`receta_id`);

--
-- Indices de la tabla `recetas_ingredientes`
--
ALTER TABLE `recetas_ingredientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recetas_ingredientes_recetas_id_foreign` (`recetas_id`),
  ADD KEY `recetas_ingredientes_ingredientes_id_foreign` (`ingredientes_id`);

--
-- Indices de la tabla `recetas_semanas`
--
ALTER TABLE `recetas_semanas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recetas_semanas_semana_id_foreign` (`semana_id`),
  ADD KEY `recetas_semanas_desayuno_receta_id_foreign` (`desayuno_receta_id`),
  ADD KEY `recetas_semanas_comida_receta_id_foreign` (`comida_receta_id`),
  ADD KEY `recetas_semanas_merienda_receta_id_foreign` (`merienda_receta_id`),
  ADD KEY `recetas_semanas_cena_receta_id_foreign` (`cena_receta_id`);

--
-- Indices de la tabla `semanas`
--
ALTER TABLE `semanas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `semanas_usuario_id_inicio_fin_unique` (`usuario_id`,`inicio`,`fin`),
  ADD UNIQUE KEY `semanas_inicio_unique` (`inicio`),
  ADD UNIQUE KEY `semanas_fin_unique` (`fin`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuarios_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `recetas`
--
ALTER TABLE `recetas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `recetas_favoritas`
--
ALTER TABLE `recetas_favoritas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `recetas_ingredientes`
--
ALTER TABLE `recetas_ingredientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `recetas_semanas`
--
ALTER TABLE `recetas_semanas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `semanas`
--
ALTER TABLE `semanas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD CONSTRAINT `recetas_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `recetas_favoritas`
--
ALTER TABLE `recetas_favoritas`
  ADD CONSTRAINT `recetas_favoritas_receta_id_foreign` FOREIGN KEY (`receta_id`) REFERENCES `recetas` (`id`),
  ADD CONSTRAINT `recetas_favoritas_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `recetas_ingredientes`
--
ALTER TABLE `recetas_ingredientes`
  ADD CONSTRAINT `recetas_ingredientes_ingredientes_id_foreign` FOREIGN KEY (`ingredientes_id`) REFERENCES `ingredientes` (`id`),
  ADD CONSTRAINT `recetas_ingredientes_recetas_id_foreign` FOREIGN KEY (`recetas_id`) REFERENCES `recetas` (`id`);

--
-- Filtros para la tabla `recetas_semanas`
--
ALTER TABLE `recetas_semanas`
  ADD CONSTRAINT `recetas_semanas_cena_receta_id_foreign` FOREIGN KEY (`cena_receta_id`) REFERENCES `recetas` (`id`),
  ADD CONSTRAINT `recetas_semanas_comida_receta_id_foreign` FOREIGN KEY (`comida_receta_id`) REFERENCES `recetas` (`id`),
  ADD CONSTRAINT `recetas_semanas_desayuno_receta_id_foreign` FOREIGN KEY (`desayuno_receta_id`) REFERENCES `recetas` (`id`),
  ADD CONSTRAINT `recetas_semanas_merienda_receta_id_foreign` FOREIGN KEY (`merienda_receta_id`) REFERENCES `recetas` (`id`),
  ADD CONSTRAINT `recetas_semanas_semana_id_foreign` FOREIGN KEY (`semana_id`) REFERENCES `semanas` (`id`);

--
-- Filtros para la tabla `semanas`
--
ALTER TABLE `semanas`
  ADD CONSTRAINT `semanas_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
