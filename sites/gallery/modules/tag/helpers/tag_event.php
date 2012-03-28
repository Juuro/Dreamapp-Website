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
class tag_event_Core {
  /**
   * Handle the creation of a new photo.
   * @todo Get tags from the XMP and/or IPTC data in the image
   *
   * @param Item_Model $photo
   */
  static function item_created($photo) {
    if ($photo->is_photo()) {
      $path = $photo->file_path();
      $tags = array();
      $size = getimagesize($photo->file_path(), $info);
      if (is_array($info) && !empty($info["APP13"])) {
        $iptc = iptcparse($info["APP13"]);
        if (!empty($iptc["2#025"])) {
          foreach($iptc["2#025"] as $tag) {
            $tags[$tag]= 1;
          }
        }
      }
    }

    // @todo figure out how to read the keywords from xmp

    foreach(array_keys($tags) as $tag) {
      tag::add($photo, $tag);
    }

    return;
  }

  static function item_before_delete($item) {
    $tags = ORM::factory("tag")
      ->join("items_tags", "tags.id", "items_tags.tag_id")
      ->join("items", "items.id", "items_tags.item_id")
      ->where("items_tags.item_id", $item->id)
      ->find_all();

    foreach($tags as $tag) {
      $tag->count--;
      if ($tag->count > 0) {
        $tag->save();
      } else {
        $tag->delete();
      }
    }
    
    $db = Database::instance();
    $db->query("DELETE FROM `items_tags` WHERE `item_id` = $item->id;");
  }

}
