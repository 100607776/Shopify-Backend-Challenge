<?php
    $dbhost = "localhost";
    $dbuser = "urtheman";
    $dbpass = "Urtheman117";
    $dbname = "photo_organizer";
    $connection = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
    if(!$connection){die("Database connection failed");}


    $albumid =$_GET['albumid'];
    //$userid=$_GET['userid'];
    
    if($albumid!= -1)
    {
        
        $qy ="SELECT albumName FROM albums  WHERE album_id ='$albumid' and albumName='shared'";
        $r=mysqli_query($connection,$qy);
         if(mysqli_num_rows($r)<=0)
         {
             
             $delete_album="DELETE FROM albums WHERE album_id = '$albumid';";
             $success =mysqli_query($connection,$delete_album);
             if($success){echo "Deleted!";}
             else{echo "not_good";}
             
             
             
         }
         else
         {
             echo "not_good";
         }
         
        
        
    }
    else
    {
        echo"not_good";
        
    }

?>