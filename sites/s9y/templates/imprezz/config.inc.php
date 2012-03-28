<?php
if (IN_serendipity !== true) {
  die ("Don't hack!");
}

$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';

if (file_exists($probelang)) {
    include $probelang;
}

include dirname(__FILE__) . '/lang_en.inc.php';

$serendipity['smarty']->assign(array('currpage'=> "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));

$template_config = array(
    array(
        'var'           => 'externalfeed',
        'name'          => IMPR_EXTERNAL_FEED,
        'type'          => 'string',
        'default'       => '',
    ),
    array(
        'var'           => 'twitterwidget',
        'name'          => IMPR_TWITTER_WIDGET,
        'description'   => IMPR_TWITTER_WIDGET_DESC,
        'type'          => 'boolean',
        'default'       => 'true',
    ),
    array(
        'var'           => 'twitteruser',
        'name'          => IMPR_TWITTER_USERNAME,
        'type'          => 'string',
        'default'       => '',
    ),
    array(
        'var'           => 'googleads_use',
        'name'          => IMPR_GOOGLE_ADS_USE,
        'description'   => IMPR_GOOGLE_ADS_DESC,
        'type'          => 'boolean',
        'default'       => 'false',
    ),
    array(
        'var'           => 'googleads_code',
        'name'          => IMPR_GOOGLE_ADS_CODE,
        'type'          => 'text',
        'default'       => '',
    ),
    array(
        'var'           => 'amount',
        'name'          => NAVLINK_AMOUNT,
        'type'          => 'string',
        'default'       => '5',
    )
);

$template_loaded_config = serendipity_loadThemeOptions($template_config, $serendipity['smarty_vars']['template_option']);

$navlinks = array();

for ($i = 0; $i < $template_loaded_config['amount']; $i++) {
    $navlinks[] = array(
        'title' => $template_loaded_config['navlink' . $i . 'text'],
        'href'  => $template_loaded_config['navlink' . $i . 'url']
    );
    $template_config[] = array(
        'var'           => 'navlink' . $i . 'text',
        'name'          => NAV_LINK_TEXT . ' #' . $i,
        'type'          => 'string',
        'default'       => 'Link #' . $i,
        );
    $template_config[] = array(
        'var'           => 'navlink' . $i . 'url',
        'name'          => NAV_LINK_URL . ' #' . $i,
        'type'          => 'string',
        'default'       => '#',
    );
}

$serendipity['smarty']->assign_by_ref('navlinks', $navlinks);
