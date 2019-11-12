<?php 
header("Location: index.html");
// to read a POST parameter sent by form use the $_POST global array.
// the index of the $_POST is the name of the HTML element we want to read.
 $full_name = $_POST['full_name']; 
// the above line reads the value in the HTML element named 'full_name'
 $email = $_POST['email']; 
 $action= $_POST['action']; 
 
$host = "localhost";
$port = "5432"; 
$database = "profile_db";
$username = "pdbuser";
$password = "pdb0000"; 
 
$connection_string =   
 "pgsql:host={$host};port={$port};dbname={$database};" .  
"user={$username};password={$password}"; 
 
$query =  
  "INSERT INTO profile(full_name, email)" .  
  "VALUES (:full_name, :email)"; 
 
$pdo = null; try{  
     // create a PDO object  
      $pdo = new \PDO($connection_string); 
 
  // set the error notification via exception 
  // see https://www.php.net/manual/en/pdo.setattribute.php  
  $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); 
 
  $pstatement = $pdo->prepare($query); 
  $pstatement->bindParam(":full_name", $full_name);  
  $pstatement->bindParam(":email", $email); 
 
  $success = $pstatement->execute();
 }  catch (\PDOException $exception) {   
      echo($exception->getMessage()); 
    } 
 
// disconnecting 
$pdo = null; 
header("Location:all_profiles.php");

exit;
?>