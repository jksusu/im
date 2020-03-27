-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2019-04-08 09:56:09
-- 服务器版本： 5.6.43-log
-- PHP 版本： 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `person`
--

-- --------------------------------------------------------

--
-- 表的结构 `apply`
--

CREATE TABLE `apply` (
  `id` int(11) NOT NULL,
  `apply_uid` int(11) NOT NULL COMMENT '申请人用户id',
  `to_id` int(11) NOT NULL COMMENT '被申请人或者群ID',
  `remark` varchar(255) NOT NULL COMMENT '附加信息',
  `friend_group_id` int(11) NOT NULL COMMENT '好友分组',
  `status` tinyint(1) NOT NULL COMMENT '1=申请种 2 = 未通过 3 =通过',
  `type` tinyint(1) NOT NULL COMMENT '申请类型 1 = 好友申请 2 = 群申请',
  `creattime` int(11) NOT NULL COMMENT '申请时间',
  `updatetime` int(11) NOT NULL COMMENT '最后操作时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `apply`
--

INSERT INTO `apply` (`id`, `apply_uid`, `to_id`, `remark`, `friend_group_id`, `status`, `type`, `creattime`, `updatetime`) VALUES
(12, 9, 10, '', 8, 3, 1, 1553429466, 0),
(13, 18, 12, '1', 17, 1, 1, 1554168753, 0),
(14, 20, 12, '', 19, 1, 1, 1554168932, 0),
(15, 24, 23, 'yekongddd', 23, 1, 1, 1554170640, 0),
(16, 23, 24, '', 22, 1, 1, 1554170702, 0),
(17, 25, 9, '', 24, 1, 1, 1554172875, 0),
(18, 25, 23, '', 24, 1, 1, 1554172878, 0),
(19, 25, 21, '', 24, 1, 1, 1554172881, 0),
(20, 25, 20, '', 24, 1, 1, 1554172883, 0),
(21, 22, 9, '', 21, 1, 1, 1554191409, 0),
(22, 31, 9, '', 30, 1, 1, 1554349537, 0),
(23, 30, 9, '1234', 29, 1, 1, 1554349595, 0);

-- --------------------------------------------------------

--
-- 表的结构 `chatuser`
--

CREATE TABLE `chatuser` (
  `id` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL COMMENT '密码',
  `nickname` varchar(20) DEFAULT NULL COMMENT '昵称',
  `avatar` varchar(100) DEFAULT NULL COMMENT '头像地址',
  `email` varchar(20) DEFAULT NULL COMMENT '邮箱',
  `sign` varchar(100) DEFAULT NULL COMMENT '个性签名',
  `sex` tinyint(1) DEFAULT NULL COMMENT '性别 1男 -1女',
  `age` int(3) DEFAULT NULL COMMENT '年龄',
  `pid` int(10) DEFAULT NULL COMMENT '所在省份id',
  `cid` int(10) DEFAULT NULL COMMENT '所在城市id',
  `aid` int(10) DEFAULT NULL COMMENT '所在区id',
  `area` varchar(255) DEFAULT NULL COMMENT '所在区域描述',
  `status` varchar(10) DEFAULT '0',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `chatuser`
--

INSERT INTO `chatuser` (`id`, `username`, `password`, `nickname`, `avatar`, `email`, `sign`, `sex`, `age`, `pid`, `cid`, `aid`, `area`, `status`, `createtime`) VALUES
(7, 'gollum', 'e2ba01c259d796bb4bf60e5d4ad8cdb2', NULL, 'http://p19.qhimg.com/bdm/480_296_0/t01648cc26c003cdb0b.jpg', 'gollum@qq.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1553423370),
(9, 'user1', '24c9e15e52afc47c225b757e7bee1f9d', NULL, 'http://p15.qhimg.com/bdm/480_296_0/t0184553137052bf866.jpg', 'user1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1553423566),
(10, 'user2', '7e58d63b60197ceb55a1c487989a3720', NULL, 'http://p16.qhimg.com/bdm/960_593_0/t014d980d568df4c92d.jpg', 'user2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1553423638),
(11, '随风', '9791dd0794ae05b9736a6182b1df4af8', NULL, 'http://p15.qhimg.com/bdm/480_296_0/t01fa565ac0ae947f93.jpg', '1171977595@qq.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1553523230),
(12, 'Shirley', '257f4d1a26d393d41524ad7e83e7c524', NULL, 'http://p19.qhimg.com/bdm/480_296_0/t01648cc26c003cdb0b.jpg', '1184793244@qq.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1553523491),
(13, '小易', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'http://p16.qhimg.com/bdm/480_296_0/t013727104fdfe5d815.jpg', 'gouweicaosheji@163.c', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1553524994),
(14, 'shyar', '7fef6171469e80d32c0559f88b377245', NULL, 'http://p15.qhimg.com/bdm/480_296_0/t01fa565ac0ae947f93.jpg', '17231721@qq.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1553664604),
(15, 'fdsa', 'fc2baa1a20b4d5190b122b383d7449fd', NULL, 'http://p19.qhimg.com/bdm/480_296_0/t01ccd91eda9f4010a5.jpg', 'fdsa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1554120840),
(16, 'fsd', '148a8a406f8ea822a3e48ee848505715', NULL, 'http://p15.qhimg.com/bdm/480_296_0/t0184553137052bf866.jpg', 'fds', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1554120885),
(17, 'qwe123', '200820e3227815ed1756a6b531e7e0d2', NULL, 'http://p15.qhimg.com/bdm/480_296_0/t01fa565ac0ae947f93.jpg', '13664@163.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1554130009),
(18, '111', '6512bd43d9caa6e02c990b0a82652dca', NULL, 'http://p15.qhimg.com/bdm/480_296_0/t0184553137052bf866.jpg', '11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1554168722),
(19, '111111', '96e79218965eb72c92a549dd5a330112', NULL, 'http://p19.qhimg.com/bdm/480_296_0/t01ccd91eda9f4010a5.jpg', '111111@11.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1554168810),
(20, 'cswingbin', '5dd2d11a17f7dc651c03ebc5dd1a7b1b', NULL, 'http://p17.qhimg.com/bdm/480_296_0/t013209e68165407af7.jpg', 'cswingbin@163.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1554168886),
(21, 'QQ', '343b1c4a3ea721b2d640fc8700db0f36', NULL, 'http://p17.qhimg.com/bdm/480_296_0/t013209e68165407af7.jpg', 'q@qq.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1554169140),
(22, 'admin', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'http://p15.qhimg.com/bdm/480_296_0/t01fa565ac0ae947f93.jpg', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1554169970),
(23, 'yekong', '21232f297a57a5a743894a0e4a801fc3', NULL, 'http://p16.qhimg.com/bdm/960_593_0/t014d980d568df4c92d.jpg', '1249909197@qq.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1554170389),
(24, 'yekongddd', 'cfd136bcc22777afc25a97f722821b86', NULL, 'http://p15.qhimg.com/bdm/480_296_0/t01fa565ac0ae947f93.jpg', '1111111', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1554170471),
(25, 'lenghai923', '2781f8d8a9cb9d006fae1ee9daf6077d', NULL, 'http://p19.qhimg.com/bdm/480_296_0/t01ccd91eda9f4010a5.jpg', 'lenghai923@112.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1554172856),
(26, 'abc123456', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'http://p15.qhimg.com/bdm/480_296_0/t01fa565ac0ae947f93.jpg', '123456', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1554177052),
(27, 'chao', 'ea3a30935ffcb96e133bd978d259838a', NULL, 'http://p16.qhimg.com/bdm/480_296_0/t013727104fdfe5d815.jpg', '843307434@qq.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1554178423),
(28, 'Www', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'http://p19.qhimg.com/bdm/480_296_0/t01ccd91eda9f4010a5.jpg', '191504063@qq.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1554178958),
(29, '123', '202cb962ac59075b964b07152d234b70', NULL, 'http://p17.qhimg.com/bdm/480_296_0/t013209e68165407af7.jpg', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1554190701),
(30, '1234', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'http://p19.qhimg.com/bdm/480_296_0/t01648cc26c003cdb0b.jpg', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1554349154),
(31, 'qwe', '202cb962ac59075b964b07152d234b70', NULL, 'http://p15.qhimg.com/bdm/480_296_0/t01fa565ac0ae947f93.jpg', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1554349364),
(32, '502661058', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'http://p15.qhimg.com/bdm/480_296_0/t0184553137052bf866.jpg', '123@qq.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1554370874),
(33, '哈哈', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'http://p19.qhimg.com/bdm/480_296_0/t01ccd91eda9f4010a5.jpg', '1@qq.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1554685249),
(34, 'haha', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'http://p19.qhimg.com/bdm/480_296_0/t01ccd91eda9f4010a5.jpg', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1554685275);

-- --------------------------------------------------------

--
-- 表的结构 `chat_group`
--

CREATE TABLE `chat_group` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `group_name` varchar(155) NOT NULL COMMENT '群名称',
  `group_avatar` varchar(155) DEFAULT NULL COMMENT '群头像',
  `group_number` int(11) DEFAULT NULL COMMENT '群号码',
  `groupowner_id` int(11) DEFAULT NULL COMMENT '群主id',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  `group_introduce` varchar(255) DEFAULT NULL COMMENT '简介'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='群';

-- --------------------------------------------------------

--
-- 表的结构 `chat_group_user`
--

CREATE TABLE `chat_group_user` (
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `group_id` int(11) NOT NULL COMMENT '群id',
  `status` tinyint(1) NOT NULL COMMENT '状态（1=申请中 2 = 已拒绝 3=已同意）',
  `creattime` int(11) DEFAULT NULL COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='群成员表，群主也必须在这张表中，入群申请';

-- --------------------------------------------------------

--
-- 表的结构 `chat_record`
--

CREATE TABLE `chat_record` (
  `id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL COMMENT '发送ID',
  `to_id` int(11) NOT NULL COMMENT '接收ID，群填写群id',
  `content` text NOT NULL COMMENT '发送的内容',
  `type` varchar(55) NOT NULL COMMENT '聊天类型1=单聊 2=群聊',
  `need_send` tinyint(1) DEFAULT '0' COMMENT '0 不需要推送 1 需要推送',
  `creattime` int(10) NOT NULL COMMENT '记录时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `chat_record`
--

INSERT INTO `chat_record` (`id`, `from_id`, `to_id`, `content`, `type`, `need_send`, `creattime`);

-- --------------------------------------------------------

--
-- 表的结构 `friends`
--

CREATE TABLE `friends` (
  `chatuser_id` int(11) NOT NULL COMMENT '用户id',
  `friend_id` int(11) NOT NULL COMMENT '朋友id',
  `group_id` int(11) NOT NULL COMMENT '朋友所属组别id',
  `remarks` varchar(20) DEFAULT NULL COMMENT '好友备注',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='朋友关系表';

--
-- 转存表中的数据 `friends`
--

INSERT INTO `friends` (`chatuser_id`, `friend_id`, `group_id`, `remarks`, `createtime`) VALUES
(9, 7, 8, 'gollum开发者', 1553423566),
(7, 9, 6, 'user1', 1553423567),
(10, 7, 9, 'gollum开发者', 1553423639),
(7, 10, 6, 'user2', 1553423639),
(9, 10, 8, NULL, 1553429478),
(10, 9, 9, NULL, 1553429478),
(11, 7, 10, 'gollum开发者', 1553523230),
(7, 11, 6, '随风', 1553523230),
(12, 7, 11, 'gollum开发者', 1553523491),
(7, 12, 6, 'Shirley', 1553523491),
(13, 7, 12, 'gollum开发者', 1553524994),
(7, 13, 6, '小易', 1553524994),
(14, 7, 13, 'gollum开发者', 1553664604),
(7, 14, 6, 'shyar', 1553664604),
(15, 7, 14, 'gollum开发者', 1554120840),
(7, 15, 6, 'fdsa', 1554120841),
(16, 7, 15, 'gollum开发者', 1554120886),
(7, 16, 6, 'fsd', 1554120886),
(17, 7, 16, 'gollum开发者', 1554130009),
(7, 17, 6, 'qwe123', 1554130009),
(18, 7, 17, 'gollum开发者', 1554168722),
(7, 18, 6, '111', 1554168722),
(19, 7, 18, 'gollum开发者', 1554168810),
(7, 19, 6, '111111', 1554168810),
(20, 7, 19, 'gollum开发者', 1554168886),
(7, 20, 6, 'cswingbin', 1554168886),
(21, 7, 20, 'gollum开发者', 1554169140),
(7, 21, 6, 'QQ', 1554169140),
(22, 7, 21, 'gollum开发者', 1554169971),
(7, 22, 6, 'admin', 1554169971),
(23, 7, 22, 'gollum开发者', 1554170389),
(7, 23, 6, 'yekong', 1554170389),
(24, 7, 23, 'gollum开发者', 1554170471),
(7, 24, 6, 'yekongddd', 1554170471),
(25, 7, 24, 'gollum开发者', 1554172856),
(7, 25, 6, 'lenghai923', 1554172856),
(26, 7, 25, 'gollum开发者', 1554177052),
(7, 26, 6, 'abc123456', 1554177052),
(27, 7, 26, 'gollum开发者', 1554178423),
(7, 27, 6, 'chao', 1554178423),
(28, 7, 27, 'gollum开发者', 1554178958),
(7, 28, 6, 'Www', 1554178958),
(29, 7, 28, 'gollum开发者', 1554190701),
(7, 29, 6, '123', 1554190701),
(30, 7, 29, 'gollum开发者', 1554349154),
(7, 30, 6, '1234', 1554349154),
(31, 7, 30, 'gollum开发者', 1554349364),
(7, 31, 6, 'qwe', 1554349364),
(32, 7, 31, 'gollum开发者', 1554370874),
(7, 32, 6, '502661058', 1554370874),
(33, 7, 32, 'gollum开发者', 1554685249),
(7, 33, 6, '哈哈', 1554685249),
(34, 7, 33, 'gollum开发者', 1554685275),
(7, 34, 6, 'haha', 1554685275);

-- --------------------------------------------------------

--
-- 表的结构 `friends_group`
--

CREATE TABLE `friends_group` (
  `id` int(11) NOT NULL COMMENT '关联firend group_id',
  `group_name` varchar(20) DEFAULT NULL COMMENT '好友列表分组名字',
  `user_id` int(11) DEFAULT NULL COMMENT '用户ID关联当前登陆用户',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='好友分组表';

--
-- 转存表中的数据 `friends_group`
--

INSERT INTO `friends_group` (`id`, `group_name`, `user_id`, `createtime`) VALUES
(6, '默认分组', 7, 1553423371),
(8, '默认分组', 9, 1553423566),
(9, '默认分组', 10, 1553423639),
(10, '默认分组', 11, 1553523230),
(11, '默认分组', 12, 1553523491),
(12, '默认分组', 13, 1553524994),
(13, '默认分组', 14, 1553664604),
(14, '默认分组', 15, 1554120840),
(15, '默认分组', 16, 1554120885),
(16, '默认分组', 17, 1554130009),
(17, '默认分组', 18, 1554168722),
(18, '默认分组', 19, 1554168810),
(19, '默认分组', 20, 1554168886),
(20, '默认分组', 21, 1554169140),
(21, '默认分组', 22, 1554169970),
(22, '默认分组', 23, 1554170389),
(23, '默认分组', 24, 1554170471),
(24, '默认分组', 25, 1554172856),
(25, '默认分组', 26, 1554177052),
(26, '默认分组', 27, 1554178423),
(27, '默认分组', 28, 1554178958),
(28, '默认分组', 29, 1554190701),
(29, '默认分组', 30, 1554349154),
(30, '默认分组', 31, 1554349364),
(31, '默认分组', 32, 1554370874),
(32, '默认分组', 33, 1554685249),
(33, '默认分组', 34, 1554685275);

--
-- 转储表的索引
--

--
-- 表的索引 `apply`
--
ALTER TABLE `apply`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `chatuser`
--
ALTER TABLE `chatuser`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `chat_group`
--
ALTER TABLE `chat_group`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `chat_record`
--
ALTER TABLE `chat_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fromid` (`from_id`) USING BTREE,
  ADD KEY `toid` (`to_id`) USING BTREE;

--
-- 表的索引 `friends`
--
ALTER TABLE `friends`
  ADD KEY `chatuser_id` (`chatuser_id`) USING BTREE;

--
-- 表的索引 `friends_group`
--
ALTER TABLE `friends_group`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `apply`
--
ALTER TABLE `apply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- 使用表AUTO_INCREMENT `chatuser`
--
ALTER TABLE `chatuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- 使用表AUTO_INCREMENT `chat_group`
--
ALTER TABLE `chat_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `chat_record`
--
ALTER TABLE `chat_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=467;

--
-- 使用表AUTO_INCREMENT `friends_group`
--
ALTER TABLE `friends_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '关联firend group_id', AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
