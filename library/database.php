<?php
class database {
  protected $host;
  protected $user;
  private $password;
  public $db;

  /**
   * Create the database instance and store local values.
   * @param $host     string  The host of the MySQL server, ie 127.0.0.1
   * @param $user     string  MySQL user name
   * @param $pass     string  MySQL user password
   * @param $database string  MyQL database to be used by this connection.
   * @param $debug    boolean If true, print debug information about the connection to the DOM.
   * @return void
   */
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

  /**
   * Connect to the MySQL database.
   * @return void
   */
  private function connect() {
    $this->connection = mysqli_connect($this->host, $this->user, $this->password, $this->db);
    if ($this->connection) {
      return true;
    } else {
      return false;
    }
  }
  /**
   * Test the connection to the MySQLi database
   * @return $success boolean Success or failure to connect.
   */
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

  /**
   * Perform an insert query
   * @param $q string the MySQL INSERT query.
   * @return $success boolean The success or failure of the insert query.
   */
  public function insert($q){
    $this->query($q);
    $affected = $this->connection->affected_rows;
    if ($affected > 0) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Perform a select query and return an array of objects.
   * @param $q string MySQL query.
   * @return $data array An array of objects, each representing a row of data.
   */
  public function select($q) {
    $data = [];
    if ($result = $this->query($q)) {

      /* fetch object array */
      while ($row = $result->fetch_object()) {
          $data[] = $row;
      }

      /* free result set */
      $result->close();
      return $data;
    } else {
      return false;
    }
  }

  /**
   * Perform a MySQLi query and return the result for other functions.
   * @param  $q      string        MySQL query.
   * @return $result MySQLi result The result object of the query.
   * 
   * @todo Sanitize the input. It is bad practice to open a raw string to MySQL query execution.
   */
  private function query($q){
    return $this->connection->query($q);
  }

  /**
   * Escape a string value for use in a MySQL query.
   * @param  $value   string The value to be escaped.
   * @return $escaped string The escaped, trimmed, and quoted value.
   */
  public function escape_string($value) {
    return '\''.$this->connection->real_escape_string(trim($value)).'\'';
  }

  /**
   * End the MySQLi connection
   */
  public function disconnect() {
    mysqli_close($this->connection);
  }
}
?>
