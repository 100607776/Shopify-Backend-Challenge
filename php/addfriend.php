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
if($userid==$friendid)
{
    echo 'cant add yourself!';   
    die("Please check the friend id!");
    
}

$qy= "SELECT user1ID, user2ID FROM friends WHERE user2ID= '$userid' and user1ID   = '$friendid'
      UNION
      SELECT user1ID, user2ID FROM friends WHERE user2ID= '$friendid' and
      user1ID   = '$userid'";
$res=mysqli_query($connection,$qy);
if(mysqli_num_rows($res)>0)
{
    echo 'your already friends !'; 
    
}
else{
 
 $friendidcheck="SELECT user_id
            FROM user
            WHERE user_id = '$friendid'
            ";
 $check = mysqli_query($connection,$friendidcheck);          
 if(mysqli_num_rows($check)<=0)
 die("user dose not exsit !");
 
 
 
 $addF ="INSERT INTO friends (user1ID,user2ID) VALUES ('$userid','$friendid');";
 $result = mysqli_query($connection,$addF);
 if($result)
 {
    echo 'friendadded';
 }
 else
 {
    echo "not_good";
    
 }
}
?>