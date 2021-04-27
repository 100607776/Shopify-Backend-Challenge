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

$photoid=$_GET['photoid'];
$friendid=$_GET['friendid'];
$get_albumid ="SELECT album_id FROM albums WHERE albumName ='shared' and user_id ='$friendid';";
$res=mysqli_query($con,$get_albumid);

if(mysqli_num_rows($res)>0)
{
    $result=mysqli_fetch_assoc($res);
    $permission='x';
    $albumid=$result['album_id'];
    
    
    $checkphoto="SELECT photoID FROM albums_photos WHERE albumID ='$albumid' and photoID ='$photoid';";
    $no_photo=mysqli_query($con,$checkphoto);
    
    if(mysqli_num_rows($no_photo)>0)
    {
        
        echo "not_good";
    }
    else
    {
        
        $set_permission="INSERT INTO user_photos (UserID,PhotoID,permission) VALUES(
                    '$friendid','$photoid','$permission');";
        $res =mysqli_query($con,$set_permission);
        
        $result=mysqli_fetch_assoc($no_photo);
        $addphoto="INSERT INTO albums_photos (photoID,albumID) VALUES
        ('$photoid','$albumid');";
        $r=mysqli_query($con,$addphoto);
        if($r)
        {
            echo "shared to friend";
        
        }
        else
        {
         echo"failed to share!(not_good)";
        
        }
        
    }
    
            
                
            
        
}
else
{
    echo"not_good";
}


?>