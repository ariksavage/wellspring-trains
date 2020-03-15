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
      $page = isset($_GET['page'])? $_GET['page'] : 1;
      $order = isset($_GET['order'])? $_GET['order'] : 'run_number';
      $dir = isset($_GET['dir'])? $_GET['dir'] : 'asc';
      $routes = $trains->get_all_routes_paginated($page, $order, $dir);
    ?>
    <table>
      <thead>
        <tr>
          <?php 
            function sort_link($text, $column, $order, $dir, $page){
              $link = "?order=$column";
              if (($order == $column) && ($dir == 'asc')){
                $dir = 'desc';
              } else {
                $dir = 'asc';
              }
              $link .= "&dir=$dir";
              $link .= "&page=$page";
              return "<a href=\"$link\">$text</a>";
            }
            
          ?>
          <th><?php echo sort_link('Train Line', 'train_line', $order, $dir, $page);?></th>
          <th><?php echo sort_link('Route', 'route_number', $order, $dir, $page);?></th>
          <th><?php echo sort_link('Run Number', 'run_number', $order, $dir, $page);?></th>
          <th><?php echo sort_link('Operator ID', 'operator_id', $order, $dir, $page);?></th>
        </tr>
      </thead>
      <tbody>

    <?php
      if(isset($_FILES['import_file']) && $file = $_FILES['import_file']) {
        $trains->import_routes($file);
      }
      ?>
    <h1>Wellspring Trains App</h1>
    
    <?php 
    
    foreach ($routes as $route){
      echo '<tr>';
      echo "<td>$route->train_line</td>";
      echo "<td>$route->route_name</td>";
      echo "<td>$route->run_number</td>";
      echo "<td>$route->operator_id</td>";
      echo '</tr>';
    }
    ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="4">
        <?php 
        $page_up = "?page=".($page + 1);
        $page_down = "?page=".($page - 1);
        if ($order) {
          $page_up .= '&order='.$order;
          $page_down .= '&order='.$order;
        }

        if ($page > 1) {
          echo '<a href="'.$page_down.'"> < </a>';
        }
      ?>
      <span class="page">Page <?php echo $page;?></span>
      <a href="<?php echo ($page_up);?>"> > </a>
      </td>
    </tr>
  </tfoot>
</table>
    <h2>Import</h2>
    <form method="post" action="" enctype="multipart/form-data">
      <input type="file" name="import_file"/>
      <input type="submit" value="import"/>
    </form>
  </body>
</html>
