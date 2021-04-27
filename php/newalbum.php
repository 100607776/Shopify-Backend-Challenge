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
$albumname=$_GET['albumname'];
$time=$_GET['time'];

$add_album="INSERT INTO albums (albumName,user_id,creationDate) VALUES (
            '$albumname','$userid','$time')";
$res = mysqli_query($connection,$add_album);
if($res){
    echo "good";
}
else{
    echo"failed to create album.(not_good)";
}

?>