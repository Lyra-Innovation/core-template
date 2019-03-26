<?php


namespace App;

class ModelHelper {
  public static function containsItem($items, $value) {
        foreach($items as $item) {
            if($item->item_id == $value) return true;
        }
        return false;
    }

}