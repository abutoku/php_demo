-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2021 年 12 月 09 日 01:04
-- サーバのバージョン： 10.4.21-MariaDB
-- PHP のバージョン: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `gsacf_l06_10`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `date_table`
--

CREATE TABLE `date_table` (
  `id` int(12) NOT NULL,
  `date` date NOT NULL,
  `dive_site` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `temp` int(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `user_id` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `date_table`
--

INSERT INTO `date_table` (`id`, `date`, `dive_site`, `temp`, `created_at`, `updated_at`, `user_id`) VALUES
(23, '2021-08-20', '志賀島　白瀬', 26, '2021-12-07 23:15:51', '2021-12-07 23:15:51', 8),
(24, '2021-09-01', '呼子　家康', 26, '2021-12-07 23:16:40', '2021-12-07 23:16:40', 8),
(25, '2021-09-26', '呼子　家康', 25, '2021-12-07 23:17:24', '2021-12-07 23:17:24', 8),
(26, '2021-12-03', '長崎　辰ノ口', 26, '2021-12-07 23:17:44', '2021-12-07 23:17:44', 8),
(27, '2021-08-04', '志賀島　白瀬', 26, '2021-12-07 23:20:11', '2021-12-07 23:20:11', 8);

-- --------------------------------------------------------

--
-- テーブルの構造 `fish_table`
--

CREATE TABLE `fish_table` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `infomation` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `user_id` int(12) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `fish_table`
--

INSERT INTO `fish_table` (`id`, `name`, `infomation`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'タツノオトシゴ', '', 8, '2021-12-08 22:53:41', '2021-12-08 22:53:41'),
(2, 'メバル', '', 8, '2021-12-09 08:50:07', '2021-12-09 08:50:07'),
(3, 'カサゴ', '', 8, '2021-12-09 08:57:29', '2021-12-09 08:57:29'),
(4, 'イサキ', '', 8, '2021-12-09 08:58:25', '2021-12-09 08:58:25');

-- --------------------------------------------------------

--
-- テーブルの構造 `like_table`
--

CREATE TABLE `like_table` (
  `id` int(12) NOT NULL,
  `user_id` int(12) NOT NULL,
  `todo_id` int(12) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `like_table`
--

INSERT INTO `like_table` (`id`, `user_id`, `todo_id`, `created_at`) VALUES
(2, 9, 4, '2021-12-07 11:26:41'),
(3, 9, 5, '2021-12-07 11:26:42'),
(5, 9, 3, '2021-12-07 11:27:01'),
(6, 10, 14, '2021-12-07 11:27:32'),
(16, 9, 13, '2021-12-07 11:36:34'),
(17, 9, 3, '2021-12-07 11:36:37'),
(19, 10, 13, '2021-12-07 11:37:04'),
(20, 10, 13, '2021-12-07 11:37:05'),
(21, 10, 13, '2021-12-07 11:37:06'),
(22, 10, 14, '2021-12-07 11:37:08'),
(23, 10, 14, '2021-12-07 11:37:08'),
(24, 10, 14, '2021-12-07 11:37:08'),
(25, 10, 4, '2021-12-07 11:37:10'),
(26, 10, 4, '2021-12-07 11:37:10'),
(28, 8, 5, '2021-12-07 12:02:32'),
(29, 8, 11, '2021-12-07 12:02:35'),
(31, 8, 12, '2021-12-07 12:04:41'),
(40, 8, 1, '2021-12-07 12:05:34'),
(45, 9, 14, '2021-12-07 12:05:51'),
(46, 9, 1, '2021-12-07 12:06:19'),
(47, 10, 1, '2021-12-07 12:06:43'),
(48, 10, 5, '2021-12-07 12:06:55'),
(49, 10, 11, '2021-12-07 12:06:57'),
(52, 8, 4, '2021-12-07 15:45:23');

-- --------------------------------------------------------

--
-- テーブルの構造 `log_table`
--

CREATE TABLE `log_table` (
  `id` int(11) NOT NULL,
  `fishname` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `depth` int(4) NOT NULL,
  `date_id` int(12) NOT NULL,
  `user_id` int(12) NOT NULL,
  `fish_id` int(12) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `log_table`
--

INSERT INTO `log_table` (`id`, `fishname`, `depth`, `date_id`, `user_id`, `fish_id`, `created_at`, `updated_at`) VALUES
(11, 'タツノオトシゴ', 10, 23, 8, 1, '2021-12-09 08:33:12', '2021-12-09 08:33:12'),
(12, 'タツノオトシゴ', 10, 23, 8, 1, '2021-12-09 08:34:59', '2021-12-09 08:34:59'),
(13, 'タツノオトシゴ', 10, 23, 8, 1, '2021-12-09 08:35:36', '2021-12-09 08:35:36'),
(14, 'タツノオトシゴ', 10, 23, 8, 1, '2021-12-09 08:38:48', '2021-12-09 08:38:48'),
(15, 'タツノオトシゴ', 10, 23, 8, 1, '2021-12-09 08:39:38', '2021-12-09 08:39:38'),
(16, 'タツノオトシゴ', 10, 23, 8, 1, '2021-12-09 08:39:41', '2021-12-09 08:39:41'),
(17, 'タツノオトシゴ', 10, 23, 8, 1, '2021-12-09 08:39:55', '2021-12-09 08:39:55'),
(18, 'タツノオトシゴ', 10, 23, 8, 1, '2021-12-09 08:40:02', '2021-12-09 08:40:02'),
(19, 'タツノオトシゴ', 10, 23, 8, 1, '2021-12-09 08:40:48', '2021-12-09 08:40:48'),
(20, 'メバル', 10, 26, 8, 2, '2021-12-09 08:50:07', '2021-12-09 08:50:07'),
(21, 'カサゴ', 10, 27, 8, 3, '2021-12-09 08:57:29', '2021-12-09 08:57:29'),
(22, 'イサキ', 10, 27, 8, 4, '2021-12-09 08:58:25', '2021-12-09 08:58:25'),
(23, 'イサキ', 10, 27, 8, 4, '2021-12-09 08:58:31', '2021-12-09 08:58:31');

-- --------------------------------------------------------

--
-- テーブルの構造 `tag_table`
--

CREATE TABLE `tag_table` (
  `id` int(12) NOT NULL,
  `tagname` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `log_id` int(12) NOT NULL,
  `user_id` int(12) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- テーブルの構造 `todo_table`
--

CREATE TABLE `todo_table` (
  `id` int(12) NOT NULL,
  `todo` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `deadline` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `todo_table`
--

INSERT INTO `todo_table` (`id`, `todo`, `deadline`, `created_at`, `updated_at`) VALUES
(1, 'SQL練習', '2021-12-31', '2021-11-26 11:49:57', '2021-11-26 11:49:57'),
(2, 'SQL課題', '2021-12-31', '2021-11-26 11:50:15', '2021-11-26 11:50:15'),
(3, 'PHP練習', '2021-12-31', '2021-11-26 11:53:56', '2021-11-26 11:53:56'),
(4, 'JavaScript練習', '2021-12-25', '2021-11-26 11:54:33', '2021-11-30 12:29:06'),
(5, 'JavaScript課題', '2021-12-31', '2021-11-26 11:54:50', '2021-11-26 11:54:50'),
(6, 'SQL練習', '2022-01-12', '2021-11-26 11:58:54', '2021-11-26 11:58:54'),
(7, 'PHP練習', '2022-12-31', '2021-11-26 12:01:23', '2021-11-26 12:01:23'),
(11, 'SQLとは', '2022-12-31', '2021-11-26 12:01:23', '2021-11-26 12:01:23'),
(12, 'test todo　編集', '2021-11-26', '2021-11-26 15:37:42', '2021-11-30 12:31:01'),
(13, 'DBDBDB', '2021-11-30', '2021-11-30 10:53:11', '2021-11-30 18:00:53'),
(14, 'todo', '2021-11-30', '2021-11-30 18:00:25', '2021-11-30 18:00:25');

-- --------------------------------------------------------

--
-- テーブルの構造 `users_table`
--

CREATE TABLE `users_table` (
  `id` int(12) NOT NULL,
  `username` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `is_admin` int(1) NOT NULL,
  `is_deleted` int(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `users_table`
--

INSERT INTO `users_table` (`id`, `username`, `password`, `is_admin`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'たけし', 'testpass', 1, 0, '2021-11-30 16:32:22', '2021-11-30 16:32:22'),
(2, 'たぬき', 'testpass', 0, 0, '2021-11-30 16:54:37', '2021-11-30 16:54:37'),
(3, 'Atsushi', 'testpass', 0, 1, '2021-11-30 16:55:02', '2021-12-07 14:06:23'),
(4, 'しめじ', 'testpass', 0, 0, '2021-11-30 16:55:26', '2021-12-03 16:46:07'),
(5, 'うに', 'testpass', 0, 0, '2021-11-30 16:55:45', '2021-11-30 18:48:36'),
(6, 'しいたけ', 'testpass', 0, 0, '2021-11-30 17:20:58', '2021-12-03 16:46:32'),
(8, 'testuser01', '111111', 0, 0, '2021-12-03 12:07:35', '2021-12-03 12:07:35'),
(9, 'testuser02', '222222', 0, 0, '2021-12-03 12:07:35', '2021-12-03 12:07:35'),
(10, 'testuser03', '333333', 0, 0, '2021-12-03 12:07:35', '2021-12-03 12:07:35'),
(11, 'testuser04', '444444', 0, 0, '2021-12-03 12:07:35', '2021-12-03 12:07:35'),
(12, 'ジャックマイヨール', 'testpass', 0, 0, '2021-12-06 15:49:39', '2021-12-06 15:49:39'),
(13, 'レブロンジェームズ', 'testpass', 0, 0, '2021-12-06 15:50:36', '2021-12-06 15:50:36'),
(14, 'ドゥウェイン　ウェイド', 'testpass', 0, 0, '2021-12-07 13:44:47', '2021-12-07 13:44:47'),
(15, 'クリスボッシュ', 'testpass', 0, 0, '2021-12-07 13:45:12', '2021-12-07 13:45:12');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `date_table`
--
ALTER TABLE `date_table`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `fish_table`
--
ALTER TABLE `fish_table`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `like_table`
--
ALTER TABLE `like_table`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `log_table`
--
ALTER TABLE `log_table`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `tag_table`
--
ALTER TABLE `tag_table`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `todo_table`
--
ALTER TABLE `todo_table`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users_table`
--
ALTER TABLE `users_table`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `date_table`
--
ALTER TABLE `date_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- テーブルの AUTO_INCREMENT `fish_table`
--
ALTER TABLE `fish_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- テーブルの AUTO_INCREMENT `like_table`
--
ALTER TABLE `like_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- テーブルの AUTO_INCREMENT `log_table`
--
ALTER TABLE `log_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- テーブルの AUTO_INCREMENT `tag_table`
--
ALTER TABLE `tag_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `todo_table`
--
ALTER TABLE `todo_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- テーブルの AUTO_INCREMENT `users_table`
--
ALTER TABLE `users_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
