<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2008 Bharat Mediratta
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 */

/**
 * Translates a localizable message.
 * @param $message String The message to be translated. E.g. "Hello world"
 * @param $options array (optional) Options array for key value pairs which are used
 *        for pluralization and interpolation. Special key: "locale" to override the
 *        currently configured locale.
 * @return String The translated message string.
 */
function t($message, $options=array()) {
  return I18n::instance()->translate($message, $options);
}

/**
 * Translates a localizable message with plural forms.
 * @param $singular String The message to be translated. E.g. "There is one album."
 * @param $plural String The plural message to be translated. E.g.
 *        "There are %count albums."
 * @param $count Number The number which is inserted for the %count placeholder and
 *        which is used to select the proper plural form ($singular or $plural).
 * @param $options array (optional) Options array for key value pairs which are used
 *        for pluralization and interpolation. Special key: "locale" to override the
 *        currently configured locale.
 * @return String The translated message string.
 */
function t2($singular, $plural, $count, $options=array()) {
  return I18n::instance()->translate(array("one" => $singular, "other" => $plural),
                                     array_merge($options, array("count" => $count)));
}

class I18n_Core {
  private $_config = array();

  private $_cache = array();

  private static $_instance;

  private function __construct($config) {
    $this->_config = $config;
  }

  public static function instance($config=null) {
    if (self::$_instance == NULL || isset($config)) {
      $config = isset($config) ? $config : Kohana::config('locale');
      self::$_instance = new I18n_Core($config);
    }

    return self::$_instance;
  }

  /**
   * Translates a localizable message.
   * @param $message String|array The message to be translated. E.g. "Hello world"
   *                 or array("one" => "One album", "other" => "%count albums")
   * @param $options array (optional) Options array for key value pairs which are used
   *        for pluralization and interpolation. Special keys are "count" and "locale",
   *        the latter to override the currently configured locale.
   * @return String The translated message string.
   */
  public function translate($message, $options=array()) {
    $locale = empty($options['locale']) ? $this->_config['default_locale'] : $options['locale'];
    $count = empty($options['count']) ? null : $options['count'];
    $values = $options;
    unset($values['locale']);

    $entry = $this->lookup($locale, $message);

    if (empty($entry)) {
      // Default to the root locale.
      $entry = $message;
      $locale = $this->_config['root_locale'];
    }

    $entry = $this->pluralize($locale, $entry, $count);

    $entry = $this->interpolate($locale, $entry, $values);

    return $entry;
  }

  private function lookup($locale, $message) {
    if (!isset($this->_cache[$locale])) {
      $this->_cache[$locale] = array();
      // TODO: Load data from locale file instead of the DB.
      foreach (Database::instance()
               ->select("key", "translation")
               ->from("incoming_translations")
               ->where(array("locale" => $locale))
               ->get()
               ->as_array() as $row) {
        $this->_cache[$locale][$row->key] = unserialize($row->translation);
      }
    }

    // If message is an array (plural forms), use the first form as message id.
    $key = is_array($message) ? array_shift($message) : $message;
    $key = md5($key, true);

    if (isset($this->_cache[$locale][$key])) {
      return $this->_cache[$locale][$key];
    } else {
      return null;
    }
  }

  private function interpolate($locale, $string, $values) {
    // TODO: Handle locale specific number formatting.

    // Replace x_y before replacing x.
    krsort($values, SORT_STRING);

    $keys = array();
    foreach (array_keys($values) as $key) {
      $keys[] = "%$key";
    }
    return str_replace($keys, array_values($values), $string);
  }

  private function pluralize($locale, $entry, $count) {
    if (!is_array($entry)) {
      return $entry;
    } else if ($count == null) {
      $count = 1;
    }

    $plural_key = self::get_plural_key($locale, $count);
    if (!isset($entry[$plural_key])) {
      // Fallback to the default plural form.
      $plural_key = 'other';
    }

    if (isset($entry[$plural_key])) {
      return $entry[$plural_key];
    } else {
      // Fallback to just any plural form.
      list ($plural_key, $string) = each($entry);
      return $string;
    }
  }

  private static function get_plural_key($locale, $count) {
    $parts = explode('_', $locale);
    $language = $parts[0];

    // Data from CLDR 1.6 (http://unicode.org/cldr/data/common/supplemental/plurals.xml).
    // Docs: http://www.unicode.org/cldr/data/charts/supplemental/language_plural_rules.html
    switch ($language) {
      case 'az':
      case 'fa':
      case 'hu':
      case 'ja':
      case 'ko':
      case 'my':
      case 'to':
      case 'tr':
      case 'vi':
      case 'yo':
      case 'zh':
      case 'bo':
      case 'dz':
      case 'id':
      case 'jv':
      case 'ka':
      case 'km':
      case 'kn':
      case 'ms':
      case 'th':
        return 'other';

      case 'ar':
        if ($count == 0) {
          return 'zero';
        } else if ($count == 1) {
          return 'one';
        } else if ($count == 2) {
          return 'two';
        } else if (is_int($count) && ($i = $count % 100) >= 3 && $i <= 10) {
          return 'few';
        } else if (is_int($count) && ($i = $count % 100) >= 11 && $i <= 99) {
          return 'many';
        } else {
          return 'other';
        }

      case 'pt':
      case 'am':
      case 'bh':
      case 'fil':
      case 'tl':
      case 'guw':
      case 'hi':
      case 'ln':
      case 'mg':
      case 'nso':
      case 'ti':
      case 'wa':
        if ($count == 0 || $count == 1) {
          return 'one';
        } else {
          return 'other';
        }

      case 'fr':
        if ($count >= 0 and $count < 2) {
          return 'one';
        } else {
          return 'other';
        }

      case 'lv':
        if ($count == 0) {
          return 'zero';
        } else if ($count % 10 == 1 && $count % 100 != 11) {
          return 'one';
        } else {
          return 'other';
        }

      case 'ga':
      case 'se':
      case 'sma':
      case 'smi':
      case 'smj':
      case 'smn':
      case 'sms':
        if ($count == 1) {
          return 'one';
        } else if ($count == 2) {
          return 'two';
        } else {
          return 'other';
        }

      case 'ro':
      case 'mo':
        if ($count == 1) {
          return 'one';
        } else if (is_int($count) && $count == 0 && ($i = $count % 100) >= 1 && $i <= 19) {
          return 'few';
        } else {
          return 'other';
        }

      case 'lt':
        if (is_int($count) && $count % 10 == 1 && $count % 100 != 11) {
          return 'one';
        } else if (is_int($count) && ($i = $count % 10) >= 2 && $i <= 9 && ($i = $count % 100) < 11 && $i > 19) {
          return 'few';
        } else {
          return 'other';
        }

      case 'hr':
      case 'ru':
      case 'sr':
      case 'uk':
      case 'be':
      case 'bs':
      case 'sh':
        if (is_int($count) && $count % 10 == 1 && $count % 100 != 11) {
          return 'one';
        } else if (is_int($count) && ($i = $count % 10) >= 2 && $i <= 4 && ($i = $count % 100) < 12 && $i > 14) {
          return 'few';
        } else if (is_int($count) && ($count % 10 == 0 || (($i = $count % 10) >= 5 && $i <= 9) || (($i = $count % 100) >= 11 && $i <= 14))) {
          return 'many';
        } else {
          return 'other';
        }

      case 'cs':
      case 'sk':
        if ($count == 1) {
          return 'one';
        } else if (is_int($count) && $count >= 2 && $count <= 4) {
          return 'few';
        } else {
          return 'other';
        }

      case 'pl':
        if ($count == 1) {
          return 'one';
        } else if (is_int($count) && ($i = $count % 10) >= 2 && $i <= 4 &&
                   ($i = $count % 100) < 12 && $i > 14 && ($i = $count % 100) < 22 && $i > 24) {
          return 'few';
        } else {
          return 'other';
        }

      case 'sl':
        if ($count % 100 == 1) {
          return 'one';
        } else if ($count % 100 == 2) {
          return 'two';
        } else if (is_int($count) && ($i = $count % 100) >= 3 && $i <= 4) {
          return 'few';
        } else {
          return 'other';
        }

      case 'mt':
        if ($count == 1) {
          return 'one';
        } else if ($count == 0 || is_int($count) && ($i = $count % 100) >= 2 && $i <= 10) {
          return 'few';
        } else if (is_int($count) && ($i = $count % 100) >= 11 && $i <= 19) {
          return 'many';
        } else {
          return 'other';
        }

      case 'mk':
        if ($count % 10 == 1) {
          return 'one';
        } else {
          return 'other';
        }

      case 'cy':
        if ($count == 1) {
          return 'one';
        } else if ($count == 2) {
          return 'two';
        } else if ($count == 8 || $count == 11) {
          return 'many';
        } else {
          return 'other';
        }

      default: // en, de, etc.
        return $count == 1 ? 'one' : 'other';
    }
  }
}