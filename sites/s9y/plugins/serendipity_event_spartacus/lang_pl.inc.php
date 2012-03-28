<?php # $Id: lang_pl.inc.php 1548 2006-12-20 18:26:17Z garvinhicking $

/**
 *  @version $Revision: 1548 $
 *  @author Kostas CoSTa Brzezinski <costa@kofeina.net>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_SPARTACUS_NAME', 'Spartacus');
@define('PLUGIN_EVENT_SPARTACUS_DESC', '[S]erendipity [P]lugin [A]ccess [R]epository [T]ool [A]nd [C]ustomization/[U]nification [S]ystem - pozwala na pobieranie wtyczek z repoztori�w sieciowych');
@define('PLUGIN_EVENT_SPARTACUS_FETCH', 'Kliknij tutaj by pobra� %s z Sieciowego Repozytorium Serendipity');
@define('PLUGIN_EVENT_SPARTACUS_FETCHERROR', 'URL %s nie m�g� by� otwarty. By� mo�e serwer Serendipity lub SourceFroge.net aktualnie nie dzia�a - w takim przypadku przepraszamy i prosimy spr�bowac ponownie p�niej.');
@define('PLUGIN_EVENT_SPARTACUS_FETCHING', 'Pr�ba otwarcia URLa %s...');
@define('PLUGIN_EVENT_SPARTACUS_FETCHED_BYTES_URL', 'Pobrano %s bajt�w z powy�szego URLa. Zapisuj� plik jako %s...');
@define('PLUGIN_EVENT_SPARTACUS_FETCHED_BYTES_CACHE', 'Pobrano %s bajt�w z ju� istniej�cego pliku na Twoim serwerze. Zapisuj� plik jako %s...');
@define('PLUGIN_EVENT_SPARTACUS_FETCHED_DONE', 'Pobieranie danych zako�czone sukcesem.');
@define('PLUGIN_EVENT_SPARTACUS_REPOSITORY_ERROR', '<br />(repozytorium zwr�ci�o kod b��du %s.)<br />');
@define('PLUGIN_EVENT_SPARTACUS_HEALTHCHECK', '<P>Nie mog� pobra� danych z repozytorium SPARTACUSa. Sprawdzam dost�pno�� repozytorium.</P>');
@define('PLUGIN_EVENT_SPARTACUS_HEALTHERROR', '<P>Strona z informacj� o dost�pno�ci repozytori�w dla SPARTACUSa zwr�ci�a b��d (kod HTTP %s). To oznacza, �e strona aktualnie nie funkcjonuje. Prosz� spr�bowa� ponownie p�niej.</P>');
@define('PLUGIN_EVENT_SPARTACUS_HEALTHLINK', '<P><a target="_blank" href="%s">Kliknij tutaj</a> by zobaczy� stron� z informacj� o dost�pno�ci repozytori�w dla SPARTACUSa i sprawd�, czy strona odpowiada.</P>');
@define('PLUGIN_EVENT_SPARTACUS_HEALTHBLOCKED', '<P>SPARTACUS pr�bowa� po��czy� si� z Google i nie powiod�a si� ta operacja (b��d %d: %s).<br />Tw�j serwer blokuje po��czenia wychodz�ce.    Your server is blocking outgoing connections. SPARTACUS nie b�dzie funkcjonowa� prawid�owo poniewa� nie mo�e skontaktowa� si� z repozytorium. <b>Prosz�, skontaktuj si� z providerem i popro� o zezwolenie na po��czenia wychodz�ce z serwera.</b></P><P>Wtyczki mog� by� oczywi�cie instalowane bezpo�rednio z katalog�w na serwerze. Po prostu pobierz wtyczk� z <a href="http://spartacus.s9y.org">repozytorium SPARTACUSa</a>, rozpakuj, wgraj rozpakowany katalog do katalogu wtyczek (plugins).</P>');
@define('PLUGIN_EVENT_SPARTACUS_HEALTHDOWN', '<P>SPARTACUS mo�e po��czy� si� z Google ale nie mo�e po��czy� si� z repozytorium. Jest mo�liwe, �e Tw�j serwer blokuje pewne po��czenia wychodz�ce albo �e strona z repozytorium SPARTACUSa aktualnie nie dzia�a. Skontaktuj si� z firm� hostuj�c� Twoj� stron� i upewnij si�, �e po��czenia wychodz�ce s� dozwolone. <b>Nie b�dziesz m�g� u�ywa� SPARTACUSa dop�ki Tw�j serwer nie b�dzie m�g� kontaktowa� si� z repozytorium SPARTACUSa.</b></P>');
@define('PLUGIN_EVENT_SPARTACUS_MIRROR_XML', 'Lokalizacja pliku/mirrora (metadane XML)');
@define('PLUGIN_EVENT_SPARTACUS_MIRROR_FILES', 'Lokalizacja pliku/mirrora (pliki)');
@define('PLUGIN_EVENT_SPARTACUS_MIRROR_DESC', 'Wybierz lokalizacj�, z kt�rej b�d� pobierane dane. NIE zmieniaj tej warto�ci o ile dobrze nie wiesz, co robisz i o ile serwer jest dost�pny.	Opcja istnieje g��wnie dla kompatybilno�ci z przysz�ymi wersjami wtyczki.');
@define('PLUGIN_EVENT_SPARTACUS_CHOWN', 'W�a�ciciel pobranych plik�w');
@define('PLUGIN_EVENT_SPARTACUS_CHOWN_DESC', 'Tu mo�esz poda� w�a�ciciela (jak np. "nobody") plik�w pobieranych i zapisywanych przez Spartacusa. Pozostawienie pustego pola nie spowoduje zmian uprawnie� do plik�w.');
@define('PLUGIN_EVENT_SPARTACUS_CHMOD', 'Upraweniania pobieranych plik�w');
@define('PLUGIN_EVENT_SPARTACUS_CHMOD_DESC', 'Tu mo�esz wprowadzi� �semkowe warto�ci (jak "0777") uprawnie� dost�pu do plik�w pobranych przez Spartacusa. Je�li nic nie ustawisz - przyj�ta zostanie domy�lna maska systemu. Zwr�� uwag� na to, by wprowadzone uprawnienia umo�liwia�y czytanie i zapisywanie plik�w przez u�ytkownika serwera www. W przeciwnym wypadku Spartacus/Serendipiy nie b�dzie m�g� nadpisa� istniej�cych plik�w. Uwaga, nie wszystkie serwery zezwalaj� na takie operacje.');
@define('PLUGIN_EVENT_SPARTACUS_CHMOD_DIR', 'Uprawnienia pobieranych katalog�w');
@define('PLUGIN_EVENT_SPARTACUS_CHMOD_DIR_DESC', 'Tu mo�esz wprowadzi� �semkowe warto�ci (jak "0777") uprawnie� dost�pu do katalog�w pobranych przez Spartacusa. Je�li nic nie ustawisz - przyj�ta zostanie domy�lna maska systemu. Zwr�� uwag� na to, by wprowadzone uprawnienia umo�liwia�y czytanie i zapisywanie katalog�w przez u�ytkownika serwera www. W przeciwnym wypadku Spartacus/Serendipiy nie b�dzie m�g� nadpisa� istniej�cych katalog�w. Uwaga, nie wszystkie serwery zezwalaj� na takie operacje.');

@define('PLUGIN_EVENT_SPARTACUS_CHECK_SIDEBAR', 'Sprawd� czy s� nowe wtyczki Panelu bocznego');
@define('PLUGIN_EVENT_SPARTACUS_CHECK_EVENT', 'Sprawd� czy s� nowe wtyczki Zdarze�');
@define('PLUGIN_EVENT_SPARTACUS_CHECK_HINT', 'Podpowied�: Mo�esz uaktualni� kilka wtyczek jednocze�nie klikaj�c link uaktualnienia �rodkowym klawiszem myszy, tak by otworzy� ten link w nowym oknie lub nowym tabie (zak�adce) przegl�darki. Zauwa�, �e uaktualnianie kilku wtyczek jednocze�nie mog�oby prowadzi� do timeout�w i problem�w z pobieraniem plik�w a w efekcie - nagromadzenia �mieci i potencjalnych problem�w. Dlatego taka funkcjonalno�� nie zosta�a zaimplementowana rozmy�lnie.');
?>
