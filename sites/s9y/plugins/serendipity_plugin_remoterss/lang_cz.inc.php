<?php # lang_cz.inc.php 1427.1 2009-02-14 16:13:06 VladaAjgl $

/**
 *  @version 1427.1
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  @author Vladimir Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/02/14
 */

@define('PLUGIN_REMOTERSS_TITLE',		'Ciz� RSS/OPML kan�l');
@define('PLUGIN_REMOTERSS_BLAHBLAH',		'Zobrazuje polo�ky z ciz�ho RSS/OPML kan�lu (nap��klad Blogroll)');
@define('PLUGIN_REMOTERSS_NUMBER',		'Po�et p��sp�vk�');
@define('PLUGIN_REMOTERSS_NUMBER_BLAHBLAH',		'Kolik p��sp�vk� z RSS kan�lu m� b�t zobrazeno? (P�ednastaveno: 0 = v�echny p��sp�vky RSS kan�lu)');
@define('PLUGIN_REMOTERSS_SIDEBARTITLE',		'Nadpis RSS kan�lu');
@define('PLUGIN_REMOTERSS_SIDEBARTITLE_BLAHBLAH',		'Nadpis bloku v postrann�m sloupci s ciz�m RSS kan�lem');
@define('PLUGIN_REMOTERSS_RSSURI',		'RSS/OPML URI');
@define('PLUGIN_REMOTERSS_RSSURI_BLAHBLAH',		'URI adresa RSS/OPML kan�lu, kter� chcete zobrazit');
@define('PLUGIN_REMOTERSS_NOURI',		'��dn� RSS/OPML kan�l nebyl vybr�n');
@define('PLUGIN_REMOTERSS_RSSTARGET',		'RSS/OPML c�l odkaz�');
@define('PLUGIN_REMOTERSS_RSSTARGET_BLAHBLAH',		'C�l (target) odkaz� z RSS kan�lu. Tedy do jak�ho okna se maj� odkazy otev�rat. (P�ednastaveno: _blank = nov� okno)');
@define('PLUGIN_REMOTERSS_CACHETIME',		'Jak �asto aktualizovat RSS kan�l?');
@define('PLUGIN_REMOTERSS_CACHETIME_BLAHBLAH',		'Obsah RSS kan�lu je uchov�v�n v cachi a je aktualizov�n pouze pokud je star�� ne� X vte�in (P�ednastaveno: 3 hodiny)');
@define('PLUGIN_REMOTERSS_FEEDTYPE',		'Typ kan�lu');
@define('PLUGIN_REMOTERSS_FEEDTYPE_BLAHBLAH',		'Vyberte typ zobrazovan�ho kan�lu');
@define('PLUGIN_REMOTERSS_BULLETIMG',		'Odr�ka');
@define('PLUGIN_REMOTERSS_BULLETIMG_BLAHBLAH',		'Obr�zek, kter� se m� zobrazit p�ed ka�d�m nadpisem z RSS');
@define('PLUGIN_REMOTERSS_DISPLAYDATE',		'Zobrazov�n� data');
@define('PLUGIN_REMOTERSS_DISPLAYDATE_BLAHBLAH',		'Zobrazit pod nadpisem p��sp�vku datum?');

@define('PLUGIN_REMOTERSS_RSSLINK',		'Pou��vat RSS odkazy?');
@define('PLUGIN_REMOTERSS_RSSLINK_DESC',		'Maj� b�t odkazy z RSS kan�lu zobrazeny jako skute�n� odkazy?');
@define('PLUGIN_REMOTERSS_RSSFIELD',		'Zobrazovan� element');
@define('PLUGIN_REMOTERSS_RSSFIELD_DESC',		'Kter� element RSS kan�lu se m� zobrazovat? (nap�. "title" = nadpis, "content:encoded" = t�lo p��sp�vku, "description" = popis, ...)');
@define('PLUGIN_REMOTERSS_RSSESCAPE',		'K�dovat HTML v�stup');
@define('PLUGIN_REMOTERSS_RSSESCAPE_DESC',		'Pokud je povoleno, HTML zna�ky z RSS kan�lu jsou k�dov�ny. Pokud je tato volby zam�tnuta, v�echny HTML zna�ky jsou v RSS kan�lu ponech�ny a p��slu�n� se zobrazuj�. Tato mo�nost p�edstavuje bezpe�nostn� riziku, pokud zobrazovan� RSS kan�l nen� V� nebo pokud mu stoprocentn� ned�v��ujete!');

@define('PLUGIN_REMOTERSS_TEMPLATE',		'�ablona pro tento kan�l');
@define('PLUGIN_REMOTERSS_TEMPLATE_DESC',		'Zde m��ete vybrat soubor se �ablonou, kter� se nach�z� v adres��� tohoto pluginu, kter� m� b�t pou�it k zobrazen� kan�lu v postrann�m sloupci. M��ete p�idat dal�� �ablony do adres��e pluginu. Pokud je stejn� pojmenovan� soubor �ablony um�st�n v adres��i se �ablonami, bude pou�it m�sto �ablony v adres��i pluginu. T�m, �e zde vyberete jakoukoliv �ablonu jinou ne� p�ednastavenou/defaultn�, bude automaticky povolen �ablonovac� syst�m Smarty.');
