#
# phpBB Backup Script
# Dump of tables for usr_web651_1
#
# DATE : 07-12-2004 23:53:00 GMT
#
#
# TABLE: phpbb_auth_access
#
DROP TABLE IF EXISTS phpbb_auth_access;
CREATE TABLE phpbb_auth_access(
	group_id mediumint(8) NOT NULL,
	forum_id smallint(5) unsigned NOT NULL,
	auth_view tinyint(1) NOT NULL,
	auth_read tinyint(1) NOT NULL,
	auth_post tinyint(1) NOT NULL,
	auth_reply tinyint(1) NOT NULL,
	auth_edit tinyint(1) NOT NULL,
	auth_delete tinyint(1) NOT NULL,
	auth_sticky tinyint(1) NOT NULL,
	auth_announce tinyint(1) NOT NULL,
	auth_vote tinyint(1) NOT NULL,
	auth_pollcreate tinyint(1) NOT NULL,
	auth_attachments tinyint(1) NOT NULL,
	auth_mod tinyint(1) NOT NULL, 
	KEY group_id (group_id), 
	KEY forum_id (forum_id)
);
#
# TABLE: phpbb_banlist
#
DROP TABLE IF EXISTS phpbb_banlist;
CREATE TABLE phpbb_banlist(
	ban_id mediumint(8) unsigned NOT NULL auto_increment,
	ban_userid mediumint(8) NOT NULL,
	ban_ip varchar(8) NOT NULL,
	ban_email varchar(255), 
	PRIMARY KEY (ban_id), 
	KEY ban_ip_user_id (ban_ip, ban_userid)
);
#
# TABLE: phpbb_categories
#
DROP TABLE IF EXISTS phpbb_categories;
CREATE TABLE phpbb_categories(
	cat_id mediumint(8) unsigned NOT NULL auto_increment,
	cat_title varchar(100),
	cat_order mediumint(8) unsigned NOT NULL, 
	PRIMARY KEY (cat_id), 
	KEY cat_order (cat_order)
);

#
# Table Data for phpbb_categories
#

INSERT INTO phpbb_categories (cat_id, cat_title, cat_order) VALUES('1', 'Komittees', '10');
INSERT INTO phpbb_categories (cat_id, cat_title, cat_order) VALUES('2', 'Website', '20');
INSERT INTO phpbb_categories (cat_id, cat_title, cat_order) VALUES('3', 'der Rest der Welt', '30');
#
# TABLE: phpbb_config
#
DROP TABLE IF EXISTS phpbb_config;
CREATE TABLE phpbb_config(
	config_name varchar(255) NOT NULL,
	config_value varchar(255) NOT NULL, 
	PRIMARY KEY (config_name)
);

#
# Table Data for phpbb_config
#

INSERT INTO phpbb_config (config_name, config_value) VALUES('config_id', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES('board_disable', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES('sitename', 'ABunnI \'05');
INSERT INTO phpbb_config (config_name, config_value) VALUES('site_desc', 'Nichts ist erotischer als Erfolg');
INSERT INTO phpbb_config (config_name, config_value) VALUES('cookie_name', 'phpbb2mysql');
INSERT INTO phpbb_config (config_name, config_value) VALUES('cookie_path', '/');
INSERT INTO phpbb_config (config_name, config_value) VALUES('cookie_domain', '');
INSERT INTO phpbb_config (config_name, config_value) VALUES('cookie_secure', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES('session_length', '3600');
INSERT INTO phpbb_config (config_name, config_value) VALUES('allow_html', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES('allow_html_tags', 'b,i,u,pre');
INSERT INTO phpbb_config (config_name, config_value) VALUES('allow_bbcode', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES('allow_smilies', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES('allow_sig', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES('allow_namechange', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES('allow_theme_create', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES('allow_avatar_local', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES('allow_avatar_remote', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES('allow_avatar_upload', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES('enable_confirm', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES('override_user_style', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES('posts_per_page', '15');
INSERT INTO phpbb_config (config_name, config_value) VALUES('topics_per_page', '50');
INSERT INTO phpbb_config (config_name, config_value) VALUES('hot_threshold', '25');
INSERT INTO phpbb_config (config_name, config_value) VALUES('max_poll_options', '10');
INSERT INTO phpbb_config (config_name, config_value) VALUES('max_sig_chars', '255');
INSERT INTO phpbb_config (config_name, config_value) VALUES('max_inbox_privmsgs', '50');
INSERT INTO phpbb_config (config_name, config_value) VALUES('max_sentbox_privmsgs', '25');
INSERT INTO phpbb_config (config_name, config_value) VALUES('max_savebox_privmsgs', '50');
INSERT INTO phpbb_config (config_name, config_value) VALUES('board_email_sig', 'Die betse Website der Welt:
http://www.i-wars.net');
INSERT INTO phpbb_config (config_name, config_value) VALUES('board_email', 'webmaster@nachderschule.ocm');
INSERT INTO phpbb_config (config_name, config_value) VALUES('smtp_delivery', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES('smtp_host', '');
INSERT INTO phpbb_config (config_name, config_value) VALUES('smtp_username', '');
INSERT INTO phpbb_config (config_name, config_value) VALUES('smtp_password', '');
INSERT INTO phpbb_config (config_name, config_value) VALUES('sendmail_fix', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES('require_activation', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES('flood_interval', '15');
INSERT INTO phpbb_config (config_name, config_value) VALUES('board_email_form', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES('avatar_filesize', '6144');
INSERT INTO phpbb_config (config_name, config_value) VALUES('avatar_max_width', '80');
INSERT INTO phpbb_config (config_name, config_value) VALUES('avatar_max_height', '80');
INSERT INTO phpbb_config (config_name, config_value) VALUES('avatar_path', 'images/avatars');
INSERT INTO phpbb_config (config_name, config_value) VALUES('avatar_gallery_path', 'images/avatars/gallery');
INSERT INTO phpbb_config (config_name, config_value) VALUES('smilies_path', 'images/smiles');
INSERT INTO phpbb_config (config_name, config_value) VALUES('default_style', '2');
INSERT INTO phpbb_config (config_name, config_value) VALUES('default_dateformat', 'D M d, Y g:i a');
INSERT INTO phpbb_config (config_name, config_value) VALUES('board_timezone', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES('prune_enable', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES('privmsg_disable', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES('gzip_compress', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES('coppa_fax', '');
INSERT INTO phpbb_config (config_name, config_value) VALUES('coppa_mail', 'webmaster@nachderschule.com');
INSERT INTO phpbb_config (config_name, config_value) VALUES('record_online_users', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES('record_online_date', '1102460354');
INSERT INTO phpbb_config (config_name, config_value) VALUES('server_name', 'nachderschule.com');
INSERT INTO phpbb_config (config_name, config_value) VALUES('server_port', '80');
INSERT INTO phpbb_config (config_name, config_value) VALUES('script_path', '/abi/forum/');
INSERT INTO phpbb_config (config_name, config_value) VALUES('version', '.0.11');
INSERT INTO phpbb_config (config_name, config_value) VALUES('board_startdate', '1102460147');
INSERT INTO phpbb_config (config_name, config_value) VALUES('default_lang', 'german');
#
# TABLE: phpbb_disallow
#
DROP TABLE IF EXISTS phpbb_disallow;
CREATE TABLE phpbb_disallow(
	disallow_id mediumint(8) unsigned NOT NULL auto_increment,
	disallow_username varchar(25) NOT NULL, 
	PRIMARY KEY (disallow_id)
);
#
# TABLE: phpbb_forums
#
DROP TABLE IF EXISTS phpbb_forums;
CREATE TABLE phpbb_forums(
	forum_id smallint(5) unsigned NOT NULL,
	cat_id mediumint(8) unsigned NOT NULL,
	forum_name varchar(150),
	forum_desc text,
	forum_status tinyint(4) NOT NULL,
	forum_order mediumint(8) unsigned DEFAULT '1' NOT NULL,
	forum_posts mediumint(8) unsigned NOT NULL,
	forum_topics mediumint(8) unsigned NOT NULL,
	forum_last_post_id mediumint(8) unsigned NOT NULL,
	prune_next int(11),
	prune_enable tinyint(1) NOT NULL,
	auth_view tinyint(2) NOT NULL,
	auth_read tinyint(2) NOT NULL,
	auth_post tinyint(2) NOT NULL,
	auth_reply tinyint(2) NOT NULL,
	auth_edit tinyint(2) NOT NULL,
	auth_delete tinyint(2) NOT NULL,
	auth_sticky tinyint(2) NOT NULL,
	auth_announce tinyint(2) NOT NULL,
	auth_vote tinyint(2) NOT NULL,
	auth_pollcreate tinyint(2) NOT NULL,
	auth_attachments tinyint(2) NOT NULL, 
	PRIMARY KEY (forum_id), 
	KEY forums_order (forum_order), 
	KEY cat_id (cat_id), 
	KEY forum_last_post_id (forum_last_post_id)
);

#
# Table Data for phpbb_forums
#

INSERT INTO phpbb_forums (forum_id, cat_id, forum_name, forum_desc, forum_status, forum_order, forum_posts, forum_topics, forum_last_post_id, prune_next, prune_enable, auth_view, auth_read, auth_post, auth_reply, auth_edit, auth_delete, auth_sticky, auth_announce, auth_vote, auth_pollcreate, auth_attachments) VALUES('1', '1', 'Zentralkomitee', 'Alle Fragen/Anliegen/Probleme die den Bereich des Zentralkomoitees betreffen.', '0', '10', '1', '1', '2', NULL, '0', '0', '0', '0', '0', '1', '1', '3', '3', '1', '1', '3');
INSERT INTO phpbb_forums (forum_id, cat_id, forum_name, forum_desc, forum_status, forum_order, forum_posts, forum_topics, forum_last_post_id, prune_next, prune_enable, auth_view, auth_read, auth_post, auth_reply, auth_edit, auth_delete, auth_sticky, auth_announce, auth_vote, auth_pollcreate, auth_attachments) VALUES('2', '1', 'Abi-Hütte', 'Alle Fragen/Anliegen/Probleme die die Abi-Hütte betreffen.', '0', '20', '1', '1', '6', NULL, '0', '0', '0', '0', '0', '1', '1', '3', '3', '1', '1', '0');
INSERT INTO phpbb_forums (forum_id, cat_id, forum_name, forum_desc, forum_status, forum_order, forum_posts, forum_topics, forum_last_post_id, prune_next, prune_enable, auth_view, auth_read, auth_post, auth_reply, auth_edit, auth_delete, auth_sticky, auth_announce, auth_vote, auth_pollcreate, auth_attachments) VALUES('3', '1', 'Abi-Band', 'Alle Fragen/Anliegen/Probleme die die Abi-Band betreffen.', '0', '30', '1', '1', '8', NULL, '0', '0', '0', '0', '0', '1', '1', '3', '3', '1', '1', '0');
INSERT INTO phpbb_forums (forum_id, cat_id, forum_name, forum_desc, forum_status, forum_order, forum_posts, forum_topics, forum_last_post_id, prune_next, prune_enable, auth_view, auth_read, auth_post, auth_reply, auth_edit, auth_delete, auth_sticky, auth_announce, auth_vote, auth_pollcreate, auth_attachments) VALUES('4', '1', 'Abi-Ball', 'Alle Fragen/Anliegen/Probleme die den Abi-Ball betreffen.', '0', '40', '1', '1', '4', NULL, '0', '0', '0', '0', '0', '1', '1', '3', '3', '1', '1', '0');
INSERT INTO phpbb_forums (forum_id, cat_id, forum_name, forum_desc, forum_status, forum_order, forum_posts, forum_topics, forum_last_post_id, prune_next, prune_enable, auth_view, auth_read, auth_post, auth_reply, auth_edit, auth_delete, auth_sticky, auth_announce, auth_vote, auth_pollcreate, auth_attachments) VALUES('5', '1', 'Abi-Zeitung', 'Alle Fragen/Anliegen/Probleme die die Abi-Zeitung betreffen.', '0', '50', '1', '1', '5', NULL, '0', '0', '0', '0', '0', '1', '1', '3', '3', '1', '1', '0');
INSERT INTO phpbb_forums (forum_id, cat_id, forum_name, forum_desc, forum_status, forum_order, forum_posts, forum_topics, forum_last_post_id, prune_next, prune_enable, auth_view, auth_read, auth_post, auth_reply, auth_edit, auth_delete, auth_sticky, auth_announce, auth_vote, auth_pollcreate, auth_attachments) VALUES('6', '1', 'Abi-Motto', 'Alle Fragen/Anliegen/Probleme die das Abi-Motto betreffen.', '0', '60', '1', '1', '3', NULL, '0', '0', '0', '0', '0', '1', '1', '3', '3', '1', '1', '0');
INSERT INTO phpbb_forums (forum_id, cat_id, forum_name, forum_desc, forum_status, forum_order, forum_posts, forum_topics, forum_last_post_id, prune_next, prune_enable, auth_view, auth_read, auth_post, auth_reply, auth_edit, auth_delete, auth_sticky, auth_announce, auth_vote, auth_pollcreate, auth_attachments) VALUES('7', '1', 'Abi-Vorfest', 'Alle Fragen/Anliegen/Probleme die das Abi-Vorfest betreffen.', '0', '70', '1', '1', '7', NULL, '0', '0', '0', '0', '0', '1', '1', '3', '3', '1', '1', '0');
INSERT INTO phpbb_forums (forum_id, cat_id, forum_name, forum_desc, forum_status, forum_order, forum_posts, forum_topics, forum_last_post_id, prune_next, prune_enable, auth_view, auth_read, auth_post, auth_reply, auth_edit, auth_delete, auth_sticky, auth_announce, auth_vote, auth_pollcreate, auth_attachments) VALUES('8', '1', 'Abi-Streich', 'Alle Fragen/Anliegen/Probleme die den Abi-Streich betreffen.', '0', '80', '1', '1', '9', NULL, '0', '0', '0', '0', '0', '1', '1', '3', '3', '1', '1', '0');
INSERT INTO phpbb_forums (forum_id, cat_id, forum_name, forum_desc, forum_status, forum_order, forum_posts, forum_topics, forum_last_post_id, prune_next, prune_enable, auth_view, auth_read, auth_post, auth_reply, auth_edit, auth_delete, auth_sticky, auth_announce, auth_vote, auth_pollcreate, auth_attachments) VALUES('9', '2', 'zur Website', 'Alle Fragen/Anliegen/Probleme die die Abi-Website betreffen.', '0', '10', '1', '1', '11', NULL, '0', '0', '0', '0', '0', '1', '1', '3', '3', '1', '1', '0');
INSERT INTO phpbb_forums (forum_id, cat_id, forum_name, forum_desc, forum_status, forum_order, forum_posts, forum_topics, forum_last_post_id, prune_next, prune_enable, auth_view, auth_read, auth_post, auth_reply, auth_edit, auth_delete, auth_sticky, auth_announce, auth_vote, auth_pollcreate, auth_attachments) VALUES('10', '3', 'Technik', 'Technische Fragen... Autos, Hifi, ...', '0', '10', '0', '0', '0', NULL, '0', '0', '0', '0', '0', '1', '1', '3', '3', '1', '1', '0');
INSERT INTO phpbb_forums (forum_id, cat_id, forum_name, forum_desc, forum_status, forum_order, forum_posts, forum_topics, forum_last_post_id, prune_next, prune_enable, auth_view, auth_read, auth_post, auth_reply, auth_edit, auth_delete, auth_sticky, auth_announce, auth_vote, auth_pollcreate, auth_attachments) VALUES('11', '3', 'Computer', 'PC Fragen... PC-Spiele, Internet, Website, Zubehör....', '0', '20', '0', '0', '0', NULL, '0', '0', '0', '0', '0', '1', '1', '3', '3', '1', '1', '0');
INSERT INTO phpbb_forums (forum_id, cat_id, forum_name, forum_desc, forum_status, forum_order, forum_posts, forum_topics, forum_last_post_id, prune_next, prune_enable, auth_view, auth_read, auth_post, auth_reply, auth_edit, auth_delete, auth_sticky, auth_announce, auth_vote, auth_pollcreate, auth_attachments) VALUES('12', '3', 'Labersack', 'alles was sonst nirgend reinpasst :)', '0', '30', '0', '0', '0', NULL, '0', '0', '0', '0', '0', '1', '1', '3', '3', '1', '1', '0');
INSERT INTO phpbb_forums (forum_id, cat_id, forum_name, forum_desc, forum_status, forum_order, forum_posts, forum_topics, forum_last_post_id, prune_next, prune_enable, auth_view, auth_read, auth_post, auth_reply, auth_edit, auth_delete, auth_sticky, auth_announce, auth_vote, auth_pollcreate, auth_attachments) VALUES('13', '2', 'zum Forum', 'Alle Fragen/Anliegen/Probleme die das Abi-Forum betreffen.', '0', '20', '1', '1', '10', NULL, '0', '0', '0', '0', '0', '1', '1', '3', '3', '1', '1', '0');
#
# TABLE: phpbb_forum_prune
#
DROP TABLE IF EXISTS phpbb_forum_prune;
CREATE TABLE phpbb_forum_prune(
	prune_id mediumint(8) unsigned NOT NULL auto_increment,
	forum_id smallint(5) unsigned NOT NULL,
	prune_days smallint(5) unsigned NOT NULL,
	prune_freq smallint(5) unsigned NOT NULL, 
	PRIMARY KEY (prune_id), 
	KEY forum_id (forum_id)
);
#
# TABLE: phpbb_groups
#
DROP TABLE IF EXISTS phpbb_groups;
CREATE TABLE phpbb_groups(
	group_id mediumint(8) NOT NULL auto_increment,
	group_type tinyint(4) DEFAULT '1' NOT NULL,
	group_name varchar(40) NOT NULL,
	group_description varchar(255) NOT NULL,
	group_moderator mediumint(8) NOT NULL,
	group_single_user tinyint(1) DEFAULT '1' NOT NULL, 
	PRIMARY KEY (group_id), 
	KEY group_single_user (group_single_user)
);

#
# Table Data for phpbb_groups
#

INSERT INTO phpbb_groups (group_id, group_type, group_name, group_description, group_moderator, group_single_user) VALUES('1', '1', 'Anonymous', 'Personal User', '0', '1');
INSERT INTO phpbb_groups (group_id, group_type, group_name, group_description, group_moderator, group_single_user) VALUES('2', '1', 'Admin', 'Personal User', '0', '1');
#
# TABLE: phpbb_posts
#
DROP TABLE IF EXISTS phpbb_posts;
CREATE TABLE phpbb_posts(
	post_id mediumint(8) unsigned NOT NULL auto_increment,
	topic_id mediumint(8) unsigned NOT NULL,
	forum_id smallint(5) unsigned NOT NULL,
	poster_id mediumint(8) NOT NULL,
	post_time int(11) NOT NULL,
	poster_ip varchar(8) NOT NULL,
	post_username varchar(25),
	enable_bbcode tinyint(1) DEFAULT '1' NOT NULL,
	enable_html tinyint(1) NOT NULL,
	enable_smilies tinyint(1) DEFAULT '1' NOT NULL,
	enable_sig tinyint(1) DEFAULT '1' NOT NULL,
	post_edit_time int(11),
	post_edit_count smallint(5) unsigned NOT NULL, 
	PRIMARY KEY (post_id), 
	KEY forum_id (forum_id), 
	KEY topic_id (topic_id), 
	KEY poster_id (poster_id), 
	KEY post_time (post_time)
);

#
# Table Data for phpbb_posts
#

INSERT INTO phpbb_posts (post_id, topic_id, forum_id, poster_id, post_time, poster_ip, post_username, enable_bbcode, enable_html, enable_smilies, enable_sig, post_edit_time, post_edit_count) VALUES('2', '2', '1', '2', '1102461093', 'd95f713c', '', '1', '1', '1', '1', NULL, '0');
INSERT INTO phpbb_posts (post_id, topic_id, forum_id, poster_id, post_time, poster_ip, post_username, enable_bbcode, enable_html, enable_smilies, enable_sig, post_edit_time, post_edit_count) VALUES('3', '3', '6', '2', '1102461126', 'd95f713c', '', '1', '1', '1', '1', NULL, '0');
INSERT INTO phpbb_posts (post_id, topic_id, forum_id, poster_id, post_time, poster_ip, post_username, enable_bbcode, enable_html, enable_smilies, enable_sig, post_edit_time, post_edit_count) VALUES('4', '4', '4', '2', '1102461181', 'd95f713c', '', '1', '1', '1', '1', NULL, '0');
INSERT INTO phpbb_posts (post_id, topic_id, forum_id, poster_id, post_time, poster_ip, post_username, enable_bbcode, enable_html, enable_smilies, enable_sig, post_edit_time, post_edit_count) VALUES('5', '5', '5', '2', '1102461213', 'd95f713c', '', '1', '1', '1', '1', NULL, '0');
INSERT INTO phpbb_posts (post_id, topic_id, forum_id, poster_id, post_time, poster_ip, post_username, enable_bbcode, enable_html, enable_smilies, enable_sig, post_edit_time, post_edit_count) VALUES('6', '6', '2', '2', '1102461306', 'd95f713c', '', '1', '1', '1', '1', NULL, '0');
INSERT INTO phpbb_posts (post_id, topic_id, forum_id, poster_id, post_time, poster_ip, post_username, enable_bbcode, enable_html, enable_smilies, enable_sig, post_edit_time, post_edit_count) VALUES('7', '7', '7', '2', '1102461339', 'd95f713c', '', '1', '1', '1', '1', NULL, '0');
INSERT INTO phpbb_posts (post_id, topic_id, forum_id, poster_id, post_time, poster_ip, post_username, enable_bbcode, enable_html, enable_smilies, enable_sig, post_edit_time, post_edit_count) VALUES('8', '8', '3', '2', '1102461366', 'd95f713c', '', '1', '1', '1', '1', NULL, '0');
INSERT INTO phpbb_posts (post_id, topic_id, forum_id, poster_id, post_time, poster_ip, post_username, enable_bbcode, enable_html, enable_smilies, enable_sig, post_edit_time, post_edit_count) VALUES('9', '9', '8', '2', '1102461411', 'd95f713c', '', '1', '1', '1', '1', NULL, '0');
INSERT INTO phpbb_posts (post_id, topic_id, forum_id, poster_id, post_time, poster_ip, post_username, enable_bbcode, enable_html, enable_smilies, enable_sig, post_edit_time, post_edit_count) VALUES('10', '10', '13', '2', '1102462833', 'd95f713c', '', '1', '1', '1', '1', NULL, '0');
INSERT INTO phpbb_posts (post_id, topic_id, forum_id, poster_id, post_time, poster_ip, post_username, enable_bbcode, enable_html, enable_smilies, enable_sig, post_edit_time, post_edit_count) VALUES('11', '11', '9', '2', '1102463075', 'd95f713c', '', '1', '1', '1', '1', NULL, '0');
#
# TABLE: phpbb_posts_text
#
DROP TABLE IF EXISTS phpbb_posts_text;
CREATE TABLE phpbb_posts_text(
	post_id mediumint(8) unsigned NOT NULL,
	bbcode_uid varchar(10) NOT NULL,
	post_subject varchar(60),
	post_text text, 
	PRIMARY KEY (post_id)
);

#
# Table Data for phpbb_posts_text
#

INSERT INTO phpbb_posts_text (post_id, bbcode_uid, post_subject, post_text) VALUES('2', 'a380201386', 'Mitglieder', 'Bitte jemand Mitglieder posten, ich hab keine Ahnung... :roll:');
INSERT INTO phpbb_posts_text (post_id, bbcode_uid, post_subject, post_text) VALUES('3', '47a67d4401', 'Mitglieder', '[b:47a67d4401]David Keppeler[/b:47a67d4401], Sebastian Koch, Katharina Burkhardt, Angi Kern, Mustafa Sert, Moritz Rapp, Christoph Nann, Steffen Zietkowski');
INSERT INTO phpbb_posts_text (post_id, bbcode_uid, post_subject, post_text) VALUES('4', '86a4f21642', 'Mitglieder', '[b:86a4f21642]Manuel Müller[/b:86a4f21642], Deborah Buck, Manuela Haap, Heike, Kerstin, Julia, Lisa, Karina, Caroline Kratt, Alina Katzmann, Sina Mandl, Martina Katz');
INSERT INTO phpbb_posts_text (post_id, bbcode_uid, post_subject, post_text) VALUES('5', '5eb6526566', 'Mitglieder', 'Petra Hamacher, Juliane Silberzahn, Hannah Humpf, Katinka Lange, Colin Schneider, Julia Langhammer, Dana Böckle');
INSERT INTO phpbb_posts_text (post_id, bbcode_uid, post_subject, post_text) VALUES('6', '6095451b67', 'Mitglieder', '[b:6095451b67]Gudrun Wilhelm[/b:6095451b67], Christin Teufel, Fata');
INSERT INTO phpbb_posts_text (post_id, bbcode_uid, post_subject, post_text) VALUES('7', 'bbad2ae95b', 'Mitglieder', '[b:bbad2ae95b]Manuel Müller[/b:bbad2ae95b], Philipp Mehl, Karl Schmidt');
INSERT INTO phpbb_posts_text (post_id, bbcode_uid, post_subject, post_text) VALUES('8', '24d3c73d4e', 'Mitglieder', '[b:24d3c73d4e]Sebastian Koch[/b:24d3c73d4e], Phillip Kondic, Herr Michel, Michael Storr, Debo, Fata');
INSERT INTO phpbb_posts_text (post_id, bbcode_uid, post_subject, post_text) VALUES('9', '70de5d5cdc', 'Mitglieder', '[b:70de5d5cdc]Karolina Kos[/b:70de5d5cdc], Anja Löffel, Jasmin Gutbrod, Melanie Herrmann, Oliver Fink, Natalia Gasinez');
INSERT INTO phpbb_posts_text (post_id, bbcode_uid, post_subject, post_text) VALUES('10', '666ae0a4dd', 'Style/Theme', 'Wir brauchen nen andern Style... am betsen einen der Weiß auf Schwarz ist! Der hier ist irgendwie... doof.... :/');
INSERT INTO phpbb_posts_text (post_id, bbcode_uid, post_subject, post_text) VALUES('11', '0a241ee04f', 'Website-Stand', 'Bisher gibts nur ein Grundgerüst: http://nachderschule.com/abi/ Aber is doch schommal was! :D');
#
# TABLE: phpbb_privmsgs
#
DROP TABLE IF EXISTS phpbb_privmsgs;
CREATE TABLE phpbb_privmsgs(
	privmsgs_id mediumint(8) unsigned NOT NULL auto_increment,
	privmsgs_type tinyint(4) NOT NULL,
	privmsgs_subject varchar(255) NOT NULL,
	privmsgs_from_userid mediumint(8) NOT NULL,
	privmsgs_to_userid mediumint(8) NOT NULL,
	privmsgs_date int(11) NOT NULL,
	privmsgs_ip varchar(8) NOT NULL,
	privmsgs_enable_bbcode tinyint(1) DEFAULT '1' NOT NULL,
	privmsgs_enable_html tinyint(1) NOT NULL,
	privmsgs_enable_smilies tinyint(1) DEFAULT '1' NOT NULL,
	privmsgs_attach_sig tinyint(1) DEFAULT '1' NOT NULL, 
	PRIMARY KEY (privmsgs_id), 
	KEY privmsgs_from_userid (privmsgs_from_userid), 
	KEY privmsgs_to_userid (privmsgs_to_userid)
);
#
# TABLE: phpbb_privmsgs_text
#
DROP TABLE IF EXISTS phpbb_privmsgs_text;
CREATE TABLE phpbb_privmsgs_text(
	privmsgs_text_id mediumint(8) unsigned NOT NULL,
	privmsgs_bbcode_uid varchar(10) NOT NULL,
	privmsgs_text text, 
	PRIMARY KEY (privmsgs_text_id)
);
#
# TABLE: phpbb_ranks
#
DROP TABLE IF EXISTS phpbb_ranks;
CREATE TABLE phpbb_ranks(
	rank_id smallint(5) unsigned NOT NULL auto_increment,
	rank_title varchar(50) NOT NULL,
	rank_min mediumint(8) NOT NULL,
	rank_special tinyint(1),
	rank_image varchar(255), 
	PRIMARY KEY (rank_id)
);

#
# Table Data for phpbb_ranks
#

INSERT INTO phpbb_ranks (rank_id, rank_title, rank_min, rank_special, rank_image) VALUES('1', 'Site Admin', '-1', '1', NULL);
#
# TABLE: phpbb_search_results
#
DROP TABLE IF EXISTS phpbb_search_results;
CREATE TABLE phpbb_search_results(
	search_id int(11) unsigned NOT NULL,
	session_id varchar(32) NOT NULL,
	search_array text NOT NULL, 
	PRIMARY KEY (search_id), 
	KEY session_id (session_id)
);
#
# TABLE: phpbb_search_wordlist
#
DROP TABLE IF EXISTS phpbb_search_wordlist;
CREATE TABLE phpbb_search_wordlist(
	word_text varchar(50) binary NOT NULL,
	word_id mediumint(8) unsigned NOT NULL auto_increment,
	word_common tinyint(1) unsigned NOT NULL, 
	PRIMARY KEY (word_text), 
	KEY word_id (word_id)
);

#
# Table Data for phpbb_search_wordlist
#

INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('zietkowski', '47', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('steffen', '46', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('phpbb', '3', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('sert', '45', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('sebastian', '44', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('rapp', '43', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('nann', '42', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('mustafa', '41', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('moritz', '40', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('posten', '15', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('mitglieder', '14', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('ahnung', '13', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('koch', '39', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('kern', '38', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('keppeler', '37', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('katharina', '36', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('david', '35', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('christoph', '34', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('burkhardt', '33', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('angi', '32', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('sina', '97', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('müller', '96', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('martina', '95', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('manuela', '94', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('manuel', '93', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('mandl', '92', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('julia', '54', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('lisa', '91', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('kratt', '90', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('kerstin', '89', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('katzmann', '88', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('katz', '87', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('karina', '86', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('heike', '85', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('haap', '84', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('deborah', '83', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('caroline', '82', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('buck', '81', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('alina', '80', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('böckle', '67', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('colin', '68', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('dana', '69', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('hamacher', '70', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('hannah', '71', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('humpf', '72', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('juliane', '73', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('katinka', '74', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('lange', '75', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('langhammer', '76', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('petra', '77', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('schneider', '78', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('silberzahn', '79', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('christin', '98', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('fata', '99', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('gudrun', '100', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('teufel', '101', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('wilhelm', '102', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('karl', '103', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('mehl', '104', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('philipp', '105', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('schmidt', '106', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('debo', '107', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('herr', '108', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('kondic', '109', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('michael', '110', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('michel', '111', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('phillip', '112', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('storr', '113', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('anja', '114', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('fink', '115', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('gasinez', '116', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('gutbrod', '117', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('herrmann', '118', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('jasmin', '119', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('karolina', '120', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('kos', '121', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('löffel', '122', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('melanie', '123', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('natalia', '124', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('oliver', '125', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('andern', '126', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('betsen', '127', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('brauchen', '128', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('doof', '129', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('irgendwie', '130', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('schwarz', '131', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('style', '132', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('theme', '133', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('weiß', '134', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('bisher', '135', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('gibts', '136', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('grundgerüst', '137', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('schommal', '138', '0');
INSERT INTO phpbb_search_wordlist (word_text, word_id, word_common) VALUES('websitestand', '139', '0');
#
# TABLE: phpbb_search_wordmatch
#
DROP TABLE IF EXISTS phpbb_search_wordmatch;
CREATE TABLE phpbb_search_wordmatch(
	post_id mediumint(8) unsigned NOT NULL,
	word_id mediumint(8) unsigned NOT NULL,
	title_match tinyint(1) NOT NULL, 
	KEY post_id (post_id), 
	KEY word_id (word_id)
);

#
# Table Data for phpbb_search_wordmatch
#

INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('3', '14', '1');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('3', '32', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('3', '33', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('3', '34', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('3', '35', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('3', '36', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('3', '37', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('3', '38', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('3', '39', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('2', '14', '1');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('2', '15', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('2', '14', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('2', '13', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('3', '40', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('3', '41', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('3', '42', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('3', '43', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('3', '44', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('3', '45', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('3', '46', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('3', '47', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('4', '14', '1');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('4', '80', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('4', '81', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('4', '82', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('4', '83', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('4', '84', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('4', '85', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('4', '86', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('4', '87', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('4', '88', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('4', '89', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('4', '90', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('4', '91', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('4', '54', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('4', '92', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('4', '93', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('4', '94', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('4', '95', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('4', '96', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('4', '97', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('5', '54', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('5', '67', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('5', '68', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('5', '69', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('5', '70', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('5', '71', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('5', '72', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('5', '73', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('5', '74', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('5', '75', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('5', '76', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('5', '77', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('5', '78', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('5', '79', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('5', '14', '1');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('6', '98', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('6', '99', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('6', '100', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('6', '101', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('6', '102', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('6', '14', '1');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('7', '103', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('7', '93', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('7', '104', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('7', '96', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('7', '105', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('7', '106', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('7', '14', '1');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('8', '107', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('8', '99', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('8', '108', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('8', '39', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('8', '109', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('8', '110', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('8', '111', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('8', '112', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('8', '44', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('8', '113', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('8', '14', '1');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('9', '114', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('9', '115', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('9', '116', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('9', '117', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('9', '118', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('9', '119', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('9', '120', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('9', '121', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('9', '122', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('9', '123', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('9', '124', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('9', '125', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('9', '14', '1');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('10', '126', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('10', '127', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('10', '128', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('10', '129', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('10', '130', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('10', '131', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('10', '132', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('10', '134', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('10', '132', '1');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('10', '133', '1');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('11', '135', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('11', '136', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('11', '137', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('11', '138', '0');
INSERT INTO phpbb_search_wordmatch (post_id, word_id, title_match) VALUES('11', '139', '1');
#
# TABLE: phpbb_sessions
#
DROP TABLE IF EXISTS phpbb_sessions;
CREATE TABLE phpbb_sessions(
	session_id char(32) NOT NULL,
	session_user_id mediumint(8) NOT NULL,
	session_start int(11) NOT NULL,
	session_time int(11) NOT NULL,
	session_ip char(8) NOT NULL,
	session_page int(11) NOT NULL,
	session_logged_in tinyint(1) NOT NULL, 
	PRIMARY KEY (session_id), 
	KEY session_user_id (session_user_id), 
	KEY session_id_ip_user_id (session_id, session_ip, session_user_id)
);

#
# Table Data for phpbb_sessions
#

INSERT INTO phpbb_sessions (session_id, session_user_id, session_start, session_time, session_ip, session_page, session_logged_in) VALUES('22737cdcf2a7e7d5b7350e164af7b0c0', '2', '1102460184', '1102463566', 'd95f713c', '0', '1');
#
# TABLE: phpbb_smilies
#
DROP TABLE IF EXISTS phpbb_smilies;
CREATE TABLE phpbb_smilies(
	smilies_id smallint(5) unsigned NOT NULL auto_increment,
	code varchar(50),
	smile_url varchar(100),
	emoticon varchar(75), 
	PRIMARY KEY (smilies_id)
);

#
# Table Data for phpbb_smilies
#

INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('1', ':D', 'icon_biggrin.gif', 'Very Happy');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('2', ':-D', 'icon_biggrin.gif', 'Very Happy');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('3', ':grin:', 'icon_biggrin.gif', 'Very Happy');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('4', ':)', 'icon_smile.gif', 'Smile');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('5', ':-)', 'icon_smile.gif', 'Smile');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('6', ':smile:', 'icon_smile.gif', 'Smile');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('7', ':(', 'icon_sad.gif', 'Sad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('8', ':-(', 'icon_sad.gif', 'Sad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('9', ':sad:', 'icon_sad.gif', 'Sad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('10', ':o', 'icon_surprised.gif', 'Surprised');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('11', ':-o', 'icon_surprised.gif', 'Surprised');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('12', ':eek:', 'icon_surprised.gif', 'Surprised');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('13', ':shock:', 'icon_eek.gif', 'Shocked');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('14', ':?', 'icon_confused.gif', 'Confused');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('15', ':-?', 'icon_confused.gif', 'Confused');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('16', ':???:', 'icon_confused.gif', 'Confused');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('17', '8)', 'icon_cool.gif', 'Cool');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('18', '8-)', 'icon_cool.gif', 'Cool');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('19', ':cool:', 'icon_cool.gif', 'Cool');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('20', ':lol:', 'icon_lol.gif', 'Laughing');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('21', ':x', 'icon_mad.gif', 'Mad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('22', ':-x', 'icon_mad.gif', 'Mad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('23', ':mad:', 'icon_mad.gif', 'Mad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('24', ':P', 'icon_razz.gif', 'Razz');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('25', ':-P', 'icon_razz.gif', 'Razz');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('26', ':razz:', 'icon_razz.gif', 'Razz');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('27', ':oops:', 'icon_redface.gif', 'Embarassed');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('28', ':cry:', 'icon_cry.gif', 'Crying or Very sad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('29', ':evil:', 'icon_evil.gif', 'Evil or Very Mad');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('30', ':twisted:', 'icon_twisted.gif', 'Twisted Evil');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('31', ':roll:', 'icon_rolleyes.gif', 'Rolling Eyes');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('32', ':wink:', 'icon_wink.gif', 'Wink');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('33', ';)', 'icon_wink.gif', 'Wink');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('34', ';-)', 'icon_wink.gif', 'Wink');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('35', ':!:', 'icon_exclaim.gif', 'Exclamation');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('36', ':?:', 'icon_question.gif', 'Question');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('37', ':idea:', 'icon_idea.gif', 'Idea');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('38', ':arrow:', 'icon_arrow.gif', 'Arrow');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('39', ':|', 'icon_neutral.gif', 'Neutral');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('40', ':-|', 'icon_neutral.gif', 'Neutral');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('41', ':neutral:', 'icon_neutral.gif', 'Neutral');
INSERT INTO phpbb_smilies (smilies_id, code, smile_url, emoticon) VALUES('42', ':mrgreen:', 'icon_mrgreen.gif', 'Mr. Green');
#
# TABLE: phpbb_themes
#
DROP TABLE IF EXISTS phpbb_themes;
CREATE TABLE phpbb_themes(
	themes_id mediumint(8) unsigned NOT NULL auto_increment,
	template_name varchar(30) NOT NULL,
	style_name varchar(30) NOT NULL,
	head_stylesheet varchar(100),
	body_background varchar(100),
	body_bgcolor varchar(6),
	body_text varchar(6),
	body_link varchar(6),
	body_vlink varchar(6),
	body_alink varchar(6),
	body_hlink varchar(6),
	tr_color1 varchar(6),
	tr_color2 varchar(6),
	tr_color3 varchar(6),
	tr_class1 varchar(25),
	tr_class2 varchar(25),
	tr_class3 varchar(25),
	th_color1 varchar(6),
	th_color2 varchar(6),
	th_color3 varchar(6),
	th_class1 varchar(25),
	th_class2 varchar(25),
	th_class3 varchar(25),
	td_color1 varchar(6),
	td_color2 varchar(6),
	td_color3 varchar(6),
	td_class1 varchar(25),
	td_class2 varchar(25),
	td_class3 varchar(25),
	fontface1 varchar(50),
	fontface2 varchar(50),
	fontface3 varchar(50),
	fontsize1 tinyint(4),
	fontsize2 tinyint(4),
	fontsize3 tinyint(4),
	fontcolor1 varchar(6),
	fontcolor2 varchar(6),
	fontcolor3 varchar(6),
	span_class1 varchar(25),
	span_class2 varchar(25),
	span_class3 varchar(25),
	img_size_poll smallint(5) unsigned,
	img_size_privmsg smallint(5) unsigned, 
	PRIMARY KEY (themes_id)
);

#
# Table Data for phpbb_themes
#

INSERT INTO phpbb_themes (themes_id, template_name, style_name, head_stylesheet, body_background, body_bgcolor, body_text, body_link, body_vlink, body_alink, body_hlink, tr_color1, tr_color2, tr_color3, tr_class1, tr_class2, tr_class3, th_color1, th_color2, th_color3, th_class1, th_class2, th_class3, td_color1, td_color2, td_color3, td_class1, td_class2, td_class3, fontface1, fontface2, fontface3, fontsize1, fontsize2, fontsize3, fontcolor1, fontcolor2, fontcolor3, span_class1, span_class2, span_class3, img_size_poll, img_size_privmsg) VALUES('1', 'subSilver', 'subSilver', 'subSilver.css', '', 'E5E5E5', '000000', '006699', '5493B4', '', 'DD6900', 'EFEFEF', 'DEE3E7', 'D1D7DC', '', '', '', '98AAB1', '006699', 'FFFFFF', 'cellpic1.gif', 'cellpic3.gif', 'cellpic2.jpg', 'FAFAFA', 'FFFFFF', '', 'row1', 'row2', '', 'Verdana, Arial, Helvetica, sans-serif', 'Trebuchet MS', 'Courier, \'Courier New\', sans-serif', '10', '11', '12', '444444', '006600', 'FFA34F', '', '', '', NULL, NULL);
INSERT INTO phpbb_themes (themes_id, template_name, style_name, head_stylesheet, body_background, body_bgcolor, body_text, body_link, body_vlink, body_alink, body_hlink, tr_color1, tr_color2, tr_color3, tr_class1, tr_class2, tr_class3, th_color1, th_color2, th_color3, th_class1, th_class2, th_class3, td_color1, td_color2, td_color3, td_class1, td_class2, td_class3, fontface1, fontface2, fontface3, fontsize1, fontsize2, fontsize3, fontcolor1, fontcolor2, fontcolor3, span_class1, span_class2, span_class3, img_size_poll, img_size_privmsg) VALUES('2', 'Morpheus', 'Morpheus Gray', 'style_gray.css', 'gray', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'row1', 'row2', '', '', '', '', '10', '11', '12', '444444', '3FB753', 'E89512', '', '', '', '0', '0');
#
# TABLE: phpbb_themes_name
#
DROP TABLE IF EXISTS phpbb_themes_name;
CREATE TABLE phpbb_themes_name(
	themes_id smallint(5) unsigned NOT NULL,
	tr_color1_name char(50),
	tr_color2_name char(50),
	tr_color3_name char(50),
	tr_class1_name char(50),
	tr_class2_name char(50),
	tr_class3_name char(50),
	th_color1_name char(50),
	th_color2_name char(50),
	th_color3_name char(50),
	th_class1_name char(50),
	th_class2_name char(50),
	th_class3_name char(50),
	td_color1_name char(50),
	td_color2_name char(50),
	td_color3_name char(50),
	td_class1_name char(50),
	td_class2_name char(50),
	td_class3_name char(50),
	fontface1_name char(50),
	fontface2_name char(50),
	fontface3_name char(50),
	fontsize1_name char(50),
	fontsize2_name char(50),
	fontsize3_name char(50),
	fontcolor1_name char(50),
	fontcolor2_name char(50),
	fontcolor3_name char(50),
	span_class1_name char(50),
	span_class2_name char(50),
	span_class3_name char(50), 
	PRIMARY KEY (themes_id)
);

#
# Table Data for phpbb_themes_name
#

INSERT INTO phpbb_themes_name (themes_id, tr_color1_name, tr_color2_name, tr_color3_name, tr_class1_name, tr_class2_name, tr_class3_name, th_color1_name, th_color2_name, th_color3_name, th_class1_name, th_class2_name, th_class3_name, td_color1_name, td_color2_name, td_color3_name, td_class1_name, td_class2_name, td_class3_name, fontface1_name, fontface2_name, fontface3_name, fontsize1_name, fontsize2_name, fontsize3_name, fontcolor1_name, fontcolor2_name, fontcolor3_name, span_class1_name, span_class2_name, span_class3_name) VALUES('1', 'The lightest row colour', 'The medium row color', 'The darkest row colour', '', '', '', 'Border round the whole page', 'Outer table border', 'Inner table border', 'Silver gradient picture', 'Blue gradient picture', 'Fade-out gradient on index', 'Background for quote boxes', 'All white areas', '', 'Background for topic posts', '2nd background for topic posts', '', 'Main fonts', 'Additional topic title font', 'Form fonts', 'Smallest font size', 'Medium font size', 'Normal font size (post body etc)', 'Quote & copyright text', 'Code text colour', 'Main table header text colour', '', '', '');
#
# TABLE: phpbb_topics
#
DROP TABLE IF EXISTS phpbb_topics;
CREATE TABLE phpbb_topics(
	topic_id mediumint(8) unsigned NOT NULL auto_increment,
	forum_id smallint(8) unsigned NOT NULL,
	topic_title char(60) NOT NULL,
	topic_poster mediumint(8) NOT NULL,
	topic_time int(11) NOT NULL,
	topic_views mediumint(8) unsigned NOT NULL,
	topic_replies mediumint(8) unsigned NOT NULL,
	topic_status tinyint(3) NOT NULL,
	topic_vote tinyint(1) NOT NULL,
	topic_type tinyint(3) NOT NULL,
	topic_first_post_id mediumint(8) unsigned NOT NULL,
	topic_last_post_id mediumint(8) unsigned NOT NULL,
	topic_moved_id mediumint(8) unsigned NOT NULL, 
	PRIMARY KEY (topic_id), 
	KEY forum_id (forum_id), 
	KEY topic_moved_id (topic_moved_id), 
	KEY topic_status (topic_status), 
	KEY topic_type (topic_type)
);

#
# Table Data for phpbb_topics
#

INSERT INTO phpbb_topics (topic_id, forum_id, topic_title, topic_poster, topic_time, topic_views, topic_replies, topic_status, topic_vote, topic_type, topic_first_post_id, topic_last_post_id, topic_moved_id) VALUES('2', '1', 'Mitglieder', '2', '1102461093', '3', '0', '0', '0', '0', '2', '2', '0');
INSERT INTO phpbb_topics (topic_id, forum_id, topic_title, topic_poster, topic_time, topic_views, topic_replies, topic_status, topic_vote, topic_type, topic_first_post_id, topic_last_post_id, topic_moved_id) VALUES('3', '6', 'Mitglieder', '2', '1102461126', '3', '0', '1', '0', '1', '3', '3', '0');
INSERT INTO phpbb_topics (topic_id, forum_id, topic_title, topic_poster, topic_time, topic_views, topic_replies, topic_status, topic_vote, topic_type, topic_first_post_id, topic_last_post_id, topic_moved_id) VALUES('4', '4', 'Mitglieder', '2', '1102461181', '3', '0', '1', '0', '1', '4', '4', '0');
INSERT INTO phpbb_topics (topic_id, forum_id, topic_title, topic_poster, topic_time, topic_views, topic_replies, topic_status, topic_vote, topic_type, topic_first_post_id, topic_last_post_id, topic_moved_id) VALUES('5', '5', 'Mitglieder', '2', '1102461213', '1', '0', '1', '0', '1', '5', '5', '0');
INSERT INTO phpbb_topics (topic_id, forum_id, topic_title, topic_poster, topic_time, topic_views, topic_replies, topic_status, topic_vote, topic_type, topic_first_post_id, topic_last_post_id, topic_moved_id) VALUES('6', '2', 'Mitglieder', '2', '1102461306', '1', '0', '1', '0', '1', '6', '6', '0');
INSERT INTO phpbb_topics (topic_id, forum_id, topic_title, topic_poster, topic_time, topic_views, topic_replies, topic_status, topic_vote, topic_type, topic_first_post_id, topic_last_post_id, topic_moved_id) VALUES('7', '7', 'Mitglieder', '2', '1102461339', '2', '0', '1', '0', '1', '7', '7', '0');
INSERT INTO phpbb_topics (topic_id, forum_id, topic_title, topic_poster, topic_time, topic_views, topic_replies, topic_status, topic_vote, topic_type, topic_first_post_id, topic_last_post_id, topic_moved_id) VALUES('8', '3', 'Mitglieder', '2', '1102461366', '3', '0', '1', '0', '1', '8', '8', '0');
INSERT INTO phpbb_topics (topic_id, forum_id, topic_title, topic_poster, topic_time, topic_views, topic_replies, topic_status, topic_vote, topic_type, topic_first_post_id, topic_last_post_id, topic_moved_id) VALUES('9', '8', 'Mitglieder', '2', '1102461411', '2', '0', '1', '0', '1', '9', '9', '0');
INSERT INTO phpbb_topics (topic_id, forum_id, topic_title, topic_poster, topic_time, topic_views, topic_replies, topic_status, topic_vote, topic_type, topic_first_post_id, topic_last_post_id, topic_moved_id) VALUES('10', '13', 'Style/Theme', '2', '1102462833', '1', '0', '0', '0', '0', '10', '10', '0');
INSERT INTO phpbb_topics (topic_id, forum_id, topic_title, topic_poster, topic_time, topic_views, topic_replies, topic_status, topic_vote, topic_type, topic_first_post_id, topic_last_post_id, topic_moved_id) VALUES('11', '9', 'Website-Stand', '2', '1102463075', '1', '0', '0', '0', '0', '11', '11', '0');
#
# TABLE: phpbb_topics_watch
#
DROP TABLE IF EXISTS phpbb_topics_watch;
CREATE TABLE phpbb_topics_watch(
	topic_id mediumint(8) unsigned NOT NULL,
	user_id mediumint(8) NOT NULL,
	notify_status tinyint(1) NOT NULL, 
	KEY topic_id (topic_id), 
	KEY user_id (user_id), 
	KEY notify_status (notify_status)
);
#
# TABLE: phpbb_user_group
#
DROP TABLE IF EXISTS phpbb_user_group;
CREATE TABLE phpbb_user_group(
	group_id mediumint(8) NOT NULL,
	user_id mediumint(8) NOT NULL,
	user_pending tinyint(1), 
	KEY group_id (group_id), 
	KEY user_id (user_id)
);

#
# Table Data for phpbb_user_group
#

INSERT INTO phpbb_user_group (group_id, user_id, user_pending) VALUES('1', '-1', '0');
INSERT INTO phpbb_user_group (group_id, user_id, user_pending) VALUES('2', '2', '0');
#
# TABLE: phpbb_users
#
DROP TABLE IF EXISTS phpbb_users;
CREATE TABLE phpbb_users(
	user_id mediumint(8) NOT NULL,
	user_active tinyint(1) DEFAULT '1',
	username varchar(25) NOT NULL,
	user_password varchar(32) NOT NULL,
	user_session_time int(11) NOT NULL,
	user_session_page smallint(5) NOT NULL,
	user_lastvisit int(11) NOT NULL,
	user_regdate int(11) NOT NULL,
	user_level tinyint(4),
	user_posts mediumint(8) unsigned NOT NULL,
	user_timezone decimal(5,2) DEFAULT '0.00' NOT NULL,
	user_style tinyint(4),
	user_lang varchar(255),
	user_dateformat varchar(14) DEFAULT 'd M Y H:i' NOT NULL,
	user_new_privmsg smallint(5) unsigned NOT NULL,
	user_unread_privmsg smallint(5) unsigned NOT NULL,
	user_last_privmsg int(11) NOT NULL,
	user_emailtime int(11),
	user_viewemail tinyint(1),
	user_attachsig tinyint(1),
	user_allowhtml tinyint(1) DEFAULT '1',
	user_allowbbcode tinyint(1) DEFAULT '1',
	user_allowsmile tinyint(1) DEFAULT '1',
	user_allowavatar tinyint(1) DEFAULT '1' NOT NULL,
	user_allow_pm tinyint(1) DEFAULT '1' NOT NULL,
	user_allow_viewonline tinyint(1) DEFAULT '1' NOT NULL,
	user_notify tinyint(1) DEFAULT '1' NOT NULL,
	user_notify_pm tinyint(1) NOT NULL,
	user_popup_pm tinyint(1) NOT NULL,
	user_rank int(11),
	user_avatar varchar(100),
	user_avatar_type tinyint(4) NOT NULL,
	user_email varchar(255),
	user_icq varchar(15),
	user_website varchar(100),
	user_from varchar(100),
	user_sig text,
	user_sig_bbcode_uid varchar(10),
	user_aim varchar(255),
	user_yim varchar(255),
	user_msnm varchar(255),
	user_occ varchar(100),
	user_interests varchar(255),
	user_actkey varchar(32),
	user_newpasswd varchar(32), 
	PRIMARY KEY (user_id), 
	KEY user_session_time (user_session_time)
);

#
# Table Data for phpbb_users
#

INSERT INTO phpbb_users (user_id, user_active, username, user_password, user_session_time, user_session_page, user_lastvisit, user_regdate, user_level, user_posts, user_timezone, user_style, user_lang, user_dateformat, user_new_privmsg, user_unread_privmsg, user_last_privmsg, user_emailtime, user_viewemail, user_attachsig, user_allowhtml, user_allowbbcode, user_allowsmile, user_allowavatar, user_allow_pm, user_allow_viewonline, user_notify, user_notify_pm, user_popup_pm, user_rank, user_avatar, user_avatar_type, user_email, user_icq, user_website, user_from, user_sig, user_sig_bbcode_uid, user_aim, user_yim, user_msnm, user_occ, user_interests, user_actkey, user_newpasswd) VALUES('-1', '0', 'Anonymous', '', '0', '0', '0', '1102460147', '0', '0', '0.00', NULL, '', '', '0', '0', '0', NULL, '0', '0', '0', '1', '1', '1', '0', '1', '0', '1', '0', NULL, '', '0', '', '', '', '', '', NULL, '', '', '', '', '', '', '');
INSERT INTO phpbb_users (user_id, user_active, username, user_password, user_session_time, user_session_page, user_lastvisit, user_regdate, user_level, user_posts, user_timezone, user_style, user_lang, user_dateformat, user_new_privmsg, user_unread_privmsg, user_last_privmsg, user_emailtime, user_viewemail, user_attachsig, user_allowhtml, user_allowbbcode, user_allowsmile, user_allowavatar, user_allow_pm, user_allow_viewonline, user_notify, user_notify_pm, user_popup_pm, user_rank, user_avatar, user_avatar_type, user_email, user_icq, user_website, user_from, user_sig, user_sig_bbcode_uid, user_aim, user_yim, user_msnm, user_occ, user_interests, user_actkey, user_newpasswd) VALUES('2', '1', 'Juuro', '5eae1cbd5710568ac9ff3499e6a0eafc', '1102463566', '0', '1102460184', '1102460147', '1', '10', '0.00', '1', 'german', 'd M Y h:i a', '0', '0', '0', NULL, '1', '1', '1', '1', '1', '1', '1', '1', '0', '1', '1', '1', 'http://susiyin.blogger.de/static/antville/images/susiyin/portrait.jpg', '2', 'webmaster@nachderschule.ocm', '316569181', 'http://www.sebastian-engel.de', 'Baden-Würstchenberg', 'Die beste Website der Welt:
http://www.i-wars.net', '0195bd6d60', '', '', 'juuro2000@hotmail.com', 'Kässpätzle', 'PC-Hardware, Website-Coding, Münzen, Die Ärzte, Deutschrock, mein Handy (Siemens S65)', '', '');
#
# TABLE: phpbb_vote_desc
#
DROP TABLE IF EXISTS phpbb_vote_desc;
CREATE TABLE phpbb_vote_desc(
	vote_id mediumint(8) unsigned NOT NULL auto_increment,
	topic_id mediumint(8) unsigned NOT NULL,
	vote_text text NOT NULL,
	vote_start int(11) NOT NULL,
	vote_length int(11) NOT NULL, 
	PRIMARY KEY (vote_id), 
	KEY topic_id (topic_id)
);
#
# TABLE: phpbb_vote_results
#
DROP TABLE IF EXISTS phpbb_vote_results;
CREATE TABLE phpbb_vote_results(
	vote_id mediumint(8) unsigned NOT NULL,
	vote_option_id tinyint(4) unsigned NOT NULL,
	vote_option_text varchar(255) NOT NULL,
	vote_result int(11) NOT NULL, 
	KEY vote_option_id (vote_option_id), 
	KEY vote_id (vote_id)
);
#
# TABLE: phpbb_vote_voters
#
DROP TABLE IF EXISTS phpbb_vote_voters;
CREATE TABLE phpbb_vote_voters(
	vote_id mediumint(8) unsigned NOT NULL,
	vote_user_id mediumint(8) NOT NULL,
	vote_user_ip char(8) NOT NULL, 
	KEY vote_id (vote_id), 
	KEY vote_user_id (vote_user_id), 
	KEY vote_user_ip (vote_user_ip)
);
#
# TABLE: phpbb_words
#
DROP TABLE IF EXISTS phpbb_words;
CREATE TABLE phpbb_words(
	word_id mediumint(8) unsigned NOT NULL auto_increment,
	word char(100) NOT NULL,
	replacement char(100) NOT NULL, 
	PRIMARY KEY (word_id)
);
