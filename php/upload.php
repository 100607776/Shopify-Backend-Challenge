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
$target_dir = "../pic/";
$Number = count($_FILES["files"]["tmp_name"]);
$user_id = $_POST["userid"];


                
for($i = 0; $i < $Number; $i++)
{
     $sqlM = "SELECT MAX(photo_id)
                         FROM photos
                         ";
                $ress = mysqli_query($connection,$sqlM);
                
                
                if(mysqli_num_rows($ress)>0)
                {
                    $rresult = mysqli_fetch_assoc($ress);
                    $Rphotoid = $rresult["MAX(photo_id)"];
                    $Cphotoid = intval($Rphotoid);
                }
    $target_file = $target_dir . $user_id . $Cphotoid . basename($_FILES["files"]["name"][$i]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    

        if(isset($_POST["files"])) 
        {
                $check = getimagesize($_FILES["files"]["tmp_name"][$i]);
                if($check !== false) 
                {
                    echo "not_good File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else 
                {
                    echo "not_good File is not an image.";
                    $uploadOk = 0;
                }
        }
        
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) 
        {
            echo "not_good Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        if (file_exists($target_file)) 
        {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) 
        {
            echo "not_good Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } 
        else 
        {
            if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $target_file)) 
            {
                echo "The file ". basename( $_FILES["files"]["name"][$i]). " has been uploaded.";
                $date = date("y-m-d");
                $sql1 = "INSERT INTO photos(photoURL,date)
                        VALUES ('$target_file','$date');
                        ";
                mysqli_query($connection,$sql1);
                $sql2 = "SELECT photo_id
                         FROM photos
                         WHERE photoURL = '$target_file';
                        ";
                $res = mysqli_query($connection,$sql2);
                $result = mysqli_fetch_assoc($res);
                
                if(mysqli_num_rows($res)>0)
                {
                   $photoid = $result["photo_id"];
                }
                
                
                
                $permission = "ax";
                
                $sql3 = "INSERT INTO user_photos (UserID,photoID,permission)
                         VALUE('$user_id','$photoid','$permission');";
                mysqli_query($connection,$sql3);
                
            } 
            else 
            {
                echo "not_good there was an error uploading your file.";
            }
        }
    
}

    
   

?>