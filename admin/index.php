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
      $trains = new trains();
    ?>
    <?php
      if(isset($_FILES['import_file']) && $file = $_FILES['import_file']) {
        $trains->import_routes($file);
        

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
