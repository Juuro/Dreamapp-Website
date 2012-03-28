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
class Admin_Maintenance_Controller extends Admin_Controller {
  /**
   * Get all available tasks
   * @todo move task definition out into the modules
   */
  private function _get_task_definitions() {
    $tasks = array();
    foreach (module::installed() as $module_name => $module_info) {
      $class_name = "{$module_name}_task";
      if (method_exists($class_name, "available_tasks")) {
        foreach (call_user_func(array($class_name, "available_tasks")) as $task) {
          $tasks[$task->callback] = $task;
        }
      }
    }

    return $tasks;
  }

  /**
   * Show a list of all available, running and finished tasks.
   */
  public function index() {
    $query = Database::instance()->query(
      "UPDATE `tasks` SET `state` = 'stalled' " .
      "WHERE done = 0 " .
      "AND   state <> 'stalled' " .
      "AND   unix_timestamp(now()) - updated > 120");
    $stalled_count = $query->count();
    if ($stalled_count) {
      log::warning("tasks",
                   t2("One task is stalled",
                      "%count tasks are stalled",
                      $stalled_count),
                   t("%link_startview%link_end",
                     array("link_start" => "<a href=\"" . url::site("admin/maintenance") . "\">",
                           "link_start" => "</a>")));
    }

    $view = new Admin_View("admin.html");
    $view->content = new View("admin_maintenance.html");
    $view->content->task_definitions = $this->_get_task_definitions();
    $view->content->running_tasks =
      ORM::factory("task")->where("done", 0)->orderby("updated", "desc")->find_all();
    $view->content->finished_tasks =
      ORM::factory("task")->where("done", 1)->orderby("updated", "desc")->find_all();
    $view->content->csrf = access::csrf_token();
    print $view;
  }

  /**
   * Start a new task
   * @param string $task_callback
   */
  public function start($task_callback) {
    access::verify_csrf();

    $task_definitions = $this->_get_task_definitions();

    $task = ORM::factory("task");
    $task->callback = $task_callback;
    $task->name = $task_definitions[$task_callback]->name;
    $task->percent_complete = 0;
    $task->status = "";
    $task->state = "started";
    $task->context = serialize(array());
    $task->save();

    $view = new View("admin_maintenance_task.html");
    $view->csrf = access::csrf_token();
    $view->task = $task;

    log::info("tasks", t("Task %task_name started (task id %task_id)",
                         array("task_name" => $task->name, "task_id" => $task->id)),
              html::anchor(url::site("admin/maintenance"), t("maintenance")));
    print $view;
  }

  /**
   * Resume a stalled task
   * @param string $task_id
   */
  public function resume($task_id) {
    access::verify_csrf();

    $task = ORM::factory("task", $task_id);
    if (!$task->loaded) {
      throw new Exception("@todo MISSING_TASK");
    }
    $view = new View("admin_maintenance_task.html");
    $view->csrf = access::csrf_token();
    $view->task = $task;

    log::info("tasks", t("Task %task_name resumed (task id %task_id)",
                         array("task_name" => $task->name, "task_id" => $task->id)),
              html::anchor(url::site("admin/maintenance"), t("maintenance")));
    print $view;
  }

  /**
   * Cancel a task.
   * @param string $task_id
   */
  public function cancel($task_id) {
    access::verify_csrf();

    $task = ORM::factory("task", $task_id);
    if (!$task->loaded) {
      throw new Exception("@todo MISSING_TASK");
    }
    $task->done = 1;
    $task->state = "cancelled";
    $task->save();

    message::success(t("Task cancelled"));
    url::redirect("admin/maintenance");
  }

  /**
   * Remove a task.
   * @param string $task_id
   */
  public function remove($task_id) {
    access::verify_csrf();

    $task = ORM::factory("task", $task_id);
    if (!$task->loaded) {
      throw new Exception("@todo MISSING_TASK");
    }
    $task->delete();
    message::success(t("Task removed"));
    url::redirect("admin/maintenance");
  }

  /**
   * Run a task.  This will trigger the task to do a small amount of work, then it will report
   * back with status on the task.
   * @param string $task_id
   */
  public function run($task_id) {
    access::verify_csrf();

    $task = ORM::factory("task", $task_id);
    if (!$task->loaded) {
      throw new Exception("@todo MISSING_TASK");
    }

    $task->state = "running";
    call_user_func_array($task->callback, array(&$task));
    $task->save();

    if ($task->done) {
      switch ($task->state) {
      case "success":
        log::success("tasks", t("Task %task_name completed (task id %task_id)",
                                array("task_name" => $task->name, "task_id" => $task->id)),
                     html::anchor(url::site("admin/maintenance"), t("maintenance")));
        message::success(t("Task completed successfully"));
        break;

      case "error":
        log::error("tasks", t("Task %task_name failed (task id %task_id)",
                              array("task_name" => $task->name, "task_id" => $task->id)),
                   html::anchor(url::site("admin/maintenance"), t("maintenance")));
        message::success(t("Task failed"));
        break;
      }
      print json_encode(
        array("result" => "success",
              "task" => $task->as_array(),
              "location" => url::site("admin/maintenance")));
    } else {
      print json_encode(
        array("result" => "in_progress",
              "task" => $task->as_array()));
    }
  }
}
