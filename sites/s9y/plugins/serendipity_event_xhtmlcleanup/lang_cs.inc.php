<?php # lang_cs.inc.php 1381.1 2009-08-15 10:30:13 VladaAjgl $

/**
 *  @version 1381.1
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/05/06
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/08/15
 */

@define('PLUGIN_EVENT_XHTMLCLEANUP_NAME', 'Oprava nej�ast�j��ch XHTML chyb');
@define('PLUGIN_EVENT_XHTMLCLEANUP_DESC', 'Plugin opravuje nejb�n�j�� chyby XHTML jazyka. Pom�h� tak udr�et v�sledn� k�d XHTML kompatibiln� podle standard�.');
@define('PLUGIN_EVENT_XHTMLCLEANUP_XHTML', 'K�dovat zpracovan� XML data?');
@define('PLUGIN_EVENT_XHTMLCLEANUP_XHTML_DESC', 'Tento plugin pou��v� XML parsov�n� pro zaji�t�n� validity XHTML k�du. Toto parsov�n� m��e zp�sobit, �e budou validn� entity (znaky) p�evedeny na "unsescaped" entity (XHTML k�dy). Proto plugin v�echny entity znovu k�duje po zpracov�n� textu. Vypn�te tuto volbu, pokud pozorujete dvojit� rek�dov�n�!');
@define('PLUGIN_EVENT_XHTMLCLEANUP_UTF8', '�i�t�n� UTF-8 znak�?');
@define('PLUGIN_EVENT_XHTMLCLEANUP_UTF8_DESC', 'Pokud je zapnuto, HTML entity zp�soben� p�eveden�m znak� v k�dov�n� Unicode UTF-8 budou spr�vn� p�evedeny nazp�t na znaky UTF-8 a nebudou zak�dov�ny do podivn�ch znak� v zobrazen� str�nky.');
@define('PLUGIN_EVENT_XHTMLCLEANUP_YOUTUBE', 'Vy�istit k�d vide� z youtube?');
@define('PLUGIN_EVENT_XHTMLCLEANUP_YOUTUBE_DESC', 'Pokud je zapnuto, pak jsou invalidn� XHTML tagy generovan� youtube vy�ez�ny z embed ��sti. Prohl��e� p�es toto vy�ez�n� zobraz� video spr�vn�.');