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

@define('PLUGIN_EVENT_WEBLOGPING_PING', 'Annoncer les billets �: (par ping XML)');
@define('PLUGIN_EVENT_WEBLOGPING_SENDINGPING', 'Envoie le ping XML-RPC � l\'h�te %s');
@define('PLUGIN_EVENT_WEBLOGPING_TITLE', 'Annconcer les billets');
@define('PLUGIN_EVENT_WEBLOGPING_DESC', 'Envoyer une mise � jour pour les nouveaux billets aux services d\'indexation');
@define('PLUGIN_EVENT_WEBLOGPING_SUPERSEDES', '(remplace %s)');
@define('PLUGIN_EVENT_WEBLOGPING_CUSTOM', 'Services ping additionnels');
@define('PLUGIN_EVENT_WEBLOGPING_CUSTOM_BLAHBLA', 'Vous permet d\'ajouter des services additionnels; entrez les adresses cibles ici, s�parez plusieurs adresses par des virgules (,). Les adresses doivent �tre au format "h�te.domaine/chemin". Si un "*" est ajout� au d�but de l\'h�te, les options XML-RPC �tendues seront envoy�es � l\h�te cible (seulement si celui-ci les g�re).');
@define('PLUGIN_EVENT_WEBLOGPING_SEND_FAILURE', 'Le ping a �chou�. (Raison: %s)');
@define('PLUGIN_EVENT_WEBLOGPING_SEND_SUCCESS', 'Ping r�ussi.');

/* vim: set sts=4 ts=4 expandtab : */
?>