CREATE TABLE IF NOT EXISTS `students` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
`email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
`mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
`address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;
 
INSERT INTO `students` (`id`, `name`, `email`, `mobile`, `address`) VALUES
(1, 'Arif Billah', 'arif@gmail.com', '01722589654', 'Dhaka,Bangladesh'),
(2, 'Iqbal Hossain', 'iqbal@gmail.com', '01755847591', 'Thakur Gao, Bangladesh'),
(8, 'Monzur ', 'mon@zur.com', '876868', 'Dhaka,Bangladesh');