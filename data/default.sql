-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-03-25 09:30:38
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jointaichi`
--

-- --------------------------------------------------------

--
-- 表的结构 `cate`
--

CREATE TABLE IF NOT EXISTS `cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `menu` tinyint(4) NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) DEFAULT NULL,
  `lang` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `cate`
--

INSERT INTO `cate` (`id`, `title`, `menu`, `sort`, `status`, `created`, `updated`, `lang`) VALUES
(1, '默认', 0, 1, 1, 0, NULL, NULL),
(2, '太极拳', 1, 1, 1, 0, 1427164672, NULL),
(3, '吴式太极拳', 1, 1, 1, 1427270896, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `field`
--

CREATE TABLE IF NOT EXISTS `field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cate` blob,
  `field` longblob NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `field`
--

INSERT INTO `field` (`id`, `label`, `name`, `cate`, `field`, `created`, `updated`) VALUES
(1, '图片１', 'im', 0x613a313a7b693a303b733a313a2232223b7d, 0x613a313a7b733a343a226e616d65223b733a32313a2261646d696e2f6669656c642f696d6167652e706870223b7d, 1427204374, 0);

-- --------------------------------------------------------

--
-- 表的结构 `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `url` varchar(255) NOT NULL,
  `ext` varchar(50) NOT NULL,
  `mime` varchar(100) NOT NULL,
  `size` int(11) NOT NULL,
  `md5` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `file`
--

INSERT INTO `file` (`id`, `name`, `url`, `ext`, `mime`, `size`, `md5`) VALUES
(2, '1550ff08dcc2ad.jpg', 'upload_files/2015/03/1550ff08dcc2ad.jpg', 'jpG', 'image/jpeg', 9656, 'c72da2a798fbb66fdc60692ff2d46ee9'),
(3, '1550ff14e91946.zip', 'upload_files/2015/03/1550ff14e91946.zip', 'zip', 'application/x-zip-compressed', 9682, 'c237089d7f11c6f9cd21458aae1fa6ca'),
(4, '1550ff3e18e162.jpg', 'upload_files/2015/03/1550ff3e18e162.jpg', 'jpg', 'image/jpeg', 777835, '9d377b10ce778c4938b3c7e2c63a229a'),
(5, '1550ff4189fb38.jpg', 'upload_files/2015/03/1550ff4189fb38.jpg', 'jpg', 'image/jpeg', 879394, '076e3caed758a1c18c91a0e9cae3368f'),
(6, '1550ff418a4189.jpg', 'upload_files/2015/03/1550ff418a4189.jpg', 'jpg', 'image/jpeg', 845941, 'ba45c8f60456a672e003a875e469d0eb'),
(7, '1550ff42a947a3.jpg', 'upload_files/2015/03/1550ff42a947a3.jpg', 'jpg', 'image/jpeg', 595284, 'bdf3bf1da3405725be763540d6601144'),
(8, '1550ff42a999ac.jpg', 'upload_files/2015/03/1550ff42a999ac.jpg', 'jpg', 'image/jpeg', 775702, '5a44c7ba5bbe4ec867233d67e4806848'),
(9, '1550ff432b1a4c.jpg', 'upload_files/2015/03/1550ff432b1a4c.jpg', 'jpg', 'image/jpeg', 561276, '8969288f4245120e7c3870287cce0ff3'),
(10, '15511595173067.jpg', 'upload_files/2015/03/15511595173067.jpg', 'jpg', 'image/jpeg', 152626, '5f1000a1cf9578d0e65bfee36bf6e07c');

-- --------------------------------------------------------

--
-- 表的结构 `lang`
--

CREATE TABLE IF NOT EXISTS `lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `trans` text NOT NULL,
  `lang` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `slug` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- 转存表中的数据 `lang`
--

INSERT INTO `lang` (`id`, `name`, `trans`, `lang`, `created`, `updated`, `status`, `slug`) VALUES
(1, 'Post', '内容', 1, 1427168445, 1427168910, 1, 1),
(2, 'Cate', '分类', 1, 1427189990, NULL, 1, 1),
(3, 'User', '用户', 1, 1427190002, 1427191110, 1, 1),
(4, 'Lang', '多语言', 1, 1427190013, NULL, 1, 1),
(5, 'Save', '保存', 1, 1427190026, NULL, 1, 1),
(6, 'Slug', '标识', 1, 1427190034, NULL, 1, 1),
(7, 'Title', '标题', 1, 1427190063, NULL, 1, 1),
(8, 'Trans', '翻译', 1, 1427190070, NULL, 1, 1),
(9, 'Created', '创建时间', 1, 1427190101, NULL, 1, 1),
(10, 'Action', '操作', 1, 1427190110, NULL, 1, 1),
(11, 'Hidden', '隐藏', 1, 1427190122, NULL, 1, 1),
(12, 'Show', '显示', 1, 1427190128, NULL, 1, 1),
(13, 'Edit', '编辑', 1, 1427190135, NULL, 1, 1),
(14, 'Login', '登录', 1, 1427190142, NULL, 1, 1),
(15, 'Admin Control', '后台管理', 1, 1427190156, NULL, 1, 1),
(16, 'User Name', '用户名', 1, 1427190166, 1427190196, 1, 1),
(17, 'Password', '密码', 1, 1427190173, NULL, 1, 1),
(18, 'Run Trans', '生成翻译包', 1, 1427190512, NULL, 1, 1),
(19, 'Add', '添加', 1, 1427190523, NULL, 1, 1),
(20, 'Language', '多语言', 1, 1427190540, NULL, 1, 1),
(21, 'Action Success', '操作成功', 1, 1427191439, NULL, 1, 1),
(22, 'IS Menu', '是否菜单', 1, 1427191715, NULL, 1, 1),
(23, 'Teater', '简介', 1, 1427191725, NULL, 1, 1),
(24, 'Body', '内容', 1, 1427191735, NULL, 1, 1),
(25, 'Please Choice', '请选择', 1, 1427191754, NULL, 1, 1),
(26, 'Image', '图片', 1, 1427191766, NULL, 1, 1),
(27, 'Attachment', '附件', 1, 1427191776, NULL, 1, 1),
(28, 'Remove', '删除', 1, 1427191785, NULL, 1, 1),
(29, 'Field', '字段', 1, 1427191805, NULL, 1, 1),
(30, 'Verify', '验证码', 1, 1427199416, NULL, 1, 1),
(31, 'Verify', '验证码', 1, 1427199422, NULL, 1, 1),
(32, 'Verify', '验证码', 1, 1427199454, NULL, 1, 1),
(33, 'Verify', '验证码', 1, 1427199461, NULL, 1, 1),
(34, 'New Password', '新密码', 1, 1427200923, NULL, 1, 1),
(35, 'Old Password', '原密码', 1, 1427200937, NULL, 1, 1),
(36, 'Failed', '操作失败', 1, 1427200953, NULL, 1, 1),
(37, 'No', '否', 1, 1427201005, NULL, 1, 1),
(38, 'Yes', '是', 1, 1427201012, NULL, 1, 1),
(39, 'Label', '表单Lable', 1, 1427201206, NULL, 1, 1),
(40, 'Name', '名称', 1, 1427201212, NULL, 1, 1),
(41, 'Field Name', '字段名(mysql中字段)', 1, 1427201386, NULL, 1, 1),
(42, 'Exists Same Filed', '存在相同字段', 1, 1427202323, NULL, 1, 1),
(43, 'Field Settings Yaml', '字段设置(YAML格式)', 1, 1427205129, NULL, 1, 1),
(44, 'Access Deny', '访问被拒绝,如有疑问请联系管理员!', 1, 1427205251, NULL, 1, 1),
(45, 'Logout', '安全退出', 1, 1427205439, NULL, 1, 1),
(46, 'Setting', '设置', 1, 1427205576, NULL, 1, 1),
(47, 'MongoSync', '同步数据到MongoDB(非常重要)', 1, 1427269162, NULL, 1, 1),
(48, 'Home', '首页', 1, 1427271459, NULL, 1, 1),
(49, 'website_title', '元亨太极会馆', 1, 1427271528, NULL, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `teater` varchar(255) DEFAULT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) DEFAULT NULL,
  `uid` int(11) NOT NULL,
  `full` longblob,
  `status` tinyint(4) NOT NULL,
  `cate` blob,
  `lang` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `post`
--

INSERT INTO `post` (`id`, `title`, `body`, `teater`, `created`, `updated`, `uid`, `full`, `status`, `cate`, `lang`) VALUES
(1, 'test', '<p>test</p>', 'test', 1427097654, 1427109017, 1, 0x613a323a7b733a353a22696d616765223b613a353a7b693a303b733a303a22223b693a313b733a313a2234223b693a323b733a313a2239223b693a333b733a313a2235223b693a343b733a313a2236223b7d733a343a2266696c65223b613a313a7b693a303b733a303a22223b7d7d, 1, 0x613a323a7b693a303b733a313a2231223b693a313b733a313a2232223b7d, NULL),
(2, '吴式太极拳', '<p>吴式太极拳是汉族传统拳术之一。以柔化著称，架子斜中寓正、松静自然，大小适中。推手时，守静而不妄动，以善化见长。吴式太极拳，分南北两派，南派为吴鉴泉宗师传承，其传人主要有吴公藻、吴公仪、吴英华、马岳梁、徐致一等。北派为王茂斋宗师传承，其传人主要有王杰(子英)、王倜(子超)、赵铁庵、修丕勋、彭广义（仁轩）、杨禹廷等，再传有赵安祥、李经梧、王培生、修占等。修占又传周旭林等。</p>\r\n\r\n<p>河北大兴人吴鉴泉，在杨露禅到北京授拳时，其父全佑从学太极拳，后又拜杨之次子<br />\r\n王茂斋？<br />\r\n王茂斋？(2张)<br />\r\n杨班侯为师，在杨式小架太极拳的基础上逐步修订，又经吴鉴泉改进修润而形成了一个流派，即“吴式太极拳”。王茂斋（1862-1940）山东掖县人，王茂斋老先生祖居山东省莱州市（原掖县）大武官村，他是吴式太极拳宗师吴鉴泉的师兄，威望极高。吴式太极拳门人中流传着一本《同门录》，第一页便是王先生的英照，第二页是吴鉴泉宗师的英照，以后是二位先生的弟子及子侄们的照片。王先生对吴式太极拳的形成有重要的影响。[1</p>', '吴式太极拳', 1427270858, 1427271831, 1, 0x613a323a7b733a353a22696d616765223b613a313a7b693a303b733a303a22223b7d733a343a2266696c65223b613a313a7b693a303b733a303a22223b7d7d, 1, 0x613a333a7b693a303b733a313a2231223b693a313b733a313a2232223b693a323b733a313a2233223b7d, 1);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pwd` varchar(100) NOT NULL,
  `hash` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `name`, `pwd`, `hash`) VALUES
(1, 'admin', '$1$B8UGZ$wqBS4JVQ./nrGbZqPe1f10', 'B8UGZ');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
