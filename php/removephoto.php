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
$user_id=$_GET['userid'];
if($albumid == '-1')
{
        $pp = "ax";
        $ms = "
                SELECT COUNT(UserID)
                FROM user_photos
                WHERE permission = '$pp'
                AND PhotoID = '$photoid';
            ";
        $mresult = mysqli_query($connection,$ms);
        
        $ml = mysqli_fetch_assoc($mresult);
        $m = $ml['COUNT(UserID)'];
        // echo ".$m.";
        if($m > 1)
        {
            $sql = "
            DELETE FROM user_photos
            WHERE PhotoID = '$photoid'
            AND UserID = '$user_id';
            ";
            $result = mysqli_query($connection,$sql);
            if($result)
            {
                echo "bye !";
            }
            else
            {
                echo "failed(not_good)";
            }
            
        }
        else
        {
            $geturl = "
            SELECT photoURL
            FROM photos
            WHERE photo_id = '$photoid';
            ";
            $Gresult = mysqli_query($connection,$geturl);
            $gurl =  mysqli_fetch_assoc($Gresult);
            $URL = $gurl['photoURL'];
            $sql = "
                    DELETE FROM photos
                    WHERE photo_id = '$photoid';
                    ";
            $result = mysqli_query($connection,$sql);
            if($result)
            {
                echo "bye !";
                if(unlink($URL))
                {
                    echo ''.$URL.'file deleted';
                }
                else
                {
                    echo "not_good";
                }
            }
            else
            {
                echo "not_good";
            }
        
            
            
            
        }
}
else
{
    $sql ="DELETE FROM albums_photos WHERE albumID ='$albumid' AND photoID ='$photoid'";
    $res = mysqli_query($connection,$sql);
     if($res)
     {  
        echo "Remove done.";
     }
     else
     {
         echo "not_good";
         
     }
    
}

?>