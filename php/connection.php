<?php

function getDatabaseConnection() {
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "library_management_system";

   $connection = new mysqli($servername, $username, $password, $dbname);
   if ($connection->connect_error) {
       die("Connection failed: " . $connection->connect_error);
   }

   return $connection;
}

?>