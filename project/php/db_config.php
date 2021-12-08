<?php
  // Executed inside docker-compose
  if (gethostname() == "php_in_docker") {
    $db_config = array(
      'server'   => 'db',
      'login'    => 'root',
      'password' => 'root',
      'database' => 'db',
    );
  // Executed on webik server, presumably
  } else {
    $db_config = array(
      'server'   => 'localhost',
      'login'    => 'CHANGEME_YOUR_DB_LOGIN',
      'password' => 'CHANGEME_YOUR_DB_USERNAME',
      'database' => 'stud_<CHANGEME_YOUR_DB_LOGIN>', // e.g. stud_123456
    );
  }