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
$email=$_GET['email'];
$password=$_GET['password'];
if($email==''||$password=='')
{
   echo 'not_good';

}

else
{
    $array = array();
    $sql ="SELECT user_id,userName FROM user WHERE email = '$email' AND password = '$password';";
    $result=mysqli_query($connection,$sql);
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
        echo 'not_good';
        
    }

    
}
?>