-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-04-2025 a las 22:47:19
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `factuvalente`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cashier_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` bigint(20) NOT NULL,
  `impuesto_global` int(11) NOT NULL,
  `impuesto_producto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descuento` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `carts`
--

INSERT INTO `carts` (`id`, `cashier_id`, `product_id`, `qty`, `price`, `impuesto_global`, `impuesto_producto`, `descuento`, `created_at`, `updated_at`) VALUES
(895, 2, 7, 1, 365656, 2, 'IVA (19.00%)', 0, '2025-04-16 17:41:43', '2025-04-16 17:41:48'),
(896, 2, 9, 1, 365656, 2, 'IVA (5.00%)', 0, '2025-04-16 17:41:44', '2025-04-16 17:41:48'),
(897, 2, 14, 1, 365656, 2, 'IVA Excluído - Excl (0.00%)', 0, '2025-04-16 17:41:46', '2025-04-16 17:41:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `image`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(14, 'kPq86pFaVWiRylQh3l0axmVgX4mexyankm0oFuVu.jpg', 'epaleddd', 'sdfsdfdfdffdf', NULL, '2025-02-10 12:56:52', '2025-02-11 12:49:49'),
(15, 'QXbn6ntqgKMeYmEFsKk8wagCVpIsOedwZBpk3PJb.jpg', 'jason', 'asdfasdf', NULL, '2025-02-11 11:30:02', '2025-02-11 12:34:25'),
(16, 'YGPw2A3KyS8wY8vBJBVweKxpOUSUXiaJrhNdo1R8.png', 'asdfasdf', 'asdfasdf', NULL, '2025-02-11 12:18:04', '2025-02-11 12:49:38'),
(17, '38KROnqvLqCvuqhWzszFNRF0YcxvcOmZx5rMqofA.jpg', 'jasonssss', 'asdfasdfasdf', NULL, '2025-02-11 13:06:52', '2025-02-11 13:06:52'),
(18, 'zvT6hV0US4EWMdgzFA7SCgwEiryWy8mCng1ep0MA.png.png', 'jason', 'asdfsadfsdf', 1, '2025-02-21 00:04:00', '2025-03-19 22:24:46'),
(19, 'ONYohYRUKq9MmqPs1joGLOpuAabsQ2S2SQi37BrI.jpg', 'asdfasdf', 'asdfsadf', 1, '2025-03-14 04:16:02', '2025-03-14 04:16:02'),
(20, 'MpMNhHorT11B11e584IypOlQCoxpZukJExI8VV0i.jpg', 'dddd', 'sdfdf', 1, '2025-03-19 21:10:18', '2025-03-19 21:10:18'),
(21, NULL, 'internet', 'internet', 1, '2025-03-27 11:07:07', '2025-03-27 11:07:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `name`, `image`, `correo`, `telefono`, `direccion`, `is_active`, `active`, `created_at`, `updated_at`) VALUES
(1, 'entonces', 'OmYPFkmKwmWU7rbB91qpfJ9jBmEZZSFxjuDSvQgW.jpg', 'zapatin@gmail.com', '34553446', 'margarita', 2, 2, '2025-03-29 09:35:43', '2025-03-29 11:49:37'),
(2, 'jajajajaajajajaja', 'uL5eqitEKmncNaUYOwIU35sa2c7FL93yELi56YJD.jpg', 'zapatind@gmail.com', '34553446', 'margarita', 1, 1, '2025-03-29 09:45:12', '2025-04-01 07:35:22'),
(4, 'jasonsd', 'dwYgPUxURscX7gAnHQ1Ozam0Jmb7E3Da5PTzMLfZ.jpg.jpg', 'zapatiffnd@gmail.com', '345534462', 'margarita', 1, 1, '2025-03-29 09:52:10', '2025-03-29 20:45:19'),
(5, 'dfdf', NULL, 'zapatiff1nd@gmail.com', '34553446', 'margarita', 1, 1, '2025-03-29 11:01:33', '2025-03-29 11:01:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigo`
--

CREATE TABLE `codigo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `codigo`
--

INSERT INTO `codigo` (`id`, `codigo`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '123456', 'jason', 'asdfsadf', 2, '2025-02-26 19:12:06', '2025-02-26 19:13:11'),
(2, '123456', 'jason', 'asdfsadf', 2, '2025-02-26 19:12:19', '2025-02-26 19:24:09'),
(3, '`6566562', 'jason', 'asdfsadf', 2, '2025-02-26 19:13:41', '2025-02-26 19:24:06'),
(4, '3434', 'jason,', 'asdfsadf', 2, '2025-02-26 19:14:32', '2025-02-26 19:23:58'),
(5, '45455', '.sdfsd', 'sfsdfsdf', 2, '2025-02-26 19:15:28', '2025-02-26 19:24:01'),
(6, '1212121', '..,.,.ddd', 'dddddd', 2, '2025-02-26 19:17:29', '2025-02-26 19:24:11'),
(7, '.dfd', 'asdf', 'asdfsadf', 2, '2025-02-26 19:20:23', '2025-02-26 19:24:14'),
(8, '.,.ddfdf', 'jason', 'asdfsadf', 2, '2025-02-26 19:20:56', '2025-02-26 19:24:17'),
(9, '6566562', 'jason', 'asdfsadf', 2, '2025-02-26 19:24:31', '2025-02-26 19:24:49'),
(10, '88877', 'Jajajaja', 'Iii', 2, '2025-02-26 19:30:05', '2025-03-03 18:59:45'),
(11, '6566562', 'asdfasdf', NULL, 1, '2025-02-26 20:28:22', '2025-02-26 20:28:22'),
(12, '45455', 'asdfsadf', 'malon', 1, '2025-02-26 20:41:40', '2025-03-17 20:17:09'),
(13, '56566', 'ZSDSAD', '565465', 1, '2025-03-03 18:52:18', '2025-03-03 18:52:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configs`
--

CREATE TABLE `configs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `impuesto_global` int(11) NOT NULL,
  `url_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `configs`
--

INSERT INTO `configs` (`id`, `impuesto_global`, `url_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, '2025-04-08 07:18:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_03_27_203416_create_clientes_table', 2),
(7, 'create_cart_table', 3),
(8, 'create_config', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buy_price` bigint(20) NOT NULL,
  `sell_price` bigint(20) NOT NULL,
  `stock` int(11) NOT NULL,
  `impuesto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` int(11) DEFAULT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio_base` bigint(20) NOT NULL,
  `minimo` bigint(20) DEFAULT NULL,
  `maximo` bigint(20) DEFAULT NULL,
  `activo` bigint(20) DEFAULT NULL,
  `venta_negativo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_unspsc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `category_id`, `image`, `barcode`, `title`, `description`, `buy_price`, `sell_price`, `stock`, `impuesto`, `unit`, `is_active`, `tipo`, `precio_base`, `minimo`, `maximo`, `activo`, `venta_negativo`, `codigo_unspsc`, `created_at`, `updated_at`) VALUES
(1, NULL, 'KWZMV3QEUVUL9uK6MfTHgjjfr3mNWRq6ErHaHB7Y.jpg', '3dfdf', 'jabon', NULL, 65656, 435131, 6565, 'IVA (19.00%)', 'Par', 2, 'servicio', 365656, NULL, NULL, 1, 'venta_negativo', NULL, '2025-03-19 03:28:49', '2025-03-27 00:30:32'),
(2, NULL, 'initImage.jpg', '3dfdfd', 'formateo', NULL, 65656, 435131, 6565, 'IVA (19.00%)', 'Pieza', 1, 'servicio', 365656, NULL, NULL, 1, NULL, NULL, '2025-03-19 03:29:12', '2025-04-03 00:50:44'),
(3, NULL, 'initImage.jpg', '6565652', 'sii', 'sdadf', 1, 34700, 1, 'IVA (19.00%)', 'Millar', 2, 'combo', 29160, NULL, NULL, 1, NULL, NULL, '2025-03-19 03:29:35', '2025-03-27 00:27:49'),
(4, NULL, 'initImage.jpg', '2232323', 'tornillo', NULL, 24242342, 30618, 36, 'IVA (5.00%)', 'Kilovatios hora', 2, 'producto', 29160, NULL, NULL, 2, NULL, NULL, '2025-03-19 04:19:32', '2025-03-29 10:07:54'),
(5, 19, 'TDEZl3QNNLGnkd2N7Ud94MY6yijqFSmpJFKV5270.jpg', '3434333', 'power', 'sdfasdfsadf', 65656, 34700, 6565, 'IVA (19.00%)', 'Kilogramo', 2, 'producto', 56000, 15, 96, 1, 'venta_negativo', '12', '2025-03-19 06:03:29', '2025-03-22 09:48:57'),
(6, 21, 'yMpu73FLboFM4pVt62D5fTZmVU9xC6zngzAmi5GL.jpg', '2232323ss', 'tor', 'www', 24242342, 34700, 36, 'IVA (19.00%)', 'Par', 2, 'combo', 29160, NULL, NULL, 1, NULL, NULL, '2025-03-19 06:14:26', '2025-04-07 08:15:47'),
(7, 21, 'initImage.jpg', '665545l', 'internet', 'kjhjklhjkhjlkh', 1, 435131, 1, 'IVA (19.00%)', 'Millar', 1, 'servicio', 365656, NULL, NULL, 1, NULL, NULL, '2025-03-19 20:31:16', '2025-04-03 00:50:37'),
(8, NULL, 'initImage.jpg', '34343s', 'tornillox', NULL, 56000, 365656, 36, 'IVA Excluído - Excl (0.00%)', 'Pieza', 2, 'producto', 365656, NULL, NULL, 1, NULL, NULL, '2025-03-22 09:49:42', '2025-03-22 09:50:38'),
(9, NULL, 'initImage.jpg', '3dfdfww', 'dados88', NULL, 24242342, 383939, 0, 'IVA (5.00%)', 'Pieza', 1, 'producto', 365656, NULL, NULL, 1, 'venta_negativo', NULL, '2025-03-22 09:51:56', '2025-04-09 20:37:24'),
(10, NULL, 'initImage.jpg', '32323333', 'try', NULL, 65656, 365656, 500, 'IVA Excluído - Excl (0.00%)', 'Pieza', 2, 'producto', 365656, NULL, NULL, 1, NULL, NULL, '2025-03-22 09:52:42', '2025-04-07 08:22:08'),
(12, 18, 'oGA26OHxhUQpS7QRbZGCBWSfPCOWBvaXYh9EmtTj.jpg', '5544dd', 'feel', NULL, 65656, 24372, 0, 'IVA (5.00%)', 'Litro', 1, 'producto', 23211, NULL, NULL, 1, NULL, NULL, '2025-03-27 01:48:21', '2025-04-03 20:16:42'),
(13, NULL, 'initImage.jpg', 'ass333', 'estrella', NULL, 65656, 383939, 36, 'IVA (5.00%)', 'Pieza', 1, 'producto', 365656, NULL, NULL, 1, NULL, NULL, '2025-04-05 09:19:24', '2025-04-05 09:19:24'),
(14, NULL, 'initImage.jpg', 'ee333', 'tantas', NULL, 65656, 365656, 36, 'IVA Excluído - Excl (0.00%)', 'Servicio', 1, 'producto', 365656, NULL, NULL, 1, NULL, NULL, '2025-04-05 09:19:43', '2025-04-05 09:19:43'),
(15, NULL, 'initImage.jpg', 'ee333c', 'tantasx', NULL, 65656, 365656, 36, 'IVA Excluído - Excl (0.00%)', 'Servicio', 1, 'producto', 365656, NULL, NULL, 1, NULL, NULL, '2025-04-05 09:19:43', '2025-04-05 09:19:43'),
(16, NULL, 'initImage.jpg', 'ee333ce', 'tantasxe', NULL, 65656, 365656, 36, 'IVA Excluído - Excl (0.00%)', 'Servicio', 1, 'producto', 365656, NULL, NULL, 1, NULL, NULL, '2025-04-05 09:19:43', '2025-04-05 09:19:43'),
(17, NULL, 'initImage.jpg', '44555', 'sifon', NULL, 65656, 365656, 36, 'IVA Excluído - Excl (0.00%)', 'Servicio', 1, 'producto', 365656, NULL, NULL, 1, NULL, NULL, '2025-04-05 09:19:43', '2025-04-05 09:19:43'),
(18, NULL, 'initImage.jpg', '44555ww', 'sifonw', NULL, 65656, 365656, 36, 'IVA Excluído - Excl (0.00%)', 'Servicio', 1, 'producto', 365656, NULL, NULL, 1, NULL, NULL, '2025-04-05 09:19:43', '2025-04-05 09:19:43'),
(19, NULL, 'initImage.jpg', '44555wwqqq', 'data', NULL, 65656, 365656, 36, 'IVA Excluído - Excl (0.00%)', 'Servicio', 1, 'producto', 365656, NULL, NULL, 1, NULL, NULL, '2025-04-05 09:19:43', '2025-04-05 09:19:43'),
(20, NULL, 'initImage.jpg', 'dsfsdf', 'timmy', NULL, 65656, 365656, 36, 'IVA Excluído - Excl (0.00%)', 'Servicio', 1, 'producto', 365656, NULL, NULL, 1, NULL, NULL, '2025-04-05 09:19:43', '2025-04-05 09:19:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_details`
--

CREATE TABLE `product_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) DEFAULT NULL,
  `combo_product` bigint(20) DEFAULT NULL,
  `title_product` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'jason', 'admin@example.com', NULL, '$2y$10$DPwBw4sOThbEdfy0pCLcROm0Gl0bB3jobtxHcCcDplUqxwXYxLItW', NULL, '2025-02-05 14:25:21', '2025-02-05 14:25:21'),
(2, 'entonces', 'admin@gmail.com', NULL, '$2y$10$h3aASeTvmK1B2zwGq/tUS.RIqWwiKo8OlAub7mPB0iz2E./RT16Tu', NULL, '2025-04-02 09:11:23', '2025-04-02 09:11:23');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clientes_correo_unique` (`correo`);

--
-- Indices de la tabla `codigo`
--
ALTER TABLE `codigo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indices de la tabla `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_details_product_id_foreign` (`product_id`);

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
-- AUTO_INCREMENT de la tabla `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=898;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `codigo`
--
ALTER TABLE `codigo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `configs`
--
ALTER TABLE `configs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `product_details`
--
ALTER TABLE `product_details`
  ADD CONSTRAINT `product_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_details_transaction_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
