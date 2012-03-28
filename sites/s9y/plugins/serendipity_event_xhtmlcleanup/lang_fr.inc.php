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

@define('PLUGIN_EVENT_XHTMLCLEANUP_NAME', 'Correction des erreurs courantes XHTML');
@define('PLUGIN_EVENT_XHTMLCLEANUP_DESC', 'Permet de corriger automatiquement une bonne partie des erreurs courantes en XHTML.');
@define('PLUGIN_EVENT_XHTMLCLEANUP_XHTML', 'Encoder les donn�es XML?');
@define('PLUGIN_EVENT_XHTMLCLEANUP_XHTML_DESC', 'Ce plugin utilise une m�thode d\'analyse bas�e sur le XML pour valider le XHTML de votre blog. Il se peut que cette analyse peut convertisse des caract�res d�j� valides une seconde fois. D�sactivez cette option si c\'est le cas dans votre blog.');
@define('PLUGIN_EVENT_XHTMLCLEANUP_UTF8', 'Nettoyer les entit�s UTF-8?');
@define('PLUGIN_EVENT_XHTMLCLEANUP_UTF8_DESC', 'Si cette option est activ�e, les entit�s HTML d�riv�es des caract�res UTF-8 seront correctement converties.');

/* vim: set sts=4 ts=4 expandtab : */
?>