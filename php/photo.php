<?php
$dbhost = "localhost";
$dbuser = "urtheman";
$dbpass = "Urtheman117";
$dbname = "photo_organizer";
$connection = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
if(!$connection){die("Database connection failed");}

$userid=$_GET['userid'];
$albumid=$_GET['albumid'];

//$sql = "SELECT albumName FROM albums
 //   WHERE album_id = '$albumid';";


//$result = mysqli_query($connection,$sql);
//$result_a =mysqli_fetch_assoc($result);


$array =array(); 

if($albumid== '-1'){
   
    $qy = "SELECT * FROM photos 
       WHERE photo_id in 
         (SELECT photoID FROM user_photos
          WHERE UserID='$userid' and permission='ax');";



}
else 
{

    $qy = "SELECT * from photos 
       WHERE photo_id in
        (SELECT photoID FROM albums_photos
        where albumID='$albumid');";
}
$r = mysqli_query($connection,$qy);
if(mysqli_num_rows($r)>0)
{
    for($i=0;$i<mysqli_num_rows($r);$i++)
    {  $res = mysqli_fetch_assoc($r);
      $array[$i]=$res;
    }
       echo json_encode($array);
}




?>