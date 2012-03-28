<?php defined("SYSPATH") or die("No direct script access.") ?>
<a class="edit gDialogLink" href="<?= url::site("quick/form_edit/$item->id") ?>"
  title="<?= t("Edit this item's metadata") ?>">
  <span>
    <?= t("Edit this item") ?>
  </span>
</a>

<? if ($item->type == "photo" && graphics::can("rotate")): ?>
<a class="clockwise" href="<?= url::site("quick/rotate/$item->id/cw?csrf=" . access::csrf_token()) ?>"
  title="<?= t("Rotate 90 degrees clockwise") ?>">
  <span>
    <?= t("Rotate 90 degrees clockwise") ?>
  </span>
</a>
<a class="counter-clockwise" href="<?= url::site("quick/rotate/$item->id/ccw?csrf=" . access::csrf_token()) ?>"
  title="<?= t("Rotate 90 degrees counter clockwise") ?>">
  <span>
    <?= t("Rotate 90 degrees counter clockwise") ?>
  </span>
</a>
<? endif ?>

<a class="move gDialogLink" href="<?= url::site("move/browse/$item->id") ?>"
  title="<?= t("Move this item to another album") ?>">
  <span>
    <?= t("Move this item to another album") ?>
  </span>
</a>

<? if (access::can("edit", $item->parent())): ?>
<a class="cover" href="<?= url::site("quick/make_album_cover/$item->id?csrf=" . access::csrf_token()) ?>"
   title="<?= t("Select as album cover") ?>">
  <span>
    <?= t("Select as album cover") ?>
  </span>
</a>

<a class="delete" href="<?= url::site("quick/delete/$item->id?csrf=" . access::csrf_token()) ?>"
   title="<?= t("Delete this item") ?>">
  <span>
    <?= t("Delete this item") ?>
  </span>
</a>
<? endif ?>

<a class="options" href="#"
   title="<?= t("Additional options") ?>">
  <span>
    <?= t("Additional options") ?>
  </span>
</a>
