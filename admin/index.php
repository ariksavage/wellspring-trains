<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
?>

  </!DOCTYPE html>
  <html>

  <head>
    <title>Wellspring Trains Application Admin</title>
    <style>
.missing td {
  border: 1px solid #f00;
  min-width: 5em;
  height: 1.2em;
}
  </style>
  </head>
  <body>

    <?php 
      require_once('../library/trains.php');
    ?>
    <?php
      if($file = $_FILES['import_file']) {
        if ($file['type'] !== 'text/csv') {
          echo 'Uploaded file must be a CSV.';
          die();
        }
        if ($file['size'] > 500000) {
            echo 'Sorry, your file is too large.';
            $uploadOk = 0;
        }

        $data = array_map('str_getcsv', file($file['tmp_name']));
        array_shift($data);

        $processed = [];
        foreach($data as $row){
          if (!in_array($row, $processed)){
            $processed[] = $row;
            if (!empty(trim($row[0])) && !empty(trim($row[1])) && !empty(trim($row[2])) && !empty(trim($row[3])) ){
              $line = $db->escape_string($row[0]);
              $route = $db->escape_string($row[1]);
              $run = $db->escape_string($row[2]);
              $operator = $db->escape_string($row[3]);
              $query = "INSERT INTO trains(train_line, route_name, run_number, operator_id) VALUES ($line, $route, $run, $operator)";
              $db->insert($query);
            } else {
              print_r($row);
              echo '<table class="missing"><tbody><tr>';
              echo '<td>'.$row[0].'</td>';
              echo '<td>'.$row[1].'</td>';
              echo '<td>'.$row[2].'</td>';
              echo '<td>'.$row[3].'</td>';
              echo '</tr></tbody></table>';
              echo '<p>The above row is missing data and will not be imported.';
            }
          }
        }

      }
      ?>
    <h1>Wellspring Trains App</h1>
      <h2>Import</h2>
    <form method="post" action="" enctype="multipart/form-data">
      <input type="file" name="import_file"/>
      <input type="submit" value="import"/>
    </form>
  </body>
</html>
