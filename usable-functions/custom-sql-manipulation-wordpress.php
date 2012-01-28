<?php
  /**
   * Fetch all the tags created
   * @global type $wpdb
   * @return type 
   */
  function get_all_tags() {
    global $wpdb;
    $SQL = "SELECT *
              FROM wp_terms AS a
                INNER JOIN wp_term_taxonomy AS b
              WHERE b.taxonomy = 'post_tag'
                  AND a.term_id = b.term_id;";
    $tags = $wpdb->get_results($SQL);

    return $tags;
  }

  /**
   *  For custom SQL queries using the wordpress
   */
  /**
   * start using the plugin class 
   */
  $plugin = new Plugin;
  $plugin->create_plugin_table();
  $data = array('plugin_name' => 'pluginname1', 'plugin_field1' => 'field1 value', 'plugin_field2' => 'field2 value');
  $plugin->insert($data);
  $pluginRow = $plugin->get_plugin_byID(1);
  var_dump($pluginRow);
  foreach ($pluginRow as $value) {
    echo $value->plugin_name . '<br/>';
    echo $value->plugin_field1 . '<br/>';
    echo $value->plugin_field2 . '<br/>';
  }
  $data = array('plugin_name' => 'pluginnameEdit', 'plugin_field1' => 'field1 value Edit', 'plugin_field2' => 'field2 value Edit');
  $id = 1;
  $plugin->update_plugin_byID($data, $id);
  $plugin->delete_plugin_byID($id);
  /**
   * end using of plugin class 
   */

  /**
   * Sample Class: Plugin
   * For Plugin Class 
   */
  class Plugin {

    private $table;

    /**
     * Default constructor
     * Initialized the Class attributes
     * @global type $table_prefix 
     */
    public function __construct() {
      global $table_prefix;
      $this->table = $table_prefix . 'plugins';
    }

    /**
     * For creating the table plugins  if not exist
     * Using the custom SQL in wordpres  
     * @return type 
     */
    public function create_plugin_table() {
      include_once ABSPATH . 'wp-admin/includes/upgrade.php';   //import the wordpress library where dbDelta() function was resided

      $SQL = "CREATE TABLE `$this->table` (              
                `id` bigint(20) NOT NULL AUTO_INCREMENT,
                `plugin_name` text,
                `plugin_field1` text,
                `plugin_field2` text,
                PRIMARY KEY (`id`)
              );";
      $created = dbDelta($SQL);
      return $created;
    }

    /**
     * For Inserting data in the table
     * @global type $wpdb
     * @param type $data 
     */
    public function insert($data) {
      global $wpdb;

      foreach ($data as $column => $value) {
        $fieldsArr[] = $column;
        $valuesArr[] = sprintf("'%s'", $value);
      }
      $fields = implode(', ', $fieldsArr);
      $values = implode(', ', $valuesArr);
      $SQL = "INSERT INTO $this->table (%s) VALUES(%s);";
      $SQL = sprintf($SQL, $fields, $values);
      var_dump($SQL);
      $wpdb->query($SQL);
    }

    /**
     * Fetch Row data 
     * @global type $wpdb
     * @param type $id
     * @return type 
     */
    public function get_plugin_byID($id) {
      global $wpdb;

      $SQL = sprintf("SELECT
                          t.id,
                          t.plugin_name,
                          t.plugin_field1,
                          t.plugin_field2
                        FROM wp_plugins AS t
                        WHERE id = %d;", $id);

      $result = $wpdb->get_results($SQL);
      return $result;
    }

    /**
     * Updating the table data
     * @global type $wpdb
     * @param type $data
     * @param type $id 
     */
    public function update_plugin_byID($data, $id) {
      global $wpdb;

      foreach ($data as $column => $value) {
        $fields[] = sprintf("%s = '%s'", $column, $value);
      }
      $fields = implode(', ', $fields);
      $SQL = "UPDATE $this->table SET %s WHERE id = %d";
      $SQL = sprintf($SQL, $fields, $id);

      $wpdb->query($SQL);
    }

    /**
     * For Deleting Row/Record data
     * @global type $wpdb
     * @param type $id 
     */
    public function delete_plugin_byID($id) {
      global $wpdb;

      $SQL = sprintf("DELETE FROM wp_plugins WHERE id = %d;", $id);
      $wpdb->query($SQL);
    }

  }
  
  ?>