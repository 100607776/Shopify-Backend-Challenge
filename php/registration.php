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
$password=$_GET['password'];
$email= $_GET['email'];
$phoneNumber=$_GET['telephone'];
$creationdate = $_GET['time'];
if($username==''|| $password=='' || $email == '')
{
     echo "not_good";
     echo 'Fill up email username and password';

}
else
{
    $sql= "SELECT email FROM user WHERE email= '$email' ;";

    $result = mysqli_query($connection,$sql);
    if(mysqli_num_rows($result))
    {
        echo "not_good";
        echo 'Email already registed';
    }
    else
    {
        $qy = "INSERT INTO user ( userName, password, phoneNumber, email) VALUES ( '$username', '$password',   '$phoneNumber', '$email');";
        
        $register = mysqli_query($connection,$qy);
        if($register)
        {
            $getuserid = "SELECT user_id 
                          FROM user 
                          WHERE 
                          userName= '$username' ;
                         ";
            $getresult = mysqli_query($connection,$getuserid);
            $getid = mysqli_fetch_assoc($getresult);
            $userid = $getid['user_id'];
            echo $userid;
            $share = "shared";
            $Cshared = "
                        INSERT INTO albums (albumName,user_id,creationDate)
                        VALUES ('$share','$userid','$creationdate');
                        
                        
                        ";
            $creatshare = mysqli_query($connection,$Cshared); 
            if($creatshare)
            {
                echo "Good! you have successfully registered!";
            }
            
            
         
        }
        else
        {
            echo "not_good";
            echo "Connection error";
        }

        $connection->close();


    }
}
?>