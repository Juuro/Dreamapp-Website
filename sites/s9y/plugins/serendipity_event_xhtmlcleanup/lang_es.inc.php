<?php # $Id: lang_es.inc.php 1381 2006-08-15 10:14:56Z elf2000 $

/**
 *  @version $Revision: 1381 $
 *  @author Rodrigo Lazo <rlazo.paz@gmail.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_XHTMLCLEANUP_NAME', 'Arreglar errores XHTML comunes');
@define('PLUGIN_EVENT_XHTMLCLEANUP_DESC', 'Esta extensi�n corrige problemas comunes con las entradas que utilizan XHTML. Ayuda a mantener tu blog de acuerdo con el estandar XHTML.');
@define('PLUGIN_EVENT_XHTMLCLEANUP_XHTML', '�Codificar la data XML-procesada?');
@define('PLUGIN_EVENT_XHTMLCLEANUP_XHTML_DESC', 'Esta extensi�n utiliza un m�todo de procesamiento xml para asegurar la validez XHTML de tu c�digo. Este procesamiento xml pude que convierta entradas ya v�lidas a entidades sin escapes, as� que la extensi�n codifica todas las entidades antes de la revisi�n. �Define esta opci�n como APAGADA si introduce doble codificaci�n a tus entradas!');
@define('PLUGIN_EVENT_XHTMLCLEANUP_UTF8', '�Limpiar las entidades UTF-8?');
@define('PLUGIN_EVENT_XHTMLCLEANUP_UTF8_DESC', 'Si lo activas, las entidades HTML derivadas de caracteres UTF-8 se convertir�n correctamente y no habr� doble codificaci�n en tu salida.');

?>
