<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php echo '<p>Hello World</p>'; ?> 
 <?php 
  include 'db_config.php';
  $conn = new mysqli($db_config['server'], $db_config['login'], $db_config['password'], $db_config['database']);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $sql = "SELECT * FROM test_table";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      var_dump($row);
    }
  } else {
    echo "0 results, this should not happen!";
  }

 ?>
 </body>
</html>
