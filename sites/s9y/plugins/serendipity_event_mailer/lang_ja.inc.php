<?php # $Id: lang_ja.inc.php 1381 2006-08-15 10:14:56Z elf2000 $

/**
 *  @version $Revision: 1381 $
 *  @author Tadashi Jokagi <elf2000@users.sourceforge.net>
 *  EN-Revision: 817
 */

@define('PLUGIN_EVENT_MAILER_NAME', '電子メールでエントリを送信する');
@define('PLUGIN_EVENT_MAILER_DESC', '指定のアドレスに電子メールで新しく作成されたエントリを送信します。');
@define('PLUGIN_EVENT_MAILER_RECIPIENT', 'メール受信者');
@define('PLUGIN_EVENT_MAILER_RECIPIENTDESC', 'エントリを送信したい電子メールアドレス (提案: メーリングリスト)');
@define('PLUGIN_EVENT_MAILER_LINK', '記事へのリンクをメールしますか?');
@define('PLUGIN_EVENT_MAILER_LINKDESC', 'メールに記事へのリンクを含みます。');
@define('PLUGIN_EVENT_MAILER_STRIPTAGS', 'HTML を削除しますか?');
@define('PLUGIN_EVENT_MAILER_STRIPTAGSDESC', '電子メールから HTML タグを削除します。');
@define('PLUGIN_EVENT_MAILER_CONVERTP', 'HTML の段落を改行に変換しますか?');
@define('PLUGIN_EVENT_MAILER_CONVERTPDESC', 'HTML の各段落の後に改行を追加します。HTML 削除を有効にしている場合、これは非常に有用です。その結果、段落は手動で入力せずとも維持することができます。');
@define('PLUGIN_EVENT_MAILER_RECIPIENTS', 'メール受信者 (複数の受信者は半角空白で分けます)');
@define('PLUGIN_EVENT_MAILER_NOTSENDDECISION', 'それを送らないことを決定したので、このエントリは電子メールにて送信されませんでした。');
@define('PLUGIN_EVENT_MAILER_SENDING', 'Sending');
@define('PLUGIN_EVENT_MAILER_ISTOSENDIT', '電子メールにてこのエントリを送信する');

/* vim: set sts=4 ts=4 expandtab : */
?>
