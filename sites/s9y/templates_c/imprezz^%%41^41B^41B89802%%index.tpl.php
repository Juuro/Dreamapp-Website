<?php /* Smarty version 2.6.26, created on 2010-10-28 15:03:48
         compiled from /home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/default/admin/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'serendipity_hookPlugin', '/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/default/admin/index.tpl', 47, false),array('function', 'serendipity_getFile', '/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/default/admin/index.tpl', 88, false),array('modifier', 'serendipity_refhookPlugin', '/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/default/admin/index.tpl', 80, false),array('modifier', 'checkPermission', '/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/default/admin/index.tpl', 122, false),)), $this); ?>
<html>
    <head>
<!-- ADMIN-ENTRY TEMPLATE: index.tpl START -->
        <title><?php echo $this->_tpl_vars['admin_vars']['title']; ?>
 - <?php echo @SERENDIPITY_ADMIN_SUITE; ?>
</title>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo @LANG_CHARSET; ?>
" />
        <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['admin_vars']['css_file']; ?>
" />
        <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['admin_vars']['admin_css_file']; ?>
" />

        <script type="text/javascript">
        <?php echo '
        function spawn() {
            if (self.Spawnextended) {
                Spawnextended();
            }

            if (self.Spawnbody) {
                Spawnbody();
            }

            if (self.Spawnnugget) {
                Spawnnugget();
            }
        }

        function SetCookie(name, value) {
            var today  = new Date();
            var expire = new Date();
            expire.setTime(today.getTime() + (60*60*24*30*1000));
            document.cookie = \'serendipity[\' + name + \']=\'+escape(value) + \';expires=\' + expire.toGMTString();
        }

        function addLoadEvent(func) {
          var oldonload = window.onload;
          if (typeof window.onload != \'function\') {
            window.onload = func;
          } else {
            window.onload = function() {
              oldonload();
              func();
            }
          }
        }
        '; ?>


        </script>
    <?php if ($this->_tpl_vars['admin_vars']['admin_installed']): ?>
        <?php echo serendipity_smarty_hookPlugin(array('hook' => 'backend_header','hookAll' => 'true'), $this);?>

    <?php endif; ?>
    </head>

    <body id="serendipity_admin_page" onload="spawn()">
        <table cellspacing="0" cellpadding="0" border="0" id="serendipityAdminFrame">

        <?php if (! $this->_tpl_vars['admin_vars']['no_banner']): ?>
            <tr>
                <td colspan="2" id="serendipityAdminBanner">
                <?php if ($this->_tpl_vars['admin_vars']['admin_installed']): ?>
                    <h1><?php echo @SERENDIPITY_ADMIN_SUITE; ?>
</h1>
                    <h2><?php echo $this->_tpl_vars['blogTitle']; ?>
</h2>
                <?php else: ?>
                    <h1><?php echo @SERENDIPITY_INSTALLATION; ?>
</h1>
                <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" id="serendipityAdminInfopane">
                    <?php if ($this->_tpl_vars['admin_vars']['is_logged_in']): ?>
                        <span><?php echo $this->_tpl_vars['admin_vars']['self_info']; ?>
</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endif; ?>

            <tr valign="top">
<?php if (! $this->_tpl_vars['admin_vars']['is_logged_in']): ?>

    <?php echo serendipity_smarty_refhookPlugin($this->_tpl_vars['admin_vars']['out'], 'backend_login_page'); ?>

                <td colspan="2" class="serendipityAdminContent">
                    <div id="serendipityAdminWelcome" align="center">
                        <h2><?php echo @WELCOME_TO_ADMIN; ?>
</h2>
                        <h3><?php echo @PLEASE_ENTER_CREDENTIALS; ?>
</h3>
                        <?php echo $this->_tpl_vars['admin_vars']['out']['header']; ?>

                    </div>
                    <?php if ($this->_tpl_vars['admin_vars']['post_action'] != '' && ! $this->_tpl_vars['admin_vars']['is_logged_in']): ?>
                        <div class="serendipityAdminMsgError"><img width="22px" height="22px" style="border: 0px; padding-right: 2px; vertical-align: middle" src="<?php echo serendipity_smarty_getFile(array('file' => 'admin/img/admin_msg_error.png'), $this);?>
" alt="" /><?php echo @WRONG_USERNAME_OR_PASSWORD; ?>
</div>
                    <?php endif; ?>
                    <form action="serendipity_admin.php" method="post">
                        <input type="hidden" name="serendipity[action]" value="admin" />
                        <table id="serendipityAdminCredentials" cellspacing="10" cellpadding="0" border="0" align="center">
                            <tr>
                                <td><?php echo @USERNAME; ?>
</td>
                                <td><input class="input_textbox" type="text" name="serendipity[user]" /></td>
                            </tr>
                            <tr>
                                <td><?php echo @PASSWORD; ?>
</td>
                                <td><input class="input_textbox" type="password" name="serendipity[pass]" /></td>
                            </tr>
                            <tr>
                                <td colspan="2"><input class="input_checkbox" id="autologin" type="checkbox" name="serendipity[auto]" /><label for="autologin"> <?php echo @AUTOMATIC_LOGIN; ?>
</label></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="right"><input type="submit" name="submit" value="<?php echo @LOGIN; ?>
 &gt;" class="input_button serendipityPrettyButton" /></td>
                            </tr>
                            <?php echo $this->_tpl_vars['admin_vars']['out']['table']; ?>

                        </table>
                    </form>
                    <?php echo $this->_tpl_vars['admin_vars']['out']['footer']; ?>

                    <p id="serendipityBackToBlog"><a href="<?php echo $this->_tpl_vars['serendipityHTTPPath']; ?>
"><?php echo @BACK_TO_BLOG; ?>
</a></p>
<?php else: ?>
    <?php if (! $this->_tpl_vars['admin_vars']['no_sidebar']): ?>
                <td id="serendipitySideBar">

                        <ul class="serendipitySideBarMenu serendipitySideBarMenuMain">
                        <li class="serendipitySideBarMenuHead serendipitySideBarMenuMainLinks" style="display:none"></li>
                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuMainLinks serendipitySideBarMenuMainFrontpage"><a href="serendipity_admin.php"><?php echo @ADMIN_FRONTPAGE; ?>
</a></li>
                        <?php if (((is_array($_tmp='personalConfiguration')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp))): ?>
                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuMainLinks serendipitySideBarMenuMainPersonal"><a href="serendipity_admin.php?serendipity[adminModule]=personal"><?php echo @PERSONAL_SETTINGS; ?>
</a></li>
                        <?php endif; ?>
                        <li class="serendipitySideBarMenuFoot serendipitySideBarMenuMainLinks" style="display:none"></li>
                    </ul>
                    <br class="serendipitySideBarMenuSpacer" />                                                                                             
    
                        <?php if (((is_array($_tmp='adminEntries')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp)) || ((is_array($_tmp='adminEntriesPlugins')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp))): ?>
                    <ul class="serendipitySideBarMenu serendipitySideBarMenuEntry">
                        <li class="serendipitySideBarMenuHead serendipitySideBarMenuEntryLinks"><?php echo @ADMIN_ENTRIES; ?>
</li>
                        <?php if (((is_array($_tmp='adminEntries')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp))): ?>
                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="serendipity_admin.php?serendipity[adminModule]=entries&amp;serendipity[adminAction]=new"><?php echo @NEW_ENTRY; ?>
</a></li>
                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="serendipity_admin.php?serendipity[adminModule]=entries&amp;serendipity[adminAction]=editSelect"><?php echo @EDIT_ENTRIES; ?>
</a></li>
                        <?php endif; ?>

                        <?php if (((is_array($_tmp='adminComments')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp))): ?>
                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="serendipity_admin.php?serendipity[adminModule]=comments"><?php echo @COMMENTS; ?>
</a></li>
                        <?php endif; ?>

                        <?php if (((is_array($_tmp='adminCategories')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp))): ?>
                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="serendipity_admin.php?serendipity[adminModule]=category&amp;serendipity[adminAction]=view"><?php echo @CATEGORIES; ?>
</a></li>
                        <?php endif; ?>

                        <?php if (((is_array($_tmp='adminEntries')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp)) || ((is_array($_tmp='adminEntriesPlugins')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp))): ?>
                        <?php if ($this->_tpl_vars['admin_vars']['no_create'] !== true): ?> <?php echo serendipity_smarty_hookPlugin(array('hook' => 'backend_sidebar_entries','hookAll' => 'true'), $this);?>
<?php endif; ?>
                        <?php endif; ?>
                        <li class="serendipitySideBarMenuFoot serendipitySideBarMenuEntryLinks" style="display:none"></li>
                    </ul>
                    <?php endif; ?>
                    
            <?php if (((is_array($_tmp='adminImages')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp))): ?>
                    <ul class="serendipitySideBarMenu serendipitySideBarMenuMedia">
                        <li class="serendipitySideBarMenuHead serendipitySideBarMenuMediaLinks"><?php echo @MEDIA; ?>
</li>
                        <?php if (((is_array($_tmp='adminImagesAdd')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp))): ?>
                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuMediaLinks"><a href="serendipity_admin.php?serendipity[adminModule]=media&amp;serendipity[adminAction]=addSelect"><?php echo @ADD_MEDIA; ?>
</a></li>
                        <?php endif; ?>
                        <?php if (((is_array($_tmp='adminImagesView')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp))): ?>
                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuMediaLinks"><a href="serendipity_admin.php?serendipity[adminModule]=media"><?php echo @MEDIA_LIBRARY; ?>
</a></li>
                        <?php endif; ?>
                        <?php if (((is_array($_tmp='adminImagesDirectories')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp))): ?>
                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuMediaLinks"><a href="serendipity_admin.php?serendipity[adminModule]=media&amp;serendipity[adminAction]=directorySelect"><?php echo @MANAGE_DIRECTORIES; ?>
</a></li>
                        <?php endif; ?>
                        <?php if (((is_array($_tmp='adminImagesSync')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp))): ?>
                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuMediaLinks"><a href="serendipity_admin.php?serendipity[adminModule]=media&amp;serendipity[adminAction]=sync" onclick="return confirm('<?php echo @WARNING_THIS_BLAHBLAH; ?>
');"><?php echo @CREATE_THUMBS; ?>
</a></li>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['admin_vars']['no_create'] !== true): ?> <?php echo serendipity_smarty_hookPlugin(array('hook' => 'backend_sidebar_entries_images','hookAll' => 'true'), $this);?>
<?php endif; ?>
                        <li class="serendipitySideBarMenuFoot serendipitySideBarMenuMediaLinks" style="display:none"></li>
                    </ul>
        <?php endif; ?>
    
            <?php if (((is_array($_tmp='adminTemplates')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp)) || ((is_array($_tmp='adminPlugins')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp))): ?>
                    <ul class="serendipitySideBarMenu serendipitySideBarMenuAppearance">
                        <li class="serendipitySideBarMenuHead serendipitySideBarMenuAppearanceLinks"><?php echo @APPEARANCE; ?>
</li>
                        <?php if (((is_array($_tmp='adminTemplates')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp))): ?>
                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuAppearanceLinks"><a href="serendipity_admin.php?serendipity[adminModule]=templates"><?php echo @MANAGE_STYLES; ?>
</a></li>
                        <?php endif; ?>
                        <?php if (((is_array($_tmp='adminPlugins')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp))): ?>
                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuAppearanceLinks"><a href="serendipity_admin.php?serendipity[adminModule]=plugins"><?php echo @CONFIGURE_PLUGINS; ?>
</a></li>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['admin_vars']['no_create'] !== true): ?> <?php echo serendipity_smarty_hookPlugin(array('hook' => 'backend_sidebar_admin_appearance','hookAll' => 'true'), $this);?>
<?php endif; ?>
                        <li class="serendipitySideBarMenuFoot serendipitySideBarMenuAppearance" style="display:none"></li>
                    </ul>
        <?php endif; ?>
    
            <?php if (((is_array($_tmp='adminUsersGroups')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp)) || ((is_array($_tmp='adminImport')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp)) || ((is_array($_tmp='siteConfiguration')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp)) || ((is_array($_tmp='blogConfiguration')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp)) || ((is_array($_tmp='adminUsers')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp))): ?>
                    <ul class="serendipitySideBarMenu serendipitySideBarMenuUserManagement">
                        <li class="serendipitySideBarMenuHead serendipitySideBarMenuUserManagementLinks"><?php echo @ADMIN; ?>
</li>
                        <?php if (((is_array($_tmp='siteConfiguration')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp)) || ((is_array($_tmp='blogConfiguration')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp))): ?>
                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuUserManagementLinks"><a href="serendipity_admin.php?serendipity[adminModule]=configuration"><?php echo @CONFIGURATION; ?>
</a></li>
                        <?php endif; ?>
                        <?php if (((is_array($_tmp='adminUsers')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp))): ?>
                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuUserManagementLinks"><a href="serendipity_admin.php?serendipity[adminModule]=users"><?php echo @MANAGE_USERS; ?>
</a></li>
                        <?php endif; ?>
                        <?php if (((is_array($_tmp='adminUsersGroups')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp))): ?>
                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuUserManagementLinks"><a href="serendipity_admin.php?serendipity[adminModule]=groups"><?php echo @MANAGE_GROUPS; ?>
</a></li>
                        <?php endif; ?>
                        <?php if (((is_array($_tmp='adminImport')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp))): ?>
                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuUserManagementLinks"><a href="serendipity_admin.php?serendipity[adminModule]=import"><?php echo @IMPORT_ENTRIES; ?>
</a></li>
                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuUserManagementLinks"><a href="serendipity_admin.php?serendipity[adminModule]=export"><?php echo @EXPORT_ENTRIES; ?>
</a></li>
                        <?php endif; ?>
                        <?php if (((is_array($_tmp='siteConfiguration')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp)) || ((is_array($_tmp='blogConfiguration')) ? $this->_run_mod_handler('checkPermission', true, $_tmp) : serendipity_checkPermission($_tmp))): ?>
                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuUserManagementLinks"><a href="serendipity_admin.php?serendipity[adminModule]=integrity"><?php echo @INTEGRITY; ?>
</a></li>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['admin_vars']['no_create'] !== true): ?> <?php echo serendipity_smarty_hookPlugin(array('hook' => 'backend_sidebar_admin','hookAll' => 'true'), $this);?>
<?php endif; ?>
                        <li class="serendipitySideBarMenuFoot serendipitySideBarMenuUserManagement" style="display:none"></li>
                    </ul>
        <?php endif; ?>
    
                        <br class="serendipitySideBarMenuSpacer" />                                                                                             
                    <ul class="serendipitySideBarMenu serendipitySideBarMenuLogout">
                        <li class="serendipitySideBarMenuHead serendipitySideBarMenuLogoutLinks" style="display:none"></li>
                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuLogoutLinks serendipitySideBarMenuLogoutWeblog"><a href="<?php echo $this->_tpl_vars['serendipityBaseURL']; ?>
"><?php echo @BACK_TO_BLOG; ?>
</a></li>
                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuLogoutLinks serendipitySideBarMenuLogoutLogout"><a href="serendipity_admin.php?serendipity[adminModule]=logout"><?php echo @LOGOUT; ?>
</a></li>
                        <li class="serendipitySideBarMenuFoot serendipitySideBarMenuLogoutLinks" style="display:none"></li>
                    </ul>
    
                </td>
    <?php endif; ?>
                <td class="serendipityAdminContent">

                        <?php echo $this->_tpl_vars['admin_vars']['main_content']; ?>

    
<?php endif; ?>
                </td>
            </tr>
        </table>
        <div class="serendipityAdminFooterSpacer">
            <br />
        </div>
        <div id="serendipityAdminFooter">
            <span><?php echo $this->_tpl_vars['admin_vars']['version_info']; ?>
</span>
        </div>                            
    </body>
<!-- ADMIN-ENTRY TEMPLATE: index.tpl END -->
</html>