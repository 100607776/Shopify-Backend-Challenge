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
if ($_SERVER['REQUEST_METHOD'] === 'GET') 
{
    $userid=$_GET['key'];
    $friendid=$_GET['friendid'];
    if($userid == $friendid)
    die("i know you are lonely but its ok to have no friends!") ;
    $keycheck="SELECT user_id
    FROM user
    WHERE user_id = '$userid'
    ";
    $check1 = mysqli_query($connection,$keycheck);
    if(mysqli_num_rows($check1)<=0)
    die("key dose not exsit !");
    
    $friendidcheck="SELECT user_id
    FROM user
    WHERE user_id = '$friendid'
    ";
    $check2 = mysqli_query($connection,$friendidcheck);          
    if(mysqli_num_rows($check2)<=0)
    die("friendid dose not exsit !");
    
    $qy= "SELECT user1ID, user2ID FROM friends WHERE user2ID= '$userid' and user1ID   = '$friendid'
    UNION
    SELECT user1ID, user2ID FROM friends WHERE user2ID= '$friendid' and
    user1ID   = '$userid'";
    $res=mysqli_query($connection,$qy);
    if(mysqli_num_rows($res)>0)
    {
        echo "You two are already firend!";
    
    }
    else{
    
        $sql ="INSERT INTO friends (user1ID,user2ID) VALUES ('$userid','$friendid');";
        $result = mysqli_query($connection,$sql);
    
    if($result)
    {
        echo "You have added a new firend";
    }
    else
    {
        echo "not_good";
    
    }
    }
}
else if ($_SERVER['REQUEST_METHOD'] === 'DELETE')
{
    $userid=$_GET['key'];
    $friendid=$_GET['friendid'];
    if($userid == $friendid)
    die("i know you are lonely but its ok to have no friends!") ;
    $keycheck="SELECT user_id
    FROM user
    WHERE user_id = '$userid'
    ";
    $check1 = mysqli_query($connection,$keycheck);
    if(mysqli_num_rows($check1)<=0)
    die("key dose not exsit !");
    
    $friendidcheck="SELECT user_id
    FROM user
    WHERE user_id = '$friendid'
    ";
    $check2 = mysqli_query($connection,$friendidcheck);          
    if(mysqli_num_rows($check2)<=0)
    {
        die("friendid dose not exsit !");
    }
    else
    {
        $remove="DELETE FROM friends where (user1ID ='$userid' and user2ID='$friendid') OR (user1ID ='$friendid' and user2ID='$userid');";
        $result=mysqli_query($connection,$remove);
        if($result)
        {
            echo "Unfriended!";
        
        }
        else
        {
            echo "not_good";
        }
        
    }
    
}
else
{
    echo "only support DELETE OR GET";
}

?>