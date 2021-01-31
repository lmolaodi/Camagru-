<?php

try
{
  $conn = new PDO("mysql:host=localhost;dbname=registration_db", "root","");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
  try
  {
    $conn = new PDO("mysql:host=localhost", "root","");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE DATABASE IF NOT EXISTS registration_db";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute())
    {
      //echo "database created<br>";

      $conn = new PDO("mysql:host=localhost;dbname=registration_db", "root","");
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "CREATE TABLE registration(
        id INT NOT NULL AUTO_INCREMENT ,
        username VARCHAR(15) NOT NULL ,
        email VARCHAR(50) NOT NULL ,
        password VARCHAR(150) NOT NULL ,
        status INT(11) NOT NULL,
        code INT(11) NOT NULL,
        PRIMARY KEY (`id`)) ENGINE = InnoDB;";
      
      $stmt = $conn->prepare($sql);
      if ($stmt->execute())
      {
        //echo "registration table created<br>";
      }

      $sql = "CREATE TABLE IF NOT EXISTS images(
        id INT NOT NULL AUTO_INCREMENT ,
        image LONGTEXT NOT NULL,
        username LONGTEXT NOT NULL,
        date_upload datetime default CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)) ENGINE = InnoDB;";

      $stmt = $conn->prepare($sql);
      if ($stmt->execute())
      {
        //echo "images table created<br>";
      }

      $sql = "CREATE TABLE IF NOT EXISTS comments(
        id INT NOT NULL AUTO_INCREMENT,
        image_id INT NOT NULL,
        name LONGTEXT NOT NULL,
        comment LONGTEXT NOT NULL,
        PRIMARY KEY (`id`)) ENGINE = InnoDB;";

      $stmt = $conn->prepare($sql);
      if ($stmt->execute())
      {
        //echo "comments table created<br>";
      }

      $sql = "CREATE TABLE IF NOT EXISTS likes(
        id INT NOT NULL AUTO_INCREMENT,
        image_id INT NOT NULL,
        username LONGTEXT NOT NULL,
        PRIMARY KEY (`id`)) ENGINE = InnoDB;";

      $stmt = $conn->prepare($sql);
      if ($stmt->execute())
      {
        //echo "likes table created<br>";
      }
    }
  }
  catch(PDOException $e)
  {
    echo "Connection failed: ".$e->getMessage();
  }
}
?>