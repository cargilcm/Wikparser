CREATE TABLE `extraction` (  
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `old_text` mediumblob NOT NULL,/* text.old_text=	*/
  `rev_text_id` int(10) unsigned NOT NULL, /* =text.old_id*/
  `rev_page` int(10) unsigned NOT NULL,  /* = page.page_id */
  `page_namespace` int(11) NOT NULL,  /* = Wiki:Special(1) or not(0) */
  `page_title` varchar(255) COLLATE utf8_bin NOT NULL,  /* = lemma */
   KEY `entry_id` (`id`)
 ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=147485 ;
 
 