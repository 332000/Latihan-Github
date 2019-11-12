<?php
$host = "localhost";
$port = "5432"; 
$database = "profile_db"; 
$username = "pdbuser";
$password = "pdb0000"; 
 
$connection_string = 
  "pgsql:host={$host};port={$port};dbname={$database};" .
  "user={$username};password={$password}"; 
 
$query = "SELECT * FROM profile"; 
 
$pdo = null; 
try { 
    // create a PDO object 
      $pdo = new \PDO($connection_string); 
 
   // set the error notification via exception 
   // see https://www.php.net/manual/en/pdo.setattribute.php  
   $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); 
 
  $pstatement = $pdo->prepare($query); 

  $pstatement->execute(); 
 
  $pstatement->setFetchMode(\PDO::FETCH_ASSOC);
   // the result set is going to be shown in HTML format  
    $profiles = $pstatement->fetchAll();
     } catch (\PDOException $exception) { 
echo($exception->getMessage());
    } 
    // disconnecting $pdo = null
     ?> 
 
<!doctype html>
 <html lang="en">
      <head> 
<meta charset="utf-8">  
 <meta name="viewport"   
    content="width=device-width, initial-scale=1, shrink-to-fit=no">  
     <title>Semua Profil</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
     </head> 
 
 <body> 
       <div class="container">  
        <form action="simple_action.php" method="post" class="form">     
             <h1 class="text-center">Semua Profil</h1>   
            <div class="row">   
              <div class="col-md-8 offset-md-2">  
                <table class="table">            
                <thead>             
             <tr>           
             <th>#</th>     
            <th>Nama Lengkap</th>      
           <th>Email</th>            
           <th>Aksi</th>         
              </tr>       
             </thead>   
             <tbody>  
                                       
             <?php if(count($profiles)){?>          
             <?php $counter = 1; ?>        
          <?php foreach ($profiles as $profile) { ?> 
          <tr>            
          <td><?= $counter++ ?></td>          
          <td><?= $profile["full_name"] ?></td> 
          <td><?= $profile["email"] ?></td>          
          <td>          
         <a href="edit_profile.php?action=edit&email=<?=            
      $profile["email"] ?>">ubah</a>&nbsp;|&nbsp;   
   <a href="delete_profile.php?action=delete&email=<?=
   $profile["email"] ?>">hapus</a>              
        </td>        
          </tr>     
         <?php } ?>       
             <?php } else { ?>            
                     <tr>           
                  <td colspan="4"><i>Tidak ada</i></td>
          </tr>           
             <?php } ?>    
                  </tbody>  
                     </table>     
                        </div>  
                  <div class="col-md-8 offset-md-2">   
                <div class="text-right">           
              <a href="add_profile.html" class="btn btn-success">Tambah Profil</a>     
                  </div> 
                        </div>   
                        </div>   
                      </form> 
                      </div> 
                    </body> 
                    </html>