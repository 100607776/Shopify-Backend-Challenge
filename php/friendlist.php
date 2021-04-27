<?php
$dbhost = "localhost";
$dbuser = "urtheman";
$dbpass = "Urtheman117";
$dbname = "photo_organizer";
$con = NULL;
$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
if(!($con))
{
    die("Database connection failed");
}
$key = $_GET['userid'];
if($key=="")
die("key not valid"); 
$keycheck="SELECT user_id
            FROM user
            WHERE user_id = '$key'
            ";
$check = mysqli_query($con,$keycheck);
if(mysqli_num_rows($check)<=0)
die("key dose not exsit !");
$sql= " SELECT user_id,userName,phoneNumber,email
    FROM user
    WHERE user_id IN 
    ( SELECT user1ID
     FROM friends
     WHERE user2ID =  '$key'
     UNION
     SELECT user2ID 
     FROM friends
     WHERE user1ID =  '$key');";
$array = array();
$result = mysqli_query($con,$sql);
if(mysqli_num_rows($result)>0)
{
    for($i=0; $i<mysqli_num_rows($result);++$i)
    {
        $res = $result->fetch_assoc();
        $array[$i]=$res;
    }
     echo json_encode($array);
}
else
{
    echo'not_good';
}
?>




