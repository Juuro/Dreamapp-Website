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
class Task_Model extends ORM {

  public function get($key, $default=null) {
    $context = unserialize($this->context);
    if (array_key_exists($key, $context)) {
      return $context[$key];
    } else {
      return $default;
    }
  }

  public function set($key, $value) {
    $context = unserialize($this->context);
    $context[$key] = $value;
    $this->context = serialize($context);
  }

  public function save() {
    if (!empty($this->changed)) {
      $this->updated = time();
    }
    return parent::save();
  }
}