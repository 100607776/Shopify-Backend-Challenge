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
$username=$_GET['username'];
//$password=$_GET['password'];
$email= $_GET['email'];
$imgurl=$_GET['profileimg'];
$creationdate = $_GET['time'];
if($username=='')
{
    echo 'not_good';
    die("server terminated");
}

    $sql= "SELECT email FROM user WHERE email= '$email' ;";

    $result = mysqli_query($connection,$sql);
    if(mysqli_num_rows($result)>0)
    {
        $getuserid = "SELECT user_id 
                          FROM user 
                          WHERE 
                          email= '$email' ;
                         ";
            $getresult = mysqli_query($connection,$getuserid);
            $getid = mysqli_fetch_assoc($getresult);
            $userid = $getid['user_id'];
            echo $userid;
    }
    else
    {
        $qy = "INSERT INTO user ( userName, email, imgurl) VALUES ( '$username', '$email', '$imgurl');";
        
        $register = mysqli_query($connection,$qy);
        if($register)
        {
            $getuserid = "SELECT user_id 
                          FROM user 
                          WHERE 
                          email= '$email' ;
                         ";
            $getresult = mysqli_query($connection,$getuserid);
            $getid = mysqli_fetch_assoc($getresult);
            $userid = $getid['user_id'];

            $share = "shared";
            $Cshared = "
                        INSERT INTO albums (albumName,user_id,creationDate)
                        VALUES ('$share','$userid', '$creationdate');
                        
                        
                        ";
            $creatshare = mysqli_query($connection,$Cshared); 
            if($creatshare)
            {
                echo $userid;
            }
            
            
         
        }
        else
        {
            echo "not_good";
        }

        $connection->close();


    }

?>