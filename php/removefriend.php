<?php
$dbhost = "localhost";
$dbuser = "urtheman";
$dbpass = "Urtheman117";
$dbname = "photo_organizer";
$connection = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

if(!$connection)
{
    die("Database connection failed");
}

$userid=$_GET['userid'];
$friendid=$_GET['friendid'];

$friendidcheck="SELECT user_id
            FROM user
            WHERE user_id = '$friendid'
            ";
 $check = mysqli_query($connection,$friendidcheck);          
 if(mysqli_num_rows($check)<=0)
 die("user dose not exsit !");
 else{
     $remove="DELETE FROM friends where (user1ID ='$userid' and user2ID='$friendid') OR (user1ID ='$friendid' and user2ID='$userid');";
     $result=mysqli_query($connection,$remove);
     if($result){
         echo "go to the hell!";
         
     }
     else{
         echo "not_good";
     }
     
     
     
     
     
 }
 
 
 
 
 
 
 
 
 
 ?>