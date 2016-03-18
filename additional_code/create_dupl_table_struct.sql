CREATE TABLE `page` (
  `page_id` int(10) unsigned NOT NULL,
  `page_title` varchar(255) COLLATE utf8_bin NOT NULL,
  `replacement` varchar(300) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
