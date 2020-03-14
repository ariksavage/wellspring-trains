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

  private function disconnect() {
    mysqli_close($this->connection);
  }
}
?>
