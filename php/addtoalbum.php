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


$photoid=$_GET['photoid'];
$albumid=$_GET['albumid'];

$check ="SELECT photoID FROM albums_photos WHERE albumID = '$albumid' AND photoID='$photoid';";
$result=mysqli_query($connection,$check);
if(mysqli_num_rows($result)>0){
    die("The photo is already in the album.");
}
else{

 $sql ="INSERT INTO albums_photos (photoID,albumID) VALUES ('$photoid','$albumid') ";
 $res =mysqli_query($connection,$sql);
 if($res)
 {
    echo "Add done.";
 }
 else
 {
     echo "not_good";
     
 }
}

?>