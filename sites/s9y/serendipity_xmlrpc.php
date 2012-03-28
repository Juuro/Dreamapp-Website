<?php # $Id: serendipity_xmlrpc.php 1055 2006-04-06 09:14:11Z garvinhicking $
# Copyright (c) 2003-2005, Jannis Hermanns (on behalf the Serendipity Developer Team)
# All rights reserved.  See LICENSE file for licensing details

if (!defined('S9Y_FRAMEWORK')) {
    require 'serendipity_config.inc.php';
}

$data = array();
serendipity_plugin_api::hook_event('frontend_xmlrpc', $data);

if (count($data) == 0) {
    die(XMLRPC_NO_LONGER_BUNDLED);
}
