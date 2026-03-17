<?php
/**
 * Shell - class to work with $wpdb global object
 */
#[\AllowDynamicProperties]
class dbUms
{
  /**
   * Execute query and return results
   * @param string $query query to be executed
   * @param string $get what must be returned - one value (one), one row (row), one col (col) or all results (all - by default)
   * @param const $outputType type of returned data
   * @return mixed data from DB
   */
  public static $query = '';
  public static function get($query, $get = 'all', $outputType = ARRAY_A)
  {
    global $wpdb;
  }
  /**
   * Execute one query
   * @return query results
   */
  public static function query($query)
  {
    global $wpdb;
  }
  /**
   * Get last insert ID
   * @return int last ID
   */
  public static function insertID()
  {
    global $wpdb;
    return $wpdb->insert_id;
  }
  /**
   * Get number of rows returned by last query
   * @return int number of rows
   */
  public static function numRows()
  {
    global $wpdb;
    return $wpdb->num_rows;
  }
  /**
   * Replace prefixes in custom query. Suported next prefixes:
   * #__  Worumsess prefix
   * ^__  Store plugin tables prefix (@see UMS_DB_PREF if config.php)
   * @__  Compared of WP table prefix + Store plugin prefix (@example wp_s_)
   * @param string $query query to be executed
   */
  public static function prepareQuery($query)
  {
    global $wpdb;
    return str_replace(['#__', '^__', '@__'], [$wpdb->prefix, UMS_DB_PREF, $wpdb->prefix . UMS_DB_PREF], $query);
  }
  public static function getError()
  {
    global $wpdb;
    return $wpdb->last_error;
  }
  public static function lastID()
  {
    global $wpdb;
    return $wpdb->insert_id;
  }
  public static function timeToDate($timestamp = 0)
  {
    if ($timestamp) {
      if (!is_numeric($timestamp)) {
        $timestamp = dateToTimestampUms($timestamp);
      }
      return date('Y-m-d', $timestamp);
    } else {
      return date('Y-m-d');
    }
  }
  public static function dateToTime($date)
  {
    if (empty($date)) {
      return '';
    }
    if (strpos($date, UMS_DATE_DL)) {
      return dateToTimestampUms($date);
    }
    $arr = explode('-', $date);
    return dateToTimestampUms($arr[2] . UMS_DATE_DL . $arr[1] . UMS_DATE_DL . $arr[0]);
  }
  public static function exist($table)
  {
    global $wpdb;
    switch ($table) {
      case 'ums_icons':
        $res = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}ums_icons'");
        break;
      case 'ums_maps':
        $res = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}ums_maps'");
        break;
      case 'ums_markers':
        $res = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}ums_markers'");
        break;
      case 'ums_marker_groups':
        $res = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}ums_marker_groups'");
        break;
      case 'ums_marker_groups':
        $res = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}ums_marker_groups'");
        break;
      case 'ums_modules':
        $res = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}ums_modules'");
        break;
      case 'ums_modules_type':
        $res = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}ums_modules_type'");
        break;
      case 'ums_options':
        $res = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}ums_options'");
        break;
      case 'ums_options_categories':
        $res = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}ums_options_categories'");
        break;
      case 'ums_shapes':
        $res = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}ums_shapes'");
        break;
      case 'ums_usage_stat':
        $res = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}ums_usage_stat'");
        break;
    }
    return !empty($res);
  }
  public static function prepareHtml($d)
  {
    if (is_array($d)) {
      foreach ($d as $i => $el) {
        $d[$i] = self::prepareHtml($el);
      }
    } else {
      $d = esc_html($d);
    }
    return $d;
  }
  public static function escape($data)
  {
    global $wpdb;
    return $wpdb->_escape($data);
  }
  public static function getAutoIncrement($table)
  {
    // return (int) self::get('SELECT AUTO_INCREMENT
    // 	FROM information_schema.tables
    // 	WHERE table_name = "'. $table. '"
    // 	AND table_schema = DATABASE( );', 'one');
  }
  public static function setAutoIncrement($table, $autoIncrement)
  {
    // return self::query("ALTER TABLE `". $table. "` AUTO_INCREMENT = ". $autoIncrement. ";");
  }
}
