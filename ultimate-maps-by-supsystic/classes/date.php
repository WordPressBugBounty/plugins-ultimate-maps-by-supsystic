<?php
#[\AllowDynamicProperties]
class dateUms
{
  public static function _($time = null)
  {
    if (is_null($time)) {
      $time = time();
    }
    return date(UMS_DATE_FORMAT_HIS, $time);
  }
}
