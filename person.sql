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

INSERT INTO `chat_record` (`id`, `from_id`, `to_id`, `content`, `type`, `need_send`, `creattime`) VALUES
(54, 10, 9, '测试', '1', 0, 1553429504),
(55, 9, 10, '测试', '1', 0, 1553429517),
(56, 10, 7, '放大', '1', 1, 1553434035),
(57, 7, 9, 'face[嘘] ', '1', 1, 1553435703),
(58, 7, 9, 'nihoa ', '1', 1, 1553523148),
(59, 7, 11, 'nihao ', '1', 1, 1553523266),
(60, 11, 7, '哈哈哈是的', '1', 0, 1553523287),
(61, 12, 7, 'sb', '1', 0, 1553523517),
(62, 7, 12, 'gouzi ', '1', 0, 1553523520),
(63, 12, 7, 'golum~', '1', 0, 1553523526),
(64, 7, 11, '不是找别人写的', '1', 0, 1553523534),
(65, 12, 7, '可以不错流弊啊', '1', 0, 1553523537),
(66, 12, 7, '厉害', '1', 0, 1553523543),
(67, 7, 12, '哈哈哈', '1', 0, 1553523552),
(68, 7, 12, '还行吧', '1', 0, 1553523554),
(69, 12, 7, '哈哈哈', '1', 0, 1553523556),
(70, 12, 7, '傻狗', '1', 0, 1553523558),
(71, 11, 7, '可以可以', '1', 0, 1553523568),
(72, 12, 7, '好了我要去学习了', '1', 0, 1553523601),
(73, 7, 12, '号', '1', 0, 1553523607),
(74, 7, 12, '傻狗', '1', 0, 1553523611),
(75, 7, 12, '傻逼玩意', '1', 0, 1553523613),
(76, 11, 7, '还好啥都好说', '1', 0, 1553523793),
(77, 12, 7, '。。', '1', 0, 1553523812),
(78, 12, 7, '因为我要换工作啊', '1', 0, 1553523824),
(79, 12, 7, '我要学习啊', '1', 0, 1553523830),
(80, 7, 12, '号', '1', 0, 1553523834),
(81, 12, 7, '我要被面试题啊', '1', 0, 1553523836),
(82, 12, 7, '要不然我站到路口喝西北风啊', '1', 0, 1553523852),
(83, 12, 7, '我没开声音', '1', 0, 1553523865),
(84, 7, 12, '我开了', '1', 0, 1553523869),
(85, 7, 12, '我在和老范视频', '1', 0, 1553523876),
(86, 13, 7, 'face[微笑] ', '1', 0, 1553525011),
(87, 7, 13, '易', '1', 0, 1553525019),
(88, 13, 7, '这个很强势啊', '1', 0, 1553525035),
(89, 7, 13, '收到请回复呀', '1', 0, 1553525036),
(90, 13, 7, '哈哈哈', '1', 0, 1553525040),
(91, 13, 7, '你在搞那个X站？', '1', 0, 1553525062),
(92, 7, 13, '没有', '1', 0, 1553525068),
(93, 13, 7, '如果是有数据的话', '1', 0, 1553525072),
(94, 13, 7, '被抓了 ', '1', 0, 1553525075),
(95, 13, 7, '罪还大些', '1', 0, 1553525080),
(96, 7, 13, '不搞那个', '1', 0, 1553525082),
(97, 11, 7, 'face[哼] ', '1', 0, 1553525084),
(98, 13, 7, '我们这里好多', '1', 0, 1553525092),
(99, 7, 13, '其实赚不到好多钱', '1', 0, 1553525093),
(100, 13, 7, '搞那个的啊', '1', 0, 1553525096),
(101, 13, 7, '皮条客', '1', 0, 1553525102),
(102, 13, 7, '晓得不', '1', 0, 1553525104),
(103, 13, 7, '网聊', '1', 0, 1553525107),
(104, 7, 13, '厦门嘛', '1', 0, 1553525107),
(105, 13, 7, '不不', '1', 0, 1553525112),
(106, 13, 7, '广东那边', '1', 0, 1553525115),
(107, 13, 7, '我们这边有个村', '1', 0, 1553525120),
(108, 13, 7, '我擦', '1', 0, 1553525122),
(109, 13, 7, '靠它发财', '1', 0, 1553525125),
(110, 7, 13, '卧槽', '1', 0, 1553525129),
(111, 7, 13, '牛逼有a', '1', 0, 1553525131),
(112, 7, 13, '不怕嘛', '1', 0, 1553525133),
(113, 13, 7, '听说一个月就可以有4万', '1', 0, 1553525134),
(114, 13, 7, '我日 ', '1', 0, 1553525138),
(115, 13, 7, '我有几个玩伴', '1', 0, 1553525147),
(116, 13, 7, '也去搞那个了', '1', 0, 1553525150),
(117, 13, 7, '我擦 ', '1', 0, 1553525152),
(118, 13, 7, '来钱是他么的多', '1', 0, 1553525159),
(119, 7, 13, '卧槽', '1', 0, 1553525192),
(120, 7, 13, '你们那边那些人楞个强势嘛', '1', 0, 1553525198),
(121, 13, 7, '儿虎吗', '1', 0, 1553525207),
(122, 13, 7, '嘛', '1', 0, 1553525209),
(123, 13, 7, '卧槽', '1', 0, 1553525213),
(124, 7, 13, '我娘娘搞苹果试玩', '1', 0, 1553525220),
(125, 13, 7, '好几把黑人', '1', 0, 1553525223),
(126, 7, 13, '他给我说的一天可以赚几万', '1', 0, 1553525227),
(127, 13, 7, '苹果试玩？', '1', 0, 1553525234),
(128, 7, 13, '嗯', '1', 0, 1553525236),
(129, 13, 7, '赌博的？', '1', 0, 1553525239),
(130, 7, 13, '不是', '1', 0, 1553525241),
(131, 13, 7, '那是？\n啥子啊 ', '1', 0, 1553525246),
(132, 7, 13, '刷下载量', '1', 0, 1553525249),
(133, 13, 7, '卧槽 ', '1', 0, 1553525253),
(134, 13, 7, '这个还好 ', '1', 0, 1553525259),
(135, 13, 7, '不违法', '1', 0, 1553525262),
(136, 7, 13, '下载一个app4块钱', '1', 0, 1553525263),
(137, 13, 7, '还专门的公司吗？', '1', 0, 1553525276),
(138, 7, 13, '他有300台手机刷', '1', 0, 1553525277),
(139, 13, 7, '我擦', '1', 0, 1553525280),
(140, 13, 7, '300台苹果？', '1', 0, 1553525286),
(141, 7, 13, '20多个平台', '1', 0, 1553525287),
(142, 7, 13, '对', '1', 0, 1553525289),
(143, 13, 7, '我日 ', '1', 0, 1553525291),
(144, 7, 13, '苹果6', '1', 0, 1553525292),
(145, 13, 7, '光苹果手机就是几十万', '1', 0, 1553525302),
(146, 13, 7, '投资不小啊 ', '1', 0, 1553525311),
(147, 7, 13, '20多万吧', '1', 0, 1553525316),
(148, 7, 13, '赚到钱了撒', '1', 0, 1553525322),
(149, 13, 7, '牛皮', '1', 0, 1553525327),
(150, 7, 13, '还有个搞黑产的', '1', 0, 1553525332),
(151, 13, 7, '我日 那个都是需要有资金的吗', '1', 0, 1553525343),
(152, 13, 7, '那个拉皮条客的', '1', 0, 1553525349),
(153, 7, 13, '17年微信红包赌博很牛行', '1', 0, 1553525352),
(154, 13, 7, '最多十几台手机', '1', 0, 1553525360),
(155, 7, 13, '他们呢团队开发的红包外挂', '1', 0, 1553525366),
(156, 13, 7, '微信待聊', '1', 0, 1553525370),
(157, 13, 7, '我擦', '1', 0, 1553525372),
(158, 13, 7, '是的 ', '1', 0, 1553525373),
(159, 13, 7, '微信赌博', '1', 0, 1553525377),
(160, 7, 13, '在国外去开发的，两个月分了200多万', '1', 0, 1553525385),
(161, 7, 13, '他们苹果手机做任务都是有自动脚本，', '1', 0, 1553525410),
(162, 7, 13, '自动做任务', '1', 0, 1553525416),
(163, 7, 13, '自己看着就行，一般都不会出问题', '1', 0, 1553525425),
(164, 13, 7, '我草 ', '1', 0, 1553525427),
(165, 13, 7, '自动怀', '1', 0, 1553525430),
(166, 13, 7, '化', '1', 0, 1553525434),
(167, 13, 7, '就是牛逼', '1', 0, 1553525436),
(168, 13, 7, '我也准备学习PYTHON', '1', 0, 1553525444),
(169, 7, 13, '去年我还想跟着她干那个，但是感觉她没得想带我的意思，', '1', 0, 1553525449),
(170, 13, 7, '到公司那边去了上班', '1', 0, 1553525449),
(171, 13, 7, '空闲的时间就来学习', '1', 0, 1553525458),
(172, 13, 7, '要有个保障多', '1', 0, 1553525463),
(173, 7, 13, '自动化用的 lua', '1', 0, 1553525467),
(174, 13, 7, '我擦 可以自己摸索后', '1', 0, 1553525484),
(175, 7, 13, '我初中同学也是搞他们那行', '1', 0, 1553525486),
(176, 13, 7, '国人来搞哈', '1', 0, 1553525488),
(177, 7, 13, '去年买的保时捷', '1', 0, 1553525497),
(178, 13, 7, '我日', '1', 0, 1553525503),
(179, 7, 13, '过年在街上我还看到的', '1', 0, 1553525505),
(180, 13, 7, '这些都他妈赚到钱了啊 ', '1', 0, 1553525518),
(181, 7, 13, '听说他去年赚了800多w', '1', 0, 1553525519),
(182, 13, 7, '富贵险中求啊', '1', 0, 1553525524),
(183, 13, 7, '我日', '1', 0, 1553525526),
(184, 7, 13, '对呀', '1', 0, 1553525528),
(185, 13, 7, '我擦 ', '1', 0, 1553525529),
(186, 7, 13, '富贵险中求', '1', 0, 1553525548),
(187, 7, 13, '他朋友圈的转账记录都是几十万', '1', 0, 1553525570),
(188, 7, 13, '羡慕呀', '1', 0, 1553525572),
(189, 13, 7, '也是  不管嫩个还是要自己搞', '1', 0, 1553525574),
(190, 7, 13, '都是命', '1', 0, 1553525578),
(191, 13, 7, '才赚到钱', '1', 0, 1553525582),
(192, 13, 7, '命啊 ', '1', 0, 1553525585),
(193, 7, 13, '上班只是求个安稳', '1', 0, 1553525593),
(194, 7, 13, '过哈日子', '1', 0, 1553525600),
(195, 13, 7, '这还不怕哟 ', '1', 0, 1553525604),
(196, 13, 7, '没的家庭的负担 还没有结婚', '1', 0, 1553525615),
(197, 13, 7, '拴住', '1', 0, 1553525617),
(198, 13, 7, '一旦结婚', '1', 0, 1553525624),
(199, 7, 13, '对呀', '1', 0, 1553525625),
(200, 13, 7, '工作可能就一直固定了', '1', 0, 1553525631),
(201, 13, 7, '不敢拼', '1', 0, 1553525636),
(202, 7, 13, '找不到赚钱的路子呀', '1', 0, 1553525646),
(203, 7, 13, '找到路了就暴富', '1', 0, 1553525655),
(204, 13, 7, '确实', '1', 0, 1553525660),
(205, 13, 7, '搞在线教育现在也捞钱的很', '1', 0, 1553525673),
(206, 13, 7, '我日', '1', 0, 1553525677),
(207, 7, 13, '我们公司以前的一个同事每个月撸羊毛都有4w多', '1', 0, 1553525690),
(208, 13, 7, '我擦', '1', 0, 1553525696),
(209, 7, 13, '那些会赚钱的不管搞撒子都能赚钱', '1', 0, 1553525706),
(210, 13, 7, '撸羊毛还能撸这么多？', '1', 0, 1553525707),
(211, 7, 13, '不光自己撸', '1', 0, 1553525715),
(212, 7, 13, '还收别人的', '1', 0, 1553525718),
(213, 13, 7, '我日', '1', 0, 1553525720),
(214, 7, 11, '再没', '1', 1, 1553563465),
(215, 7, 13, '发大水', '1', 1, 1553563481),
(216, 7, 14, 'zaibu ', '1', 0, 1553664680),
(217, 7, 14, 'long?', '1', 0, 1553664685),
(218, 14, 7, 'en ', '1', 0, 1553664689),
(219, 7, 14, '以后有空了搞一个 app', '1', 0, 1553664724),
(220, 7, 14, '那样就不会被监听了', '1', 0, 1553664734),
(221, 14, 7, '还好', '1', 0, 1553664750),
(222, 14, 7, '用纸飞机也可以', '1', 0, 1553664756),
(223, 7, 14, '我这个聊天记录都没得，安全的很，再搞个点对点加密', '1', 0, 1553664775),
(224, 14, 7, '你聊天记录没存数据库？', '1', 0, 1553664793),
(225, 7, 14, '可以存，可以不粗', '1', 0, 1553664802),
(226, 14, 7, '好吧', '1', 0, 1553664815),
(227, 14, 7, '你没上班？', '1', 0, 1553664820),
(228, 7, 14, '在公司呀', '1', 0, 1553664828),
(229, 14, 7, '上班还可以搞别的？', '1', 0, 1553664839),
(230, 7, 14, '你们那个运营的怎么养了', '1', 0, 1553664841),
(231, 7, 14, '抽空写的呀', '1', 0, 1553664848),
(232, 14, 7, '先不说那个', '1', 0, 1553664856),
(233, 14, 7, '不方便', '1', 0, 1553664857),
(234, 7, 14, '这哈中午休息', '1', 0, 1553664857),
(235, 7, 14, '好嘛', '1', 0, 1553664867),
(236, 14, 7, '怎么清空聊天记录', '1', 0, 1553664877),
(237, 7, 14, '清楚浏览器缓存', '1', 0, 1553664893),
(238, 7, 14, '就清空了', '1', 0, 1553664897),
(239, 14, 7, 'face[黑线] ', '1', 0, 1553664925),
(240, 7, 14, 'face[给力] ', '1', 0, 1553664943),
(241, 7, 14, 'H站我找到了', '1', 0, 1553664956),
(242, 14, 7, '我清空缓存了还是有', '1', 0, 1553665070),
(243, 14, 7, '有bug啊', '1', 0, 1553665076),
(244, 14, 7, '要清空网站缓存才行', '1', 0, 1553665116),
(245, 7, 14, 'bug多了', '1', 0, 1553665119),
(246, 7, 14, '好多功能都还没有', '1', 0, 1553665132),
(247, 7, 14, '慢慢写吧，', '1', 0, 1553665149),
(248, 14, 7, '慢慢写', '1', 0, 1553665151),
(249, 14, 7, '以后写了拿来用', '1', 0, 1553665166),
(250, 14, 7, '哈哈', '1', 0, 1553665167),
(251, 7, 14, 'app可以用。', '1', 0, 1553665174),
(252, 14, 7, '你会写APP？', '1', 0, 1553665183),
(253, 7, 14, 'h5打包撒', '1', 0, 1553665195),
(254, 14, 7, '你会管理吗', '1', 0, 1553665208),
(255, 7, 14, '不会写安卓', '1', 0, 1553665209),
(256, 7, 14, '管理撒子', '1', 0, 1553665213),
(257, 14, 7, 'app安卓和苹果有差距吧', '1', 0, 1553665229),
(258, 7, 14, '有差距', '1', 0, 1553665234),
(259, 7, 14, '有个框架写的app可以运行在ios和安卓上', '1', 0, 1553665250),
(260, 14, 7, '会不会维护APP', '1', 0, 1553665254),
(261, 7, 14, '不会呀，', '1', 0, 1553665258),
(262, 7, 14, '我找到一个H站源码', '1', 0, 1553665287),
(263, 14, 7, 'face[黑线] ', '1', 0, 1553665291),
(264, 7, 14, '有没有兴趣搞一波', '1', 0, 1553665292),
(265, 14, 7, '你咋一天就想搞那个', '1', 0, 1553665302),
(266, 14, 7, '有风险啊', '1', 0, 1553665307),
(267, 7, 14, '赚钱呀', '1', 0, 1553665311),
(268, 7, 14, '穷呀', '1', 0, 1553665313),
(269, 7, 14, '你们公司不是要搞吗', '1', 0, 1553665333),
(270, 14, 7, '你是没考虑到维护费用', '1', 0, 1553665343),
(271, 14, 7, '服务器费用', '1', 0, 1553665347),
(272, 14, 7, '好大一笔的', '1', 0, 1553665350),
(273, 14, 7, '要不要出来跟我做', '1', 0, 1553665370),
(274, 7, 14, '不需要维护，数据库都不需要', '1', 0, 1553665386),
(275, 7, 14, '只需要一台服务器', '1', 0, 1553665394),
(276, 7, 14, '搞推广码', '1', 0, 1553665410),
(277, 14, 7, '不懂', '1', 0, 1553665893),
(278, 14, 7, '怎么赚钱', '1', 0, 1553665897),
(279, 7, 14, '你不是要我出来跟你干吗', '1', 0, 1553666117),
(280, 14, 7, '来我们公司啊', '1', 0, 1553666211),
(281, 14, 7, '现在很缺人啊', '1', 0, 1553666245),
(282, 7, 14, '推广吗', '1', 0, 1553666249),
(283, 14, 7, '维护一些网站什么的，然后偶尔写写东西', '1', 0, 1553666278),
(284, 14, 7, '网站搬家呀什么的', '1', 0, 1553666297),
(285, 7, 14, '你现在工资15k吗', '1', 0, 1553666315),
(286, 14, 7, '嗯', '1', 0, 1553666409),
(287, 7, 14, '牛逼呀', '1', 0, 1553666424),
(288, 7, 14, '一年有没有20w', '1', 0, 1553666439),
(289, 14, 7, '我要回来了', '1', 0, 1553667141),
(290, 7, 14, '端午回来吗', '1', 0, 1553667389),
(291, 14, 7, '最近几天', '1', 0, 1553667472),
(292, 7, 14, '又休假一个月吗', '1', 0, 1553667501),
(293, 7, 14, '爽翻呀', '1', 0, 1553667509),
(294, 14, 7, '半个月吧', '1', 0, 1553667513),
(295, 7, 14, '下半年回来不', '1', 0, 1553667526),
(296, 14, 7, '过年再回来了吧', '1', 0, 1553667541),
(297, 14, 7, '要不要出来跟我干', '1', 0, 1553667550),
(298, 14, 7, '管吃管住', '1', 0, 1553667554),
(299, 7, 14, '出来有好多k', '1', 0, 1553667612),
(300, 14, 7, '你要真想出来，我可以帮你去问问，估计是10K', '1', 0, 1553667757),
(301, 14, 7, '然后每个月涨点', '1', 0, 1553667769),
(302, 14, 7, '你这个的session存的多久', '1', 1, 1553669109),
(303, 7, 13, 'gfs ', '1', 1, 1553695775),
(304, 7, 13, 'fda ', '1', 1, 1553695777),
(305, 7, 13, 'fda ', '1', 1, 1553695777),
(306, 7, 13, 'fda ', '1', 1, 1553695778),
(307, 7, 13, 'fda ', '1', 1, 1553695779),
(308, 7, 13, 'fd a', '1', 1, 1553695780),
(309, 7, 13, 'fda ', '1', 1, 1553695781),
(310, 7, 13, 'fda ', '1', 1, 1553695781),
(311, 7, 14, 'zaima ', '1', 1, 1553873445),
(312, 7, 11, '稳定运行几天了', '1', 1, 1553873458),
(313, 7, 11, '我操你大爷的', '1', 1, 1553873461),
(314, 7, 9, 'v出现在v出现在v出现在', '1', 1, 1553873497),
(315, 18, 7, 'test', '1', 1, 1554168774),
(316, 19, 7, 'face[汗] ', '1', 1, 1554168829),
(317, 21, 7, '1111', '1', 1, 1554169158),
(318, 21, 7, '22222', '1', 1, 1554169161),
(319, 22, 7, 'halo', '1', 1, 1554169988),
(320, 23, 7, 'ff', '1', 1, 1554170411),
(321, 25, 7, 'hello', '1', 1, 1554172893),
(322, 26, 7, '0.0\\', '1', 1, 1554177067),
(323, 26, 7, 'face[偷笑] ', '1', 1, 1554177085),
(324, 26, 7, 'face[猪', '1', 1, 1554177090),
(325, 27, 7, '111', '1', 1, 1554178472),
(326, 27, 7, 'face[微笑] ', '1', 1, 1554178549),
(327, 7, 29, 'zaima', '1', 1, 1554190878),
(328, 7, 29, 'nishi yechengma ', '1', 1, 1554190936),
(329, 7, 29, 'nishi ', '1', 0, 1554190962),
(330, 29, 7, 'face[哈哈] ', '1', 0, 1554190965),
(331, 7, 29, '叶？', '1', 0, 1554190974),
(332, 29, 7, 'yeah', '1', 0, 1554190985),
(333, 7, 29, 'ok', '1', 0, 1554190988),
(334, 29, 7, '卧槽我这头像是个啥玩意儿', '1', 0, 1554190996),
(335, 7, 29, 'face[疑问] ', '1', 0, 1554190998),
(336, 7, 29, '头像是随机', '1', 0, 1554191005),
(337, 29, 7, '你的图片吗', '1', 0, 1554191006),
(338, 29, 7, '哦', '1', 0, 1554191009),
(339, 7, 29, '这个版本是一个月前的', '1', 0, 1554191019),
(340, 7, 29, 'face[嘻嘻] ', '1', 0, 1554191025),
(341, 29, 7, '牛逼', '1', 0, 1554191030),
(342, 7, 29, '一个月没写代码了', '1', 0, 1554191047),
(343, 7, 29, '天天加班', '1', 0, 1554191050),
(344, 7, 29, '麻痹的，', '1', 0, 1554191053),
(345, 29, 7, '不能粘贴截图', '1', 0, 1554191068),
(346, 7, 29, '。。。。', '1', 0, 1554191078),
(347, 7, 29, '那些高级功能不支持', '1', 0, 1554191085),
(348, 7, 29, '群聊单聊', '1', 0, 1554191092),
(349, 7, 29, '在增加个视频', '1', 0, 1554191106),
(350, 29, 7, '上传图片还报跨域', '1', 0, 1554191119),
(351, 7, 29, '有问题', '1', 0, 1554191134),
(352, 7, 29, '还没解决', '1', 0, 1554191138),
(353, 29, 7, '什么问题？', '1', 0, 1554191146),
(354, 7, 29, '跨域', '1', 0, 1554191201),
(355, 29, 7, '已经很牛皮了’', '1', 0, 1554191217),
(356, 29, 7, '我今天准备提离职了', '1', 0, 1554191246),
(357, 29, 7, '月底或者5月初去江苏混一混', '1', 0, 1554191258),
(358, 29, 7, 'face[嘻嘻] ', '1', 0, 1554191265),
(359, 29, 7, '你知道快商通或者商务通吗', '1', 0, 1554191295),
(360, 7, 29, '不知道', '1', 0, 1554191301),
(361, 7, 29, '是干什么的', '1', 0, 1554191305),
(362, 29, 7, '就是提供对话的第三方', '1', 0, 1554191323),
(363, 7, 29, '什么意思', '1', 0, 1554191339),
(364, 29, 7, '就是一个软件', '1', 0, 1554191395),
(365, 29, 7, '给认人公司用   一年几千或者几万块钱', '1', 0, 1554191409),
(366, 29, 7, '提供在线对话', '1', 0, 1554191415),
(367, 29, 7, '微信上有图', '1', 0, 1554191438),
(368, 29, 7, '就是用户在web端咨询   你在客服端跟他聊', '1', 0, 1554191475),
(369, 7, 29, '我退了哟，wx聊', '1', 0, 1554191533),
(370, 31, 7, '测试', '1', 1, 1554349389),
(371, 10, 9, '121', '1', 0, 1554349731),
(372, 9, 10, '.', '1', 0, 1554349738),
(373, 9, 10, '.', '1', 0, 1554349738),
(374, 29, 7, '.', '1', 0, 1554363215),
(375, 29, 7, '.', '1', 0, 1554363215),
(376, 29, 7, '.', '1', 0, 1554363215),
(377, 29, 7, '我这头像真丑', '1', 0, 1554363226),
(378, 7, 29, 'i清明节再写', '1', 0, 1554363287),
(379, 7, 29, '放假了在写', '1', 0, 1554363292),
(380, 29, 7, '膜拜大佬', '1', 0, 1554363311),
(381, 7, 29, 'face[钱] ', '1', 0, 1554363338),
(382, 7, 29, '你好久辞职呀', '1', 0, 1554363488),
(383, 29, 7, '已经辞了', '1', 0, 1554363532),
(384, 29, 7, '月底或者下月初走', '1', 0, 1554363538),
(385, 7, 29, '有兴趣去菲律宾不', '1', 0, 1554363666),
(386, 7, 29, 'face[微笑] ', '1', 0, 1554363709),
(387, 29, 7, '我去干嘛', '1', 0, 1554363723),
(388, 29, 7, '资金到位  哪都可以去', '1', 0, 1554363733),
(389, 29, 7, '就是不知道我去能干吗呀', '1', 0, 1554363740),
(390, 7, 29, '推广呀', '1', 0, 1554363743),
(391, 29, 7, '要技术没技术', '1', 0, 1554363744),
(392, 7, 29, 'seo', '1', 0, 1554363745),
(393, 7, 29, '我去也是推广', '1', 0, 1554363755),
(394, 29, 7, '纯做seo啊', '1', 0, 1554363758),
(395, 29, 7, '你？', '1', 0, 1554363760),
(396, 7, 29, '对呀，', '1', 0, 1554363761),
(397, 29, 7, '你不是不会seo吗', '1', 0, 1554363764),
(398, 7, 29, 'seo学起来还是挺快的，一套一套的套路可以学撒', '1', 0, 1554363784),
(399, 29, 7, '卧槽  真的假的', '1', 0, 1554363794),
(400, 29, 7, '你去菲做seo', '1', 0, 1554363806),
(401, 7, 29, '我去第一个月 8k 每个月可以涨，我同学在哪里去了四个月涨到了15k', '1', 0, 1554363813),
(402, 29, 7, '你可是我们一起住的几个里 我最看好的技术大佬', '1', 0, 1554363832),
(403, 7, 29, '我不止做 seo 还搞一些其他的', '1', 0, 1554363837),
(404, 7, 29, '。。。', '1', 0, 1554363839),
(405, 29, 7, '你居然要转行', '1', 0, 1554363840),
(406, 7, 29, '最终的目的还是挣钱', '1', 0, 1554363857),
(407, 29, 7, '对呀', '1', 0, 1554363860),
(408, 29, 7, '所以我转行不转行都无所谓', '1', 0, 1554363870),
(409, 29, 7, '但是你编程有前途啊', '1', 0, 1554363880),
(410, 29, 7, '走架构师啊', '1', 0, 1554363887),
(411, 7, 29, '那个太远了', '1', 0, 1554363893),
(412, 29, 7, '你跟那边谈过了吗', '1', 0, 1554363905),
(413, 7, 29, '写代码太累了，我怕搞不到楞个远就累死了', '1', 0, 1554363912),
(414, 29, 7, '牙刷', '1', 0, 1554363920),
(415, 7, 29, '谈了呀，开始去8k，然后递增，但是我觉得太低了', '1', 0, 1554363933),
(416, 7, 29, '没和他们老板谈', '1', 0, 1554363943),
(417, 7, 29, '只是我同学说的', '1', 0, 1554363946),
(418, 29, 7, '只有纯工资8吗', '1', 0, 1554363978),
(419, 7, 29, '一年 工资 18w ,包吃住。每年可以回国两次，机票报销', '1', 0, 1554363987),
(420, 29, 7, '那可以啊', '1', 0, 1554364010),
(421, 29, 7, '包食宿', '1', 0, 1554364016),
(422, 7, 29, '开始去 是8吧，每个月会涨一点', '1', 0, 1554364016),
(423, 29, 7, '也包食宿吗', '1', 0, 1554364029),
(424, 7, 29, '没得假期', '1', 0, 1554364033),
(425, 7, 29, '每天都要上班', '1', 0, 1554364037),
(426, 29, 7, '卧槽 跟我那朋友说的一样', '1', 0, 1554364045),
(427, 7, 29, '我同学是管理，', '1', 0, 1554364054),
(428, 7, 29, '每天 11点上班，晚上10下班，', '1', 0, 1554364070),
(429, 29, 7, '也不能请假什么的吗', '1', 0, 1554364084),
(430, 7, 29, '5个月修一次，一次15天，可以', '1', 0, 1554364087),
(431, 7, 29, '可以请假，回国也是报销机票的', '1', 0, 1554364095),
(432, 29, 7, 'emm', '1', 0, 1554364105),
(433, 29, 7, '待遇反正是可以', '1', 0, 1554364117),
(434, 7, 29, '你朋友也在那边吗', '1', 0, 1554364119),
(435, 7, 29, '其实和国内差不多', '1', 0, 1554364134),
(436, 29, 7, '哎呀我擦  你这不能粘贴图片  ', '1', 0, 1554364136),
(437, 29, 7, '想发图给你的', '1', 0, 1554364140),
(438, 7, 29, '再国内可以放假', '1', 0, 1554364141),
(439, 7, 29, '一般出国的都没得休息', '1', 0, 1554364195),
(440, 29, 7, '嗯', '1', 0, 1554364199),
(441, 7, 29, '一年放一个月', '1', 0, 1554364203),
(442, 7, 29, '带薪假期', '1', 0, 1554364211),
(443, 29, 7, '青春饭', '1', 0, 1554364225),
(444, 29, 7, '你确定要去了吗', '1', 0, 1554364244),
(445, 7, 29, '还没确定', '1', 0, 1554364248),
(446, 7, 29, '他们公司论坛，和几个小站是我做的', '1', 0, 1554364266),
(447, 29, 7, '外包给你的呀', '1', 0, 1554364275),
(448, 29, 7, '你朋友', '1', 0, 1554364278),
(449, 7, 29, '去年外包给我的', '1', 0, 1554364282),
(450, 29, 7, '嗦嘎', '1', 0, 1554364286),
(451, 29, 7, '如果要去的话    大概什么时候', '1', 0, 1554364295),
(452, 7, 29, '6月底吧', '1', 0, 1554364302),
(453, 7, 29, '只是有可能去', '1', 0, 1554364308),
(454, 7, 29, '你朋友在那边平时一个月一天假也灭有吗', '1', 0, 1554364349),
(455, 29, 7, '没问', '1', 0, 1554364388),
(456, 29, 7, '在印尼', '1', 0, 1554364393),
(457, 29, 7, '可能去   ', '1', 0, 1554364436),
(458, 7, 29, '你没考虑过去国外吗', '1', 0, 1554364451),
(459, 7, 29, '他们在重庆也有个公司', '1', 0, 1554364476),
(460, 7, 29, '做的东西是合法的', '1', 0, 1554364482),
(461, 29, 7, '有考虑', '1', 0, 1554364523),
(462, 29, 7, '看待遇都是', '1', 0, 1554364529),
(463, 29, 7, '我得看去江苏做的怎么样', '1', 0, 1554364619),
(464, 7, 29, '也好', '1', 0, 1554364655),
(465, 7, 29, '我也是在考虑中', '1', 0, 1554364663),
(466, 32, 7, 'aa1', '1', 1, 1554370894);

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