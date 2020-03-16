<?php
/**
 *  A class to handle common operations interacting with the `trains` database and displaying data thereof.
 */
class trains {
  
  /**
   *  Create an instance of a database, for later use.
   */
  public function __construct(){
    if(file_exists(__DIR__.'/../config.php')){
      require_once(__DIR__.'/../config.php');
      require_once(__DIR__.'/database.php');
      $this->db = new Database($db_server, $db_user, $db_pass, $db_database, $debug);
    } else {
      echo "No configuration file found. Rename config_example.php to config.php and update its values.";
      die();
    }
  }

  /**
  * Import route data
  * A route must contain 4 columns: train_line, route_name, run_number, operator_id
  * Route will only be imported when it contains a unique combination of values
  * All 4 values must be non-empty strings
  * @param $route array A 4 item array [train_line, route_name, run_number, operator_id].
  * @todo enforce strict values for each element of the array.
  * @return $success boolean True or false if the item was inserted.
  */
  private function insert_route($route){
    if (!empty(trim($route[0])) && !empty(trim($route[1])) && !empty(trim($route[2])) && !empty(trim($route[3])) ){
      $line = $this->db->escape_string($route[0]);
      $route_name = $this->db->escape_string($route[1]);
      $run = $this->db->escape_string($route[2]);
      $operator = $this->db->escape_string($route[3]);
      // Inert route if it doesn't already exist
      $query = "INSERT INTO trains (train_line, route_name, run_number, operator_id)
      SELECT $line, $route_name, $run, $operator
      FROM DUAL
      WHERE NOT EXISTS(
        SELECT 1
        FROM trains
        WHERE 
        train_line = $line AND route_name = $route_name AND run_number = $run AND operator_id = $operator
      )
      LIMIT 1;";
      return $this->db->insert($query);
    } else {
      echo '<table class="missing"><tbody><tr>';
      echo '<td>'.$route[0].'</td>';
      echo '<td>'.$route[1].'</td>';
      echo '<td>'.$route[2].'</td>';
      echo '<td>'.$route[3].'</td>';
      echo '</tr></tbody></table>';
      echo '<p>The above route is missing data and will not be imported.';
      return false;
    }
  }

  /**
   * Parse a CSV file, import each row as a route
   * See insert_route above
   * @param $file pointer A file pointer to an uploaded CSV temp file, where each row is a route.
   * Each route must contain train_line, route_name, run_number, operator_id
   * @return void Echoes the number of rows inserted.
   */
  public function import_routes($file) {
    if ($file['type'] !== 'text/csv') {
      echo 'Uploaded file must be a CSV.';
      return false;
    }
    // if ($file['size'] > 500000) {
    //   echo 'Sorry, your file is too large.';
    //   return false;
    // }

    $data = array_map('str_getcsv', file($file['tmp_name']));
    array_shift($data);

    $processed = [];
    $n = 0;
    foreach($data as $route){
      if (!in_array($route, $processed)){
        $processed[] = $route;
        if ( $this->insert_route($route) ){
          $n++;
        }
      }
    }
    echo "<p>$n routes imported.</p>";
  }

  /**
   * Get the total number of routes in the database.
   * @return int $count The number of rows in the `trains` table.
   */
  public function count_routes() {
    $query = "SELECT COUNT(*) AS count FROM trains";
    $result = $this->db->select($query);
    return $result[0]->count;
  }

  /**
   *  Select all routes, limited to a number per page, ordered by user choice.
   *  @param $page int Page number to display, starting with 1. Default 1.
   *  @param $order_by string Column by which to order the result routes. Default 'run_number'
   *  @param $order_dir string Direction in which to order the results, asc / desc. Default asc.
   *  @param $limit int The number of items per page. Default 5.
   *  @return $routes array An array of objects, each containing {train_line, route_name, run_number, operator_id}
   */
  public function get_all_routes_paginated($page = 1, $order_by = 'run_number', $order_dir = 'asc', $limit = 5) {
    $offset = $limit * ($page -1);
    $query = "SELECT * FROM `trains` order by $order_by $order_dir limit $limit offset $offset";
    $routes = $this->db->select($query);
    return $routes;
  }
}
