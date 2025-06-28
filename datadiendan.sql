-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 28, 2025 lúc 09:37 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `datadiendan`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_name`, `email`, `password`) VALUES
(1, 'Ngoc Tram', 'tranthingoctrammt@gmail.com', 'tram1508');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `ID_Comment` int(11) NOT NULL,
  `Comment` text DEFAULT NULL,
  `ID_User` int(11) DEFAULT NULL,
  `ID_Ques` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`ID_Comment`, `Comment`, `ID_User`, `ID_Ques`) VALUES
(1015, 'Bạn có thể lên các trang trực tuyến để tìm hiểu.', 3, 101),
(1016, 'Tôi nghĩ bạn có thể hỏi chi tiết hơn không.', 8, 102),
(1017, 'Không đúng lắm với nội dung câu hỏi.', 2, 103),
(1019, 'Cần phải nâng cao tường lửa và không nên nhấn vào cáo chương trình hay đường link lạ. ', 7, 108),
(1020, 'Có thể dùng nhưng đừng quá lạm dụng vào nó.', 2, 107),
(1021, 'Bạn nói cụ thể hơn được không?', 6, 103),
(1022, 'vẫn chưa hiểu lắm', 1, 103),
(1023, 'Nghe có vẻ khó', 1, 105),
(1024, 'Không nên', 1, 107);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `conversations`
--

CREATE TABLE `conversations` (
  `id` bigint(20) NOT NULL,
  `user1_id` int(11) NOT NULL,
  `user2_id` int(11) NOT NULL,
  `min_user_id` int(11) GENERATED ALWAYS AS (least(`user1_id`,`user2_id`)) STORED,
  `max_user_id` int(11) GENERATED ALWAYS AS (greatest(`user1_id`,`user2_id`)) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `conversations`
--

INSERT INTO `conversations` (`id`, `user1_id`, `user2_id`) VALUES
(7, 6, 5),
(8, 13, 1),
(9, 1, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `posted_at` datetime NOT NULL DEFAULT current_timestamp(),
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `user_id`, `subject`, `message`, `posted_at`, `details`) VALUES
(10, 1, 'Nền tảng tuyệt vời', 'Diễn đàn này thực sự hữu ích cho việc học tập.', '2025-06-22 09:00:00', 'Cố gắng phát huy nhé!'),
(11, 2, 'Báo lỗi', 'Tôi gặp lỗi khi đăng câu hỏi.', '2025-06-22 09:15:00', 'Làm ơn sửa giúp!'),
(12, 3, 'Góp ý', 'Bạn có thể thêm chế độ nền tối không?', '2025-06-22 09:30:00', 'Nó sẽ cải thiện trải nghiệm người dùng.'),
(13, 5, 'Cảm ơn!', 'Nhờ diễn đàn, tôi đã tìm được người hướng dẫn.', '2025-06-22 10:00:00', 'Rất cảm kích.'),
(14, 6, 'Góp ý giao diện', 'Giao diện có thể hiển thị tốt hơn trên di động.', '2025-06-22 10:15:00', 'Cần tối ưu thêm.'),
(15, 7, 'Báo lỗi 404', 'Tôi gặp lỗi 404 ở một số liên kết.', '2025-06-22 10:30:00', 'Vui lòng kiểm tra.'),
(16, 8, 'Tính năng đề xuất', 'Hãy thêm chức năng bình chọn cho câu trả lời.', '2025-06-22 10:45:00', 'Giúp làm nổi bật nội dung hay.'),
(17, 13, 'Lỗi hiển thị avatar', 'Ảnh đại diện của tôi không hiển thị đúng.', '2025-06-22 11:00:00', 'Tôi đã thử tải lại.'),
(18, 14, 'Đề xuất đăng nhập', 'Hỗ trợ đăng nhập bằng GitHub đi ạ.', '2025-06-22 11:15:00', 'Tiện hơn cho các nhà phát triển.'),
(19, 1, 'Tôi không bình luận được', 'Tại sao tôi không thể gửi bình luận được', '2025-06-27 17:57:11', 'Phản hồi từ người dùng qua form.'),
(20, 1, 'Tôi không bình luận được', 'Vẫn chưa bình luận được', '2025-06-27 17:59:09', 'Phản hồi từ người dùng qua form.'),
(21, 2, 'Toi khong gui cmt di', 'huhuhuhu', '2025-06-28 18:55:39', 'Phản hồi từ người dùng qua form.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `feedback_response`
--

CREATE TABLE `feedback_response` (
  `id` int(11) NOT NULL,
  `feedback_id` int(11) DEFAULT NULL,
  `response` text DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `responded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `feedback_response`
--

INSERT INTO `feedback_response` (`id`, `feedback_id`, `response`, `status`, `responded_at`) VALUES
(9, 10, 'Cảm ơn bạn đã đóng góp ý kiến tích cực!', 'đã phản hồi', '2025-06-21 20:30:00'),
(10, 11, 'Chúng tôi đang kiểm tra lỗi và sẽ sửa sớm nhất.', 'đã phản hồi', '2025-06-21 20:35:00'),
(11, 12, 'Chế độ nền tối đang được phát triển.', 'đã phản hồi', '2025-06-21 20:45:00'),
(12, 13, 'Cảm ơn bạn đã tin tưởng sử dụng diễn đàn.', 'đã phản hồi', '2025-06-21 20:50:00'),
(13, 14, 'Cảm ơn bạn, nhóm phát triển sẽ cải tiến giao diện.', 'đã phản hồi', '2025-06-21 21:00:00'),
(14, 15, 'Liên kết đã được cập nhật lại.', 'đã phản hồi', '2025-06-21 21:05:00'),
(15, 16, 'Vui lòng thử upload ảnh lại hoặc liên hệ hỗ trợ.', 'đã phản hồi', '0000-00-00 00:00:00'),
(16, 18, 'Đang gửi yêu cầu đến bộ phận kỹ thuật.', 'đang xử lý', '2025-06-26 07:56:26'),
(17, 17, 'asdasd', 'đã phản hồi', '2025-06-27 17:29:34');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `followers`
--

CREATE TABLE `followers` (
  `id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL COMMENT 'ID người theo dõi',
  `followed_id` int(11) NOT NULL COMMENT 'ID người được theo dõi',
  `created_at` datetime DEFAULT current_timestamp() COMMENT 'Thời gian tạo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `followers`
--

INSERT INTO `followers` (`id`, `follower_id`, `followed_id`, `created_at`) VALUES
(3, 7, 5, '2025-06-19 09:40:37'),
(4, 5, 7, '2025-06-19 09:40:37'),
(5, 8, 5, '2025-06-19 09:40:37'),
(6, 8, 6, '2025-06-19 09:40:37'),
(28, 5, 6, '2025-06-19 10:31:18'),
(36, 6, 5, '2025-06-19 10:42:29'),
(37, 13, 1, '2025-06-28 01:24:10'),
(38, 1, 7, '2025-06-28 11:40:00'),
(236, 5, 29, '2025-06-02 10:20:00'),
(237, 3, 30, '2025-06-03 11:15:00'),
(238, 8, 32, '2025-06-03 12:40:00'),
(239, 6, 34, '2025-06-04 13:55:00'),
(240, 1, 35, '2025-06-04 14:10:00'),
(241, 3, 36, '2025-06-05 08:30:00'),
(242, 7, 38, '2025-06-06 09:45:00'),
(243, 5, 40, '2025-06-07 15:00:00'),
(244, 3, 45, '2025-06-08 18:00:00'),
(245, 6, 47, '2025-06-09 19:00:00'),
(246, 3, 48, '2025-06-09 20:00:00'),
(247, 1, 50, '2025-06-10 08:00:00'),
(248, 8, 28, '2025-06-11 09:10:00'),
(249, 7, 27, '2025-06-11 10:20:00'),
(250, 3, 25, '2025-06-12 11:30:00'),
(251, 2, 26, '2025-06-13 12:40:00'),
(252, 5, 27, '2025-06-14 13:50:00'),
(253, 1, 28, '2025-06-15 14:00:00'),
(254, 8, 29, '2025-06-16 15:10:00'),
(255, 6, 30, '2025-06-17 16:20:00'),
(256, 3, 31, '2025-06-18 17:30:00'),
(257, 7, 32, '2025-06-19 18:40:00'),
(258, 3, 33, '2025-06-20 19:50:00'),
(259, 2, 34, '2025-06-21 20:00:00'),
(260, 5, 35, '2025-06-22 21:10:00'),
(261, 6, 36, '2025-06-23 22:20:00'),
(262, 1, 37, '2025-06-24 23:30:00'),
(263, 8, 38, '2025-06-25 08:40:00'),
(264, 3, 39, '2025-06-26 09:50:00'),
(265, 7, 40, '2025-06-27 10:00:00'),
(266, 3, 41, '2025-06-28 11:10:00'),
(267, 2, 42, '2025-06-28 12:20:00'),
(268, 5, 43, '2025-06-28 13:30:00'),
(269, 6, 44, '2025-06-28 14:40:00'),
(270, 1, 45, '2025-06-28 15:50:00'),
(271, 8, 46, '2025-06-28 16:00:00'),
(272, 7, 47, '2025-06-28 17:10:00'),
(273, 7, 48, '2025-06-28 18:20:00'),
(274, 3, 49, '2025-06-28 19:30:00'),
(275, 2, 50, '2025-06-28 20:40:00'),
(276, 1, 25, '2025-06-28 21:50:00'),
(277, 5, 26, '2025-06-28 22:00:00'),
(278, 6, 27, '2025-06-28 23:10:00'),
(279, 7, 28, '2025-06-28 23:20:00'),
(280, 3, 29, '2025-06-28 23:30:00'),
(281, 8, 30, '2025-06-28 23:40:00'),
(282, 1, 31, '2025-06-28 23:50:00'),
(283, 1, 66, '2025-06-28 12:57:32'),
(1220, 3, 27, '2025-06-01 09:20:00'),
(1221, 34, 28, '2025-06-01 09:30:00'),
(1222, 7, 31, '2025-06-01 10:00:00'),
(1223, 1, 33, '2025-06-01 10:20:00'),
(1224, 3, 35, '2025-06-01 10:40:00'),
(1225, 34, 36, '2025-06-01 10:50:00'),
(1226, 5, 37, '2025-06-01 11:00:00'),
(1227, 6, 38, '2025-06-01 11:10:00'),
(1228, 7, 39, '2025-06-01 11:20:00'),
(1229, 8, 40, '2025-06-01 11:30:00'),
(1230, 1, 41, '2025-06-01 11:40:00'),
(1231, 3, 43, '2025-06-01 12:00:00'),
(1232, 34, 44, '2025-06-01 12:10:00'),
(1233, 5, 45, '2025-06-01 12:20:00'),
(1234, 6, 46, '2025-06-01 12:30:00'),
(1235, 8, 48, '2025-06-01 12:50:00'),
(1236, 1, 49, '2025-06-01 13:00:00'),
(1237, 34, 26, '2025-06-02 08:10:00'),
(1238, 6, 28, '2025-06-02 08:30:00'),
(1239, 7, 29, '2025-06-02 08:40:00'),
(1240, 2, 32, '2025-06-02 09:10:00'),
(1241, 34, 34, '2025-06-02 09:30:00'),
(1242, 7, 37, '2025-06-02 10:00:00'),
(1243, 1, 39, '2025-06-02 10:20:00'),
(1244, 2, 40, '2025-06-02 10:30:00'),
(1245, 34, 42, '2025-06-02 10:50:00'),
(1246, 7, 45, '2025-06-02 11:20:00'),
(1247, 1, 47, '2025-06-02 11:40:00'),
(1248, 2, 48, '2025-06-02 11:50:00'),
(1249, 1, 29, '2025-06-28 21:14:06'),
(1250, 2, 1, '2025-06-28 23:50:30');

--
-- Bẫy `followers`
--
DELIMITER $$
CREATE TRIGGER `after_follow_delete` AFTER DELETE ON `followers` FOR EACH ROW BEGIN
  UPDATE users
  SET follow = follow - 1
  WHERE User_ID = OLD.followed_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_follow_insert` AFTER INSERT ON `followers` FOR EACH ROW BEGIN
  UPDATE users
  SET follow = follow + 1
  WHERE User_ID = NEW.followed_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) NOT NULL,
  `conversation_id` bigint(20) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `messages`
--

INSERT INTO `messages` (`id`, `conversation_id`, `sender_id`, `message`, `created_at`) VALUES
(4, 7, 6, 'hello', '2025-06-18 15:08:56'),
(5, 7, 6, 'an sang đe', '2025-06-18 15:12:20'),
(6, 7, 5, 'ok', '2025-06-18 20:17:28'),
(7, 7, 6, 'f', '2025-06-18 20:36:50'),
(8, 7, 6, 'chào', '2025-06-18 20:50:52'),
(9, 8, 13, 'Xin chao', '2025-06-28 01:24:11'),
(10, 8, 1, 'hello', '2025-06-28 23:44:13'),
(11, 9, 1, 'hello', '2025-06-28 23:44:25'),
(12, 9, 2, 'aaaaaa', '2025-06-28 23:50:31'),
(13, 9, 2, 'aaaaaaaaaaa', '2025-06-28 23:50:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `tag_id`, `title`, `content`, `created_at`) VALUES
(1, 1, 1, 'Thực hành SQL cơ bản cho người mới bắt đầu', 'Bài viết này hướng dẫn cách sử dụng SQL cơ bản cho người mới bắt đầu, từ cách tạo bảng, truy vấn SELECT, đến JOIN dữ liệu.', '2025-06-22 09:00:00'),
(2, 2, 2, 'Công cụ Frontend phổ biến năm 2025', 'Tổng hợp các công cụ Frontend phổ biến năm 2025 như React 18, Vue 4, và các framework hiện đại.', '2025-06-22 09:20:00'),
(3, 3, 3, 'Tìm hiểu về kho dữ liệu Data Lake', 'Tìm hiểu về khái niệm Data Lake, lợi ích và cách áp dụng trong lưu trữ và phân tích dữ liệu lớn.', '2025-06-22 09:45:00'),
(4, 5, 4, 'Cách xây dựng diễn đàn công nghệ', 'Chia sẻ cách xây dựng một diễn đàn công nghệ hoàn chỉnh bằng PHP và MySQL, có phân quyền người dùng và chức năng thảo luận.', '2025-06-22 10:15:00'),
(5, 6, 5, 'Xu hướng An ninh mạng năm 2025', 'Phân tích xu hướng an ninh mạng năm 2025 và cách bảo vệ dữ liệu trước các mối đe dọa hiện đại.', '2025-06-22 10:30:00'),
(7, 8, 7, 'So sánh các nền tảng đám mây', 'So sánh giữa các nền tảng đám mây như AWS, Azure và Google Cloud về giá, tính năng, và hiệu năng.', '2025-06-22 11:15:00'),
(8, 1, 8, 'Framework nổi bật cho phát triển di động', 'Top các framework lập trình mobile được ưa chuộng nhất hiện nay như Flutter, React Native, SwiftUI.', '2025-06-22 11:45:00'),
(9, 2, 9, 'Giải thích vòng đời DevOps', 'Giải thích chi tiết về vòng đời DevOps, từ phát triển, kiểm thử đến triển khai và giám sát ứng dụng.', '2025-06-22 12:15:00'),
(10, 25, 1, 'Học SQL cơ bản', 'Giới thiệu về các câu truy vấn SQL và cơ sở dữ liệu quan hệ.', '2025-02-13 09:21:00'),
(11, 26, 2, 'Công cụ phát triển web', 'Khám phá các công cụ mới nhất cho phát triển web hiện đại.', '2025-03-22 14:40:00'),
(12, 27, 3, 'Xu hướng dữ liệu 2025', 'Phân tích các xu hướng dữ liệu và công nghệ nổi bật năm 2025.', '2025-01-05 08:50:00'),
(13, 28, 4, 'Tổng kết diễn đàn công nghệ', 'Tóm tắt các nội dung trao đổi trong diễn đàn công nghệ gần đây.', '2025-05-11 19:05:00'),
(14, 29, 5, 'Thực hành bảo mật mạng', 'Các mẹo giúp bảo vệ dữ liệu và hệ thống cá nhân.', '2025-06-10 11:32:00'),
(15, 30, 6, 'Giới thiệu Machine Learning', 'Những kiến thức cơ bản về học máy và ứng dụng thực tế.', '2025-04-18 16:43:00'),
(16, 31, 7, 'Hạ tầng điện toán đám mây', 'Hướng dẫn thiết lập môi trường đám mây cho doanh nghiệp.', '2025-02-25 07:15:00'),
(17, 32, 8, 'Công cụ lập trình di động', 'So sánh các framework phát triển ứng dụng di động phổ biến.', '2025-06-01 22:10:00'),
(18, 33, 9, 'DevOps là gì?', 'Tìm hiểu về văn hóa và công cụ trong DevOps.', '2025-03-09 13:00:00'),
(19, 34, 1, 'Câu lệnh JOIN nâng cao', 'Phân tích sâu về các phép JOIN phức tạp trong SQL.', '2025-01-29 10:40:00'),
(20, 35, 2, 'Thiết kế web responsive', 'Tạo bố cục linh hoạt với CSS và HTML5.', '2025-06-15 09:50:00'),
(21, 36, 3, 'Mẹo trực quan hóa dữ liệu', 'Cách trình bày dữ liệu rõ ràng và hiệu quả.', '2025-05-24 12:00:00'),
(22, 37, 4, 'Trích dẫn từ diễn giả', 'Những câu nói nổi bật từ các chuyên gia tại hội thảo công nghệ.', '2025-02-10 17:33:00'),
(23, 38, 5, 'Phòng chống lừa đảo qua email', 'Cách nhận diện và tránh các cuộc tấn công phishing.', '2025-04-01 21:21:00'),
(24, 39, 6, 'Phân biệt ML và AI', 'Sự khác biệt giữa học máy và trí tuệ nhân tạo.', '2025-03-19 15:08:00'),
(25, 40, 7, 'Bảo mật trong môi trường đám mây', 'Những thách thức và giải pháp bảo mật khi dùng cloud.', '2025-05-28 23:47:00'),
(26, 41, 8, 'Ứng dụng đa nền tảng', 'Lợi ích và hạn chế của Flutter và React Native.', '2025-01-15 06:20:00'),
(27, 42, 9, 'Tự động hóa triển khai CI/CD', 'Giới thiệu quy trình triển khai liên tục trong DevOps.', '2025-06-12 10:10:00'),
(28, 43, 1, 'Tối ưu hóa hiệu suất SQL', 'Các cách tăng tốc độ thực thi truy vấn trong SQL.', '2025-04-05 16:35:00'),
(29, 44, 2, 'Tích hợp Web API', 'Kết nối giao diện người dùng với các API hiệu quả.', '2025-03-01 18:55:00'),
(30, 45, 1, 'Hướng dẫn tạo bảng trong SQL', 'Bài viết này hướng dẫn cách tạo bảng với khóa chính và dữ liệu mẫu.', '2025-02-12 09:45:00'),
(31, 46, 5, 'An toàn khi sử dụng wifi công cộng', 'Chia sẻ các lưu ý để bảo vệ thiết bị khi kết nối wifi lạ.', '2025-01-29 14:20:00'),
(32, 47, 3, 'Tổng quan về xử lý dữ liệu lớn', 'Giới thiệu Apache Hadoop, Spark và các công cụ phổ biến.', '2025-03-18 11:50:00'),
(33, 48, 7, 'Thiết lập môi trường Docker', 'Các bước cài đặt Docker cho dự án đầu tiên.', '2025-05-03 13:35:00'),
(34, 49, 2, 'Sử dụng CSS Grid', 'Tạo giao diện linh hoạt bằng cách sử dụng CSS Grid Layout.', '2025-04-16 15:30:00'),
(35, 50, 9, 'Áp dụng DevOps vào doanh nghiệp nhỏ', 'Chia sẻ kinh nghiệm triển khai DevOps ở quy mô vừa và nhỏ.', '2025-06-08 09:10:00'),
(36, 51, 4, 'Diễn đàn công nghệ Việt Nam 2025', 'Những nội dung nổi bật và xu hướng công nghệ mới.', '2025-06-12 08:00:00'),
(37, 52, 6, 'Phân loại thuật toán Machine Learning', 'Giới thiệu các nhóm thuật toán như supervised và unsupervised.', '2025-02-20 17:40:00'),
(38, 53, 8, 'Kỹ thuật tối ưu hiệu suất ứng dụng di động', 'Giảm lag, tiết kiệm pin và cải thiện trải nghiệm người dùng.', '2025-01-17 10:25:00'),
(39, 54, 1, 'Tối ưu câu truy vấn SQL', 'Làm sao để câu truy vấn chạy nhanh và hiệu quả hơn?', '2025-03-10 16:12:00'),
(40, 55, 3, 'Phân tích dữ liệu mạng xã hội', 'Khai thác insight từ các nền tảng như Facebook, Twitter.', '2025-06-14 07:45:00'),
(41, 46, 5, 'Ngăn chặn tấn công brute-force', 'Giải pháp để hạn chế đăng nhập sai nhiều lần.', '2025-01-23 08:55:00'),
(42, 47, 6, 'ML trong chẩn đoán y tế', 'Ứng dụng học máy để hỗ trợ bác sĩ chẩn đoán bệnh.', '2025-04-22 20:30:00'),
(43, 48, 2, 'Thiết kế web tương thích di động', 'Làm sao để giao diện hiển thị tốt trên mọi thiết bị.', '2025-03-05 13:03:00'),
(44, 49, 7, 'CI/CD với GitLab', 'Tự động hóa quy trình triển khai qua GitLab.', '2025-05-26 11:11:00'),
(45, 50, 4, 'Những công nghệ nổi bật tại TechDay', 'Cập nhật xu hướng công nghệ mới nhất từ sự kiện.', '2025-02-06 15:45:00'),
(46, 51, 8, 'Tối ưu hoá UI cho ứng dụng Android', 'Cách tổ chức giao diện hợp lý và nhẹ.', '2025-04-03 18:00:00'),
(47, 52, 9, 'Xây dựng pipeline DevOps cơ bản', 'Các công cụ cần thiết và cách kết nối chúng.', '2025-05-09 10:10:00'),
(48, 53, 2, 'Tạo hiệu ứng chuyển động bằng CSS', 'Làm web sinh động hơn với animation và transition.', '2025-03-28 19:40:00'),
(49, 54, 1, 'Tạo stored procedure trong SQL Server', 'Tự động hóa các bước xử lý dữ liệu bằng thủ tục lưu trữ.', '2025-04-15 09:25:00'),
(50, 55, 6, 'Xây dựng mô hình dự đoán doanh thu', 'Học máy được dùng như thế nào trong kinh doanh?', '2025-01-12 13:35:00'),
(51, 45, 3, 'Khám phá Power BI', 'Cách sử dụng Power BI để trực quan hóa dữ liệu.', '2025-02-25 16:00:00'),
(52, 46, 5, 'Tường lửa là gì?', 'Chức năng và cách cấu hình cơ bản firewall.', '2025-04-07 20:00:00'),
(53, 47, 6, 'ML trong nhận diện khuôn mặt', 'Cơ chế hoạt động và các kỹ thuật phổ biến.', '2025-06-05 12:34:00'),
(54, 48, 7, 'Sử dụng Kubernetes cho dự án nhỏ', 'Lợi ích và cách triển khai ban đầu.', '2025-03-15 14:50:00'),
(55, 49, 9, 'DevOps: Quy trình tự động hóa toàn diện', 'Từ phát triển đến triển khai sản phẩm.', '2025-06-13 17:10:00'),
(56, 50, 8, 'Khắc phục lỗi phổ biến trong Android Studio', 'Tổng hợp các lỗi thường gặp và cách xử lý.', '2025-01-20 11:05:00'),
(57, 51, 4, 'Talkshow công nghệ AI 2025', 'Giao lưu cùng chuyên gia về AI và dữ liệu lớn.', '2025-02-16 08:45:00'),
(58, 52, 1, 'Truy vấn lồng nhau trong SQL', 'Ứng dụng của subquery và các trường hợp nên dùng.', '2025-03-12 10:00:00'),
(59, 53, 3, 'Data Warehouse là gì?', 'Khái niệm và kiến trúc của kho dữ liệu doanh nghiệp.', '2025-04-28 09:40:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_comments`
--

CREATE TABLE `post_comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `post_comments`
--

INSERT INTO `post_comments` (`comment_id`, `post_id`, `user_id`, `content`, `created_at`) VALUES
(1, 1, 1, 'Cảm ơn bài viết rất hữu ích cho người mới bắt đầu!', '2025-06-22 13:00:00'),
(2, 2, 2, 'Công cụ nào đang hot nhất hiện nay vậy mọi người?', '2025-06-22 13:05:00'),
(3, 3, 3, 'Giải thích về Data Lake rất rõ ràng, cảm ơn bạn!', '2025-06-22 13:10:00'),
(4, 4, 5, 'Mình cũng đang muốn xây dựng diễn đàn, học hỏi thêm được nhiều.', '2025-06-22 13:15:00'),
(5, 5, 6, 'Xu hướng an ninh mạng quá cần thiết thời nay.', '2025-06-22 13:20:00'),
(6, 8, 1, 'Sẽ cập nhật sau', '2025-06-28 23:14:53');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `questions`
--

CREATE TABLE `questions` (
  `ID_Ques` int(11) NOT NULL,
  `Date_tao` date DEFAULT NULL,
  `Mo_ta` text DEFAULT NULL,
  `Hinh_anh` varchar(255) DEFAULT NULL,
  `ID_Tags` int(11) DEFAULT NULL,
  `ID_user` int(11) DEFAULT NULL,
  `like_count` int(11) DEFAULT 0,
  `content` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `questions`
--

INSERT INTO `questions` (`ID_Ques`, `Date_tao`, `Mo_ta`, `Hinh_anh`, `ID_Tags`, `ID_user`, `like_count`, `content`) VALUES
(101, '2025-06-01', 'Làm sao để join nhiều bảng trong SQL?', '', 1, 5, 15, 'Tôi có ba bảng orders, customers và products, làm cách nào để viết câu truy vấn lấy tên khách hàng, tên sản phẩm và ngày đặt hàng, sử dụng JOIN?'),
(102, '2025-06-02', 'Sự khác nhau giữa GET và POST trong Web?', NULL, 2, 6, 8, NULL),
(103, '2025-06-03', 'Thiết kế diễn đàn công nghệ bằng PHP/MySQL như thế nào?', '', 4, 7, 20, NULL),
(105, '2025-06-20', 'Làm thế nào để tối ưu hóa tốc độ website với PHP?', '', 1, 5, 12, NULL),
(106, '2025-06-20', 'Sự khác nhau giữa JOIN và UNION trong SQL là gì?', NULL, 1, 3, 9, NULL),
(107, '2025-06-21', 'Có nên dùng AI để viết code không?', '', 3, 2, 18, NULL),
(108, '2025-06-21', 'Làm sao bảo vệ tài khoản khỏi bị hack?', NULL, 4, 1, 3, NULL),
(109, '2025-06-21', 'PHP có còn phù hợp trong thời đại hiện nay không?', '', 2, 4, 11, NULL),
(122, '2025-06-29', 'Tôi bị lỗi SQL', 'uploads/1751130519_1.png', 1, 1, 0, 'Tôi chèn thì bị lỗi như này');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `question_likes`
--

CREATE TABLE `question_likes` (
  `like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `liked_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `question_likes`
--

INSERT INTO `question_likes` (`like_id`, `user_id`, `question_id`, `liked_at`) VALUES
(7, 1, 101, '2025-06-23 21:45:42'),
(8, 2, 101, '2025-06-23 21:45:42'),
(9, 1, 103, '2025-06-23 21:45:42'),
(10, 3, 105, '2025-06-23 21:45:42'),
(11, 2, 107, '2025-06-23 21:45:42'),
(12, 5, 108, '2025-06-23 21:45:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tags`
--

CREATE TABLE `tags` (
  `ID_tag` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tags`
--

INSERT INTO `tags` (`ID_tag`, `Name`) VALUES
(1, 'SQL'),
(2, 'Web Development'),
(3, 'Data'),
(4, 'Technology Forum'),
(5, 'Cybersecurity'),
(6, 'Machine Learning'),
(7, 'Cloud Computing'),
(8, 'Mobile Development'),
(9, 'DevOps');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `User_ID` int(11) NOT NULL,
  `User_name` varchar(100) DEFAULT NULL,
  `ID_Ques` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'uploads/avatar/1751079726_avatar_md.jpg',
  `follow` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `About` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`User_ID`, `User_name`, `ID_Ques`, `email`, `password`, `avatar`, `follow`, `created_at`, `last_login`, `bio`, `location`, `phone_number`, `About`) VALUES
(1, 'Lan_Nguyen@@', 105, 'lannt@gmail.com', 'lanpass', 'uploads/avatar/1751076979_ava (1).jpg', 2, '2025-06-21 08:22:14', '2025-06-21 08:22:14', 'Developer fullstack', 'HaNoi', '0123456789', '“Sự đơn giản là sự tinh tế tột cùng.” ~ Leonardo da Vinci\r\nĐồng tác giả hoặc qemacs và quickjs, với Fabrice Bellard\r\nTôi đã khám phá ra máy tính khi còn học trung học vào năm 1974.\r\nChương trình đầu tiên của tôi là một máy cộng Turing, tôi chạy nó bằng tay với băng giấy, bút và cục tẩy.\r\nTôi đã may mắn khi có quyền truy cập vào máy tính mini Honeywell Bull GE-58 với màn hình 6 chữ số, bộ nhớ lõi 10000 octet và một vài ổ cứng 2,4 MB. Nó cần 15KW điện năng. Tôi vẫn nhớ mã Hollerith để đục lỗ thủ công và từng lập trình trực tiếp bằng mã máy.\r\nTừ đó, tôi đã viết hàng triệu dòng mã, chủ yếu bằng C, nhưng cũng bằng nhiều ngôn ngữ khác nhau.'),
(2, 'TungMTP', 106, 'hoangpm@gmail.com', 'hoangpass', 'uploads/avatar/1751077001_ava (2).jpg', 0, '2025-06-21 08:22:14', '2025-06-21 08:22:14', 'Data Analysis', 'Thái Bình', '0987654321', 'Tôi là một lập trình viên. Ngôn ngữ chính của tôi là C++. Tôi cũng đã làm việc thương mại trong Java, C, Perl, Python, Javascript và APL. Tôi cũng được biết đến là đã thử nghiệm lisp, Haskell, assembler (ARM, x86, amd64) và có lẽ một vài ngôn ngữ khác chưa để lại dấu ấn lớn.'),
(3, 'HuongThi', 107, 'huonglt@gmail.com', 'huongpass', 'uploads/avatar/1751077009_ava (3).jpg', 0, '2025-06-21 08:22:14', '2025-06-21 08:22:14', 'AI developer', 'Ho Chi Minh City', '0909123456', 'Là một mô hình ngôn ngữ lớn, tôi có thể hỗ trợ nhiều khái niệm thống kê, phương pháp, kỹ thuật phân tích dữ liệu và ngôn ngữ lập trình thường được sử dụng để phân tích dữ liệu như R hoặc SAS.\r\n\r\nGạt mọi chuyện sang một bên, tôi là một nhà khoa học thực nghiệm chuyển sang làm việc trong lĩnh vực công nghệ sinh học/dược phẩm, có một số kiến ​​thức lý thuyết nhưng chủ yếu là thực hành về phân tích thống kê trong SAS và R. Vui lòng không dựa vào ChatGPT để thực hiện bất kỳ hoạt động nào trong số này cho bạn (hoặc làm, chúng ta có thể cười).\r\n\r\nNgôn ngữ mẹ đẻ của tôi không phải là tiếng Anh nên xin hãy bỏ qua bất kỳ tpyos hoặc cụm từ kỳ lạ nào.'),
(5, 'User_FFF', 101, 'vana@gmail.com', 'pass123', 'uploads/avatar/1751076908_ava (4).jpg', 3, '2025-06-17 21:51:12', '2025-06-15 09:00:00', 'Project management', 'Hanoi', '0912345678', ''),
(6, 'TranTran', 102, 'thib@gmail.com', 'pass456', 'uploads/avatar/1751077032_ava (5).jpg', 2, '2025-06-17 21:51:12', '2025-06-16 08:30:00', 'Frontend developer', 'Da Nang', '0933224455', 'PostgreSQL support specialist and consultant\r\nPostgreSQL enthusiast and contributor\r\nSystem and application programmer\r\nPostgreSQL blog'),
(7, 'Le Dinh', 103, 'dinhc@gmail.com', 'pass789', 'uploads/avatar/1751077041_ava (6).jpg', 2, '2025-06-17 21:51:12', NULL, '', '', '', ''),
(8, 'Tram', NULL, 'tranthingoctrammt@gmail.com', '1234', 'uploads/avatar/1751077060_ava (7).jpg', 0, '2025-06-17 21:51:12', NULL, 'Kỹ sư dữ liệu', 'HCM', '0933224455', 'Muốn đi du lịch!!'),
(13, 'Nguyen0209', NULL, 'nguyen@gmail.com', 'abcd', 'uploads/avatar/1751077093_ava (28).jpg', 0, '2025-06-21 08:46:42', NULL, 'Freelancer', 'Khánh Hòa', '0912345678', ''),
(14, 'BangBangNek', NULL, 'Bangbang@gmail.com', 'bang123', 'uploads/avatar/1751077080_ava (9).jpg', 0, '2025-06-21 10:28:00', NULL, 'IT Assistant', 'Quảng Trị', '0909123456', ''),
(25, 'nguyenvana', NULL, 'nguyenvana@example.com', 'nguyenvana123', 'uploads/avatar/1751077132_ava (10).jpg', 2, '2025-07-11 00:00:00', NULL, 'Kỹ sư dữ liệu', 'Hưng Yên', '0655085829', 'Tôi tên là nguyenvana. Tôi yêu công nghệ. Tôi muốn trở thành chuyên gia IT.'),
(26, 'tranthib', NULL, 'tranthib@example.com', 'tranthib123', 'uploads/avatar/1751077356_ava (11).jpg', 3, '2025-09-12 00:00:00', NULL, 'DevOps', 'Hải Phòng', '0304665107', 'Tôi tên là tranthib. Tôi yêu công nghệ. Tôi muốn trở thành chuyên gia IT.'),
(27, 'leminhc', NULL, 'leminhc@example.com', 'leminhc123', 'uploads/avatar/1751077367_ava (12).jpg', 4, '2025-11-09 00:00:00', NULL, 'Lập trình viên Backend', 'Nam Định', '0304441584', 'Tôi tên là leminhc. Tôi yêu công nghệ. Tôi muốn trở thành chuyên gia IT.'),
(28, 'phamthuyd', NULL, 'phamthuyd@example.com', 'phamthuyd123', 'uploads/avatar/1751077381_ava (13).jpg', 5, '2025-04-22 00:00:00', NULL, 'Lập trình viên Backend', 'TP. Hồ Chí Minh', '0990728801', 'Tôi tên là phamthuyd. Tôi yêu công nghệ. Tôi muốn trở thành chuyên gia IT.'),
(29, 'nguyenvana', NULL, 'nguyenvana@example.com', 'nguyenvana123', 'uploads/avatar/1751077400_ava (14).jpg', 5, '2025-07-09 00:00:00', '2025-07-11 00:00:00', 'Kỹ sư dữ liệu', 'Hưng Yên', '0655085829', 'Tôi tên là nguyenvana. Tôi yêu công nghệ. Tôi muốn trở thành chuyên gia IT.'),
(30, 'tranthib', NULL, 'tranthib@example.com', 'tranthib123', 'uploads/avatar/1751077412_ava (15).jpg', 3, '2025-08-28 00:00:00', '2025-09-12 00:00:00', 'DevOps', 'Hải Phòng', '0304665107', 'Tôi tên là tranthib. Tôi yêu công nghệ. Tôi muốn trở thành chuyên gia IT.'),
(31, 'leminhc', NULL, 'leminhc@example.com', 'leminhc123', 'uploads/avatar/1751077465_ava (16).jpg', 3, '2025-11-07 00:00:00', '2025-11-09 00:00:00', 'Lập trình viên Backend', 'Nam Định', '0304441584', 'Tôi tên là leminhc. Tôi yêu công nghệ. Tôi muốn trở thành chuyên gia IT.'),
(32, 'phamthuyd', NULL, 'phamthuyd@example.com', 'phamthuyd123', 'uploads/avatar/1751077477_ava (17).jpg', 3, '2025-04-15 00:00:00', '2025-04-22 00:00:00', 'Lập trình viên Backend', 'TP. Hồ Chí Minh', '0990728801', 'Tôi tên là phamthuyd. Tôi yêu công nghệ. Tôi muốn trở thành chuyên gia IT.'),
(33, 'hoangminh', NULL, 'hoangminh@example.com', 'hoangminh123', 'uploads/avatar/1751077488_ava (18).jpg', 2, '2025-03-23 00:00:00', '2025-03-25 00:00:00', 'Kỹ sư phần mềm', 'Hà Nội', '0912345678', 'Tôi tên là hoangminh. Tôi thích lập trình và yêu công nghệ. Tôi muốn xây dựng các ứng dụng sáng tạo.'),
(34, 'trangthao', NULL, 'trangthao@example.com', 'trangthao123', 'uploads/avatar/1751077500_ava (19).jpg', 3, '2025-05-10 00:00:00', '2025-05-12 00:00:00', 'Kỹ sư DevOps', 'Đà Nẵng', '0918765432', 'Tôi tên là trangthao. Tôi đam mê tối ưu hệ thống và tự động hóa quy trình. Tôi mong muốn học hỏi thêm trong lĩnh vực DevOps.'),
(35, 'minhphat', NULL, 'minhphat@example.com', 'minhphat123', 'uploads/avatar/1751077515_ava (20).jpg', 3, '2025-02-18 00:00:00', '2025-02-21 00:00:00', 'Data Analyst', 'Cần Thơ', '0923456789', 'Chào bạn, tôi là minhphat. Tôi yêu dữ liệu và phân tích thông tin. Mục tiêu của tôi là làm việc với dữ liệu lớn để đưa ra những quyết định sáng suốt.'),
(36, 'ngoclan', NULL, 'ngoclan@example.com', 'ngoclan123', 'uploads/avatar/1751077525_ava (21).jpg', 3, '2025-06-12 00:00:00', '2025-06-14 00:00:00', 'Lập trình viên Frontend', 'Bình Dương', '0934567890', 'Tôi là ngoclan, đam mê lập trình giao diện người dùng. Tôi luôn cố gắng học hỏi để cải thiện kỹ năng Frontend của mình.'),
(37, 'quanghuong', NULL, 'quanghuong@example.com', 'quanghuong123', 'uploads/avatar/1751079338_ava (22).jpg', 3, '2025-09-02 00:00:00', '2025-09-05 00:00:00', 'Full Stack Developer', 'Bắc Ninh', '0945678901', 'Tôi tên là quanghuong. Tôi yêu công nghệ và muốn trở thành một Full Stack Developer. Tôi đang học để phát triển cả Frontend và Backend.'),
(38, 'khanhminh', NULL, 'khanhminh@example.com', 'khanhminh123', 'uploads/avatar/1751079352_ava (23).jpg', 3, '2025-10-15 00:00:00', '2025-10-17 00:00:00', 'Chuyên gia bảo mật mạng', 'Hải Dương', '0956789012', 'Tôi là khanhminh. Tôi quan tâm đến an ninh mạng và muốn bảo vệ hệ thống khỏi các mối đe dọa từ bên ngoài.'),
(39, 'dungvietnam', NULL, 'dungvietnam@example.com', 'dungvietnam123', 'uploads/avatar/1751079374_ava (24).jpg', 3, '2025-01-22 00:00:00', '2025-01-24 00:00:00', 'Lập trình viên Python', 'Hà Nội', '0912345670', 'Tôi tên là dungvietnam. Tôi yêu lập trình Python và muốn phát triển các ứng dụng mạnh mẽ.'),
(40, 'thanhson', NULL, 'thanhson@example.com', 'thanhson123', 'uploads/avatar/1751079390_ava (25).jpg', 4, '2025-02-01 00:00:00', '2025-02-03 00:00:00', 'Kỹ sư AI', 'TP. Hồ Chí Minh', '0908765432', 'Tôi là thanhson, đam mê trí tuệ nhân tạo và mong muốn tạo ra các giải pháp AI có ích cho cộng đồng.'),
(41, 'nguyenbich', NULL, 'nguyenbich@example.com', 'nguyenbich123', 'uploads/avatar/1751079403_ava (26).jpg', 2, '2025-03-05 00:00:00', '2025-03-08 00:00:00', 'Lập trình viên Java', 'Đà Nẵng', '0901234567', 'Chào bạn, tôi là nguyenbich. Tôi yêu Java và luôn tìm cách tối ưu hóa mã nguồn. Tôi muốn học hỏi thêm về các công nghệ mới trong lập trình.'),
(42, 'quangdai', NULL, 'quangdai@example.com', 'quangdai123', 'uploads/avatar/1751079414_ava (27).jpg', 2, '2025-04-10 00:00:00', '2025-04-13 00:00:00', 'Tester', 'Cần Thơ', '0987654321', 'Tôi tên là quangdai. Tôi làm việc trong lĩnh vực kiểm thử phần mềm và luôn tìm cách để phát hiện lỗi trước khi sản phẩm đến tay người dùng.'),
(43, 'hieuan', NULL, 'hieuan@example.com', 'hieuan123', 'uploads/avatar/1751079426_ava (29).jpg', 2, '2025-05-20 00:00:00', '2025-05-23 00:00:00', 'Lập trình viên Full Stack', 'Hải Phòng', '0976543210', 'Tôi là hieuan. Tôi yêu phát triển cả frontend và backend. Mục tiêu của tôi là tạo ra các ứng dụng web hoàn thiện từ đầu đến cuối.'),
(44, 'tuananh', NULL, 'tuananh@example.com', 'tuananh123', 'uploads/avatar/1751079441_ava (30).jpg', 2, '2025-06-30 00:00:00', '2025-07-02 00:00:00', 'Chuyên gia Bảo mật mạng', 'Bắc Giang', '0932345678', 'Tôi tên là tuananh. Tôi đam mê bảo mật mạng và muốn giúp các tổ chức bảo vệ hệ thống khỏi các mối đe dọa.'),
(45, 'hanoihai', NULL, 'hanoihai@example.com', 'hanoihai123', 'uploads/avatar/1751079452_ava (31).jpg', 4, '2025-07-19 00:00:00', '2025-07-21 00:00:00', 'Lập trình viên PHP', 'Hà Nội', '0945678900', 'Tôi là hanoihai. Tôi thích lập trình web bằng PHP và luôn cố gắng cải thiện kỹ năng của mình.'),
(46, 'letrong', NULL, 'letrong@example.com', 'letrong123', 'uploads/avatar/1751079463_ava (32).jpg', 2, '2025-08-14 00:00:00', '2025-08-17 00:00:00', 'Kỹ sư phần mềm', 'Bình Dương', '0919234567', 'Tôi là letrong. Tôi yêu công nghệ phần mềm và muốn phát triển các ứng dụng cho cộng đồng. Tôi luôn sẵn sàng học hỏi những công nghệ mới.'),
(47, 'nhattruong', NULL, 'nhattruong@example.com', 'nhattruong123', 'uploads/avatar/1751079473_ava (33).jpg', 3, '2025-09-10 00:00:00', '2025-09-13 00:00:00', 'Lập trình viên Node.js', 'Nam Định', '0922345670', 'Tôi tên là nhattruong. Tôi đam mê lập trình Node.js và muốn phát triển các ứng dụng backend hiệu quả.'),
(48, 'kimtuyen', NULL, 'kimtuyen@example.com', 'kimtuyen123', 'uploads/avatar/1751079505_ava (34).jpg', 4, '2025-10-08 00:00:00', '2025-10-10 00:00:00', 'Data Scientist', 'Ninh Bình', '0931234567', 'Tôi là kimtuyen. Tôi yêu công việc với dữ liệu và muốn sử dụng machine learning để giải quyết các vấn đề thực tế.'),
(49, 'thanhhoa', NULL, 'thanhhoa@example.com', 'thanhhoa123', 'uploads/avatar/1751079515_ava (35).jpg', 2, '2025-01-11 00:00:00', '2025-01-13 00:00:00', 'Kỹ sư phần mềm', 'Hà Nội', '0912345679', 'Tôi tên là thanhhoa. Tôi đam mê lập trình và phát triển các phần mềm có ích cho xã hội.'),
(50, 'dinhhuong', NULL, 'dinhhuong@example.com', 'dinhhuong123', 'uploads/avatar/1751079551_ava (36).jpg', 2, '2025-01-26 00:00:00', '2025-01-29 00:00:00', 'Lập trình viên Frontend', 'Đà Nẵng', '0903456789', 'Tôi là dinhhuong. Tôi yêu lập trình giao diện người dùng và mong muốn tạo ra những ứng dụng web mượt mà.'),
(51, 'luanngoc', NULL, 'luanngoc@example.com', 'luanngoc123', 'uploads/avatar/1751079560_ava (37).jpg', 0, '2025-02-15 00:00:00', '2025-02-18 00:00:00', 'DevOps', 'TP. Hồ Chí Minh', '0909876543', 'Tôi là luanngoc. Tôi làm việc trong lĩnh vực DevOps và yêu thích việc tự động hóa quy trình phát triển phần mềm.'),
(52, 'quynhthu', NULL, 'quynhthu@example.com', 'quynhthu123', 'uploads/avatar/1751079569_ava (38).jpg', 0, '2025-03-03 00:00:00', '2025-03-05 00:00:00', 'Lập trình viên Java', 'Hải Phòng', '0923456789', 'Tôi tên là quynhthu. Tôi đam mê lập trình Java và muốn xây dựng những ứng dụng mạnh mẽ, dễ bảo trì.'),
(53, 'binhduong', NULL, 'binhduong@example.com', 'binhduong123', 'uploads/avatar/1751079578_ava (39).jpg', 0, '2025-04-01 00:00:00', '2025-04-03 00:00:00', 'Kỹ sư dữ liệu', 'Bình Dương', '0945123456', 'Tôi là binhduong. Tôi yêu công việc với dữ liệu và mong muốn tạo ra những phân tích hữu ích từ dữ liệu lớn.'),
(54, 'khanhhoang', NULL, 'khanhhoang@example.com', 'khanhhoang123', 'uploads/avatar/1751079599_ava (40).jpg', 0, '2025-05-14 00:00:00', '2025-05-16 00:00:00', 'Full Stack Developer', 'TP. Hồ Chí Minh', '0934567891', 'Tôi tên là khanhhoang. Tôi thích phát triển cả frontend và backend và muốn trở thành một lập trình viên Full Stack chuyên nghiệp.'),
(55, 'lindong', NULL, 'lindong@example.com', 'lindong123', 'uploads/avatar/1751079609_ava (41).jpg', 0, '2025-06-02 00:00:00', '2025-06-05 00:00:00', 'Tester', 'Hà Nội', '0916789012', 'Tôi là lindong. Tôi làm việc trong lĩnh vực kiểm thử phần mềm và luôn cố gắng phát hiện ra các lỗi trước khi phần mềm ra mắt.'),
(56, 'hoangbao', NULL, 'hoangbao@example.com', 'hoangbao123', 'uploads/avatar/1751079620_ava (42).jpg', 0, '2025-07-01 00:00:00', '2025-07-03 00:00:00', 'Kỹ sư AI', 'Bắc Ninh', '0925678901', 'Tôi tên là hoangbao. Tôi đam mê AI và muốn xây dựng các hệ thống học máy để giải quyết những vấn đề thực tiễn.'),
(57, 'minhdung', NULL, 'minhdung@example.com', 'minhdung123', 'uploads/avatar/1751079631_ava (43).jpg', 0, '2025-07-25 00:00:00', '2025-07-28 00:00:00', 'Lập trình viên PHP', 'Nam Định', '0905678902', 'Tôi là minhdung. Tôi thích phát triển các ứng dụng web bằng PHP và muốn cải thiện kỹ năng của mình trong lĩnh vực này.'),
(58, 'anhtuan', NULL, 'anhtuan@example.com', 'anhtuan123', 'uploads/avatar/1751079642_1751079403_ava (26).jpg', 0, '2025-08-05 00:00:00', '2025-08-08 00:00:00', 'Chuyên gia bảo mật mạng', 'Hải Dương', '0986789013', 'Tôi tên là anhtuan. Tôi quan tâm đến bảo mật mạng và mong muốn giúp đỡ các công ty bảo vệ hệ thống của mình khỏi các mối đe dọa.'),
(59, 'ngocbich', NULL, 'ngocbich@example.com', 'ngocbich123', 'uploads/avatar/1751079651_1751077041_ava (6).jpg', 0, '2025-09-01 00:00:00', '2025-09-04 00:00:00', 'Lập trình viên C#', 'Cần Thơ', '0912345673', 'Tôi là ngocbich. Tôi đam mê lập trình C# và mong muốn phát triển phần mềm cho các ứng dụng doanh nghiệp.'),
(60, 'truongky', NULL, 'truongky@example.com', 'truongky123', 'uploads/avatar/1751079673_1751077060_ava (7).jpg', 0, '2025-09-17 00:00:00', '2025-09-19 00:00:00', 'Data Analyst', 'Hà Nội', '0949876543', 'Tôi tên là truongky. Tôi làm việc với dữ liệu và tìm kiếm các xu hướng trong dữ liệu lớn để đưa ra quyết định chính xác hơn.'),
(61, 'hoangngoc', NULL, 'hoangngoc@example.com', 'hoangngoc123', 'uploads/avatar/1751079695_ava (33).jpg', 0, '2025-10-02 00:00:00', '2025-10-04 00:00:00', 'Lập trình viên Python', 'Đà Nẵng', '0935678902', 'Tôi tên là hoangngoc. Tôi yêu lập trình Python và mong muốn sử dụng ngôn ngữ này để phát triển các ứng dụng thông minh.'),
(62, 'thaiduong', NULL, 'thaiduong@example.com', 'thaiduong123', 'uploads/avatar/1751079726_avatar_md.jpg', 0, '2025-10-12 00:00:00', '2025-10-14 00:00:00', 'Kỹ sư phần mềm', 'Bắc Giang', '0913456789', 'Tôi là thaiduong. Tôi yêu phát triển phần mềm và mong muốn tham gia vào các dự án sáng tạo trong lĩnh vực công nghệ.'),
(63, 'hongminh', NULL, 'hongminh@example.com', 'hongminh123', 'uploads/avatar/1751079726_avatar_md.jpg', 0, '2025-11-02 00:00:00', '2025-11-05 00:00:00', 'Lập trình viên Ruby', 'Bình Dương', '0906543212', 'Tôi tên là hongminh. Tôi đam mê lập trình Ruby và muốn tham gia vào các dự án phần mềm để phát triển ứng dụng dễ sử dụng.'),
(64, 'trinhson', NULL, 'trinhson@example.com', 'trinhson123', 'uploads/avatar/1751079895_1751079726_avatar_md.jpg', 0, '2025-11-10 00:00:00', '2025-11-12 00:00:00', 'DevOps', 'TP. Hồ Chí Minh', '0902345678', 'Tôi là trinhson. Tôi chuyên về DevOps và luôn tìm cách tối ưu hóa quy trình phát triển phần mềm để tăng năng suất.'),
(65, 'nhatdung', NULL, 'nhatdung@example.com', 'nhatdung123', 'uploads/avatar/1751079908_1751079895_1751079726_avatar_md.jpg', 0, '2025-11-20 00:00:00', '2025-11-22 00:00:00', 'Lập trình viên Backend', 'Hải Phòng', '0912334455', 'Tôi tên là nhatdung. Tôi thích phát triển các hệ thống backend mạnh mẽ và mở rộng quy mô ứng dụng.'),
(66, 'trinhnguyen', NULL, 'trinhnguyen@example.com', 'trinhnguyen123', 'uploads/avatar/1751079923_1751079726_avatar_md.jpg', 1, '2025-12-02 00:00:00', '2025-12-04 00:00:00', 'Chuyên gia AI', 'Hải Dương', '0922334455', 'Tôi là trinhnguyen. Tôi nghiên cứu và phát triển các giải pháp AI và mong muốn ứng dụng công nghệ AI vào đời sống thực tế.'),
(67, 'phuoclam', NULL, 'phuoclam@example.com', 'phuoclam123', 'uploads/avatar/1751079940_ava (30).jpg', 0, '2025-12-15 00:00:00', '2025-12-17 00:00:00', 'Lập trình viên Swift', 'Cần Thơ', '0903456798', 'Tôi tên là phuoclam. Tôi yêu lập trình ứng dụng di động với Swift và mong muốn xây dựng các ứng dụng iOS hữu ích cho người dùng.'),
(68, 'minhthao', NULL, 'minhthao@example.com', 'minhthao123', 'uploads/avatar/1751079959_ava (9).jpg', 0, '2025-12-22 00:00:00', '2025-12-24 00:00:00', 'Kỹ sư dữ liệu', 'TP. Hồ Chí Minh', '0916789010', 'Tôi là minhthao. Tôi yêu công việc với dữ liệu và muốn tìm ra những insight quý giá từ dữ liệu lớn.'),
(69, 'user1111', NULL, 'user1111@gmail.com', '12345', 'uploads/avatar/1751079726_avatar_md.jpg', 0, '2025-06-28 11:24:08', NULL, NULL, NULL, NULL, '');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`ID_Comment`),
  ADD KEY `comments_ibfk_2` (`ID_Ques`),
  ADD KEY `comments_ibfk_1` (`ID_User`);

--
-- Chỉ mục cho bảng `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_conv` (`min_user_id`,`max_user_id`),
  ADD KEY `user1_id` (`user1_id`),
  ADD KEY `user2_id` (`user2_id`);

--
-- Chỉ mục cho bảng `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `feedback_response`
--
ALTER TABLE `feedback_response`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_feedback_id` (`feedback_id`);

--
-- Chỉ mục cho bảng `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_follow` (`follower_id`,`followed_id`),
  ADD KEY `followed_id` (`followed_id`);

--
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_id` (`conversation_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Chỉ mục cho bảng `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`ID_Ques`),
  ADD KEY `ID_user` (`ID_user`),
  ADD KEY `questions_ibfk_1` (`ID_Tags`);

--
-- Chỉ mục cho bảng `question_likes`
--
ALTER TABLE `question_likes`
  ADD PRIMARY KEY (`like_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`question_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Chỉ mục cho bảng `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`ID_tag`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`),
  ADD KEY `lk_Ques_User` (`ID_Ques`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `ID_Comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1025;

--
-- AUTO_INCREMENT cho bảng `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `feedback_response`
--
ALTER TABLE `feedback_response`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1251;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT cho bảng `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `questions`
--
ALTER TABLE `questions`
  MODIFY `ID_Ques` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT cho bảng `question_likes`
--
ALTER TABLE `question_likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `tags`
--
ALTER TABLE `tags`
  MODIFY `ID_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`ID_User`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`ID_Ques`) REFERENCES `questions` (`ID_Ques`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `conversations_ibfk_1` FOREIGN KEY (`user1_id`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversations_ibfk_2` FOREIGN KEY (`user2_id`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `feedback_response`
--
ALTER TABLE `feedback_response`
  ADD CONSTRAINT `fk_feedback_id` FOREIGN KEY (`feedback_id`) REFERENCES `feedback` (`feedback_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`followed_id`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`ID_tag`);

--
-- Các ràng buộc cho bảng `post_comments`
--
ALTER TABLE `post_comments`
  ADD CONSTRAINT `post_comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`ID_Tags`) REFERENCES `tags` (`ID_tag`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `question_likes`
--
ALTER TABLE `question_likes`
  ADD CONSTRAINT `question_likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_likes_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`ID_Ques`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `lk_Ques_User` FOREIGN KEY (`ID_Ques`) REFERENCES `questions` (`ID_Ques`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
