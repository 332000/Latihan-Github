<?php
// the $_GET global variable is used here since we are reading parameters
// sent via hyperlink.
$action = $_GET['action']; 
$email  = $_GET['email']; 
$host = "localhost";
$port = "5432";
$database = "profile_db";
$username = "pdbuser";
$password = "pdb0000"; 
 
$connection_string =  
 "pgsql:host={$host};port={$port};dbname={$database};" .
 "user={$username};password={$password}"; 
 
$query = "SELECT * FROM profile WHERE email=:email";
$query = "DELETE FROM profile WHERE email=:email";
 
$pdo = null; 
try {  
     // create a PDO object  
      $pdo = new \PDO($connection_string); 
 
  // set the error notification via exception  
 // see https://www.php.net/manual/en/pdo.setattribute.php  
  $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); 
 
  $pstatement = $pdo->prepare($query); 
  $pstatement->bindParam(":email", $email); 
 
  $pstatement->execute(); 
 
  $pstatement->setFetchMode(\PDO::FETCH_ASSOC);
     // since we are expecting only one tuple to be fetched.
   // see https://www.php.net/manual/en/pdostatement.fetch.php 
     $profile = $pstatement->fetch(); 
    } catch (\PDOException $exception) {  
         echo($exception->getMessage()); } 
 
// disconnecting 
$pdo = null;
header("Location:all_profiles.php");
?> 
 
<!doctype html> 
<html lang="en"> 
 
 <head>   
     <meta charset="utf-8">  
  <meta name="viewport"    
 content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Profil</title>  
     <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
     </head> 
  
 <body>  
      <div class="container"> 
    <h1 class="text-center">Ubah Profil</h1>   
     <form action="save_profile.php" method="post" class="form">   
    <div class="row">         
    <div class="col-md-4 offset-md-4">           
    <div class="form-group">             
    <label for="full_name"><b>Nama Lengkap:</b></label>            
     <div class="input-group input-group-sm">     
      <input type="text" class="form-control" name="full_name"                 
       id="full_name" maxlength="40"                  
       value="<?= $profile["full_name"] ?>"/>             
    </div>          
 </div>          
  <div class="form-group">         
          <label for="email"><b>Email:</b></label>             
          <div class="input-group input-group-sm">       
                      <input type="text" class="form-control" name="email"             
                         id="email" maxlength="64"                
                         value="<?= $profile["email"] ?>"/>            
                         </div>          
                         </div>         
                        </div>       
                    </div> 
  
       <div class="row">   
                 <div class="col">           
                     <div class="text-center">             
                         <input type="submit" class="btn btn-success" value="Simpan" />
                         &nbsp;            
                          <input type="reset" class="btn btn-secondary" value="Reset" />            
                           &nbsp;            
                            <a href="all_profiles.php">Semua profil</a>          
                         </div>        
                         </div>      
                         </div>
       <input type="hidden" name="action" value="save_profile"/>     
    </form> 
  </div>
 </body> 
 
 </html>