<?php # $Id: entries_overview.inc.php 2100 2008-02-01 14:10:14Z garvinhicking $
# Copyright (c) 2003-2005, Jannis Hermanns (on behalf the Serendipity Developer Team)
# All rights reserved.  See LICENSE file for licensing details
/* vim: set sts=4 ts=4 expandtab : */

if (IN_serendipity !== true) {
    die ('Don\'t hack!');
}

echo WELCOME_BACK . ' ' . htmlspecialchars($_SESSION['serendipityUser']);

?>
