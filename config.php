<?php

//Set Debug On

  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  

//Creating Conf Class to be used for database connection
class Conf
{
 const DB_HOST = 'localhost';
 const DB_NAME   = 'moviedatabase';
 const DB_USERNAME = 'davidcurbina';
 const DB_PASSWORD = 'password';

 /*
  const DB_HOST = "us-cdbr-iron-east-03.cleardb.net";
  const DB_USERNAME = "b65ad6fc98e041";
  const DB_PASSWORD = "d91b216f";
  const DB_NAME = "heroku_b42a4752efa0e9d";
  */
}
?>
