CREATE TABLE `archive` (
  `ar_namespace` int(11) NOT NULL DEFAULT '0',
  `ar_title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `ar_text` mediumblob NOT NULL,
  `ar_comment` tinyblob NOT NULL,
  `ar_user` int(10) unsigned NOT NULL DEFAULT '0',
  `ar_user_text` varchar(255) COLLATE utf8_bin NOT NULL,
  `ar_timestamp` binary(14) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `ar_minor_edit` tinyint(4) NOT NULL DEFAULT '0',
  `ar_flags` tinyblob NOT NULL,
  `ar_rev_id` int(10) unsigned DEFAULT NULL,
  `ar_text_id` int(10) unsigned DEFAULT NULL,
  `ar_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ar_len` int(10) unsigned DEFAULT NULL,
  `ar_page_id` int(10) unsigned DEFAULT NULL,
  `ar_parent_id` int(10) unsigned DEFAULT NULL,
  KEY `name_title_timestamp` (`ar_namespace`,`ar_title`,`ar_timestamp`),
  KEY `ar_usertext_timestamp` (`ar_user_text`,`ar_timestamp`),
  KEY `ar_revid` (`ar_rev_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `category` (
  `cat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_title` varchar(255) COLLATE utf8_bin NOT NULL,
  `cat_pages` int(11) NOT NULL DEFAULT '0',
  `cat_subcats` int(11) NOT NULL DEFAULT '0',
  `cat_files` int(11) NOT NULL DEFAULT '0',
  `cat_hidden` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`),
  UNIQUE KEY `cat_title` (`cat_title`),
  KEY `cat_pages` (`cat_pages`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

CREATE TABLE `categorylinks` (
  `cl_from` int(10) unsigned NOT NULL DEFAULT '0',
  `cl_to` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `cl_sortkey` varbinary(230) NOT NULL DEFAULT '',
  `cl_sortkey_prefix` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `cl_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cl_collation` varbinary(32) NOT NULL DEFAULT '',
  `cl_type` enum('page','subcat','file') COLLATE utf8_bin NOT NULL DEFAULT 'page',
  UNIQUE KEY `cl_from` (`cl_from`,`cl_to`),
  KEY `cl_sortkey` (`cl_to`,`cl_type`,`cl_sortkey`,`cl_from`),
  KEY `cl_timestamp` (`cl_to`,`cl_timestamp`),
  KEY `cl_collation` (`cl_collation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `change_tag` (
  `ct_rc_id` int(11) DEFAULT NULL,
  `ct_log_id` int(11) DEFAULT NULL,
  `ct_rev_id` int(11) DEFAULT NULL,
  `ct_tag` varchar(255) COLLATE utf8_bin NOT NULL,
  `ct_params` blob,
  UNIQUE KEY `change_tag_rc_tag` (`ct_rc_id`,`ct_tag`),
  UNIQUE KEY `change_tag_log_tag` (`ct_log_id`,`ct_tag`),
  UNIQUE KEY `change_tag_rev_tag` (`ct_rev_id`,`ct_tag`),
  KEY `change_tag_tag_id` (`ct_tag`,`ct_rc_id`,`ct_rev_id`,`ct_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `externallinks` (
  `el_from` int(10) unsigned NOT NULL DEFAULT '0',
  `el_to` blob NOT NULL,
  `el_index` blob NOT NULL,
  KEY `el_from` (`el_from`,`el_to`(40)),
  KEY `el_to` (`el_to`(60),`el_from`),
  KEY `el_index` (`el_index`(60))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `external_user` (
  `eu_local_id` int(10) unsigned NOT NULL,
  `eu_external_id` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`eu_local_id`),
  UNIQUE KEY `eu_external_id` (`eu_external_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `filearchive` (
  `fa_id` int(11) NOT NULL AUTO_INCREMENT,
  `fa_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `fa_archive_name` varchar(255) COLLATE utf8_bin DEFAULT '',
  `fa_storage_group` varbinary(16) DEFAULT NULL,
  `fa_storage_key` varbinary(64) DEFAULT '',
  `fa_deleted_user` int(11) DEFAULT NULL,
  `fa_deleted_timestamp` binary(14) DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `fa_deleted_reason` text COLLATE utf8_bin,
  `fa_size` int(10) unsigned DEFAULT '0',
  `fa_width` int(11) DEFAULT '0',
  `fa_height` int(11) DEFAULT '0',
  `fa_metadata` mediumblob,
  `fa_bits` int(11) DEFAULT '0',
  `fa_media_type` enum('UNKNOWN','BITMAP','DRAWING','AUDIO','VIDEO','MULTIMEDIA','OFFICE','TEXT','EXECUTABLE','ARCHIVE') COLLATE utf8_bin DEFAULT NULL,
  `fa_major_mime` enum('unknown','application','audio','image','text','video','message','model','multipart') COLLATE utf8_bin DEFAULT 'unknown',
  `fa_minor_mime` varbinary(100) DEFAULT 'unknown',
  `fa_description` tinyblob,
  `fa_user` int(10) unsigned DEFAULT '0',
  `fa_user_text` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `fa_timestamp` binary(14) DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `fa_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`fa_id`),
  KEY `fa_name` (`fa_name`,`fa_timestamp`),
  KEY `fa_storage_group` (`fa_storage_group`,`fa_storage_key`),
  KEY `fa_deleted_timestamp` (`fa_deleted_timestamp`),
  KEY `fa_user_timestamp` (`fa_user_text`,`fa_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

CREATE TABLE `hitcounter` (
  `hc_id` int(10) unsigned NOT NULL
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COLLATE=utf8_bin MAX_ROWS=25000;

CREATE TABLE `image` (
  `img_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `img_size` int(10) unsigned NOT NULL DEFAULT '0',
  `img_width` int(11) NOT NULL DEFAULT '0',
  `img_height` int(11) NOT NULL DEFAULT '0',
  `img_metadata` mediumblob NOT NULL,
  `img_bits` int(11) NOT NULL DEFAULT '0',
  `img_media_type` enum('UNKNOWN','BITMAP','DRAWING','AUDIO','VIDEO','MULTIMEDIA','OFFICE','TEXT','EXECUTABLE','ARCHIVE') COLLATE utf8_bin DEFAULT NULL,
  `img_major_mime` enum('unknown','application','audio','image','text','video','message','model','multipart') COLLATE utf8_bin NOT NULL DEFAULT 'unknown',
  `img_minor_mime` varbinary(100) NOT NULL DEFAULT 'unknown',
  `img_description` tinyblob NOT NULL,
  `img_user` int(10) unsigned NOT NULL DEFAULT '0',
  `img_user_text` varchar(255) COLLATE utf8_bin NOT NULL,
  `img_timestamp` varbinary(14) NOT NULL DEFAULT '',
  `img_sha1` varbinary(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`img_name`),
  KEY `img_usertext_timestamp` (`img_user_text`,`img_timestamp`),
  KEY `img_size` (`img_size`),
  KEY `img_timestamp` (`img_timestamp`),
  KEY `img_sha1` (`img_sha1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `imagelinks` (
  `il_from` int(10) unsigned NOT NULL DEFAULT '0',
  `il_to` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  UNIQUE KEY `il_from` (`il_from`,`il_to`),
  UNIQUE KEY `il_to` (`il_to`,`il_from`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `interwiki` (
  `iw_prefix` varchar(32) COLLATE utf8_bin NOT NULL,
  `iw_url` blob NOT NULL,
  `iw_api` blob NOT NULL,
  `iw_wikiid` varchar(64) COLLATE utf8_bin NOT NULL,
  `iw_local` tinyint(1) NOT NULL,
  `iw_trans` tinyint(4) NOT NULL DEFAULT '0',
  UNIQUE KEY `iw_prefix` (`iw_prefix`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `ipblocks` (
  `ipb_id` int(11) NOT NULL AUTO_INCREMENT,
  `ipb_address` tinyblob NOT NULL,
  `ipb_user` int(10) unsigned NOT NULL DEFAULT '0',
  `ipb_by` int(10) unsigned NOT NULL DEFAULT '0',
  `ipb_by_text` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `ipb_reason` tinyblob NOT NULL,
  `ipb_timestamp` binary(14) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `ipb_auto` tinyint(1) NOT NULL DEFAULT '0',
  `ipb_anon_only` tinyint(1) NOT NULL DEFAULT '0',
  `ipb_create_account` tinyint(1) NOT NULL DEFAULT '1',
  `ipb_enable_autoblock` tinyint(1) NOT NULL DEFAULT '1',
  `ipb_expiry` varbinary(14) NOT NULL DEFAULT '',
  `ipb_range_start` tinyblob NOT NULL,
  `ipb_range_end` tinyblob NOT NULL,
  `ipb_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `ipb_block_email` tinyint(1) NOT NULL DEFAULT '0',
  `ipb_allow_usertalk` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ipb_id`),
  UNIQUE KEY `ipb_address` (`ipb_address`(255),`ipb_user`,`ipb_auto`,`ipb_anon_only`),
  KEY `ipb_user` (`ipb_user`),
  KEY `ipb_range` (`ipb_range_start`(8),`ipb_range_end`(8)),
  KEY `ipb_timestamp` (`ipb_timestamp`),
  KEY `ipb_expiry` (`ipb_expiry`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

CREATE TABLE `iwlinks` (
  `iwl_from` int(10) unsigned NOT NULL DEFAULT '0',
  `iwl_prefix` varbinary(20) NOT NULL DEFAULT '',
  `iwl_title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  UNIQUE KEY `iwl_from` (`iwl_from`,`iwl_prefix`,`iwl_title`),
  UNIQUE KEY `iwl_prefix_title_from` (`iwl_prefix`,`iwl_title`,`iwl_from`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `job` (
  `job_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `job_cmd` varbinary(60) NOT NULL DEFAULT '',
  `job_namespace` int(11) NOT NULL,
  `job_title` varchar(255) COLLATE utf8_bin NOT NULL,
  `job_params` blob NOT NULL,
  PRIMARY KEY (`job_id`),
  KEY `job_cmd` (`job_cmd`,`job_namespace`,`job_title`,`job_params`(128))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

CREATE TABLE `l10n_cache` (
  `lc_lang` varbinary(32) NOT NULL,
  `lc_key` varchar(255) COLLATE utf8_bin NOT NULL,
  `lc_value` mediumblob NOT NULL,
  KEY `lc_lang_key` (`lc_lang`,`lc_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `langlinks` (
  `ll_from` int(10) unsigned NOT NULL DEFAULT '0',
  `ll_lang` varbinary(20) NOT NULL DEFAULT '',
  `ll_title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  UNIQUE KEY `ll_from` (`ll_from`,`ll_lang`),
  KEY `ll_lang` (`ll_lang`,`ll_title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `logging` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_type` varbinary(32) NOT NULL DEFAULT '',
  `log_action` varbinary(32) NOT NULL DEFAULT '',
  `log_timestamp` binary(14) NOT NULL DEFAULT '19700101000000',
  `log_user` int(10) unsigned NOT NULL DEFAULT '0',
  `log_user_text` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `log_namespace` int(11) NOT NULL DEFAULT '0',
  `log_title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `log_page` int(10) unsigned DEFAULT NULL,
  `log_comment` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `log_params` blob NOT NULL,
  `log_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`log_id`),
  KEY `type_time` (`log_type`,`log_timestamp`),
  KEY `user_time` (`log_user`,`log_timestamp`),
  KEY `page_time` (`log_namespace`,`log_title`,`log_timestamp`),
  KEY `times` (`log_timestamp`),
  KEY `log_user_type_time` (`log_user`,`log_type`,`log_timestamp`),
  KEY `log_page_id_time` (`log_page`,`log_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

CREATE TABLE `log_search` (
  `ls_field` varbinary(32) NOT NULL,
  `ls_value` varchar(255) COLLATE utf8_bin NOT NULL,
  `ls_log_id` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `ls_field_val` (`ls_field`,`ls_value`,`ls_log_id`),
  KEY `ls_log_id` (`ls_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `module_deps` (
  `md_module` varbinary(255) NOT NULL,
  `md_skin` varbinary(32) NOT NULL,
  `md_deps` mediumblob NOT NULL,
  UNIQUE KEY `md_module_skin` (`md_module`,`md_skin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `msg_resource` (
  `mr_resource` varbinary(255) NOT NULL,
  `mr_lang` varbinary(32) NOT NULL,
  `mr_blob` mediumblob NOT NULL,
  `mr_timestamp` binary(14) NOT NULL,
  UNIQUE KEY `mr_resource_lang` (`mr_resource`,`mr_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `msg_resource_links` (
  `mrl_resource` varbinary(255) NOT NULL,
  `mrl_message` varbinary(255) NOT NULL,
  UNIQUE KEY `mrl_message_resource` (`mrl_message`,`mrl_resource`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `objectcache` (
  `keyname` varbinary(255) NOT NULL DEFAULT '',
  `value` mediumblob,
  `exptime` datetime DEFAULT NULL,
  PRIMARY KEY (`keyname`),
  KEY `exptime` (`exptime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `oldimage` (
  `oi_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `oi_archive_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `oi_size` int(10) unsigned NOT NULL DEFAULT '0',
  `oi_width` int(11) NOT NULL DEFAULT '0',
  `oi_height` int(11) NOT NULL DEFAULT '0',
  `oi_bits` int(11) NOT NULL DEFAULT '0',
  `oi_description` tinyblob NOT NULL,
  `oi_user` int(10) unsigned NOT NULL DEFAULT '0',
  `oi_user_text` varchar(255) COLLATE utf8_bin NOT NULL,
  `oi_timestamp` binary(14) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `oi_metadata` mediumblob NOT NULL,
  `oi_media_type` enum('UNKNOWN','BITMAP','DRAWING','AUDIO','VIDEO','MULTIMEDIA','OFFICE','TEXT','EXECUTABLE','ARCHIVE') COLLATE utf8_bin DEFAULT NULL,
  `oi_major_mime` enum('unknown','application','audio','image','text','video','message','model','multipart') COLLATE utf8_bin NOT NULL DEFAULT 'unknown',
  `oi_minor_mime` varbinary(100) NOT NULL DEFAULT 'unknown',
  `oi_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `oi_sha1` varbinary(32) NOT NULL DEFAULT '',
  KEY `oi_usertext_timestamp` (`oi_user_text`,`oi_timestamp`),
  KEY `oi_name_timestamp` (`oi_name`,`oi_timestamp`),
  KEY `oi_name_archive_name` (`oi_name`,`oi_archive_name`(14)),
  KEY `oi_sha1` (`oi_sha1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `page` (
  `page_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_namespace` int(11) NOT NULL,
  `page_title` varchar(255) COLLATE utf8_bin NOT NULL,
  `page_restrictions` tinyblob NOT NULL,
  `page_counter` bigint(20) unsigned NOT NULL DEFAULT '0',
  `page_is_redirect` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `page_is_new` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `page_random` double unsigned NOT NULL,
  `page_touched` binary(14) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `page_latest` int(10) unsigned NOT NULL,
  `page_len` int(10) unsigned NOT NULL,
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `name_title` (`page_namespace`,`page_title`),
  KEY `page_random` (`page_random`),
  KEY `page_len` (`page_len`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=147485 ;

CREATE TABLE `pagelinks` (
  `pl_from` int(10) unsigned NOT NULL DEFAULT '0',
  `pl_namespace` int(11) NOT NULL DEFAULT '0',
  `pl_title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  UNIQUE KEY `pl_from` (`pl_from`,`pl_namespace`,`pl_title`),
  UNIQUE KEY `pl_namespace` (`pl_namespace`,`pl_title`,`pl_from`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `page_props` (
  `pp_page` int(11) NOT NULL,
  `pp_propname` varbinary(60) NOT NULL,
  `pp_value` blob NOT NULL,
  UNIQUE KEY `pp_page_propname` (`pp_page`,`pp_propname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `page_restrictions` (
  `pr_page` int(11) NOT NULL,
  `pr_type` varbinary(60) NOT NULL,
  `pr_level` varbinary(60) NOT NULL,
  `pr_cascade` tinyint(4) NOT NULL,
  `pr_user` int(11) DEFAULT NULL,
  `pr_expiry` varbinary(14) DEFAULT NULL,
  `pr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`pr_id`),
  UNIQUE KEY `pr_pagetype` (`pr_page`,`pr_type`),
  KEY `pr_typelevel` (`pr_type`,`pr_level`),
  KEY `pr_level` (`pr_level`),
  KEY `pr_cascade` (`pr_cascade`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

CREATE TABLE `protected_titles` (
  `pt_namespace` int(11) NOT NULL,
  `pt_title` varchar(255) COLLATE utf8_bin NOT NULL,
  `pt_user` int(10) unsigned NOT NULL,
  `pt_reason` tinyblob,
  `pt_timestamp` binary(14) NOT NULL,
  `pt_expiry` varbinary(14) NOT NULL DEFAULT '',
  `pt_create_perm` varbinary(60) NOT NULL,
  UNIQUE KEY `pt_namespace_title` (`pt_namespace`,`pt_title`),
  KEY `pt_timestamp` (`pt_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `querycache` (
  `qc_type` varbinary(32) NOT NULL,
  `qc_value` int(10) unsigned NOT NULL DEFAULT '0',
  `qc_namespace` int(11) NOT NULL DEFAULT '0',
  `qc_title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  KEY `qc_type` (`qc_type`,`qc_value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `querycachetwo` (
  `qcc_type` varbinary(32) NOT NULL,
  `qcc_value` int(10) unsigned NOT NULL DEFAULT '0',
  `qcc_namespace` int(11) NOT NULL DEFAULT '0',
  `qcc_title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `qcc_namespacetwo` int(11) NOT NULL DEFAULT '0',
  `qcc_titletwo` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  KEY `qcc_type` (`qcc_type`,`qcc_value`),
  KEY `qcc_title` (`qcc_type`,`qcc_namespace`,`qcc_title`),
  KEY `qcc_titletwo` (`qcc_type`,`qcc_namespacetwo`,`qcc_titletwo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `querycache_info` (
  `qci_type` varbinary(32) NOT NULL DEFAULT '',
  `qci_timestamp` binary(14) NOT NULL DEFAULT '19700101000000',
  UNIQUE KEY `qci_type` (`qci_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `recentchanges` (
  `rc_id` int(11) NOT NULL AUTO_INCREMENT,
  `rc_timestamp` varbinary(14) NOT NULL DEFAULT '',
  `rc_cur_time` varbinary(14) NOT NULL DEFAULT '',
  `rc_user` int(10) unsigned NOT NULL DEFAULT '0',
  `rc_user_text` varchar(255) COLLATE utf8_bin NOT NULL,
  `rc_namespace` int(11) NOT NULL DEFAULT '0',
  `rc_title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `rc_comment` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `rc_minor` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rc_bot` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rc_new` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rc_cur_id` int(10) unsigned NOT NULL DEFAULT '0',
  `rc_this_oldid` int(10) unsigned NOT NULL DEFAULT '0',
  `rc_last_oldid` int(10) unsigned NOT NULL DEFAULT '0',
  `rc_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rc_moved_to_ns` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rc_moved_to_title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `rc_patrolled` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rc_ip` varbinary(40) NOT NULL DEFAULT '',
  `rc_old_len` int(11) DEFAULT NULL,
  `rc_new_len` int(11) DEFAULT NULL,
  `rc_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rc_logid` int(10) unsigned NOT NULL DEFAULT '0',
  `rc_log_type` varbinary(255) DEFAULT NULL,
  `rc_log_action` varbinary(255) DEFAULT NULL,
  `rc_params` blob,
  PRIMARY KEY (`rc_id`),
  KEY `rc_timestamp` (`rc_timestamp`),
  KEY `rc_namespace_title` (`rc_namespace`,`rc_title`),
  KEY `rc_cur_id` (`rc_cur_id`),
  KEY `new_name_timestamp` (`rc_new`,`rc_namespace`,`rc_timestamp`),
  KEY `rc_ip` (`rc_ip`),
  KEY `rc_ns_usertext` (`rc_namespace`,`rc_user_text`),
  KEY `rc_user_text` (`rc_user_text`,`rc_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

CREATE TABLE `redirect` (
  `rd_from` int(10) unsigned NOT NULL DEFAULT '0',
  `rd_namespace` int(11) NOT NULL DEFAULT '0',
  `rd_title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `rd_interwiki` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `rd_fragment` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`rd_from`),
  KEY `rd_ns_title` (`rd_namespace`,`rd_title`,`rd_from`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `revision` (
  `rev_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rev_page` int(10) unsigned NOT NULL,
  `rev_text_id` int(10) unsigned NOT NULL,
  `rev_comment` tinyblob NOT NULL,
  `rev_user` int(10) unsigned NOT NULL DEFAULT '0',
  `rev_user_text` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `rev_timestamp` binary(14) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `rev_minor_edit` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rev_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rev_len` int(10) unsigned DEFAULT NULL,
  `rev_parent_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`rev_id`),
  UNIQUE KEY `rev_page_id` (`rev_page`,`rev_id`),
  KEY `rev_timestamp` (`rev_timestamp`),
  KEY `page_timestamp` (`rev_page`,`rev_timestamp`),
  KEY `user_timestamp` (`rev_user`,`rev_timestamp`),
  KEY `usertext_timestamp` (`rev_user_text`,`rev_timestamp`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin MAX_ROWS=10000000 AVG_ROW_LENGTH=1024 AUTO_INCREMENT=8516346 ;

CREATE TABLE `searchindex` (
  `si_page` int(10) unsigned NOT NULL,
  `si_title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `si_text` mediumtext COLLATE utf8_bin NOT NULL,
  UNIQUE KEY `si_page` (`si_page`),
  FULLTEXT KEY `si_title` (`si_title`),
  FULLTEXT KEY `si_text` (`si_text`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `site_stats` (
  `ss_row_id` int(10) unsigned NOT NULL,
  `ss_total_views` bigint(20) unsigned DEFAULT '0',
  `ss_total_edits` bigint(20) unsigned DEFAULT '0',
  `ss_good_articles` bigint(20) unsigned DEFAULT '0',
  `ss_total_pages` bigint(20) DEFAULT '-1',
  `ss_users` bigint(20) DEFAULT '-1',
  `ss_active_users` bigint(20) DEFAULT '-1',
  `ss_admins` int(11) DEFAULT '-1',
  `ss_images` int(11) DEFAULT '0',
  UNIQUE KEY `ss_row_id` (`ss_row_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `tag_summary` (
  `ts_rc_id` int(11) DEFAULT NULL,
  `ts_log_id` int(11) DEFAULT NULL,
  `ts_rev_id` int(11) DEFAULT NULL,
  `ts_tags` blob NOT NULL,
  UNIQUE KEY `tag_summary_rc_id` (`ts_rc_id`),
  UNIQUE KEY `tag_summary_log_id` (`ts_log_id`),
  UNIQUE KEY `tag_summary_rev_id` (`ts_rev_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `templatelinks` (
  `tl_from` int(10) unsigned NOT NULL DEFAULT '0',
  `tl_namespace` int(11) NOT NULL DEFAULT '0',
  `tl_title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  UNIQUE KEY `tl_from` (`tl_from`,`tl_namespace`,`tl_title`),
  UNIQUE KEY `tl_namespace` (`tl_namespace`,`tl_title`,`tl_from`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `text` (
  `old_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `old_text` mediumblob NOT NULL,
  `old_flags` tinyblob NOT NULL,
  PRIMARY KEY (`old_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin MAX_ROWS=10000000 AVG_ROW_LENGTH=10240 AUTO_INCREMENT=8516346 ;

CREATE TABLE `trackbacks` (
  `tb_id` int(11) NOT NULL AUTO_INCREMENT,
  `tb_page` int(11) DEFAULT NULL,
  `tb_title` varchar(255) COLLATE utf8_bin NOT NULL,
  `tb_url` blob NOT NULL,
  `tb_ex` text COLLATE utf8_bin,
  `tb_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`tb_id`),
  KEY `tb_page` (`tb_page`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

CREATE TABLE `transcache` (
  `tc_url` varbinary(255) NOT NULL,
  `tc_contents` text COLLATE utf8_bin,
  `tc_time` binary(14) NOT NULL,
  UNIQUE KEY `tc_url_idx` (`tc_url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `updatelog` (
  `ul_key` varchar(255) COLLATE utf8_bin NOT NULL,
  `ul_value` blob,
  PRIMARY KEY (`ul_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `user_real_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `user_password` tinyblob NOT NULL,
  `user_newpassword` tinyblob NOT NULL,
  `user_newpass_time` binary(14) DEFAULT NULL,
  `user_email` tinytext COLLATE utf8_bin NOT NULL,
  `user_options` blob NOT NULL,
  `user_touched` binary(14) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `user_token` binary(32) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `user_email_authenticated` binary(14) DEFAULT NULL,
  `user_email_token` binary(32) DEFAULT NULL,
  `user_email_token_expires` binary(14) DEFAULT NULL,
  `user_registration` binary(14) DEFAULT NULL,
  `user_editcount` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `user_email_token` (`user_email_token`),
  KEY `user_email` (`user_email`(50),`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

CREATE TABLE `user_groups` (
  `ug_user` int(10) unsigned NOT NULL DEFAULT '0',
  `ug_group` varbinary(16) NOT NULL DEFAULT '',
  UNIQUE KEY `ug_user_group` (`ug_user`,`ug_group`),
  KEY `ug_group` (`ug_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `user_newtalk` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_ip` varbinary(40) NOT NULL DEFAULT '',
  `user_last_timestamp` varbinary(14) DEFAULT NULL,
  KEY `un_user_id` (`user_id`),
  KEY `un_user_ip` (`user_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `user_properties` (
  `up_user` int(11) NOT NULL,
  `up_property` varbinary(255) NOT NULL,
  `up_value` blob,
  UNIQUE KEY `user_properties_user_property` (`up_user`,`up_property`),
  KEY `user_properties_property` (`up_property`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `valid_tag` (
  `vt_tag` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`vt_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `watchlist` (
  `wl_user` int(10) unsigned NOT NULL,
  `wl_namespace` int(11) NOT NULL DEFAULT '0',
  `wl_title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `wl_notificationtimestamp` varbinary(14) DEFAULT NULL,
  UNIQUE KEY `wl_user` (`wl_user`,`wl_namespace`,`wl_title`),
  KEY `namespace_title` (`wl_namespace`,`wl_title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;