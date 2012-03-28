<?php # $Id: serendipity_lang_zh.inc.php 2575 2009-08-24 08:24:19Z garvinhicking $
# Copyright (c) 2003-2005, Jannis Hermanns (on behalf the Serendipity Developer Team)
# All rights reserved.  See LICENSE file for licensing details
# Translated by
# (c) 2006 Aphonex Li <aphonex.li@gmail.com> 
#          http://www.cexten.com  
/* vim: set sts=4 ts=4 expandtab : */

@define('LANG_CHARSET', 'gb2312');
@define('SQL_CHARSET', 'gb2312');
@define('DATE_LOCALES', 'zh_CN.GB2312, cn, zh, zh_GB, zh_CN');
@define('DATE_FORMAT_SHORT', '%Y-%m-%d %H:%M');
@define('WYSIWYG_LANG', 'en');
@define('NUMBER_FORMAT_DECIMALS', '2');
@define('NUMBER_FORMAT_DECPOINT', '.');
@define('NUMBER_FORMAT_THOUSANDS', ',');
@define('LANG_DIRECTION', 'ltr');

@define('SERENDIPITY_ADMIN_SUITE', 'Serendipity���ܲ���ϵͳ'); // ��̨����ҳ
@define('HAVE_TO_BE_LOGGED_ON', '���ȵ���');
@define('WRONG_USERNAME_OR_PASSWORD', '������ʺŻ���������');
@define('APPEARANCE', '��Ҫ����');
@define('MANAGE_STYLES', '�������');
@define('CONFIGURE_PLUGINS', '�趨���');
@define('CONFIGURATION', '�����趨');
@define('BACK_TO_BLOG', '��վ��ҳ');
@define('LOGIN', '����');
@define('LOGOUT', '�ǳ�');
@define('LOGGEDOUT', '�ǳ���');
@define('CREATE', '����');
@define('SAVE', '����');
@define('NAME', '����');
@define('CREATE_NEW_CAT', '���');
@define('I_WANT_THUMB', '��������ʹ����ͼ.');
@define('I_WANT_BIG_IMAGE', '��������ʹ�ô���ͼƬ.');
@define('I_WANT_NO_LINK', '��ͼƬ��ʾ');
@define('I_WANT_IT_TO_LINK', '��������ʾ�����ַ:');
@define('BACK', '����');
@define('FORWARD', 'ǰ��');
@define('ANONYMOUS', '����');
@define('NEW_TRACKBACK_TO', '�µ����õ�');
@define('NEW_COMMENT_TO', '�µĻظ���');
@define('RECENT', '���Ŀ�...');
@define('OLDER', '���Ŀ�...');
@define('DONE', '���');
@define('WELCOME_BACK', '�ǳ����˼�����,');
@define('TITLE', '����');
@define('DESCRIPTION', '���');
@define('PLACEMENT', '��ַ');
@define('DELETE', 'ɾ��');
@define('SAVE', '����');
@define('UP', '��');
@define('DOWN', '��');
@define('ENTRIES', '���¹���');
@define('NEW_ENTRY', '��������');
@define('EDIT_ENTRIES', '�༭����');
@define('CATEGORIES', '������');
@define('WARNING_THIS_BLAHBLAH', "����:\\n����кܶ�ͼƬ�Ļ���������Ҫ�ܳ�ʱ�䡣");
@define('CREATE_THUMBS', '�ؽ�ϸͼ');
@define('MANAGE_IMAGES', '����ͼƬ');
@define('NAME', '����');
@define('EMAIL', '����');
@define('HOMEPAGE', '��ַ');
@define('COMMENT', '�ظ�');
@define('REMEMBER_INFO', '��¼����');
@define('SUBMIT_COMMENT', '���ͻظ�');
@define('NO_ENTRIES_TO_PRINT', 'û������');
@define('COMMENTS', '�ظ�'); // ��ҳ
@define('ADD_COMMENT', '�����ظ�');
@define('NO_COMMENTS', 'û�лظ�');
@define('POSTED_BY', '����');
@define('ON', '��');
@define('A_NEW_COMMENT_BLAHBLAH', '�»ظ��ѷ�������վ "%s", ������������� "%s"��');
@define('A_NEW_TRACKBACK_BLAHBLAH', '������� "%s" �����µ����á�');
@define('NO_CATEGORY', 'û�����');
@define('ENTRY_BODY', '����������');
@define('EXTENDED_BODY', '���¸�����');
@define('CATEGORY', 'ȫ�����'); // ��ҳ
@define('EDIT', '�༭');
@define('NO_ENTRIES_BLAHBLAH', '�Ҳ�����ѯ %s ������' . "\n");
@define('YOUR_SEARCH_RETURNED_BLAHBLAH', '����Ѱ�� %s ��ʾ�� %s ���:');
@define('IMAGE', 'ͼƬ');
@define('ERROR_FILE_NOT_EXISTS', '����: �ļ������ڣ�');
@define('ERROR_FILE_EXISTS', '����: �ļ����ѱ�ʹ��, ���������룡');
@define('ERROR_SOMETHING', '����');
@define('ADDING_IMAGE', '����ͼƬ...');
@define('THUMB_CREATED_DONE', '��ͼ������<br>��ɣ�');
@define('ERROR_FILE_EXISTS_ALREADY', '����: �ļ��Ѵ���');
@define('ERROR_UNKNOWN_NOUPLOAD', '��������, �ļ�û���ϴ���������Ϊ����ļ��������ƵĴ�С�� ��ѯ����������̻��޸���� php.ini �ļ����ԡ�');
@define('GO', '����');
@define('NEWSIZE', '��С: ');
@define('RESIZE_BLAHBLAH', '<b>�����С %s</b>');
@define('ORIGINAL_SIZE', 'ԭ�еĴ�С: <i>%sx%s</i> ����');
@define('HERE_YOU_CAN_ENTER_BLAHBLAH', '<p>������������޸�ͼƬ��С�������Ҫ�޸ĳ���ͬ��ͼƬ����, ��ֻ��Ҫ����һ����ֵȻ�� TAB -- ϵͳ���Զ������������������</p>');
@define('QUICKJUMP_CALENDAR', '����������Ծ');
@define('QUICKSEARCH', '������Ѱ');
@define('SEARCH_FOR_ENTRY', '��Ѱ����');
@define('ARCHIVES', '���¹鵵');
@define('BROWSE_ARCHIVES', '���·ݱ�������');
@define('TOP_REFERRER', '��Ҫ��Դ');
@define('SHOWS_TOP_SITES', '��ʾ���ӵ������վ');
@define('TOP_EXITS', '��Ҫ��Դ');
@define('SHOWS_TOP_EXIT', '��ʾ��վ����Ҫ��Դ');
@define('SYNDICATION', '����ͬ��');
@define('SHOWS_RSS_BLAHBLAH', '��ʾ RSS ͬ������');
@define('ADVERTISES_BLAHBLAH', '���������־');
@define('HTML_NUGGET', 'HTML ��Ϣ');
@define('HOLDS_A_BLAHBLAH', '��ʾ HTML ѶϢ������');
@define('TITLE_FOR_NUGGET', '��Ϣ����');
@define('THE_NUGGET', 'HTML ѶϢ');
@define('SYNDICATE_THIS_BLOG', '���ϲ˵�');
@define('YOU_CHOSE', '��ѡ�� %s');
@define('IMAGE_SIZE', 'ͼƬ��С');
@define('IMAGE_AS_A_LINK', '����ͼƬ');
@define('POWERED_BY', '��վ��Ϣ');
@define('TRACKBACKS', '����');
@define('TRACKBACK', '����');
@define('NO_TRACKBACKS', 'û������');
@define('TOPICS_OF', '����');
@define('VIEW_FULL', '���ȫ��');
@define('VIEW_TOPICS', '�������');
@define('AT', 'ʱ��');
@define('SET_AS_TEMPLATE', 'ʹ������');
@define('IN', '����');
@define('EXCERPT', 'ժҪ');
@define('TRACKED', '����');
@define('LINK_TO_ENTRY', '���ӵ�����');
@define('LINK_TO_REMOTE_ENTRY', '���ӵ�Զ������');
@define('IP_ADDRESS', 'IP ��ַ');
@define('USER', '����');
@define('THUMBNAIL_USING_OWN', 'ʹ�� %s ��������ͼ�ߴ���ΪͼƬ�Ѿ���С�ˡ�');
@define('THUMBNAIL_FAILED_COPY', 'ʹ�� %s ��������ͼ, �����޷����ƣ�');
@define('AUTHOR', '������');
@define('LAST_UPDATED', '������');
@define('TRACKBACK_SPECIFIC', '���ô������ض�����ַ');
@define('DIRECT_LINK', 'ֱ�ӵ���������');
@define('COMMENT_ADDED', '��Ļظ��ѳɹ���� ');
@define('COMMENT_ADDED_CLICK', '�� %s���ﷵ��%s ���ظ�, �͵� %s����ر�%s ����Ӵ���');
@define('COMMENT_NOT_ADDED_CLICK', '�� %s���ﷵ��%s ���ظ�, �͵� %s����ر�%s ����Ӵ���');
@define('COMMENTS_DISABLE', '������ظ�����ƪ����');
@define('COMMENTS_ENABLE', '����ظ�����ƪ����');
@define('COMMENTS_CLOSED', '���߲�����ظ�����ƪ����');
@define('EMPTY_COMMENT', '��Ļظ�û���κ���Ϣ, �� %s����%s ����');
@define('ENTRIES_FOR', '���¸� %s');
@define('DOCUMENT_NOT_FOUND', '�Ҳ�����ƪ�ļ� %s');
@define('USERNAME', '�ʺ�');
@define('PASSWORD', '����');
@define('AUTOMATIC_LOGIN', '�Զ�����');
@define('SERENDIPITY_INSTALLATION', 'Serendipity ��װ����');
@define('LEFT', '��');
@define('RIGHT', '��');
@define('HIDDEN', '����');
@define('REMOVE_TICKED_PLUGINS', '�Ƴ���ѡ�����');
@define('SAVE_CHANGES_TO_LAYOUT', '������������');
@define('COMMENTS_FROM', '�ظ���Դ');
@define('ERROR', '����');
@define('ENTRY_SAVED', '��������ѱ���');
@define('DELETE_SURE', 'ȷ��Ҫɾ�� #%s ��');
@define('NOT_REALLY', '����...');
@define('DUMP_IT', 'ɾ��');
@define('RIP_ENTRY', 'R.I.P. ���� #%s');
@define('CATEGORY_DELETED_ARTICLES_MOVED', '��� #%s ��ɾ��. �������ѱ��ƶ������ #%s');
@define('CATEGORY_DELETED', '��� #%s ��ɾ����');
@define('INVALID_CATEGORY', 'û���ṩɾ�������');
@define('CATEGORY_SAVED', '����ѱ���');
@define('SELECT_TEMPLATE', '��ѡ����־������');
@define('ENTRIES_NOT_SUCCESSFULLY_INSERTED', 'û������������£�');
@define('MT_DATA_FILE', 'Movable Type ����');
@define('FORCE', 'ǿ��');
@define('CREATE_AUTHOR', '�������� \'%s\'.');
@define('CREATE_CATEGORY', '������� \'%s\'.');
@define('MYSQL_REQUIRED', '�����Ҫ�� MySQL �����书�ܲ���ִ���������');
@define('COULDNT_CONNECT', '�������ӵ� MySQL ���Ͽ�: %s.');
@define('COULDNT_SELECT_DB', '����ѡ�����ݿ�: %s.');
@define('COULDNT_SELECT_USER_INFO', '����ѡ��ʹ���ߵ�����: %s.');
@define('COULDNT_SELECT_CATEGORY_INFO', '����ѡ����������: %s.');
@define('COULDNT_SELECT_ENTRY_INFO', '����ѡ�����µ�����: %s.');
@define('COULDNT_SELECT_COMMENT_INFO', '����ѡ��ظ�������: %s.');
@define('YES', '��');
@define('NO', '��');
@define('USE_DEFAULT', 'Ԥ��');
@define('CHECK_N_SAVE', '����');
@define('DIRECTORY_WRITE_ERROR', '���ܶ�д�ļ��� %s������Ȩ�ޣ�');
@define('DIRECTORY_CREATE_ERROR', '�ļ��� %s ������Ҳ�޷����������Լ���������ļ��У�');
@define('DIRECTORY_RUN_CMD', '&nbsp;-&gt; run <i>%s %s</i>');
@define('CANT_EXECUTE_BINARY', '�޷�ִ�� %s �ļ���');
@define('FILE_WRITE_ERROR', '�޷���д�ļ� %s��');
@define('FILE_CREATE_YOURSELF', '���Լ���������ļ�����Ȩ��');
@define('COPY_CODE_BELOW', '<br />* �븴������Ĵ���Ȼ����� %s ����� %s �ļ���:<b><pre>%s</pre></b>' . "\n");
@define('WWW_USER', '��ı� www ��ʹ���ߵ� Apache (i.e. nobody)��');
@define('BROWSER_RELOAD', '���֮��, ����ˢ����������.');
@define('DIAGNOSTIC_ERROR', 'ϵͳ��⵽һЩ����:');
@define('SERENDIPITY_NOT_INSTALLED', 'Serendipity ��û��װ���. �밴 <a href="%s">��װ</a>.');
@define('INCLUDE_ERROR', 'serendipity ����: �޷����� %s - �˳���');
@define('DATABASE_ERROR', 'serendipity ����: �޷����ӵ��� - �˳���');
@define('CHECK_DATABASE_EXISTS', '������ݿ��Ƿ���ڡ� ����㿴�����ݿ��ѯ����, �Ƿ���Ҫ��װ...');
@define('CREATE_DATABASE', '����Ԥ�����ݿ���趨...');
@define('ATTEMPT_WRITE_FILE', '��д %s �ļ�...');
@define('SERENDIPITY_INSTALLED', 'Serendipity �������İ汾 �Ѱ�װ��ɣ�%s ��ǵ��������: "%s", ����ʺ��� "%s".%s�����ڿ��Ե��½����� <a href="%s">�����ռ�</a>');
@define('WRITTEN_N_SAVED', '�������');
@define('IMAGE_ALIGNMENT', 'ͼƬ����');
@define('ENTER_NEW_NAME', '����������: ');
@define('RESIZING', '�����С');
@define('RESIZE_DONE', '��� (���� %s ��ͼƬ)');
@define('SYNCING', '�������ݿ��ͼƬ�ļ�������ͬ��');
@define('SYNC_OPTION_LEGEND', 'Thumbnail Synchronization Options');
@define('SYNC_OPTION_KEEPTHUMBS', 'Keep all existing thumbnails');
@define('SYNC_OPTION_SIZECHECKTHUMBS', 'Keep existing thumbnails only if they are the correct size');
@define('SYNC_OPTION_DELETETHUMBS', 'Regenerate all thumbnails');
@define('SYNC_DONE', '��� (ͬ���� %s ��ͼƬ)');
@define('FILE_NOT_FOUND', '�Ҳ����ļ� <b>%s</b>, �����ѱ�ɾ��');
@define('ABORT_NOW', '����');
@define('REMOTE_FILE_NOT_FOUND', '�ļ�����Զ��������, ��ȷ�������ַ: <b>%s</b> ����ȷ�ġ�');
@define('FILE_FETCHED', '%s ȡ��Ϊ %s');
@define('FILE_UPLOADED', '�ļ� %s �ϴ�Ϊ %s');
@define('WORD_OR', '��');
@define('SCALING_IMAGE', '���� %s �� %s x %s ����');
@define('KEEP_PROPORTIONS', 'ά�ֱ���');
@define('REALLY_SCALE_IMAGE', 'ȷ��Ҫ����ͼƬ��? ����������ָܻ���');
@define('TOGGLE_ALL', '�л�չ��');
@define('TOGGLE_OPTION', '�л�ѡ��');
@define('SUBSCRIBE_TO_THIS_ENTRY', '������ƪ����');
@define('UNSUBSCRIBE_OK', "%s ��ȡ��������ƪ����");
@define('NEW_COMMENT_TO_SUBSCRIBED_ENTRY', '�»ظ������ĵ����� "%s"');
@define('SUBSCRIPTION_MAIL', "��� %s,\n\n�㶩�ĵ����������µĻظ��� \"%s\", ������ \"%s\"\n�ظ��ķ�������: %s\n\n����������ҵ�������: %s\n\n����Ե��������ȡ������: %s\n");
@define('SUBSCRIPTION_TRACKBACK_MAIL', "��� %s,\n\n�㶩�ĵ����������µ������� \"%s\", ������ \"%s\"\n���õ�������: %s\n\n����������ҵ�������: %s\n\n����Ե��������ȡ������: %s\n");
@define('SIGNATURE', "\n-- \n%s is powered by Serendipity.\n <http://www.s9y.org>");
@define('SYNDICATION_PLUGIN_091', 'RSS 0.91 feed');
@define('SYNDICATION_PLUGIN_10', 'RSS 1.0 feed');
@define('SYNDICATION_PLUGIN_20', 'RSS 2.0 feed');
@define('SYNDICATION_PLUGIN_20c', 'RSS 2.0 comments');
@define('SYNDICATION_PLUGIN_ATOM03', 'ATOM 0.3 feed');
@define('SYNDICATION_PLUGIN_MANAGINGEDITOR', '�˵� "managingEditor"');
@define('SYNDICATION_PLUGIN_WEBMASTER',  '�˵� "webMaster"');
@define('SYNDICATION_PLUGIN_BANNERURL', 'RSS feed ��ͼƬ');
@define('SYNDICATION_PLUGIN_BANNERWIDTH', 'ͼƬ���');
@define('SYNDICATION_PLUGIN_BANNERHEIGHT', 'ͼƬ�߶�');
@define('SYNDICATION_PLUGIN_WEBMASTER_DESC',  '����Ա�ĵ����ʼ�, ����У� (�հ�: ����) [RSS 2.0]');
@define('SYNDICATION_PLUGIN_MANAGINGEDITOR_DESC', '���ߵĵ����ʼ�, ����У� (�հ�: ����) [RSS 2.0]');
@define('SYNDICATION_PLUGIN_BANNERURL_DESC', 'ͼƬ��λַ URL, �� GIF/JPEG/PNG ��ʽ, ����У� (�հ�: serendipity-logo)');
@define('SYNDICATION_PLUGIN_BANNERWIDTH_DESC', '����, ���. 144');
@define('SYNDICATION_PLUGIN_BANNERHEIGHT_DESC', '����, ���. 400');
@define('SYNDICATION_PLUGIN_TTL', '�˵� "ttl" (time-to-live)');
@define('SYNDICATION_PLUGIN_TTL_DESC', '�ڼ����Ӻ����²��ᱻ��������վ������¼ (�հ�: ����) [RSS 2.0]');
@define('SYNDICATION_PLUGIN_PUBDATE', '��λ "pubDate"');
@define('SYNDICATION_PLUGIN_PUBDATE_DESC', '"pubDate"-�˵���Ҫ��Ƕ��RSS-Ƶ��, ����ʾ������µ�������');
@define('CONTENT', '����');
@define('TYPE', '����');
@define('DRAFT', '�ݸ�');
@define('PUBLISH', '����');
@define('PREVIEW', 'Ԥ��');
@define('DATE', '����');
@define('DATE_FORMAT_2', 'Y-m-d H:i'); // Needs to be ISO 8601 compliant for date conversion!
@define('DATE_INVALID', '����: �ṩ�����ڲ���ȷ. �������� YYYY-MM-DD HH:MM �ĸ�ʽ');
@define('CATEGORY_PLUGIN_DESC', '��ʾ����嵥');
@define('ALL_AUTHORS', 'ȫ������');
@define('CATEGORIES_TO_FETCH', '��ʾ���');
@define('CATEGORIES_TO_FETCH_DESC', '��ʾ��λ���ߵ����');
@define('PAGE_BROWSE_ENTRIES', 'ҳ�� %s �� %s, �ܹ� %s ƪ����');
@define('PREVIOUS_PAGE', '��һҳ');
@define('NEXT_PAGE', '��һҳ');
@define('ALL_CATEGORIES', 'ȫ�����');
@define('DO_MARKUP', 'ִ�б��ת��');
@define('GENERAL_PLUGIN_DATEFORMAT', '���ڸ�ʽ');
@define('GENERAL_PLUGIN_DATEFORMAT_BLAHBLAH', '���µ����ڸ�ʽ, ʹ�� PHP �� strftime() ����. (Ԥ��: "%s")');
@define('ERROR_TEMPLATE_FILE', '�޷����������ļ�, �����ϵͳ��');
@define('ADVANCED_OPTIONS', '�߼�ѡ��');
@define('EDIT_ENTRY', '�༭����');
@define('HTACCESS_ERROR', 'Ҫ�����İ�װ�趨, ϵͳ��Ҫ��д ".htaccess"��������ΪȨ�޴���, û�а취Ϊ���飬��ı��ļ�Ȩ��: <br />&nbsp;&nbsp;%s<br />Ȼ��ˢ�¡�');
@define('SIDEBAR_PLUGINS', '�������');
@define('EVENT_PLUGINS', '�¼����');
@define('SORT_ORDER', '����');
@define('SORT_ORDER_NAME', '�ļ�����');
@define('SORT_ORDER_EXTENSION', '���ļ���');
@define('SORT_ORDER_SIZE', '�ļ���С');
@define('SORT_ORDER_WIDTH', 'ͼƬ���');
@define('SORT_ORDER_HEIGHT', 'ͼƬ����');
@define('SORT_ORDER_DATE', '�ϴ�����');
@define('SORT_ORDER_ASC', '��������');
@define('SORT_ORDER_DESC', '�ݼ�����');
@define('THUMBNAIL_SHORT', '��ͼ');
@define('ORIGINAL_SHORT', 'ԭʼ');
@define('APPLY_MARKUP_TO', '���ñ�ǵ� %s');
@define('CALENDAR_BEGINNING_OF_WEEK', 'һ�ܵĵ�һ��');
@define('SERENDIPITY_NEEDS_UPGRADE', 'ϵͳ����İ汾�� %s, �� Serendipity ���ڵİ汾�� %s, �������ĳ���<a href="%s">����</a>');
@define('SERENDIPITY_UPGRADER_WELCOME', '���, ��ӭʹ�� Serendipity �ĸ��³���');
@define('SERENDIPITY_UPGRADER_PURPOSE', '���³���������µ� Serendipity �汾 %s.');
@define('SERENDIPITY_UPGRADER_WHY', '���Ѿ����� Serendipity %s, �����ϵͳû�и���������ݿ⣡');
@define('SERENDIPITY_UPGRADER_DATABASE_UPDATES', '���ݿ���� (%s)');
@define('SERENDIPITY_UPGRADER_FOUND_SQL_FILES', 'ϵͳ�ҵ����µ� .sql ��, ��Щ���ݱ�����ִ�в��ܼ�����װ Serendipity');
@define('SERENDIPITY_UPGRADER_VERSION_SPECIFIC',  '�ض��İ汾����');
@define('SERENDIPITY_UPGRADER_NO_VERSION_SPECIFIC', 'û���ض��İ汾����');
@define('SERENDIPITY_UPGRADER_PROCEED_QUESTION', 'ȷ��Ҫִ�����ϵ�������?');
@define('SERENDIPITY_UPGRADER_PROCEED_ABORT', '���Լ�ִ��');
@define('SERENDIPITY_UPGRADER_PROCEED_DOIT', '�����ִ��');
@define('SERENDIPITY_UPGRADER_NO_UPGRADES', '����Ҫ�����κθ���');
@define('SERENDIPITY_UPGRADER_CONSIDER_DONE', 'Serendipity �������');
@define('SERENDIPITY_UPGRADER_YOU_HAVE_IGNORED', '�������˸�������, ��ȷ�����ݿ��Ѱ�װ���, ������������װ����');
@define('SERENDIPITY_UPGRADER_NOW_UPGRADED', '��� Serendipity �Ѿ����°汾Ϊ %s');
@define('SERENDIPITY_UPGRADER_RETURN_HERE', '����Ե� %s����%s ������վ��ҳ');
@define('MANAGE_USERS', '��������');
@define('CREATE_NEW_USER', '��������');
@define('CREATE_NOT_AUTHORIZED', '�㲻���޸ĸ�����ͬȨ�޵�����');
@define('CREATE_NOT_AUTHORIZED_USERLEVEL', '�㲻�������������Ȩ�޵�����');
@define('CREATED_USER', '������ %s �Ѿ�����');
@define('MODIFIED_USER', '���� %s �������Ѿ�����');
@define('USER_LEVEL', '����Ȩ��');
@define('DELETE_USER', '��Ҫɾ��������� #%d %s? �������ҳ��������д���κ����¡�');
@define('DELETED_USER', '���� #%d %s �ѱ�ɾ��.');
@define('LIMIT_TO_NUMBER', 'Ҫ��ʾ������');
@define('ENTRIES_PER_PAGE', 'ÿҳ��ʾ������');
@define('XML_IMAGE_TO_DISPLAY', 'XML ��ť');
@define('XML_IMAGE_TO_DISPLAY_DESC','���ӵ� XML Feeds �Ķ��������ͼƬ��ʾ. ����д����ʹ��Ԥ���ͼƬ, ������ \'none\' �ر�������ܡ�');

@define('DIRECTORIES_AVAILABLE', '����������ｨ��ý���ŵ�Ŀ¼');
@define('ALL_DIRECTORIES', 'ȫ��Ŀ¼');
@define('MANAGE_DIRECTORIES', '����Ŀ¼');
@define('DIRECTORY_CREATED', 'Ŀ¼ <strong>%s</strong> �Ѿ�����');
@define('PARENT_DIRECTORY', '��Ŀ¼');
@define('CONFIRM_DELETE_DIRECTORY', 'ȷ��Ҫɾ�����Ŀ¼�ڵ�ȫ������ %s');
@define('ERROR_NO_DIRECTORY', '����: Ŀ¼ %s ������');
@define('CHECKING_DIRECTORY', '����Ŀ¼���ļ� %s');
@define('DELETING_FILE', 'ɾ���ļ� %s...');
@define('ERROR_DIRECTORY_NOT_EMPTY', '����ɾ��δ��յ�Ŀ¼. ��ѡ "ǿ��ɾ��" �����ȷ��Ҫɾ����Щ�ļ�, Ȼ���ڼ����� ���ڵ��ļ���:');
@define('DIRECTORY_DELETE_FAILED', '����ɾ��Ŀ¼ %s. ����Ȩ�޻������ѶϢ.');
@define('DIRECTORY_DELETE_SUCCESS', 'Ŀ¼ %s �ɹ�ɾ��.');
@define('SKIPPING_FILE_EXTENSION', '�����ļ�: û�� %s �ĸ�����');
@define('SKIPPING_FILE_UNREADABLE', '�Թ��ļ�: %s ���ܶ�ȡ');
@define('FOUND_FILE', '�ҵ� ��/�޸� ���ĵ���: %s');
@define('ALREADY_SUBCATEGORY', '%s �Ѿ��Ǵ������ӷ��� %s');
@define('PARENT_CATEGORY', '�����');
@define('IN_REPLY_TO', '�ظ���');
@define('TOP_LEVEL', '��߲�');
@define('SYNDICATION_PLUGIN_GENERIC_FEED', '%s feed');
@define('PERMISSIONS', 'Ȩ��');
@define('INTEGRITY', 'Verify Installation Integrity');
@define('CHECKSUMS_NOT_FOUND', 'Unable to compare checksums! (No checksums.inc.php in main directory)');
@define('CHECKSUMS_PASS', 'All required files verified.');
@define('CHECKSUM_FAILED', '%s corrupt or modified: failed verification');
@define('SETTINGS_SAVED_AT', '���趨�Ѿ������浽 %s');

/* DATABASE SETTINGS */
@define('INSTALL_CAT_DB', '���ݿ��趨');
@define('INSTALL_CAT_DB_DESC', '�������������ȫ�������ݿ����ϣ�ϵͳ��Ҫ��Щ���ϲ�����������');
@define('INSTALL_DBTYPE', '���ݿ�����');
@define('INSTALL_DBTYPE_DESC', '���ݿ�����');
@define('INSTALL_DBHOST', '���ݿ�����');
@define('INSTALL_DBHOST_DESC', '���ݿ���������');
@define('INSTALL_DBUSER', '���ݿ��ʺ�');
@define('INSTALL_DBUSER_DESC', '�������ݿ���ʺ�');
@define('INSTALL_DBPASS', '��������');
@define('INSTALL_DBPASS_DESC', '������ݿ�����');
@define('INSTALL_DBNAME', '��������');
@define('INSTALL_DBNAME_DESC', '���Ͽ�����');
@define('INSTALL_DBPREFIX', '��ǰ������');
@define('INSTALL_DBPREFIX_DESC', '���ǰ������, ���� serendipity_');

/* PATHS */
@define('INSTALL_CAT_PATHS', '·���趨');
@define('INSTALL_CAT_PATHS_DESC', '���ļ��е�·��. ��Ҫ��������б��!');
@define('INSTALL_FULLPATH', '��ȫ·��');
@define('INSTALL_FULLPATH_DESC', 'ϵͳ��װ������·���;���·��');
@define('INSTALL_UPLOADPATH', '�ϴ�·��');
@define('INSTALL_UPLOADPATH_DESC', 'ȫ���ϴ����ļ���浽����, �� \'��ȫ·��\' ��ʾ�����·�� - ���� \'uploads/\'');
@define('INSTALL_RELPATH', '���·��');
@define('INSTALL_RELPATH_DESC', '���������·��, ���� \'/serendipity/\'');
@define('INSTALL_RELTEMPLPATH', '��Ե�����·��');
@define('INSTALL_RELTEMPLPATH_DESC', '�����·�� - �� \'���·��\' ��ʾ�����·��');
@define('INSTALL_RELUPLOADPATH', '��Ե��ϴ�·��');
@define('INSTALL_RELUPLOADPATH_DESC', '��������ϴ��ļ���·�� - �� \'���·��\' ��ʾ�����·��');
@define('INSTALL_URL', '��վ��ַ');
@define('INSTALL_URL_DESC', 'ϵͳ��װ�Ļ�����ַ');
@define('INSTALL_INDEXFILE', 'Index �ļ�');
@define('INSTALL_INDEXFILE_DESC', 'ϵͳ�� index �ļ�');

/* Generel settings */
@define('INSTALL_CAT_SETTINGS', 'һ���趨');
@define('INSTALL_CAT_SETTINGS_DESC', 'ϵͳ��һ���趨');
@define('INSTALL_USERNAME', '����Ա�ʺ�');
@define('INSTALL_USERNAME_DESC', '����Ա��½ϵͳ���ʺ�');
@define('INSTALL_PASSWORD', '����Ա����');
@define('INSTALL_PASSWORD_DESC', '����Ա��½ϵͳ������');
@define('INSTALL_EMAIL', '�����ʼ�');
@define('INSTALL_EMAIL_DESC', '����Ա�ĵ����ʼ�');
@define('INSTALL_SENDMAIL', '���͵����ʼ�������Ա��');
@define('INSTALL_SENDMAIL_DESC', '�����˻ظ��������ʱҪ�յ������ʼ�֪ͨ��');
@define('INSTALL_SUBSCRIBE', '����ʹ���߶�������?');
@define('INSTALL_SUBSCRIBE_DESC', '���������ʹ�����յ������ʼ�֪ͨ, ���лظ�ʱ���ǻ��յ�֪ͨ��');
@define('INSTALL_BLOGNAME', '��վ����');
@define('INSTALL_BLOGNAME_DESC', '����վ������');
@define('INSTALL_BLOGDESC', '��վ���');
@define('INSTALL_BLOGDESC_DESC', '���������־');
@define('INSTALL_LANG', '����');
@define('INSTALL_LANG_DESC', '����վʹ�õ�����');

/* Appearance and options */
@define('INSTALL_CAT_DISPLAY', '���⼰ѡ���趨');
@define('INSTALL_CAT_DISPLAY_DESC', '�趨ϵͳ������������趨');
@define('INSTALL_WYSIWYG', 'ʹ�� WYSIWYG �༭��');
@define('INSTALL_WYSIWYG_DESC', '��Ҫʹ�� WYSIWYG �༭����(���� IE5+ ʹ��, ĳЩ���ֿ�ʹ���� Mozilla 1.3+)');
@define('INSTALL_XHTML11', 'ǿ�Ʒ��� XHTML 1.1 Ҫ��');
@define('INSTALL_XHTML11_DESC', '�����ϵͳǿ�Ʒ��� XHTML 1.1 Ҫ�� (�Ծɵ����������������)');
@define('INSTALL_POPUP', 'ʹ�õ�������');
@define('INSTALL_POPUP_DESC', '��Ҫ�ڻظ������õȵط�ʹ�õ���������');
@define('INSTALL_EMBED', 'ʹ����Ƕ����?');
@define('INSTALL_EMBED_DESC', '�����Ҫ�� Serendipity ����Ƕ�ķ�ʽ�ŵ���ҳ��, ѡ�� �� ����������κα���Ȼ��ֻ��ʾ��վ���ݡ� ������� indexFile ���趨������ܡ��������ѯ README �ļ�!');
@define('INSTALL_TOP_AS_LINKS', '�����ӷ�ʽ��ʾ ��Ҫ��Դ/��Ҫ��Դ');
@define('INSTALL_TOP_AS_LINKS_DESC', '"��": ��Դ����Դ����������ʾ������ google �Ĺ�档 "��": ��Դ����Դ����������ʾ. "Ԥ��": ��ȫ��������趨 (����)');
@define('INSTALL_BLOCKREF', '�赲��Դ');
@define('INSTALL_BLOCKREF_DESC', '���������վ������Դ����ʾ��? �� \';\' ���ֿ���վ����, ע����������ַ���ʽ�赲�ģ�');
@define('INSTALL_REWRITE', 'URL Rewriting');
@define('INSTALL_REWRITE_DESC', '��ѡ�� URL Rewriting ��ʽ������ rewrite ������ԱȽ�����ķ�ʽ��ʾ URL, �Ա�������վ����ȷ����¼������£����������������֧�� mod_rewrite �� "AllowOverride All" �Ĺ��ܡ�[Ԥ����趨��ϵͳ�Զ�������]');

/* Imageconversion Settings */
@define('INSTALL_CAT_IMAGECONV', 'ͼƬת���趨');
@define('INSTALL_CAT_IMAGECONV_DESC', '���趨ͼƬת���ķ�ʽ');
@define('INSTALL_IMAGEMAGICK', 'ʹ�� Imagemagick');
@define('INSTALL_IMAGEMAGICK_DESC', '�����װ image magick, ��Ҫ�������ı�ͼƬ��С��?');
@define('INSTALL_IMAGEMAGICKPATH', 'ת����ʽ·��');
@define('INSTALL_IMAGEMAGICKPATH_DESC', 'image magick ת����ʽ����ȫ·��������');
@define('INSTALL_THUMBSUFFIX', '��ͼ�����ַ�');
@define('INSTALL_THUMBSUFFIX_DESC', '��ͼ��������ĸ�ʽ��������: original.[�����ַ�].ext');
@define('INSTALL_THUMBWIDTH', '��ͼ��С');
@define('INSTALL_THUMBWIDTH_DESC', '�Զ�������ͼ�������');
@define('INSTALL_THUMBDIM', 'Thumbnail constrained dimension');
@define('INSTALL_THUMBDIM_LARGEST', 'Largest');
@define('INSTALL_THUMBDIM_WIDTH', 'Width');
@define('INSTALL_THUMBDIM_HEIGHT', 'Height');
@define('INSTALL_THUMBDIM_DESC', 'Dimension to be constrained to the thumbnail max size. The default "' . 
    INSTALL_THUMBDIM_LARGEST .  '" limits both dimensions, so neither can be greater than the max size; "' . 
    INSTALL_THUMBDIM_WIDTH . '" and "' .  INSTALL_THUMBDIM_HEIGHT . 
    '" only limit the chosen dimension, so the other could be larger than the max size.');

/* Personal details */
@define('USERCONF_CAT_PERSONAL', '���������趨');
@define('USERCONF_CAT_PERSONAL_DESC', '�ı���ĸ�������');
@define('USERCONF_USERNAME', '����ʺ�');
@define('USERCONF_USERNAME_DESC', '�����ϵͳ������');
@define('USERCONF_PASSWORD', '�������');
@define('USERCONF_PASSWORD_DESC', '�����ϵͳ������');
@define('USERCONF_EMAIL', '��ĵ����ʼ�');
@define('USERCONF_EMAIL_DESC', '��ʹ�õĵ����ʼ�');
@define('USERCONF_SENDCOMMENTS', '���ͻظ�֪ͨ');
@define('USERCONF_SENDCOMMENTS_DESC', '�����»ظ�ʱʹ��֪ͨ');
@define('USERCONF_SENDTRACKBACKS', '��������֪ͨ?');
@define('USERCONF_SENDTRACKBACKS_DESC', '����������ʱʹ��֪ͨ');
@define('USERCONF_ALLOWPUBLISH', 'Ȩ��: �ɷ�������');
@define('USERCONF_ALLOWPUBLISH_DESC', '������λ���߷�������');
@define('SUCCESS', '���');
@define('POWERED_BY_SHOW_TEXT', '��������ʾ "Serendipity"');
@define('POWERED_BY_SHOW_TEXT_DESC', '����������ʾ "Serendipity Weblog"');
@define('POWERED_BY_SHOW_IMAGE', '�� logo ��ʾ "Serendipity"');
@define('POWERED_BY_SHOW_IMAGE_DESC', '��ʾ Serendipity �� logo');
@define('PLUGIN_ITEM_DISPLAY', '����Ŀ����ʾ��ַ');
@define('PLUGIN_ITEM_DISPLAY_EXTENDED', 'ֻ�ڸ�������ʾ');
@define('PLUGIN_ITEM_DISPLAY_OVERVIEW', 'ֻ�ڿ������ʾ');
@define('PLUGIN_ITEM_DISPLAY_BOTH', '��Զ��ʾ');

@define('COMMENTS_WILL_BE_MODERATED', '�����Ļظ���Ҫ����Ա���');
@define('YOU_HAVE_THESE_OPTIONS', '��������ѡ��:');
@define('THIS_COMMENT_NEEDS_REVIEW', '����: ����ظ�����˲Ż���ʾ��');
@define('DELETE_COMMENT', 'ɾ���ظ�');
@define('APPROVE_COMMENT', '��˻ظ�');
@define('REQUIRES_REVIEW', '��Ҫ���');
@define('COMMENT_APPROVED', '�ظ� #%s �Ѿ�ͨ�����');
@define('COMMENT_DELETED', '�ظ� #%s �Ѿ��ɹ�ɾ��');
@define('COMMENTS_MODERATE', '�ظ���������Ҫ����Ա���');
@define('THIS_TRACKBACK_NEEDS_REVIEW', '����: ���������Ҫ����Ա��˲Ż���ʾ��');
@define('DELETE_TRACKBACK', 'ɾ������');
@define('APPROVE_TRACKBACK', '�������');
@define('TRACKBACK_APPROVED', '���� #%s �Ѿ�ͨ�����');
@define('TRACKBACK_DELETED', '���� #%s �Ѿ��ɹ�ɾ��');
@define('VIEW', '���');
@define('COMMENT_ALREADY_APPROVED', '�ظ� #%s �Ѿ�ͨ�����');
@define('COMMENT_EDITED', '�����ѱ��༭');
@define('HIDE', '����');
@define('VIEW_EXTENDED_ENTRY', '�����Ķ� "%s"');
@define('TRACKBACK_SPECIFIC_ON_CLICK', '������Ӳ����������. ��������������µ����� URI. ����Դ���� URI ������ ping �����õ��������. ���Ҫ�����������, �������ϵ��Ҽ�Ȼ��ѡ�� "��������" (IE) �� "�������ӵ�ַ" (Mozilla).');
@define('PLUGIN_SUPERUSER_HTTPS', '�� https ����');
@define('PLUGIN_SUPERUSER_HTTPS_DESC', 'ʹ�� https ��ַ�������������֧�������');
@define('INSTALL_SHOW_EXTERNAL_LINKS', '���ⲿ������ʾ');
@define('INSTALL_SHOW_EXTERNAL_LINKS_DESC', '"��": �ⲿ���� (��Ҫ��Դ, ��Ҫ��Դ, �ظ�) ��������������ʾ������ google ��� (����ʹ��)�� "��": �������ӽ��Գ����ӵķ�ʽ��ʾ�� �����ڲ�����Ҹ��Ǵ��趨��');
@define('PAGE_BROWSE_COMMENTS', 'ҳ�� %s �� %s, �ܹ� %s ���ظ�');
@define('FILTERS', '����');
@define('FIND_ENTRIES', '��������');
@define('FIND_COMMENTS', '�����ظ�');
@define('FIND_MEDIA', '����ý��');
@define('FILTER_DIRECTORY', 'Ŀ¼');
@define('SORT_BY', '����');
@define('TRACKBACK_COULD_NOT_CONNECT', 'û���ͳ�����: �޷�����·���� %s �����ӵ� %d');
@define('MEDIA', 'ý�����');
@define('MEDIA_LIBRARY', 'ý��ͼ��');
@define('ADD_MEDIA', '����ý��');
@define('ENTER_MEDIA_URL', '�������ļ���ַ:');
@define('ENTER_MEDIA_UPLOAD', '��ѡ��Ҫ�ϴ����ļ�:');
@define('SAVE_FILE_AS', '�����ļ�:');
@define('STORE_IN_DIRECTORY', '���浽����Ŀ¼: ');
@define('ADD_MEDIA_BLAHBLAH', '<b>�����ļ���ý��Ŀ¼:</b><p>������ϴ�ý���ļ�, �����ϵͳ����Ѱ�ҡ������û����Ҫ��ͼƬ, ����Ե� <a href="http://images.google.com" target="_blank">google����ͼƬ</a>.<p><b>ѡ��ʽ:</b><br>');
@define('MEDIA_RENAME', '�����ļ�����');
@define('IMAGE_RESIZE', '����ͼƬ�ߴ�');
@define('MEDIA_DELETE', 'ɾ������ļ�');
@define('FILES_PER_PAGE', 'ÿҳ��ʾ���ļ���');
@define('CLICK_FILE_TO_INSERT', '��ѡ��Ҫ������ļ�:');
@define('SELECT_FILE', 'ѡ��Ҫ������ļ�');
@define('MEDIA_FULLSIZE', '�����ߴ�');
@define('CALENDAR_BOW_DESC', 'һ�����ڵĵ�һ��[Ԥ��������һ]');
@define('SUPERUSER', 'ϵͳ����');
@define('ALLOWS_YOU_BLAHBLAH', '�ڲ����ṩ���ӵ���־����');
@define('CALENDAR', 'վ������');
@define('SUPERUSER_OPEN_ADMIN', '��������ҳ��');
@define('SUPERUSER_OPEN_LOGIN', '��������ҳ��');
@define('INVERT_SELECTIONS', '����ѡ');
@define('COMMENTS_DELETE_CONFIRM', 'ȷ��Ҫɾ����ѡ�Ļظ���');
@define('COMMENT_DELETE_CONFIRM', 'ȷ��Ҫɾ���ظ� #%d, �������� %s��');
@define('DELETE_SELECTED_COMMENTS', 'ɾ����ѡ�Ļظ�');
@define('VIEW_COMMENT', '����ظ�');
@define('VIEW_ENTRY', '�������');
@define('DELETE_FILE_FAIL' , '�޷�ɾ���ļ� <b>%s</b>');
@define('DELETE_THUMBNAIL', 'ɾ��ͼƬ��ͼ <b>%s</b>');
@define('DELETE_FILE', 'ɾ���ļ� <b>%s</b>');
@define('ABOUT_TO_DELETE_FILE', '�㽫ɾ���ļ� <b>%s</b><br />���������������������ʹ������ļ�, �Ǹ����ӻ�ͼƬ������Ч<br />ȷ��Ҫ������<br /><br />');
@define('TRACKBACK_SENDING', '�������õ� URI %s...');
@define('TRACKBACK_SENT', '�������');
@define('TRACKBACK_FAILED', '���ô���: %s');
@define('TRACKBACK_NOT_FOUND', '�Ҳ������õĵ�ַ');
@define('TRACKBACK_URI_MISMATCH', '�Զ���Ѱ�����ø�����Ŀ�겻��ͬ.');
@define('TRACKBACK_CHECKING', '��Ѱ <u>%s</u> ������...');
@define('TRACKBACK_NO_DATA', 'Ŀ��û���κ�����');
@define('TRACKBACK_SIZE', 'Ŀ���ַ����������� %s bytes �ļ���С.');
@define('COMMENTS_VIEWMODE_THREADED', '���߳�');
@define('COMMENTS_VIEWMODE_LINEAR', 'ֱ�߳�');
@define('DISPLAY_COMMENTS_AS', '�ظ���ʾ��ʽ');
@define('COMMENTS_FILTER_SHOW', '��ʾ');
@define('COMMENTS_FILTER_ALL', 'ȫ��');
@define('COMMENTS_FILTER_APPROVED_ONLY', '��ʾ��˻ظ�');
@define('COMMENTS_FILTER_NEED_APPROVAL', '��ʾ�ȴ����');
@define('RSS_IMPORT_BODYONLY', '����������ַŵ�������, �����𿪹��������µ�������');
@define('SYNDICATION_PLUGIN_FULLFEED', '�� RSS feed ����ʾȫ��������');
@define('WEEK', '��');
@define('WEEKS', '��');
@define('MONTHS', '��');
@define('DAYS', '��');
@define('ARCHIVE_FREQUENCY', '�����ļ���Ƶ��');
@define('ARCHIVE_FREQUENCY_DESC', '�����ļ�ʹ�õ���Ŀ�嵥���');
@define('ARCHIVE_COUNT', '�����ļ�����Ŀ��');
@define('ARCHIVE_COUNT_DESC', '��ʾ����, ��, ����');
@define('BELOW_IS_A_LIST_OF_INSTALLED_PLUGINS', '�����ǰ�װ�õ����');
@define('SIDEBAR_PLUGIN', '�������');
@define('EVENT_PLUGIN', '�¼����');
@define('CLICK_HERE_TO_INSTALL_PLUGIN', '�����ﰲװ�� %s');
@define('VERSION', '�汾');
@define('INSTALL', '��װ');
@define('ALREADY_INSTALLED', '�Ѿ���װ');
@define('SELECT_A_PLUGIN_TO_ADD', '��ѡ��Ҫ��װ�����');
@define('RSS_IMPORT_CATEGORY', '�������������ͬ������');

@define('INSTALL_OFFSET', '����ʱ��'); // Translate
@define('STICKY_POSTINGS', '�ö�����'); // Translate
@define('INSTALL_FETCHLIMIT', '����ҳ��ʾ������'); // Translate
@define('INSTALL_FETCHLIMIT_DESC', '����ҳ��ʾ���µ�����'); // Translate
@define('IMPORT_ENTRIES', '��������'); // Translate
@define('EXPORT_ENTRIES', '��������'); // Translate
@define('IMPORT_WELCOME', '��ӭʹ��Serendipity������ת������'); // Translate
@define('IMPORT_WHAT_CAN', '����Ե����������������'); // Translate
@define('IMPORT_SELECT', '��ѡ����Ҫ����ĳ���'); // Translate
@define('IMPORT_PLEASE_ENTER', '����������'); // Translate
@define('IMPORT_NOW', '��ʼ����'); // Translate
@define('IMPORT_STARTING', '���ڵ���...'); // Translate
@define('IMPORT_FAILED', '����ʧ��'); // Translate
@define('IMPORT_DONE', '����ɹ�'); // Translate
@define('IMPORT_WEBLOG_APP', '����'); // Translate
@define('EXPORT_FEED', '��� RSS feed'); // Translate
@define('STATUS', '�������״̬'); // Translate
@define('IMPORT_GENERIC_RSS', 'һ�� RSS ����'); // Translate
@define('ACTIVATE_AUTODISCOVERY', '�������������õ�����'); // Translate
@define('WELCOME_TO_ADMIN', '��ӭ��½Serendipity���ܲ���ϵͳ');
@define('PLEASE_ENTER_CREDENTIALS', '��������ȷ�ĵ�½�ʺ�'); // Translate
@define('ADMIN_FOOTER_POWERED_BY', 'Powered by Serendipity %s and PHP %s'); // Translate
@define('INSTALL_USEGZIP', 'ʹ�� gzip ѹ����ҳ'); // Translate
@define('INSTALL_USEGZIP_DESC', 'Ϊ������ҳ���еø���, ϵͳ����ѹ������ʾ, ����ÿ�ʹ�õ������֧��ѹ����ҳ�Ļ�������ʹ�á�'); // Translate
@define('INSTALL_SHOWFUTURE', '��ʾδ������'); // Translate
@define('INSTALL_SHOWFUTURE_DESC', '�����, ϵͳ������ʾδ����������£�Ԥ�����趨δ���������أ�Ȼ�󵽷������Զ���ʾ��'); // Translate
@define('INSTALL_DBPERSISTENT', 'ʹ�ó�������'); // Translate
@define('INSTALL_DBPERSISTENT_DESC', '�����ݿ�ʹ�ó�������, ������� <a href="http://php.net/manual/features.persistent-connections.php" target="_blank">����</a>��ͨ��������ʹ�á�'); // Translate
@define('NO_IMAGES_FOUND', '�Ҳ����ļ�'); // Translate
@define('PERSONAL_SETTINGS', '��������'); // Translate
@define('REFERER', '��Դ'); // Translate
@define('NOT_FOUND', '�Ҳ���'); // Translate
@define('NOT_WRITABLE', '���ɶ�д'); // Translate
@define('WRITABLE', '�ɶ�д'); // Translate
@define('PROBLEM_DIAGNOSTIC', '��Ϊ�����������,�������������˲��ܰ�װ��'); // Translate
@define('SELECT_INSTALLATION_TYPE', '��ѡ��װ����'); // Translate
@define('WELCOME_TO_INSTALLATION', '��ӭʹ�� Serendipity �������İ�'); // Translate
@define('FIRST_WE_TAKE_A_LOOK', '����ϵͳ������������Ա��ⰲװ����'); // Translate
@define('ERRORS_ARE_DISPLAYED_IN', '������ʾ %s, ���� %s ������� %s'); // Translate
@define('RED', '��'); // Translate
@define('YELLOW', '��'); // Translate
@define('GREEN', '��'); // Translate
@define('PRE_INSTALLATION_REPORT', 'Serendipity Blog v%s ��װǰ����'); // Translate
@define('RECOMMENDED', '����'); // Translate
@define('ACTUAL', 'ʵ��'); // Translate
@define('PHPINI_CONFIGURATION', 'php.ini ����'); // Translate
@define('PHP_INSTALLATION', 'PHP ��װ'); // Translate
@define('THEY_DO', 'ͨ��'); // Translate
@define('THEY_DONT', 'they don\'t'); // Translate
@define('SIMPLE_INSTALLATION', '���ٰ�װ'); // Translate
@define('EXPERT_INSTALLATION', '�߼���װ'); // Translate
@define('COMPLETE_INSTALLATION', '������װ'); // Translate
@define('WONT_INSTALL_DB_AGAIN', '�����ظ���װ���ݿ�'); // Translate
@define('CHECK_DATABASE_EXISTS', '��������Ƿ����'); // Translate
@define('CREATING_PRIMARY_AUTHOR', '�趨����Ա \'%s\''); // Translate
@define('SETTING_DEFAULT_TEMPLATE', '�趨����'); // Translate
@define('INSTALLING_DEFAULT_PLUGINS', '��װԤ�趨���'); // Translate
@define('SERENDIPITY_INSTALLED', 'Serendipity�������İ氲װ���'); // Translate
@define('VISIT_BLOG_HERE', '��ʼ�����Ĳ���'); // Translate
@define('THANK_YOU_FOR_CHOOSING', '�ǳ���л��ѡ�� Serendipity�������İ�'); // Translate
@define('ERROR_DETECTED_IN_INSTALL', '��װʱ��������'); // Translate
@define('OPERATING_SYSTEM', 'ϵͳ����'); // Translate
@define('WEBSERVER_SAPI', '���� SAPI'); // Translate
@define('TEMPLATE_SET', '\'%s\' �ѱ��趨Ϊ����'); // Translate
@define('SEARCH_ERROR', '�������ܳ��ִ��󣬱������Ա:�����������������ݿ�û����ȷ��index keys,���ʹ��MYSQL������ʺű������ִ�� <pre>CREATE FULLTEXT INDEX entry_idx on %sentries (title,body,extended)</pre> ��Ȩ�ޣ����ݿ���ʾ�Ĵ�����: <pre>%s</pre>'); // Translate
@define('EDIT_THIS_CAT', '�༭ "%s"'); // Translate
@define('CATEGORY_REMAINING', 'ɾ���������Ȼ������ת���������'); // Translate
@define('CATEGORY_INDEX', '�����ǿ���ת�Ƶķ���'); // Translate
@define('NO_CATEGORIES', 'û�з���'); // Translate
@define('RESET_DATE', '��������'); // Translate
@define('RESET_DATE_DESC', '��������������'); // Translate
@define('PROBLEM_PERMISSIONS_HOWTO', 'Ȩ�޿���ʹ������� shell ��ִ��: `<em>%s</em>` Ȼ��ִ��Ҫ���ĵ��ļ���, ��ʹ�� FTP ���'); // Translate
@define('WARNING_TEMPLATE_DEPRECATED', '����:  ��Ŀǰʹ�õ������Ǿɷ��������ģ��뾡�����'); // Translate
@define('ENTRY_PUBLISHED_FUTURE', '��ƪ����δ����'); // Translate
@define('ENTRIES_BY', '���� %s'); // Translate
@define('PREVIOUS', '��һҳ'); // Translate
@define('NEXT', '��һҳ'); 
@define('APPROVE', '���'); 

@define('DO_MARKUP_DESCRIPTION', '�����Զ�����ʽ�������� (����, ���� *, /, _, ...)���ر�����ܽ��ᱣ���κ������ڳ��ֵ� HTML �﷨��');
@define('CATEGORY_ALREADY_EXIST', '��� "%s" �Ѿ�����');
@define('IMPORT_NOTES', 'ע��:');
@define('ERROR_FILE_FORBIDDEN', '�㲻���ϴ����ļ�');
@define('ADMIN', '��Ҫ�趨');
@define('ADMIN_FRONTPAGE', '��ҳ');
@define('QUOTE', '����');
@define('IFRAME_SAVE', '���ڱ������£��������ú�ִ�� XML-RPC calls�����Ժ�..');
@define('IFRAME_SAVE_DRAFT', '���²ݸ��ѱ�����');
@define('IFRAME_PREVIEW', '���ڽ������Ԥ������...');
@define('IFRAME_WARNING', '����������֧�� iframes. ��� serendipity_config.inc.php �ļ�Ȼ���趨 $serendipity[\'use_iframe\'] Ϊ FALSE��');
@define('NONE', 'None');
@define('USERCONF_CAT_DEFAULT_NEW_ENTRY', '�����½�ʹ��Ԥ���趨');
@define('UPGRADE', '����');
@define('UPGRADE_TO_VERSION', '�������°汾 %s');
@define('DELETE_DIRECTORY', 'ɾ��Ŀ¼');
@define('DELETE_DIRECTORY_DESC', 'ɾ��Ŀ¼�ڵ�ý���ļ���ע���ļ�Ҳ����������������ڡ�');
@define('FORCE_DELETE', 'ɾ����Ŀ¼�ڵ��ļ��������޷�ʶ����ļ�');
@define('CREATE_DIRECTORY', '����Ŀ¼');
@define('CREATE_NEW_DIRECTORY', '������Ŀ¼');
@define('CREATE_DIRECTORY_DESC', '����������Խ����µ�Ŀ¼�����ý���ļ�������Ŀ¼���ƺ������ѡ���Ƿ����ŵ���Ŀ¼�ڡ�');
@define('BASE_DIRECTORY', '����Ŀ¼');
@define('USERLEVEL_EDITOR_DESC', 'һ������');
@define('USERLEVEL_CHIEF_DESC', '����');
@define('USERLEVEL_ADMIN_DESC', '����Ա');
@define('USERCONF_USERLEVEL', 'Ȩ��');
@define('USERCONF_USERLEVEL_DESC', '���ѡ������趨�������������־�ڵ�Ȩ��');
@define('USER_SELF_INFO', '�����û��� %s (%s)');
@define('ADMIN_ENTRIES', '���¹���');// ���Ǻ�̨�˵������¹���
@define('RECHECK_INSTALLATION', '���¼�鰲װ����');
@define('IMAGICK_EXEC_ERROR', '�޷�ִ��: "%s", ����: %s, ϵ��: %d');
@define('INSTALL_OFFSET_DESC', '��Сʱ���㣬������������ʱ�� (Ŀǰ: %clock%) �����ʱ��');
@define('UNMET_REQUIREMENTS', 'δ�ﵽ����: %s');
@define('CHARSET', '����');
@define('AUTOLANG', 'ʹ����������趨�ı���');
@define('AUTOLANG_DESC', '�������������ܽ�ʹ����������趨�ı���');
@define('INSTALL_AUTODETECT_URL', '�Զ���� HTTP-Host');
@define('INSTALL_AUTODETECT_URL_DESC', '����趨Ϊ "true"��HTTP Host �������ĵ�ַ�趨��ͬ����������ܿ���������ʹ�ö������������־��ʹ�������־�������ӡ�');
@define('CONVERT_HTMLENTITIES', '�Զ��ı� HTML �ı�ǩ');
@define('EMPTY_SETTING', '��û���ṩ "%s" ����ȷ����');
@define('USERCONF_REALNAME', 'ȫ��');
@define('USERCONF_REALNAME_DESC', '����ȫ��������ʾȫ������');
@define('HOTLINK_DONE', '�ļ��ⲿ����<br />������');
@define('ENTER_MEDIA_URL_METHOD', 'ȡ�÷���:');
@define('ADD_MEDIA_BLAHBLAH_NOTE', 'ע��:�����ѡ���ⲿ���ӣ����ȵõ���Դ��վ�������ⲿ������������������վ��ͼƬ������Ҫ��ͼƬ��������������ڡ�');
@define('MEDIA_HOTLINKED', '�ⲿ����ͼƬ');
@define('FETCH_METHOD_IMAGE', '����ͼƬ������');
@define('FETCH_METHOD_HOTLINK', '�ⲿ���ӵ�����');
@define('DELETE_HOTLINK_FILE', 'ɾ���ⲿ���ӵ��ļ� <b>%s</b>');
@define('SYNDICATION_PLUGIN_SHOW_MAIL', '��ʾ�����ʼ�');
@define('IMAGE_MORE_INPUT', '����ͼƬ');
@define('BACKEND_TITLE', '�������ҳ��Ķ�����Ϣ');
@define('BACKEND_TITLE_FOR_NUGGET', '����������趨һЩ�Զ����֣����� HTML Nugget ���һ������ʾ���������ҳ�档������ж������� HTML Nuggets�������������ֱ�����ͬ����ҡ�');
@define('CATEGORIES_ALLOW_SELECT', '����ÿ���ʾ������');
@define('CATEGORIES_ALLOW_SELECT_DESC', '����������ѡ��� sidebar ����������Ա߻���ֹ�ѡ�˵�����Ա���Թ�ѡҪ��ʾ�����');
@define('PAGE_BROWSE_PLUGINS', 'ҳ�� %s �� %s, �ܹ� %s ����ҡ�');
@define('INSTALL_CAT_PERMALINKS', '��̬����');
@define('INSTALL_CAT_PERMALINKS_DESC', '���ø��ֲ�ͬ��ַ��ʽ�����徲̬���ӡ���������Ԥ�����ʽ����ʹ�� %id% ֵ���������ݿ�Ѱ�ҵ�ַĿ�ꡣ');
@define('INSTALL_PERMALINK', '���µľ�̬����');
@define('INSTALL_PERMALINK_DESC', '������������趨�Ի���λ�����������µ�������ӡ�����������²�����%id%, %title%, %day%, %month%, %year% �������ַ���');
@define('INSTALL_PERMALINK_AUTHOR', '���ߵľ�̬����');
@define('INSTALL_PERMALINK_AUTHOR_DESC', '������������趨�Ի���λ�����������µ�������ӡ�����������²�����%id%, %realname%, %username%, %email% �������ַ���');
@define('INSTALL_PERMALINK_CATEGORY', '���ľ�̬����');
@define('INSTALL_PERMALINK_CATEGORY_DESC', '������������趨�Ի���λ�����������µ�������ӡ�����������²�����%id%, %name%, %parentname%, %description% �������ַ���');
@define('INSTALL_PERMALINK_FEEDCATEGORY', 'RSS-Feed ���ľ�̬����');
@define('INSTALL_PERMALINK_FEEDCATEGORY_DESC', '������������趨�Ի���λ�������� RSS-Feed ������µ�������ӡ�����������²�����%id%, %name%, %description% �������ַ���');
@define('INSTALL_PERMALINK_ARCHIVESPATH', '�����ļ�·��');
@define('INSTALL_PERMALINK_ARCHIVEPATH', '�����ļ�·��');
@define('INSTALL_PERMALINK_CATEGORIESPATH', '���·��');
@define('INSTALL_PERMALINK_UNSUBSCRIBEPATH', '�����Ļظ�·��');
@define('INSTALL_PERMALINK_DELETEPATH', 'ɾ���ظ�·��');
@define('INSTALL_PERMALINK_APPROVEPATH', '��׼�ظ�·��');
@define('INSTALL_PERMALINK_FEEDSPATH', 'RSS Feeds ·��');
@define('INSTALL_PERMALINK_PLUGINPATH', '�����·��');
@define('INSTALL_PERMALINK_ADMINPATH', '����·��');
@define('INSTALL_PERMALINK_SEARCHPATH', '����·��');
@define('INSTALL_CAL', '��������');
@define('INSTALL_CAL_DESC', '��ѡ����Ҫ����������');
@define('REPLY', '�ظ�');
@define('USERCONF_GROUPS', '��ԱȺ��');
@define('USERCONF_GROUPS_DESC', '�˻�Ա�����Ⱥ����Ա����Ա���Լ�����Ⱥ�顣');
@define('MANAGE_GROUPS', '����Ⱥ��');
@define('DELETED_GROUP', 'Ⱥ�� #%d %s ��ɾ��');
@define('CREATED_GROUP', '��Ⱥ�� %s ������');
@define('MODIFIED_GROUP', 'Ⱥ�� %s ���趨�ѱ��ı�');
@define('GROUP', 'Ⱥ��');
@define('CREATE_NEW_GROUP', '����Ⱥ��');
@define('DELETE_GROUP', 'ȷ��Ҫɾ��Ⱥ�� #%d %s ');
@define('USERLEVEL_OBSOLETE', 'ע��: ��ԱȨ�޵�����ֻ��Ϊ�����ֻظ��ļ��ݺ������Ȩ��ϵͳ����ʹ�����µĻ�ԱȨ�ޡ�');
@define('SYNDICATION_PLUGIN_FEEDBURNERID', 'FeedBurner ID');
@define('SYNDICATION_PLUGIN_FEEDBURNERID_DESC', '��Ҫ�������µ� ID');
@define('SYNDICATION_PLUGIN_FEEDBURNERIMG', 'FeedBurner ͼƬ');
@define('SYNDICATION_PLUGIN_FEEDBURNERIMG_DESC', 'λ�� feedburner.com ��ͼƬ��ʾ������ (��հ���ʾ����)�����磺fbapix.gif');
@define('SYNDICATION_PLUGIN_FEEDBURNERTITLE', 'FeedBurner ����');
@define('SYNDICATION_PLUGIN_FEEDBURNERTITLE_DESC', '��ʾ��ͼƬ�Եı��� (�����)');
@define('SYNDICATION_PLUGIN_FEEDBURNERALT', 'FeedBurner ͼƬ����');
@define('SYNDICATION_PLUGIN_FEEDBURNERALT_DESC', '�����ͼƬʱ��ʾ������ (�����)');
@define('SEARCH_TOO_SHORT', '��Ѱ�ֱ������3�ֽڡ������ʹ�� * �����棬�����Ѱ�ֽ�С�� 3 �ֽڡ����磺s9y*��');
@define('INSTALL_DBPORT', '���ݿ����Ӷ�');
@define('INSTALL_DBPORT_DESC', '�������ݿ���ʹ�õ����Ӷ�');
@define('PLUGIN_GROUP_FRONTEND_EXTERNAL_SERVICES', 'ǰ�ˣ��ⲿ����');
@define('PLUGIN_GROUP_FRONTEND_FEATURES', 'ǰ�ˣ�����');
@define('PLUGIN_GROUP_FRONTEND_FULL_MODS', 'ǰ�ˣ��������');
@define('PLUGIN_GROUP_FRONTEND_VIEWS', 'ǰ�ˣ����');
@define('PLUGIN_GROUP_FRONTEND_ENTRY_RELATED', 'ǰ�ˣ��������');
@define('PLUGIN_GROUP_BACKEND_EDITOR', '��ˣ��༭��');
@define('PLUGIN_GROUP_BACKEND_USERMANAGEMENT', '��ˣ���Ա����');
@define('PLUGIN_GROUP_BACKEND_METAINFORMATION', '��ˣ�Meta ����');
@define('PLUGIN_GROUP_BACKEND_TEMPLATES', '��ˣ�����');
@define('PLUGIN_GROUP_BACKEND_FEATURES', '��ˣ�����');
@define('PLUGIN_GROUP_IMAGES', 'ͼƬ');
@define('PLUGIN_GROUP_ANTISPAM', '��ֹ���');
@define('PLUGIN_GROUP_MARKUP', '���');
@define('PLUGIN_GROUP_STATISTICS', 'ͳ������');
@define('PERMISSION_PERSONALCONFIGURATION', '��ȡ˽���趨');
@define('PERMISSION_PERSONALCONFIGURATIONUSERLEVEL', '�ı��ԱȨ��');
@define('PERMISSION_PERSONALCONFIGURATIONNOCREATE', '��� "��ֹ��������"');
@define('PERMISSION_PERSONALCONFIGURATIONRIGHTPUBLISH', '����������µ�Ȩ��');
@define('PERMISSION_SITECONFIGURATION', '��ȡϵͳ�趨');
@define('PERMISSION_BLOGCONFIGURATION', '��ȡ��־�趨');
@define('PERMISSION_ADMINENTRIES', '��������');
@define('PERMISSION_ADMINENTRIESMAINTAINOTHERS', '�����Ա������');
@define('PERMISSION_ADMINIMPORT', '��������');
@define('PERMISSION_ADMINCATEGORIES', '�������');
@define('PERMISSION_ADMINCATEGORIESMAINTAINOTHERS', '�����Ա�����');
@define('PERMISSION_ADMINCATEGORIESDELETE', 'ɾ��');
@define('PERMISSION_ADMINUSERS', '�����Ա');
@define('PERMISSION_ADMINUSERSDELETE', 'ɾ����Ա');
@define('PERMISSION_ADMINUSERSEDITUSERLEVEL', '���Ȩ��');
@define('PERMISSION_ADMINUSERSMAINTAINSAME', '������ͬȺ��Ļ�Ա');
@define('PERMISSION_ADMINUSERSMAINTAINOTHERS', 'admin: maintainOthers');
@define('PERMISSION_ADMINUSERSCREATENEW', '������Ա');
@define('PERMISSION_ADMINUSERSGROUPS', '����Ⱥ��');
@define('PERMISSION_ADMINPLUGINS', '�������');
@define('PERMISSION_ADMINPLUGINSMAINTAINOTHERS', '�����Ա�����');
@define('PERMISSION_ADMINIMAGES', '����ý���ļ�');
@define('PERMISSION_ADMINIMAGESDIRECTORIES', '����ý��Ŀ¼');
@define('PERMISSION_ADMINIMAGESADD', '����ý���ļ�');
@define('PERMISSION_ADMINIMAGESDELETE', 'ɾ��ý���ļ�');
@define('PERMISSION_ADMINIMAGESMAINTAINOTHERS', '�����Ա��ý���ļ�');
@define('PERMISSION_ADMINIMAGESVIEW', '���ý���ļ�');
@define('PERMISSION_ADMINIMAGESSYNC', 'ͬ����ͼ');
@define('PERMISSION_ADMINCOMMENTS', '����ظ�');
@define('PERMISSION_ADMINTEMPLATES', '��������');
@define('INSTALL_BLOG_EMAIL', '��վ�ĵ����ʼ�');
@define('INSTALL_BLOG_EMAIL_DESC', '����趨��ĵ����ʼ����κ���־�ڼĳ����ʼ�������ʾ��������ʼ���ַ���ǵ���������ʼ�����������������ڣ��ܶ�������ܾ����ղ������ʼ���');
@define('CATEGORIES_PARENT_BASE', 'ֻ��ʾ�������...');
@define('CATEGORIES_PARENT_BASE_DESC', '�����ѡ��һ�������ֻ��ʾ������������');
@define('CATEGORIES_HIDE_PARALLEL', '���ز������ṹ�����');
@define('CATEGORIES_HIDE_PARALLEL_DESC', '�������λ���������ṹ�����������ȿ�������趨���������ͨ�������ڶ�����־����ҡ�');
@define('PERMISSION_ADMINIMAGESVIEWOTHERS', '�����Ա��ý���ļ�');
@define('CHARSET_NATIVE', 'Ԥ��');
@define('INSTALL_CHARSET', '����ѡ��');
@define('INSTALL_CHARSET_DESC', '�����������ת�� UTF-8 ��Ԥ����� (ISO, GB2312, ...)��Щ���԰�ֻ�� UTF-8 ���룬���Ի���Ԥ�������в����κθı䡣�°�װ����־����ʹ�� UTF-8 ���롣�ǵò�Ҫ�ı�����趨������Ѿ����������¡�������� http://www.s9y.org/index.php?node=46');
@define('CALENDAR_ENABLE_EXTERNAL_EVENTS', 'External Events');
@define('CALENDAR_EXTEVENT_DESC', '�����������ҿ���������������ɫ��ʾ�����¼������û��ʹ����Щ�������ң����鲻Ҫʹ�á�');
@define('XMLRPC_NO_LONGER_BUNDLED', 'XML-RPC API ���ܲ�������� s9y �İ�װ���Ϊ©���Ͳ�����ʹ�õĹ�ϵ�����Ա��밲װ XML-RPC ��������ʹ�� XML-RPC API�����е� URL ������˸ı䣬��װ�����Һ�����ʹ�á�');
@define('PERM_READ', '��ȡȨ��');
@define('PERM_WRITE', 'д��Ȩ��');

@define('PERM_DENIED', 'Ȩ�޾ܾ�');
@define('INSTALL_ACL', '�����ȡ��Ȩ�޵����');
@define('INSTALL_ACL_DESC', '���������Ⱥ�������Ȩ���趨�������õ�����Ļ�Ա������رգ����Ķ�ȡȨ�޲��ᱻʹ�ã����ǻ�ӿ�����־���ٶȡ�����㲻��Ҫ���ʹ���ߵĶ�ȡȨ�ޣ������㽫����趨�رա�');
@define('PLUGIN_API_VALIDATE_ERROR', '���õ��趨 "%s" �﷨������Ҫ "%s" ���͡�');
@define('USERCONF_CHECK_PASSWORD', '������');
@define('USERCONF_CHECK_PASSWORD_DESC', '�����Ҫ�������룬�뽫���������뵽���');
@define('USERCONF_CHECK_PASSWORD_ERROR', '���ṩ�˴���ľ��������Բ��ܸ������롣����趨δ���档');
@define('ERROR_XSRF', '�������������˴���� HTTP-Referrer �ַ�����������Ϊ browser/proxy �Ĵ����趨���� Cross Site Request Forgery (XSRF) �Ĺ�ϵ����Ĳ����޷���ɡ�');
@define('INSTALL_PERMALINK_FEEDAUTHOR_DESC', '����������㶨����� URL ���ӻ��� URL ����Ա��ȡ�� RSS-feeds Ϊ��׼�����������Щ���� %id%, %realname%, %username%, %email% �������ַ���');
@define('INSTALL_PERMALINK_FEEDAUTHOR', 'Permalink RSS-Feed ���ߵ� URL');
@define('INSTALL_PERMALINK_AUTHORSPATH', '����·��');
@define('AUTHORS', '����');
@define('AUTHORS_ALLOW_SELECT', '����ÿ���ʾ��λ����?');
@define('AUTHORS_ALLOW_SELECT_DESC', '����������ѡ��ÿͿ��Թ�ѡҪ��ȡ�����ߵ����¡�');
@define('AUTHOR_PLUGIN_DESC', '��ʾ�����б�');
@define('CATEGORY_PLUGIN_TEMPLATE', '���� Smarty-Templates');
@define('CATEGORY_PLUGIN_TEMPLATE_DESC', '����������ѡ���һ����� Smarty-Templating �Ĺ������������б���Ҳ������ "plugin_categories.tpl" ��ģ���ļ����ı���ۡ����ѡ��������ҳ����ʾ�ٶȣ�����㲻���κθı䣬��ùر����ѡ�');
@define('CATEGORY_PLUGIN_SHOWCOUNT', '��ʾÿ������������');
@define('AUTHORS_SHOW_ARTICLE_COUNT', '��ʾ���ߵ�������');
@define('AUTHORS_SHOW_ARTICLE_COUNT_DESC', '�����������趨�����ߵ����»���ʾ�������ԡ�');
@define('CUSTOM_ADMIN_INTERFACE', '�����Զ��Ĺ������');

@define('COMMENT_NOT_ADDED', '��Ļظ����ܼ�����Ϊ��ƪ���²�����ظ��������˴�����Ϣ����ͨ����������'); 
@define('INSTALL_TRACKREF', '��¼��Դ');
@define('INSTALL_TRACKREF_DESC', '������¼��Դ����ʾ�Ǹ���վ������������¡�����Թر��������������յ�̫��������档');
@define('CATEGORIES_HIDE_PARENT', '����ѡ������');
@define('CATEGORIES_HIDE_PARENT_DESC', '�������������ʾ���б�Ԥ���ǻ���ʾ���������ơ��������������ܣ����������ƽ�������ʾ��');
@define('WARNING_NO_GROUPS_SELECTED', '���棺��û��ѡ���ԱȺ�顣��Ὣ��ǳ�Ⱥ��Ĺ�����Ա��Ⱥ�鲻�ᱻ�ı䡣');
@define('INSTALL_RSSFETCHLIMIT', 'Entries to display in Feeds');
@define('INSTALL_RSSFETCHLIMIT_DESC', 'RSS Feed ҳ������ʾ������������');
@define('INSTAL_DB_UTF8', '�������ݿ����ת��');
@define('INSTAL_DB_UTF8_DESC', 'ʹ�� MySQL �� "SET NAMES" ��ѯ���趨���롣������³���������Խ����趨�򿪻�رա�');
@define('ONTHEFLYSYNCH', '����ý��ͬ��');
@define('ONTHEFLYSYNCH_DESC', '���������Serendipity Blog��Ƚ����ݿ��ý��Ŀ¼���ļ���Ȼ���������ͬ����');
@define('USERCONF_CHECK_USERNAME_ERROR', '�ʺŲ��ܿհ�');
@define('FURTHER_LINKS', '��������');
@define('FURTHER_LINKS_S9Y', '�ٷ���ҳ');
@define('FURTHER_LINKS_S9Y_DOCS', '����֧��');
@define('FURTHER_LINKS_S9Y_BLOG', '��վ��־');
@define('FURTHER_LINKS_S9Y_FORUMS', '������̳');
@define('FURTHER_LINKS_S9Y_SPARTACUS', '�������');
@define('COMMENT_IS_DELETED', '(�ظ���ɾ��)');

@define('CURRENT_AUTHOR', 'Ŀǰ������');

@define('WORD_NEW', '��');
@define('SHOW_MEDIA_TOOLBAR', '��ѡ��ý����Ӵ�����ʾ������');
@define('MEDIA_KEYWORDS', 'ý��Ĺؼ���');
@define('MEDIA_KEYWORDS_DESC', '����Ԥ���ý��ؼ��֣��� ";" ���ֿ�ÿ���ؼ��֡�');
@define('MEDIA_EXIF', '���� EXIF/JPEG ͼƬ����');
@define('MEDIA_EXIF_DESC', '���������EXIF/JPEG ͼ����� metadata ���Զ����浽���ݿ⡣');
@define('MEDIA_PROP', 'ý������');


@define('GO_ADD_PROPERTIES', '��������');
@define('MEDIA_PROPERTY_DPI', 'DPI');
@define('MEDIA_PROPERTY_COPYRIGHT', '��Ȩ');
@define('MEDIA_PROPERTY_COMMENT1', '�̽���');
@define('MEDIA_PROPERTY_COMMENT2', '������');
@define('MEDIA_PROPERTY_TITLE', '����');
@define('MEDIA_PROP_DESC', '����ý��ʹ�õ����ݲ˵����� ";" ���ֿ�ÿ���˵�������');
@define('MEDIA_PROP_MULTIDESC', '(����������ƺ������ ":MULTI" ���趨�Ӵ�������������)');

@define('STYLE_OPTIONS_NONE', '�������û���ر��ѡ����Ҫ��������������ѡ������ www.s9y.org �ڵ� Technical Documentation��Ȼ�� "Configuration of Theme options"��');
@define('STYLE_OPTIONS', '����ѡ��');

@define('PLUGIN_AVAILABLE_COUNT', '�ܹ��� %d �����');

@define('SYNDICATION_RFC2616', '���������ϸ�� RFC2616 RSS-Feed');
@define('SYNDICATION_RFC2616_DESC', '��ǿ�� RFC2616 ��ʾȫ���������� GETs �� Serendipity Blog ֻ�ᴫ������޸ĵ����¡�����趨Ϊ "false" ��ʾ�ÿͽ���ȫ�������¡�������һЩ��־�ĳ����� Planet ���������������������������ʾ��Υ���� RFC2616 �ı�׼�������趨Ϊ "TRUE" ��ʾ����� RFC �ı�׼�����ÿͿ��ܶ�ȡ����ȫ�����¡�������˵�������������޷��չ˵���������������ģ�<a href="https://sourceforge.net/tracker/index.php?func=detail&amp;aid=1461728&amp;group_id=75065&amp;atid=542822" target="_blank" rel="nofollow">SourceForge</a>');
@define('MEDIA_PROPERTY_DATE', '�������');
@define('MEDIA_PROPERTY_RUN_LENGTH', '����');
@define('FILENAME_REASSIGNED', '�Զ�ָ�����ļ����ƣ� %s');
@define('MEDIA_UPLOAD_SIZE', '�ļ���С������');
@define('MEDIA_UPLOAD_SIZE_DESC', '�����ļ������ֵ������趨Ҳ���Դ������ڵ� PHP.ini �ļ��ı䣺 upload_max_filesize, post_max_size, max_input_time ȫ��������������趨��Ч������������ʾ������������ơ�');
@define('MEDIA_UPLOAD_SIZEERROR', '�����㲻���ϴ����� %s �ֽڵ��ļ�');
@define('MEDIA_UPLOAD_MAXWIDTH', 'ͼƬ�����');
@define('MEDIA_UPLOAD_MAXWIDTH_DESC', '�����ϴ�ͼƬ����ȡ�');
@define('MEDIA_UPLOAD_MAXHEIGHT', 'ͼƬ��󳤶�');
@define('MEDIA_UPLOAD_MAXHEIGHT_DESC', '�����ϴ�ͼƬ��󳤶ȡ�');
@define('MEDIA_UPLOAD_DIMERROR', '�����㲻���ϴ����� %s x %s ��ͼƬ');

@define('MEDIA_TARGET', '���ӵ�Ŀ��');
@define('MEDIA_TARGET_JS', '�������� (ʹ�� JavaScript)');
@define('MEDIA_ENTRY', '��������');
@define('MEDIA_TARGET_BLANK', '�������� (ʹ�� target=_blank)');

@define('MEDIA_DYN_RESIZE', '����ı�ͼƬ��С');
@define('MEDIA_DYN_RESIZE_DESC', '���������ý���ѡ���Ӵ�����ʾ���� GET �������趨��ͼƬ��С��ͼƬ�ᱣ���ڻ����ڣ����Գ�ʹ�û�ռ�������Ŀռ䡣');

@define('MEDIA_DIRECTORY_MOVED', 'Directory and files were successfully moved to %s');
@define('MEDIA_DIRECTORY_MOVE_ERROR', 'Directory and files could not be moved to %s!');
@define('MEDIA_DIRECTORY_MOVE_ENTRY', 'On Non-MySQL databases, iterating through every article to replace the old directory URLs with new directory URLs is not possible. You will need to manually edit your entries to fix new URLs. You can still move your old directory back to where it was, if that is too cumbersome for you.');
@define('MEDIA_DIRECTORY_MOVE_ENTRIES', 'Moved the URL of the moved directory in %s entries.');
@define('PLUGIN_ACTIVE', 'Active');
@define('PLUGIN_INACTIVE', 'Inactive');
@define('PREFERENCE_USE_JS', 'Enable advanced JS usage?');
@define('PREFERENCE_USE_JS_DESC', 'If enabled, advanced JavaScript sections will be enabled for better usability, like in the Plugin Configuration section you can use drag and drop for re-ordering plugins.');
@define('PREFERENCE_USE_JS_WARNING', '(This page uses advanced JavaScripting. If you are having functionality issues, please disable the use of advanced JS usage in your personal preferences or disable your browser\'s JavaScript)');
@define('INSTALL_PERMALINK_COMMENTSPATH', 'Path to comments');
@define('PERM_SET_CHILD', 'Set the same permissions on all child directories');
@define('PERMISSION_FORBIDDEN_PLUGINS', 'Forbidden plugins');
@define('PERMISSION_FORBIDDEN_HOOKS', 'Forbidden events');
@define('PERMISSION_FORBIDDEN_ENABLE', 'Enable Plugin ACL for usergroups?');
@define('PERMISSION_FORBIDDEN_ENABLE_DESC', 'If the option "Plugin ACL for usergroups" is enabled in the configuration, you can specify which usergroups are allowed to execute certain plugins/events.');
@define('DELETE_SELECTED_ENTRIES', 'Delete selected entries');
@define('PLUGIN_AUTHORS_MINCOUNT', 'Show only authors with at least X articles');
@define('FURTHER_LINKS_S9Y_BOOKMARKLET', 'Bookmarklet');
@define('FURTHER_LINKS_S9Y_BOOKMARKLET_DESC', 'Bookmark this link and then use it on any page you want to blog about to quickly access your Serendipity Blog.');
@define('IMPORT_WP_PAGES', 'Also fetch attachments and staticpages as normal blog entries?');
@define('USERCONF_CREATE', 'Disable user / forbid activity?');
@define('USERCONF_CREATE_DESC', 'If selected, the user will not have any editing or creation possibilities on the blog anymore. When logging in to the backend, he cannot do anything else apart from logging out and viewing his personal configuration.');
@define('CATEGORY_HIDE_SUB', 'Hide postings made to sub-categories?');
@define('CATEGORY_HIDE_SUB_DESC', 'By default, when you browse a category also entries of any subcategory are displayed. If this option is turned on, only postings of the currently selected category are displayed.');
@define('PINGBACK_SENDING', 'Sending pingback to URI %s...');
@define('PINGBACK_SENT', 'Pingback successful');
@define('PINGBACK_FAILED', 'Pingback failed: %s');
@define('PINGBACK_NOT_FOUND', 'No pingback-URI found.');
@define('CATEGORY_PLUGIN_HIDEZEROCOUNT', 'Hide archives link when no entries were made in that timespan (requires counting entries)');
@define('RSS_IMPORT_WPXRSS', 'WordPress eXtended RSS import, requires PHP5 and might take up much memory');
@define('SET_TO_MODERATED', 'Moderate');
@define('COMMENT_MODERATED', 'Comment #%s has successfully been set as moderated');
@define('CENTER', 'center');
@define('FULL_COMMENT_TEXT', 'Yes, with full comment text');

@define('COMMENT_TOKENS', 'Use Tokens for Comment Moderation?');
@define('COMMENT_TOKENS_DESC', 'If tokens are used, comments can be approved and deleted by clicking the email links without requiring login access to the blog. Note that this is a convenience feature, and if your mails get hijacked, those people can approve/delete the referenced comment without further authentication.');
@define('COMMENT_NOTOKENMATCH', 'Moderation link has expired or comment #%s has already been approved or deleted');
@define('TRACKBACK_NOTOKENMATCH', 'Moderation link has expired or trackback #%s has already been approved or deleted');
@define('BADTOKEN', 'Invalid Moderation Link'); 

@define('CONFIRMATION_MAIL_ALWAYS', "Hello %s,\n\nYou have sent a new comment to \"%s\". Your comment was:\n\n%s\n\nThe owner of the blog has enabled mail verification, so you need to click on the following link to authenticate your comment:\n<%s>\n");
@define('CONFIRMATION_MAIL_ONCE', "Hello %s,\n\nYou have sent a new comment to \"%s\". Your comment was:\n\n%s\n\nThe owner of the blog has enabled one-time mail verification, so you need to click on the following link to authenticate your comment:\n<%s>\n\nAfter you have done that, you can always post comments on that blog with your username and e-mail address without receiving such notifications.");
@define('INSTALL_SUBSCRIBE_OPTIN', 'Use Double-Opt In for comment subscriptions?');
@define('INSTALL_SUBSCRIBE_OPTIN_DESC', 'If enabled, when a comment is made where the person wants to be notified via e-mail about new comments to the same entry, he must confirm his subscription to the entry. This Double-Opt In is required by german law, for example.');
@define('CONFIRMATION_MAIL_SUBSCRIPTION', "Hello %s,\n\nYou have requested to be notified for comments to \"%s\" (<%s>). To approve this subscription (\"Double Opt In\") please click this link:\n<%s>\n.");
@define('NOTIFICATION_CONFIRM_SUBMAIL', 'Your confirmation of your comment subscription has been successfully entered.');
@define('NOTIFICATION_CONFIRM_MAIL', 'Your confirmation of the comment has been successfully entered.');
@define('NOTIFICATION_CONFIRM_SUBMAIL_FAIL', 'Your comment subscription could not be confirmed. Please check the link you clicked on for completion. If the link was sent more than 3 weeks ago, you must request a new confirmation mail.');
@define('NOTIFICATION_CONFIRM_MAIL_FAIL', 'Your comment confirmation could not be confirmed.  Please check the link you clicked on for completion. If the link was sent more than 3 weeks ago, you must send your comment again.');
@define('PLUGIN_DOCUMENTATION', 'Documentation');
@define('PLUGIN_DOCUMENTATION_LOCAL', 'Local Documentation');
@define('PLUGIN_DOCUMENTATION_CHANGELOG', 'Version history');
@define('SYNDICATION_PLUGIN_BIGIMG', 'Big Image');
@define('SYNDICATION_PLUGIN_BIGIMG_DESC', 'Display a (big) image at the top of the feeds in sidebar, enter full or absolute URL to image file.');
@define('SYNDICATION_PLUGIN_FEEDNAME', 'Displayed name for "feed"');
@define('SYNDICATION_PLUGIN_FEEDNAME_DESC', 'Enter an optional custom name for the feeds (defaults to "feed" when empty)');
@define('SYNDICATION_PLUGIN_COMMENTNAME', 'Displayed name for "comment" feed');
@define('SYNDICATION_PLUGIN_COMMENTNAME_DESC', 'Enter an optional custom name for the comment feed');
@define('SYNDICATION_PLUGIN_FEEDBURNERID_FORWARD', '(If you enter an absolute URL with http://... here, this URL will be used as the redirection target in case you have enabled the "Force" option for FeedBurner. Note that this can also be a URL independent to FeedBurner. For new Google FeedBurner feeds, you need to enter http://feeds2.feedburner.com/yourfeedname here)');

@define('SYNDICATION_PLUGIN_FEEDBURNERID_FORWARD2', 'If you set this option to "Force" you can forward the RSS feed to any webservice, not only FeedBurner. Look at the option "Feedburner ID" below to enter an absolute URL)');
@define('COMMENTS_FILTER_NEED_CONFIRM', 'Pending user confirmation');
@define('NOT_WRITABLE_SPARTACUS', ' (Only required when you plan to use Spartacus plugin for remote plugin download)');
@define('MEDIA_ALT', 'ALT-Attribute (depiction or short description)');
@define('MEDIA_PROPERTY_ALT', 'Depiction (summary for ALT-Attribute)');

@define('MEDIA_TITLE', 'TITLE-Attribute (will be displayed on mouse over)');

@define('QUICKSEARCH_SORT', 'How should search-results be sorted?');

@define('QUICKSEARCH_SORT_RELEVANCE', 'Relevance');

