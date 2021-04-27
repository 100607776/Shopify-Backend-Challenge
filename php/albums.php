    <?php
    $dbhost = "localhost";
    $dbuser = "urtheman";
    $dbpass = "Urtheman117";
    $dbname = "photo_organizer";
    $connection = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
    if(!$connection){die("Database connection failed");}

    $user_id =$_GET['userid'];
    
    $sql =  " SELECT user.user_id, albums.album_id,albums.albumName
              FROM (user
              INNER JOIN albums ON user.user_id = albums.user_id)
              where user.user_id= '$user_id' 
              group by albums.album_id;

        " ;
    $result = mysqli_query($connection,$sql);

    $array =array();
    if(mysqli_num_rows($result)>0){
        for($i=0;$i<mysqli_num_rows($result);$i++)
         {  $res = mysqli_fetch_assoc($result);
            $array[$i]=$res;
         }
        
        $myJSON =json_encode($array);
        echo $myJSON;
    }
    else
    {
        echo "please sign up first!(not_good)";
    }





    ?>
