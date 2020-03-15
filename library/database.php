<?php
class database {
  protected $host;
  protected $user;
  private $password;
  public $db;

  public function __construct($host, $user, $pass, $database, $debug = false) {
    $this->host = $host;
    $this->user = $user;
    $this->password = $pass;
    $this->db = $database;
    if($debug){
      $this->test_connection();
    }
    $this->connect();
  }

  private function connect() {
    $this->connection = mysqli_connect($this->host, $this->user, $this->password, $this->db);
    if ($this->connection) {
      return true;
    } else {
      return false;
    }
  }

  protected function test_connection() {
    if ($this->connect()){
      echo "Success: A proper connection to $this->database was made!" . PHP_EOL;
      echo "Host information: " . mysqli_get_host_info($this->connection) . PHP_EOL;
      $this->disconnect();
      return true;
    } else {
      echo "Error: Unable to connect to MySQL." . PHP_EOL;
      echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
      echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
      return false;
    }
  }

  public function insert($q){
    $this->query($q);
  }

  private function query($q){
    $this->connection->query($q);
  }

  INSERT INTO `trains`(`id`, `train_line`, `route_name`, `run_number`, `operator_id`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5])

  public function escape_string($value) {
    return '\''.$this->connection->real_escape_string(trim($value)).'\'';
  }

  public function disconnect() {
    mysqli_close($this->connection);
  }
}
?>
