<?php
class trains {
  
  public function __construct(){
    if(file_exists('../config.php')){
      require_once('../config.php');
      require_once('./library/database.php');
      $this->$db = new Database($db_server, $db_user, $db_pass, $db_database, $debug);
    } else {
      echo "No configuration file found. Rename config_example.php to config.php and update its values.";
      die();
    }
  }
  private function insert_route($route){
    if (!empty(trim($route[0])) && !empty(trim($route[1])) && !empty(trim($route[2])) && !empty(trim($route[3])) ){
      $line = $this->db->escape_string($route[0]);
      $route = $this->db->escape_string($route[1]);
      $run = $this->db->escape_string($route[2]);
      $operator = $this->db->escape_string($route[3]);
      $query = "INSERT INTO trains(train_line, route_name, run_number, operator_id) VALUES ($line, $route, $run, $operator)";
      $this->db->insert($query);
    } else {
      echo '<table class="missing"><tbody><tr>';
      echo '<td>'.$route[0].'</td>';
      echo '<td>'.$route[1].'</td>';
      echo '<td>'.$route[2].'</td>';
      echo '<td>'.$route[3].'</td>';
      echo '</tr></tbody></table>';
      echo '<p>The above route is missing data and will not be imported.';
    }
  }

  public function update($file) {
    if ($file['type'] !== 'text/csv') {
      echo 'Uploaded file must be a CSV.';
      return false;
    }
    if ($file['size'] > 500000) {
      echo 'Sorry, your file is too large.';
      return false
    }

    $data = array_map('str_getcsv', file($file['tmp_name']));
    array_shift($data);

    $processed = [];
    foreach($data as $route){
      if (!in_array($route, $processed)){
        $processed[] = $route;
        $this->insert_route($route);
      }
    }
  }
}
