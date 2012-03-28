<?php # $Id: lang_es.inc.php 1381 2006-08-15 10:14:56Z elf2000 $
/**
 *  @version $Revision: 1381 $
 *  @author Rodrigo Lazo Paz <rlazo.paz@gmail.com>
 *  EN-Revision: 690
 */

@define('PLUGIN_EVENT_SPARTACUS_NAME', 'Spartacus');
@define('PLUGIN_EVENT_SPARTACUS_DESC', '[S]erendipity [P]lugin [A]ccess [R]epository [T]ool [A]nd [C]ustomization/[U]nification [S]ystem - Te permite descargar extensiones desde nuestro repositorio en linea');
@define('PLUGIN_EVENT_SPARTACUS_FETCH', 'Haz click aqu� para descargar un nuevo %s desde el Respositorio En-linea Serendipity');
@define('PLUGIN_EVENT_SPARTACUS_FETCHERROR', 'El URL %s no pudo ser abierto. Quiz�s Serendipity o el servidor en SourceForge.net est�n desconectados - lo lamentamos, intenta de nuevo m�s tarde.');
@define('PLUGIN_EVENT_SPARTACUS_FETCHING', 'Intentando acceder al URL %s...');
@define('PLUGIN_EVENT_SPARTACUS_FETCHED_BYTES_URL', 'Descargados %s bytes desde la URL. Guardando el archivo como %s...');
@define('PLUGIN_EVENT_SPARTACUS_FETCHED_BYTES_CACHE', 'Descargandos %s bytes desde un archivo ya existente en tu servidor. Guardando el archivo como %s...');
@define('PLUGIN_EVENT_SPARTACUS_FETCHED_DONE', 'Data descargada con �xito.');
@define('PLUGIN_EVENT_SPARTACUS_MIRROR_XML', 'Ubicaci�n del archivo/r�plica (XML metadata)');
@define('PLUGIN_EVENT_SPARTACUS_MIRROR_FILES', 'Ubicaci�n del archivo/r�plica (files)');
@define('PLUGIN_EVENT_SPARTACUS_MIRROR_DESC', 'Escoge una ubicaci�n de descarga. NO alteres este valor a menos que sepas lo que est�s haciendo y si el servidor se desactualiza. Esta opci�n est� disponible principalmente para compatibilidad con forward.');
@define('PLUGIN_EVENT_SPARTACUS_CHOWN', 'Due�o de los archivos descargados');
@define('PLUGIN_EVENT_SPARTACUS_CHOWN_DESC', 'Aqu� puedes ingresar el (FTP/Shell) due�o (por ejemplo "nobody") de los archivos descargados por Spartacus. Si lo dejas en blanco, no se realizar�n cambios en la propiedad.');
@define('PLUGIN_EVENT_SPARTACUS_CHMOD', 'Permisos de los archivos descargados');
@define('PLUGIN_EVENT_SPARTACUS_CHMOD_DESC', 'Aqu� puedes ingresar los permisos de los archivos (FTP/Shell) descargados por Spartacus en modo octal (por ejemplo "0777"). Si lo dejas vac�o,  los permisos por defecto del sistema ser�n utilizados. Nota que no todos los servidores permiten definir/cambiar permisos. Presta atenci�n que los permisos aplicados permiten la lectura y escritura por parte del usuario del webserver. Fuera de eso spartacus/Serendipity no puede sobreescribir archivos existentes.');
@define('PLUGIN_EVENT_SPARTACUS_CHMOD_DIR', 'Permisos de los directorios descargados');
@define('PLUGIN_EVENT_SPARTACUS_CHMOD_DIR_DESC', 'Aqu� puedes ingresar los permisos de los directorios (FTP/Shell) descargados por Spartacus en modo octal (por ejemplo "0777"). Si lo dejas vac�o,  los permisos por defecto del sistema ser�n utilizados. Nota que no todos los servidores permiten definir/cambiar permisos. Presta atenci�n que los permisos aplicados permiten la lectura y escritura por parte del usuario del webserver. Fuera de eso spartacus/Serendipity no puede sobreescribir directorios existentes.');

?>
