<?php
// Colorsets
@define('THEME_COLORSET', 'Farbwahl');
@define('USER_STYLESHEET','Zus�tzliches Benutzerstylesheet einbinden. Dieses Stylesheet muss vom Benutzer im Template-Verzeichnis angelegt werden. Es muss user.css hei�en und kann benutzt werden, um ausgew�hlte Styles zu �berschreiben.');
// Layout
@define('LAYOUT_TYPE','Layout des Blogs (B = Blogeintr�ge, S = Seitenleiste, CF = Content first)');
@define('LAYOUT_SBS','Dreispaltig S-B-S');
@define('LAYOUT_BSS','Dreispaltig, B-S-S, CF');
@define('LAYOUT_SSB','Dreispaltig, S-S-B');
@define('LAYOUT_SB','Zweispaltig, Seitenleiste links');
@define('LAYOUT_BS','Zweispaltig, Seitenleiste rechts, CF');
@define('LAYOUT_SC','Einspaltig, Seitenleiste(n) unten, CF');
@define('LAYOUT_SBF','Zweispaltig, Seitenleisten links + unten');
@define('LAYOUT_BSF','Zweispaltig, Seitenleisten rechts + unten, CF');
@define('JAVASCRIPT_COLUMNS','Gleich lange Spalten �ber Javascript erzeugen (Kann den Seitenaufbau verz�gern.)');
// Custom header
@define('BP_CUSTOM_HEADER','Eigene Header-Grafik aus der Mediendatenbank verwenden');
@define('BP_HEADER_IMAGE','Auswahl der Header-Grafik');
@define('BP_HEADER_TYPE','Kachelung der Header-Grafik');
@define('BP_HEADER_BANNER', 'Banner (nicht gekachelt)');
@define('BP_HEADER_HTILED', 'Horizontal gekachelt');
@define('BP_HEADER_VTILED', 'Vertikal gekachelt');
@define('BP_HEADER_BTILED', 'Horizontal und vertikal gekachelt');
@define('BP_HEADER_POSHOR', 'Horizontale Ausrichtung');
@define('BP_HEADER_POSVER', 'Vertikale Ausrichtung');
@define('BP_CENTER', 'zentriert');
@define('BP_TOP', 'oben');
@define('BP_BOTTOM', 'unten');
// Fahrner Image Replacement
@define('FIR_BTITLE','Blogtitel im Header anzeigen');
@define('FIR_BDESCR','Blogbeschreibung im Header anzeigen');
// Date format
@define('BP_DATE_FORMAT', 'Datumsformat');
// Entry footer
@define('ENTRY_FOOTER_POS','Position des Eintragsfu�es');
@define('BELOW_ENTRY','Unter dem Eintrag');
@define('BELOW_TITLE','Unter dem Titel des Eintrags');
@define('SPLIT_FOOTER','Aufgeteilter Eintragsfu�');
@define('FOOTER_AUTHOR','Verfasser im Eintragsfu� anzeigen');
@define('FOOTER_CATEGORIES','Kategorie(n) im Eintragsfu� anzeigen');
@define('FOOTER_TIMESTAMP','Zeitstempel im Eintragsfu� anzeigen');
@define('FOOTER_COMMENTS','Anzahl der Kommentare im Eintragsfu� anzeigen');
@define('FOOTER_TRACKBACKS','Anzahl der Trackbacks im Eintragsfu� anzeigen');
@define('ALT_COMMTRACK','Alternative Darstellung der Anzahl der Kommentare und Trackbacks benutzen (z.B. "Keine Kommentare" bzw. "1 Kommentar" statt "Kommentare (0)" bzw. "Kommentare(1)")');
@define('SHOW_ADDTHIS_WIDGET','AddThis (http://www.addthis.com) Bookmark-Widget im Eintragsfu� anzeigen');
@define('ADDTHIS_ACCOUNT','AddThis.com Account-Nummer.  Nicht erforderlich, aber falls angegeben, werden Statistiken dar�ber ermittelt, wie Besucher Seiten bookmarken und die Bookmarks mit anderen teilen.');
@define('SHOW_STICKY_ENTRY_FOOTER','Eintragsfu� f�r klebrige Eintr�ge anzeigen (ben�tigt das Plugin "Erweiterte Eigenschaften von Artikeln")');
@define('SHOW_STICKY_ENTRY_HEADING','Eintragstitel f�r klebrige Eintr�ge anzeigen (ben�tigt das Plugin "Erweiterte Eigenschaften von Artikeln")');
// Page footer next page  and previous page links
@define('PREV_NEXT_STYLE','Links zur vorigen/n�chsten Seite im Seitenfu� anzeigen als');
@define('PREV_NEXT_TEXT','Nur Text');
@define('PREV_NEXT_TEXT_ICON','Text und Icon');
@define('PREV_NEXT_ICON','Nur Icon');
@define('SHOW_PAGINATION','Zus�tzliche Seitennummerierung (Pagination) anzeigen');
// coComment support
@define('COCOMMENT_ACTIVE','coComment (http://www.cocomment.com) in Kommentarformulare einbinden');
// Counter code
@define('COUNTER_CODE', 'Code f�r Counter und/oder Statistik-Tools einf�gen');
@define('USE_COUNTER', 'Oben eingegeben Counter-Code in das Blog einbinden');
// Additional footer text
@define('FOOTER_TEXT', 'Hier zus�tzlichen Text, der im Seitenfuss erscheinen soll, einf�gen.');
@define('USE_FOOTER_TEXT', 'Oben eingegebenen Text einbinden');
//Sitenav
@define('SITENAV_POSITION','Darstellung der Navigationsleiste');
@define('SITENAV_NONE','Keine Navigationsleiste');
@define('SITENAV_ABOVE','�ber dem Kopfbereich');
@define('SITENAV_BELOW','Unter dem Kopfbereich');
@define('SITENAV_LEFT','Oben in der linken Seitenleiste');
@define('SITENAV_RIGHT','Oben in der rechten Seitenleiste');
@define('SITENAV_FOOTER','Links der Navigationleiste zus�tzlich im Seitenfuss anzeigen (werden nicht angezeigt, wenn oben "Keine Navigationsleiste" ausgew�hlt wurde)');
@define('SITENAV_QUICKSEARCH','Suchfeld in der Navigationsleiste anzeigen (funktioniert nur, wenn Navigationsleiste �ber oder unter dem Kopfbereich; Anzeige des entsprechenden Seitenleistenplugins wird automatisch unterdr�ckt)');
@define('SITENAV_TITLE','Titel des Navigations-Men�s (nur bei Anzeige in der Seitenleiste');
@define('SITENAV_TITLE_TEXT','Hauptmen�');
@define('NAVLINK_AMOUNT', 'Anzahl der Links in der Navigationsleiste (Styles verwalten-Seite muss danach neu geladen werden)');
@define('NAV_LINK_TEXT', 'Text des Navigationsleisten-Links');
@define('NAV_LINK_URL', 'URL des Navigationsleisten-Links');
