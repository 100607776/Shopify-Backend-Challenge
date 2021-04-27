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
$userid = $_GET['userid'];
if($userid=='')
{
    die("no");
}
$sql = "
        SELECT imgurl
        FROM user
        WHERE user_id = '$userid';
        ";
$result = mysqli_query($connection,$sql);

$RR = mysqli_fetch_assoc($result);
$R = $RR['imgurl'];
if($R == '')
{
    echo'DEF';
}
else
{
   echo $R; 
}
















?>