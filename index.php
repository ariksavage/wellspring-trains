<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

	<head>
		<title>Wellspring Trains Application</title>
	</head>
	<body>
    <?php
      error_reporting(E_ALL);
      ini_set("display_errors", 1);
    ?>
    <?php 
    if(file_exists('./config.php')){
      require_once('./config.php');
      require_once('./library/database.php');
      $db = new Database($db_server, $db_user, $db_pass, $db_database);
    } else {
      echo "No configuration file found. Rename config_example.php to config.php and update its values.";
      die();
    }
    ?>
    <H1>Wellspring Trains App</h1>
      <h2>Import</h2>
    <form method="post" action="import.php">
      <input type="file" name="import_file"/>
      <input type="submit" value="import"/>
    </form>
	</body>
</html>
