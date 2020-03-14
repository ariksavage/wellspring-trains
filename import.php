<?php

$file = $_FILES['import_file'];
if ($file['type'] !== 'text/csv') {
  echo 'Uploaded file must be a CSV.';
  die();
}
if ($file['size'] > 500000) {
    echo 'Sorry, your file is too large.';
    $uploadOk = 0;
}

//
$data = array_map('str_getcsv', file($file['tmp_name']));
array_shift($data); // remove column header
?>
<table>
  <thead>
    <tr>
      <th>Train Line</th>
      <th>Route</th>
      <th>Run Number</th>
      <th>Operator ID</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach ($data as $row) {
      echo '<tr>';
      echo '<td>'.$row[0].'</td>';
      echo '<td>'.$row[1].'</td>';
      echo '<td>'.$row[2].'</td>';
      echo '<td>'.$row[3].'</td>';
      echo '</tr>';
    }
    ?>
  </tbody>
</table>
