<?php # $Id:$

##########################################################################
# serendipity - another blogger...                                       #
##########################################################################
#                                                                        #
# (c) 2003 Jannis Hermanns <J@hacked.it>                                 #
# http://www.jannis.to/programming/serendipity.html                      #
#                                                                        #
# Translated by                                                          #
# Jo�o P Matos <jmatos@math.ist.utl.pt>                                  #
#                                                                        #
##########################################################################

@define('PLUGIN_EVENT_SPARTACUS_NAME', 'Spartacus');
@define('PLUGIN_EVENT_SPARTACUS_DESC', '[S]erendipity [P]lugin [A]ccess [R]epository [T]ool [A]nd [C]ustomization/[U]nification [S]ystem - Permite obter plugins directamente dos arquivos oficiais do Serendipity.');
@define('PLUGIN_EVENT_SPARTACUS_FETCH', 'Prima aqui para carregar um novo %s do arquivo oficial do Serendipity');
@define('PLUGIN_EVENT_SPARTACUS_FETCHERROR', 'Imposs�vel aceder ao endere�o %s. Pode ser que o servidor do Serendipity ou de SourceForge.net esteja temporariamente inacess�vel. Tente por favor mais tarde.');
@define('PLUGIN_EVENT_SPARTACUS_FETCHING', 'Tentando aceder ao endere�o %s...');
@define('PLUGIN_EVENT_SPARTACUS_FETCHED_BYTES_URL', 'Obteve %s bytes da URL acima. Guardando o ficheiro como %s...');
@define('PLUGIN_EVENT_SPARTACUS_FETCHED_BYTES_CACHE', 'Obteve %s bytes dum ficheiro j� existente no seu servidor. Guardando o ficheiro como %s...');
@define('PLUGIN_EVENT_SPARTACUS_FETCHED_DONE', 'Dados descarregados com sucesso.');
@define('PLUGIN_EVENT_SPARTACUS_MIRROR_XML', 'Localiza��o de Ficheiro/Mirror (metadata XML)');
@define('PLUGIN_EVENT_SPARTACUS_MIRROR_FILES', 'Localiza��o de Ficheiro/Mirror (ficheiros)');
@define('PLUGIN_EVENT_SPARTACUS_MIRROR_DESC', 'Escolha a localiza��o do arquivo. N�O mude este valor a n�o ser que saiba o que est� a fazer e os servidores estiverem desactualizados. Esta op��o foi disponibilizada principalmente para compatibilidade futura.');
@define('PLUGIN_EVENT_SPARTACUS_CHOWN', 'Propriet�rio dos ficheiros descarregados');
@define('PLUGIN_EVENT_SPARTACUS_CHOWN_DESC', 'Aqui pode mudar o (FTP/Shell) propriet�rio (por exemplo "nobody") de ficheiros descarregados pelo Spartacus. Se vazio, n�o s�o s�o feitas altera��es.');
@define('PLUGIN_EVENT_SPARTACUS_CHMOD', 'Permiss�es de ficheiros descarregados');
@define('PLUGIN_EVENT_SPARTACUS_CHMOD_DESC', 'Aqui pode introduzir o modo octal (por exemplo "0777") das permiss�es de ficheiros (FTP/Shell) descarregados pelo Spartacus. Se vazio, a m�scara de permiss�es por omiss�o do sistema � usada. Note que nem todos os servidores permitem definir ou alterar permiss�es. Note que as permiss�es aplicadas devem permitir leitura e escrita por parte do utilizador do servidor web. Al�m disso o spartacus/Serendipity n�o pode escrever sobre ficheiros existentes.');
@define('PLUGIN_EVENT_SPARTACUS_CHMOD_DIR', 'Permiss�es das directorias descarregadas');
@define('PLUGIN_EVENT_SPARTACUS_CHMOD_DIR_DESC', 'Aqui pode introduzir o modo octal (por exemplo "0777") das permiss�es de directorias (FTP/Shell) downloaded by Spartacus. descarregados pelo Spartacus. Se vazio, a m�scara de permiss�es por omiss�o do sistema � usada. Note que nem todos os servidores permitem definir ou alterar permiss�es. Note que as permiss�es aplicadas devem permitir leitura e escrita por parte do utilizador do servidor web. Al�m disso o spartacus/Serendipity n�o pode escrever sobre ficheiros existentes.');

/* vim: set sts=4 ts=4 expandtab : */
?>