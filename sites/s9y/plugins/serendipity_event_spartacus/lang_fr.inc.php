<?php # $Id: lang_fr.inc.php 1381 2006-08-15 10:14:56Z elf2000 $

##########################################################################
# serendipity - another blogger...                                       #
##########################################################################
#                                                                        #
# (c) 2003 Jannis Hermanns <J@hacked.it>                                 #
# http://www.jannis.to/programming/serendipity.html                      #
#                                                                        #
# Translated by                                                          #
# Sebastian Mordziol <argh@php-tools.net>                                #
# http://sebastian.mordziol.de                                           #
#                                                                        #
##########################################################################

@define('PLUGIN_EVENT_SPARTACUS_NAME', 'Spartacus');
@define('PLUGIN_EVENT_SPARTACUS_DESC', '[S]erendipity [P]lugin [A]ccess [R]epository [T]ool [A]nd [C]ustomization/[U]nification [S]ystem - Vous permet de t�l�charger des plugins directement de notre d�p�t officiel.');
@define('PLUGIN_EVENT_SPARTACUS_FETCH', 'Cliquez ici pour t�l�charger un nouveau %s du d�p�t officiel de Serendipity');
@define('PLUGIN_EVENT_SPARTACUS_FETCHERROR', 'Impossible d\'acc�der � l\'adresse %s. Peut-�tre que le serveur de Serendipity ou de SourceForge.net n\'est momentan�ment pas accessible. Merci de r�essayer plus tard.');
@define('PLUGIN_EVENT_SPARTACUS_FETCHING', 'Essaie d\'acc�der � l\'adresse %s...');

@define('PLUGIN_EVENT_SPARTACUS_FETCHED_BYTES_URL', '%s octets lus � partir de l\'adresse ci-dessus. Enregistrement du fichier sous %s...');
@define('PLUGIN_EVENT_SPARTACUS_FETCHED_BYTES_CACHE', '%s octets lus � partir du fichier d�j� pr�sent sur votre serveur. Enregsitrement du fichier sous %s...');
@define('PLUGIN_EVENT_SPARTACUS_FETCHED_DONE', 'Donn�es lues avec succ�s.');
@define('PLUGIN_EVENT_SPARTACUS_MIRROR_XML', 'Emplacement du fichier/miroir (Donn�es XML)');
@define('PLUGIN_EVENT_SPARTACUS_MIRROR_FILES', 'Emplacement du fichier/miroir (Fichiers)');
@define('PLUGIN_EVENT_SPARTACUS_MIRROR_DESC', 'S�lectionnez un emplacement de t�l�chargement. Attention: ne changez PAS cette valeur si vous ne savez pas exactement ce que vous faites et si des serveurs sont p�rim�s. Cette option n\'existe que pour la compatibilit� avec les versions futures de Serendipity.');
@define('PLUGIN_EVENT_SPARTACUS_CHOWN', 'Propri�taire des fichiers t�l�charg�s');
@define('PLUGIN_EVENT_SPARTACUS_CHOWN_DESC', 'Ici vous pouvez entrer le nom de l\'utilisateur (FTP/Shell) propri�taire des fichiers, comme par ex. "nobody". Si vous laissez ce champs vide, aucun changement ne sera fait.');
@define('PLUGIN_EVENT_SPARTACUS_CHMOD', 'Permissions des fichiers t�l�charg�s');
@define('PLUGIN_EVENT_SPARTACUS_CHMOD_DESC', 'Ici vous pouvez entrer le mode octal (comme "0777" par ex.) pour les fichiers t�l�charg�s. Si vous laissez ce champs vide, les permissions par d�faut de votre serveur seront utilis�s. Notez que tous les serveurs ne permettent pas de changer les permissions de fichier. Faites attention aussi que les permissions que vous d�finissez permettent encore � Serendipity d\'acc�der aux fichiers.');
@define('PLUGIN_EVENT_SPARTACUS_CHMOD_DIR', 'Permissions des r�pertoires t�l�charg�s');
@define('PLUGIN_EVENT_SPARTACUS_CHMOD_DIR_DESC', 'Ici vous pouvez entrer le mode octal (comme "0777" par ex.) pour les r�pertoires t�l�charg�s. Si vous laissez ce champs vide, les permissions par d�faut de votre serveur seront utilis�s. Notez que tous les serveurs ne permettent pas de changer les permissions de r�pertoire. Faites attention aussi que les permissions que vous d�finissez permettent encore � Serendipity d\'acc�der aux r�pertoires.');

/* vim: set sts=4 ts=4 expandtab : */
?>