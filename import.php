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

$contents = file_get_contents($file['tmp_name']);
var_dump($contents);

?>
