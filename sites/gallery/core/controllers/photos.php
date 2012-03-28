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
class Photos_Controller extends Items_Controller {

  /**
   *  @see REST_Controller::_show($resource)
   */
  public function _show($photo) {
    access::required("view", $photo);

    // We sort by id ascending so for now, find sibling info by doing id based queries.
    $next_item = ORM::factory("item")
      ->viewable()
      ->where("parent_id", $photo->parent_id)
      ->where("id >", $photo->id)
      ->orderby("id", "ASC")
      ->find();
    $previous_item = ORM::factory("item")
      ->viewable()
      ->where("parent_id", $photo->parent_id)
      ->where("id <", $photo->id)
      ->orderby("id", "DESC")
      ->find();
    $position = ORM::factory("item")
      ->viewable()
      ->where("parent_id", $photo->parent_id)
      ->where("id <=", $photo->id)
      ->count_all();

    $template = new Theme_View("page.html", "photo");
    $template->set_global("item", $photo);
    $template->set_global("children", array());
    $template->set_global("children_count", $photo->children_count());
    $template->set_global("parents", $photo->parents());
    $template->set_global("next_item", $next_item->loaded ? $next_item : null);
    $template->set_global("previous_item", $previous_item->loaded ? $previous_item : null);
    $template->set_global("sibling_count", $photo->parent()->children_count());
    $template->set_global("position", $position);

    $template->content = new View("photo.html");

    $photo->view_count++;
    $photo->save();

    print $template;
  }

  /**
   * @see REST_Controller::_update($resource)
   */
  public function _update($photo) {
    access::required("edit", $photo);

    $form = photo::get_edit_form($photo);
    if ($form->validate()) {
      // @todo implement changing the name.  This is not trivial, we have
      // to check for conflicts and rename the album itself, etc.  Needs an
      // api method.
      $orig = clone $photo;
      $photo->title = $form->edit_photo->title->value;
      $photo->description = $form->edit_photo->description->value;
      $photo->save();

      module::event("item_updated", $orig, $photo);

      log::success("content", "Updated photo", "<a href=\"photos/$photo->id\">view</a>");
      message::success(t("Saved photo %photo_title", array("photo_title" => $photo->title)));

      print json_encode(
        array("result" => "success",
              "location" => url::site("photos/$photo->id")));
    } else {
      print json_encode(
        array("result" => "error",
              "form" => $form->__toString()));
    }
  }

  /**
   *  @see REST_Controller::_form_edit($resource)
   */
  public function _form_edit($photo) {
    access::required("edit", $photo);
    print photo::get_edit_form($photo);
  }
}
