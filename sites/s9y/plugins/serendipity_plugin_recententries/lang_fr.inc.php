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

@define('PLUGIN_RECENTENTRIES_TITLE', 'Billets r�cents');
@define('PLUGIN_RECENTENTRIES_BLAHBLAH', 'Affiche les titres et dates des billets les plus r�cents');
@define('PLUGIN_RECENTENTRIES_NUMBER', 'Nombre de billets');
@define('PLUGIN_RECENTENTRIES_NUMBER_BLAHBLAH', 'D�finit combien de billets doivent �tre affich�s. Valeur par d�faut: 10');
@define('PLUGIN_RECENTENTRIES_NUMBER_FROM', 'Ignorer les billets sur la page d\'accueil');
@define('PLUGIN_RECENTENTRIES_NUMBER_FROM_DESC', 'D�finit si seulement les billets r�cents qui ne sont pas affich�s sur la page principale du blog seront affich�s. (Par d�faut, les ' . $serendipity['fetchLimit'] . ' derniers billets seront ignor�s)');
@define('PLUGIN_RECENTENTRIES_NUMBER_FROM_RADIO_ALL', 'Non, afficher tous les billets');
@define('PLUGIN_RECENTENTRIES_NUMBER_FROM_RADIO_RECENT', 'Oui');

/* vim: set sts=4 ts=4 expandtab : */
?>