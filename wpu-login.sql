/*
 Navicat Premium Data Transfer

 Source Server         : Localhost_PHP_7_3
 Source Server Type    : MySQL
 Source Server Version : 100137
 Source Host           : localhost:3306
 Source Schema         : wpu-login

 Target Server Type    : MySQL
 Target Server Version : 100137
 File Encoding         : 65001

 Date: 05/12/2019 22:02:41
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for user_access_menus
-- ----------------------------
DROP TABLE IF EXISTS `user_access_menus`;
CREATE TABLE `user_access_menus`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NULL DEFAULT NULL,
  `menu_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of user_access_menus
-- ----------------------------
INSERT INTO `user_access_menus` VALUES (1, 1, 1);
INSERT INTO `user_access_menus` VALUES (10, 2, 2);
INSERT INTO `user_access_menus` VALUES (11, 3, 2);
INSERT INTO `user_access_menus` VALUES (15, 1, 2);
INSERT INTO `user_access_menus` VALUES (18, 1, 3);

-- ----------------------------
-- Table structure for user_menus
-- ----------------------------
DROP TABLE IF EXISTS `user_menus`;
CREATE TABLE `user_menus`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of user_menus
-- ----------------------------
INSERT INTO `user_menus` VALUES (1, 'Admin');
INSERT INTO `user_menus` VALUES (2, 'User');
INSERT INTO `user_menus` VALUES (3, 'Menu');

-- ----------------------------
-- Table structure for user_roles
-- ----------------------------
DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE `user_roles`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of user_roles
-- ----------------------------
INSERT INTO `user_roles` VALUES (1, 'Admin');
INSERT INTO `user_roles` VALUES (2, 'Member');

-- ----------------------------
-- Table structure for user_sub_menus
-- ----------------------------
DROP TABLE IF EXISTS `user_sub_menus`;
CREATE TABLE `user_sub_menus`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NULL DEFAULT NULL,
  `title` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `url` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `icon` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `is_active` int(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of user_sub_menus
-- ----------------------------
INSERT INTO `user_sub_menus` VALUES (1, 1, 'Dashboard', 'admin', 'fas fa-fw fa-tachometer-alt', 1);
INSERT INTO `user_sub_menus` VALUES (2, 2, 'My Profile', 'user', 'fas fa-fw fa-user', 1);
INSERT INTO `user_sub_menus` VALUES (3, 2, 'Edit Profile', 'user/edit', 'fas fa-fw fa-user-edit', 1);
INSERT INTO `user_sub_menus` VALUES (4, 3, 'Menu Management', 'menu', 'fas fa-fw fa-folder', 1);
INSERT INTO `user_sub_menus` VALUES (5, 3, 'Submenu Management', 'menu/submenu', 'fas fa-fw fa-folder-open', 1);
INSERT INTO `user_sub_menus` VALUES (7, 1, 'Roles', 'admin/roles', 'fas fa-fw fa-user-tie', 1);
INSERT INTO `user_sub_menus` VALUES (8, 2, 'Change Password', 'user/changepassword', 'fas fa-fw fa-key', 1);

-- ----------------------------
-- Table structure for user_tokens
-- ----------------------------
DROP TABLE IF EXISTS `user_tokens`;
CREATE TABLE `user_tokens`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `token` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_date` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of user_tokens
-- ----------------------------
INSERT INTO `user_tokens` VALUES (2, 'yudhistiragilang22@gmail.com', 'bicBy3X6vMt+/v5Wm2fVH9VDCsIhmdx/ZxSrYmH5UEo=', 1575477144);
INSERT INTO `user_tokens` VALUES (3, 'yudhistiragilang22@gmail.com', 'WmxxerkrW1tkjI6hSzYoAHrXgQ6Z0Sd2k0VpqDUeasM=', 1575478276);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `image` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(256) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `role_id` int(11) NULL DEFAULT NULL,
  `is_active` int(1) NULL DEFAULT NULL,
  `created_date` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (8, 'Yudhistira Gilang Adisetyo', 'yudhistiragilang1122@gmail.com', 'logo_gilang.png', '$2y$10$bgjbDxzcXVK3ycrQ.cJP/evgU2pZ4lYD0dP0YJ9vKO8oqhZ2N8PvK', 1, 1, 1572369346);
INSERT INTO `users` VALUES (9, 'Yudhistira Gilang', 'yudhistiragilang22@gmail.com', 'default.jpg', '$2y$10$LbD6vkVrVV5Nsg5JfvLJyOnau128UiIBedbwkmr0c/gqL2tgtlLqu', 2, 1, 1575475194);

SET FOREIGN_KEY_CHECKS = 1;
