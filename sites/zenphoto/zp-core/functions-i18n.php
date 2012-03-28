<?php
/**
 * functions-i18n.php -- support functions for internationalization
 * @package core
 */

// force UTF-8 Ø


define ('DEBUG_LOCALE', false); // used for examining language selection problems

function setupLanguageArray() {
	global $_zp_languages;
	$_zp_languages = array(
		'af' => gettext('Afrikaans'),
		'sq_AL' => gettext('Albanian'),
		'ar_AE' => gettext('Arabic (United Arab Emirates)'),
		'ar_BH' => gettext('Arabic (Bahrain)'),
		'ar_DZ' => gettext('Arabic (Algeria)'),
		'ar_EG' => gettext('Arabic (Egypt)'),
		'ar_IN' => gettext('Arabic (Iran)'),
		'ar_IQ' => gettext('Arabic (Iraq)'),
		'ar_JO' => gettext('Arabic (Jordan)'),
		'ar_KW' => gettext('Arabic (Kuwait)'),
		'ar_LB' => gettext('Arabic (Lebanon)'),
		'ar_LY' => gettext('Arabic (Libya)'),
		'ar_MA' => gettext('Arabic (Morocco)'),
		'ar_OM' => gettext('Arabic (Oman)'),
		'ar_QA' => gettext('Arabic (Qatar)'),
		'ar_SA' => gettext('Arabic (Saudi Arabia)'),
		'ar_SD' => gettext('Arabic (Sudan)'),
		'ar_SY' => gettext('Arabic (Syria)'),
		'ar_TN' => gettext('Arabic (Tunisia)'),
		'ar_YE' => gettext('Arabic (Yemen)'),
		'eu_ES' => gettext('Basque (Basque)'),
		'be_BY' => gettext('Belarusian'),
		'bn_BD' => gettext('Bengali'),
		'bg_BG' => gettext('Bulgarian'),
		'ca_ES' => gettext('Catalan'),
		'zh_CN' => gettext('Chinese (People\'s Republic of China)'),
		'zh_HK' => gettext('Chinese (Hong Kong)'),
		'zh_TW' => gettext('Chinese (Taiwan)'),
		'hr_HR' => gettext('Croatian'),
		'cs_CZ' => gettext('Czech'),
		'km_KH' => gettext('Cambodian'),
		'da_DK' => gettext('Danish'),
		'nl_BE' => gettext('Dutch (Belgium)'),
		'nl_NL' => gettext('Dutch (The Netherlands)'),
		'en_AU' => gettext('English (Australia)'),
		'en_CA' => gettext('English (Canada)'),
		'en_GB' => gettext('English (United Kingdom)'),
		'en_IN' => gettext('English (India)'),
		'en_NZ' => gettext('English (New Zealand)'),
		'en_PH' => gettext('English (Philippines)'),
		'en_US' => gettext('English (United States)'),
		'en_ZA' => gettext('English (South Africa)'),
		'en_ZW' => gettext('English (Zimbabwe)'),
		'eo' => gettext('Esperanto'),
		'EE' => gettext('Estonian'),
		'fi_FI' => gettext('Finnish'),
		'fo_FO' => gettext('Faroese'),
		'fr_BE' => gettext('French (Belgium)'),
		'fr_CA' => gettext('French (Canada)'),
		'fr_CH' => gettext('French (Switzerland)'),
		'fr_FR' => gettext('French (France)'),
		'fr_LU' => gettext('French (Luxembourg)'),
		'gl_ES' => gettext('Galician'),
		'gu_IN' => gettext('Gujarati'),
		'el' => gettext('Greek'),
		'de_AT' => gettext('German (Austria)'),
		'de_BE' => gettext('German (Belgium)'),
		'de_CH' => gettext('German (Switzerland)'),
		'de_DE' => gettext('German (Germany)'),
		'de_LU' => gettext('German (Luxembourg)'),
		'he_IL' => gettext('Hebrew'),
		'hi_IN' => gettext('Hindi'),
		'hu_HU' => gettext('Hungarian'),
		'id_ID' => gettext('Indonesian'),
		'is_IS' => gettext('Icelandic'),
		'it_CH' => gettext('Italian (Switzerland)'),
		'it_IT' => gettext('Italian (Italy)'),
		'ja_JP' => gettext('Japanese'),
		'ko_KR' => gettext('Korean'),
		'lt_LT' => gettext('Lithuanian'),
		'lv_LV' => gettext('Latvian'),
		'mk_MK' => gettext('Macedonian'),
		'mn_MN' => gettext('Mongolian'),
		'ms_MY' => gettext('Malay'),
		'mg_MG' => gettext('Malagasy'),
		'nb_NO' => gettext('Norwegian (Bokml)'),
		'no_NO' => gettext('Norwegian'),
		'ni_ID' => gettext('Nias'),
		'fa_IR' => gettext('Persian'),
		'pl_PL' => gettext('Polish'),
		'pt_BR' => gettext('Portuguese (Brazil)'),
		'pt_PT' => gettext('Portuguese (Portugal)'),
		'ro_RO' => gettext('Romanian'),
		'ru_RU' => gettext('Russian (Russia)'),
		'ru_UA' => gettext('Russian (Ukraine)'),
		'si_LK' => gettext('Sinhala'),
		'sk_SK' => gettext('Slovaka'),
		'sl_SI' => gettext('Slovenian'),
		'es_AR' => gettext('Spanish (Argentina)'),
		'es_BO' => gettext('Spanish (Bolivia)'),
		'es_CL' => gettext('Spanish (Chile)'),
		'es_CO' => gettext('Spanish (Columbia)'),
		'es_CR' => gettext('Spanish (Costa Rica)'),
		'es_DO' => gettext('Spanish (Dominican Republic)'),
		'es_EC' => gettext('Spanish (Ecuador)'),
		'es_ES' => gettext('Spanish (Spain)'),
		'es_GT' => gettext('Spanish (Guatemala)'),
		'es_HN' => gettext('Spanish (Honduras)'),
		'es_MX' => gettext('Spanish (Mexico)'),
		'es_NI' => gettext('Spanish (Nicaragua)'),
		'es_PA' => gettext('Spanish (Panama)'),
		'es_PE' => gettext('Spanish (Peru)'),
		'es_PR' => gettext('Spanish (Puerto Rico)'),
		'es_PY' => gettext('Spanish (Paraguay)'),
		'es_SV' => gettext('Spanish (El Salvador)'),
		'es_US' => gettext('Spanish (United States)'),
		'es_UY' => gettext('Spanish (Uruguay)'),
		'es_VE' => gettext('Spanish (Venezuela)'),
		'es_LA' => gettext('Spanish (Latin America)'),
		'sr_YU' => gettext('Serbian'),
		'sr_RS' => gettext('Serbian'),
		'sv_FI' => gettext('Swedish (Finland)'),
		'sv_SE' => gettext('Swedish (Sweden)'),
		'ta_IN' => gettext('Tamil'),
		'te_IN' => gettext('Telugu'),
		'th_TH' => gettext('Thai'),
		'tr_TR' => gettext('Turkish'),
		'uk_UA' => gettext('Ukrainian'),
		'uz_UZ' => gettext('Uzbek'),
		'ur_PK' => gettext('Urdu (Pakistan)'),
		'vi_VN' => gettext('Vietnamese'),
		'cy' => gettext('Welsh')
	);
	
}

/**
 * Returns an array of available language locales.
 *
 * @return array
 *
 */
function generateLanguageList() {
	global $_zp_languages;
	$dir = @opendir(SERVERPATH . "/" . ZENFOLDER ."/locale/");
	$locales = array();
	if ($dir !== false) {
		while ($dirname = readdir($dir)) {
			if (is_dir(SERVERPATH . "/" . ZENFOLDER ."/locale/".$dirname) && (substr($dirname, 0, 1) != '.')) {
				if (isset($_zp_languages[$dirname])) {
					$language = $_zp_languages[$dirname];
					if (empty($language)) {
						$language = $dirname;
					}
					$locales[$language] = $dirname;
				} else {
					$locales[$dirname] = $dirname;
				}
			}
		}
		closedir($dir);
	}
	natsort($locales);
	return $locales;
}

$_zp_active_languages = NULL;
/**
 * Generates the option list for the language selectin <select>
 * @param bool $HTTPAccept set to true to include the HTTPAccept item
 *
 */
function generateLanguageOptionList($HTTPAccept) {
	global $_zp_active_languages;
	if (is_null($_zp_active_languages)) {
		$_zp_active_languages = generateLanguageList();
	}
	$locales = $_zp_active_languages;
	if ($HTTPAccept) {  // for admin only
		$locales[gettext("HTTP Accept Language")] = '';
	}
	generateListFromArray(array(getOption('locale', $HTTPAccept)), $locales, false, true);
}


/**
 * Sets the optional textdomain for separate translation files for plugins.
 * The plugin translation files must be located within
 * zp-core/plugins/<plugin name>/locale/<language locale>/LC_MESSAGES/ and must
 * have the name of the plugin (<plugin name>.po  <plugin name>.mo)
 * 
 * Return value is the success of the setlocale() call
 * 
 * @param string $plugindomain The name of the plugin
 * @return bool 
 * 
 */
function setPluginDomain($plugindomain) {
	return setupCurrentLocale($plugindomain,"plugin");
}

/**
 * Sets the locale, etc. to the zenphoto domain details.
 * Returns the rewult of setupCurrentLocale()
 *
 */
function setMainDomain() {
	getUserLocale();
	return setupCurrentLocale();
}

/**
 * Sets the optional textdomain for separate translation files for themes.
 * The plugin translation files must be located within
 * zenphoto/themes/<theme name>/locale/<language locale>/LC_MESSAGES/ and must
 * have the name of the theme (<theme name>.po  <theme name>.mo)
 *
 * Return value is the success of the setlocale() call
 * 
 * @param string $plugindomain The name of the theme
 * @return bool
 */
function setThemeDomain($themedomain) {
	return setupCurrentLocale($themedomain,"theme");
}

/**
 * Setup code for gettext translation
 * Returns the result of the setlocale call
 *
 * @return mixed
 */
function setupCurrentLocale($plugindomain='', $type='') {
	global $_zp_languages;
	$encoding = getOption('charset');
	if (empty($encoding)) $encoding = 'UTF-8';
	if(empty($plugindomain) && empty($type)) {
		$locale = getOption("locale");
		@putenv("LANG=$locale");
		// gettext setup
		$result = setlocale(LC_ALL, $locale.'.'.$encoding, $locale);
		if (!$result) { // failed to set the locale
			if (isset($_POST['dynamic-locale'])) { // and it was chosen via dynamic-locale
				$cookiepath = WEBPATH;
				if (WEBPATH == '') { $cookiepath = '/'; }
				$locale = sanitize($_POST['oldlocale'], 3);
				setOption('locale', $locale, false);
				zp_setCookie('dynamic_locale', '', time()-368000, $cookiepath);
			}
		}
		// Set the text domain as 'messages'
		$domain = 'zenphoto';
		$domainpath = SERVERPATH . "/" . ZENFOLDER . "/locale/";
		if (DEBUG_LOCALE) debugLogBacktrace("setupCurrentLocale($plugindomain, $type): locale=$locale");
	} else {
		$domain = $plugindomain;
		switch ($type) {
			case "plugin":
				$domainpath = SERVERPATH . "/" . ZENFOLDER . PLUGIN_FOLDER . $domain . "/locale/";
				break;
			case "theme":
				$domainpath = SERVERPATH . "/" . THEMEFOLDER . "/" . $domain."/locale/";
				break;
			case 'admin':
				$domainpath = SERVERPATH . "/" . ZENFOLDER . PLUGIN_FOLDER . $domain . "/locale/";
				$domain = 'zenphoto';
				break;
		}
		$result = true;
		if (DEBUG_LOCALE) debugLogBacktrace("setupCurrentLocale($plugindomain, $type): domainpath=$domainpath");
	}
	bindtextdomain($domain, $domainpath);
	// function only since php 4.2.0
	if(function_exists('bind_textdomain_codeset')) {
		bind_textdomain_codeset($domain, $encoding);
	}
	textdomain($domain);
	return $result;
}

/**
 * This function will parse a given HTTP Accepted language instruction
 * (or retrieve it from $_SERVER if not provided) and will return a sorted
 * array. For example, it will parse fr;en-us;q=0.8
 *
 * Thanks to Fredbird.org for this code.
 *
 * @param string $str optional language string
 * @return array
 */
function parseHttpAcceptLanguage($str=NULL) {
	if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) return array();
	// getting http instruction if not provided
	$str=$str?$str:$_SERVER['HTTP_ACCEPT_LANGUAGE'];
	// exploding accepted languages
	$langs=explode(',',$str);
	// creating output list
	$accepted=array();
	foreach ($langs as $lang) {
		// parsing language preference instructions
		// 2_digit_code[-longer_code][;q=coefficient]
		ereg('([A-Za-z]{1,2})(-([A-Za-z0-9]+))?(;q=([0-9\.]+))?',$lang,$found);
		// 2 digit lang code
		$code=$found[1];
		// lang code complement
		$morecode=$found[3];
		// full lang code
		$fullcode=$morecode?$code.'_'.$morecode:$code;
		// coefficient
		$coef=sprintf('%3.1f',$found[5]?$found[5]:'1');
		// for sorting by coefficient
		$key=$coef.'-'.$code;
		// adding
		$accepted[$key]=array('code'=>$code,'coef'=>$coef,'morecode'=>$morecode,'fullcode'=>$fullcode);
	}
	// sorting the list by coefficient desc
	krsort($accepted);
	if (DEBUG_LOCALE) {
		debugLog("parseHttpAcceptLanguage($str)");
		debugLogArray('$accepted', $accepted);
	}
	return $accepted;
}

/**
 * Returns a saved (or posted) locale. Posted locales are stored as a cookie.
 *
 * Sets the 'locale' option to the result (non-persistent)
 */
function getUserLocale() {
	if (DEBUG_LOCALE) debugLogBackTrace("getUserLocale()");
	$cookiepath = WEBPATH;
	if (WEBPATH == '') { $cookiepath = '/'; }
	if (isset($_POST['dynamic-locale'])) {
		$locale = sanitize($_POST['dynamic-locale'], 0);
		zp_setCookie('dynamic_locale', $locale, time()+COOKIE_PESISTENCE, $cookiepath);
		if (DEBUG_LOCALE) debugLog("dynamic_locale post: $locale");
	} else {
		$localeOption = getOption('locale');
		$locale = zp_getCookie('dynamic_locale');
		if (DEBUG_LOCALE) debugLog("locale from option: ".$localeOption.'; dynamic locale='.$locale);
		if (empty($localeOption) && ($locale === false)) {  // if one is not set, see if there is a match from 'HTTP_ACCEPT_LANGUAGE'
			$languageSupport = generateLanguageList();
			$userLang = parseHttpAcceptLanguage();
			foreach ($userLang as $lang) {
				$l = strtoupper($lang['fullcode']);
				foreach ($languageSupport as $key=>$value) {
					if (strtoupper($value) == $l) { // we got a match
						$locale = $value;
						if (DEBUG_LOCALE) debugLog("locale set from HTTP Accept Language: ".$locale);
						break;
					} else if (preg_match('/^'.$l.'/', strtoupper($value))) { // we got a partial match
						$locale = $value;
						if (DEBUG_LOCALE) debugLog("locale set from HTTP Accept Language (partial match): ".$locale);
						break;
					}
				}
				if ($locale) break;
			}
		}
	}
	if ($locale !== false) {
		setOption('locale', $locale, false);
	}
	if (DEBUG_LOCALE) debugLog("Returning locale: ".$locale);
	return $locale;
}

/**
 * Returns the sring for the current language from a serialized set of language strings
 * Defaults to the string for the current locale, the en_US string, or the first string which ever is present
 *
 * @param string $dbstring either a serialized languag string array or a single string
 * @param string $locale optional locale of the translation desired
 * @return string
 */
function get_language_string($dbstring, $locale=NULL) {
	if (!preg_match('/^a:[0-9]+:{/', $dbstring)) {
		return $dbstring;
	}
	$strings = unserialize($dbstring);
	$actual_local = getOption('locale');
	if (is_null($locale)) $locale = $actual_local;
	if (isset($strings[$locale])) {
		return $strings[$locale];
	}
	if (isset($strings[$actual_local])) {
		return $strings[$actual_local];
	}
	if (isset($strings['en_US'])) {
		return $strings['en_US'];
	}
	return array_shift($strings);
}

setupLanguageArray();

?>