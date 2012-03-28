<?php # lang_de.inc.php 1.0 2009-06-03 09:50:12 VladaAjgl $

/**
 *  @version 1.0
 *  @author Konrad Bauckmeier <kontakt@dd4kids.de>
 *  @translated 2009/06/03
 */
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_TITLE', 'Erweiterte Eigenschaften von Artikeln');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_DESC', '(Cache, nicht-�ffentliche Artikel, dauerhafte Artikel)');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_STICKYPOSTS', 'Dauerhafte Artikel');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_ACCESS', 'Artikel k�nnen gelesen werden von');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_ACCESS_PRIVATE', 'mir selbst');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_ACCESS_MEMBERS', 'Co-Autoren');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_ACCESS_PUBLIC', 'allen');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_CACHE', 'Artikel cachen?');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_CACHE_DESC', 'Falls diese Option aktiviert ist, wird eine Cache-Version des Artikels gespeichert. Dieses Caching wird zwar die Performance erh�hen, aber Flexibilit�t anderer Plugins eventuell einschr�nken.');
        @define('PLUGIN_EVENT_ENTRYPROPERTY_BUILDCACHE', 'Cachen aller Artikel');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_CACHE_FETCHNEXT', 'Suche nach zu cachenden Artikeln...');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_CACHE_FETCHNO', 'Bearbeite Artikel %d bis %d');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_CACHE_BUILDING', 'Erzeuge cache f�r Artikel #%d, <em>%s</em>...');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_CACHED', 'Artikel gecached.');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_CACHE_DONE', 'Alle Artikel gecached.');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_CACHE_ABORTED', 'Caching der Artikel ABGEBROCHEN.');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_CACHE_TOTAL', ' (insgesamt %d Artikel vorhanden)...');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_NL2BR', 'Automatischen Zeilenumbruch deaktivieren');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_NO_FRONTPAGE', 'Nicht in Artikel�bersicht zeigen');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_GROUPS', 'Leserechte auf Gruppen beschr�nken');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_GROUPS_DESC', 'Wenn aktiviert, k�nnen Leserechte abh�ngig von Gruppen vergeben werden. Dies wirkt sich auf die Performance der Artikel�bersicht stark aus. Aktivieren Sie die Option daher nur, wenn Sie sie wirklich ben�tigen.');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_USERS', 'Leserechte auf Benutzer beschr�nken');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_USERS_DESC', 'Wenn aktiviert, k�nnen Leserechte abh�ngig von einzelnen Benutzern vergeben werden. Dies wirkt sich auf die Performance der Artikel�bersicht stark aus. Aktivieren Sie die Option daher nur, wenn Sie sie wirklich ben�tigen.');

        @define('PLUGIN_EVENT_ENTRYPROPERTIES_HIDERSS', 'Eintragsinhalt im RSS-Feed verstecken');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_HIDERSS_DESC', 'Falls aktiviert, wird dieser Artikel im RSS-Feed ohne Inhalt dargestellt und sofort per URL aufgerufen.');
        
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_CUSTOMFIELDS', 'Freie Felder');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_CUSTOMFIELDS_DESC1', 'Zus�tzliche, freie Felder k�nnen in Ihrem Template an beliebigen Stellen eingesetzt werden. Daf�r m�ssen Sie nur Ihr entries.tpl Template bearbeiten und Smarty-Tags wie {$entry.properties.ep_MyCustomField} an gew�nschter Stelle einf�gen. Bitte beachten Sie den Pr�fix ep_ f�r jedes Feld! ');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_CUSTOMFIELDS_DESC2', 'Geben Sie hier eine Liste von kommaseparierten Feldnamen an, die Sie f�r die Eintr�ge verwenden m�chten. Keine Sonderzeichen und Leerzeichen benutzen. Beispiel: "Customfield1, Customfield2". Zus�tzliche, freie Felder k�nnen in Ihrem Template an beliebigen Stellen eingesetzt werden. Daf�r m�ssen Sie nur Ihr entries.tpl Template bearbeiten und Smarty-Tags wie {$entry.properties.ep_MyCustomField} an gew�nschter Stelle einf�gen. Bitte beachten Sie den Pr�fix ep_ f�r jedes Feld!');
        @define('PLUGIN_EVENT_ENTRYPROPERTIES_CUSTOMFIELDS_DESC3', 'Die Liste verf�gbarer freier Felder kann in der <a href="%s" target="_blank" title="' . PLUGIN_EVENT_ENTRYPROPERTIES_TITLE . '">Plugin-Konfiguration</a> bearbeitet werden.');

// Next lines were translated on 2009/06/03
@define('PLUGIN_EVENT_ENTRYPROPERTIES_DISABLE_MARKUP', 'Formatierungs-PlugIns f�r diesen Eintrag deaktivieren');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_EXTJOINS', 'Verwende erweiterte Datenbankabfragen');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_EXTJOINS_DESC', 'Wenn aktiviert, werden zus�tzliche Datenbankabfragen ausgef�hrt. Damit wird es m�glich, dauerhafte , nicht in Artikel�bersicht aufgef�hrte und im RSS-Feed versteckte Artikel zu verwenden . Wenn diese Funktionen nicht ben�tigt werden, kann das Abschalten der Abfragen die Geschwindigkeit verbessern.');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_SEQUENCE', 'Reihenfolge der Optionen');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_SEQUENCE_DESC', 'Hier kann ausgew�hlt werden, welche Optionen in welcher Reihenfolge im Editiermodus des Artikels angezeigt werden.');