var loginuserid="";
var loginusername="";
var userfriends;
var useralbums;
function register(){
    var username=document.getElementById("rusername").value;
    var password=document.getElementById("rpassword").value;
    var email=document.getElementById("remail").value;
    var telephone=document.getElementById("rtelephone").value;
    //var loginusername="";
    var today = new Date();
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    var dateTime = date+' '+time;

    if(username==''||password==''||email=='')
        document.getElementById("display").innerHTML="WTF";

    else{
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() 
        {

            if (this.readyState == 4 && this.status == 200)
            {
                if(!this.responseText.includes("not_good"))
                {
                    console.log(this.responseText);
                    //loginusername = this.responseText;
                    //this.loginusername = loginusername;
                    document.getElementById("display").innerHTML = "Register successful! <br>You can now login to the website";
                }
                else
                {
                    console.log(this.responseText);
                    ///loginusername = "";
                    document.getElementById("display").innerHTML = this.responseText;


                }

            }
            else
                document.getElementById("display").innerHTML="Processing...";
        };
        xmlhttp.open("POST","php/registration.php?username="+username+"&password="+password+"&email="+email+"&telephone="+telephone+"&time="+dateTime,true);
        xmlhttp.send();
    }
}
function onSignIn(googleUser) {//google signin
    var profile = googleUser.getBasicProfile();
    loginusername=profile.getName();

    var today = new Date();
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    var dateTime = date+' '+time;

    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {

        if (this.readyState == 4 && this.status == 200)
        {
            if(!this.responseText.includes("not_good"))
            {
                console.log(this.responseText);
                document.getElementById("display").innerHTML = "Register successful! <br>You can now login to the website";
                loginuserid = this.responseText;
                localStorage.setItem("loguserid",loginuserid);
                localStorage.setItem("logusername",loginusername);

                window.location.href="user_page.html";
            }
            else
            {
                ///loginusername = "";
                document.getElementById("display").innerHTML = this.responseText;
                console.log(this.responseText);

            }

        }
        else
            document.getElementById("display").innerHTML="Processing...";
    };
    xmlhttp.open("POST","php/googlesignin.php?username="+profile.getName()+"&email="+profile.getEmail()+"&time="+dateTime+"&profileimg="+profile.getImageUrl(),true);
    xmlhttp.send();
}

function login(){
    var email=document.getElementById("lemail").value;
    var password=document.getElementById("lpassword").value;
    //loginusername=username;

    if(email==''||password=='')
        document.getElementById("display").innerHTML="WTF";

    else{
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() 
        {

            if (this.readyState == 4 && this.status == 200)
            {
                if(!this.responseText.includes("not_good"))
                {
                    console.log(this.responseText);
                    var arr=JSON.parse(this.responseText);
                    loginuserid = arr[0]['user_id'];
                    loginusername=arr[0]['userName'];
                    //alert(loginuserid);
                    //location.replace("user_page.html");
                    localStorage.setItem("loguserid",loginuserid);
                    localStorage.setItem("logusername",loginusername);

                    window.location.href="user_page.html";

                    //document.getElementById("username").innerHTML=loginusername;
                    //getUserPic();
                    //getUserAlbums();
                    //getUserFriends();

                }
                else
                {
                    console.log(this.responseText);
                    ///loginusername = "";
                    document.getElementById("display").innerHTML = this.responseText;


                }

            }
            else
                document.getElementById("display").innerHTML="Processing...";
        };
        xmlhttp.open("POST","php/login.php?email="+email+"&password="+password,true);
        xmlhttp.send();
    }
}

function initialUserPage(){
    loginuserid=localStorage.getItem("loguserid");
    loginusername=localStorage.getItem("logusername");
    document.getElementById("username").innerHTML=loginusername;
    document.getElementById("idnumber").innerHTML="id "+loginuserid;

    getUserAlbums();
    getUserFriends();
    getUserPic();

}

function getUserPic(){
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {

        if (this.readyState == 4 && this.status == 200)
        {
            if(this.responseText=="DEF")
            {
                console.log(this.responseText);
                //document.getElementById("userpic").src="/default_userimg.png";
            }
            else if(!this.responseText.includes("not_good"))
            {
                document.getElementById("userpic").src=this.responseText;
                console.log(this.responseText);
            }  
            else
            {
                console.log(this.responseText);
                //document.getElementById("userpic").src="/default_userimg.png";
            } 
        }

    };
    xmlhttp.open("POST","php/profileimg.php?userid="+loginuserid,true);
    xmlhttp.send();
}

function getUserAlbums(){
    document.getElementById("albums").innerHTML="<div class='albumadder' id='adder' onmouseenter=addalbum() onmouseleave=hidadd()><div>+</div></div>";
    document.getElementById("albums").innerHTML+="<div class='albumblock' onclick=getPhoto("+(-1)+")>All Photo</div>";

    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {

        if (this.readyState == 4 && this.status == 200)
        {
            if(!this.responseText.includes("not_good"))
            {
                useralbums=this.responseText;
                var alb=JSON.parse(this.responseText);

                for(var i=0;i<alb.length;i++)
                {
                    document.getElementById("albums").innerHTML+="<div class='albumblock' id='alb_"+i+"' onclick=getPhoto("+alb[i].album_id+")>"+alb[i].albumName+" <button class='deletor' onclick='delAlb("+alb[i].album_id+")'>-</button></div>";//$event.preventDefault();$(event).stopPropagation();
                }
            }  
            else
            {


            } 
        }

    };
    xmlhttp.open("POST","php/albums.php?userid="+loginuserid,true);
    xmlhttp.send();
}
function hidadd()//add add album textbox
{
    document.getElementById("adder").innerHTML="<div>+</div>";
}
function addalbum(){//hover button show
    document.getElementById("adder").innerHTML="<input id='addertext' type='text'><input id='adderbut' type='submit' onclick=addingalb()>";

}
function addingalb(){//adding a new album
    var nalbname=document.getElementById("addertext").value;

    var today = new Date();
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    var dateTime = date+' '+time;

    if(nalbname!='')
    {
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() 
        {
            if (this.readyState == 4 && this.status == 200)
            {
                if(!this.responseText.includes("not_good"))
                {
                    getUserAlbums();
                }  
                else
                {
                } 
            }
        };
        xmlhttp.open("POST","php/newalbum.php?userid="+loginuserid+"&albumname="+nalbname+"&time="+dateTime,true);
        xmlhttp.send();
    }


}
function delAlb(albid){//delete album
    var e=window.event;//prevent parent events firing
    e.preventDefault();
    e.stopPropagation();
    
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200)
        {
            if(!this.responseText.includes("not_good"))
            {
                getUserAlbums();
            }  
            else
            {
            } 
        }
    };
    xmlhttp.open("POST","php/deletealbum.php?albumid="+albid+"&userid="+loginuserid,true);
    xmlhttp.send();
}


function getUserFriends(){
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {

        if (this.readyState == 4 && this.status == 200)
        {
            if(!this.responseText.includes("not_good"))
            {
                //alert(this.responseText);
                console.log(this.responseText);
                userfriends=this.responseText;
                var friend=JSON.parse(this.responseText);

                for(var i=0;i<friend.length;i++)
                {
                    document.getElementById("friendlist_t").innerHTML+="<li class='friendLine'><div onclick=getFriend("+friend[i].user_id+")>"+friend[i].userName+" </div><button onclick=deleteFriend("+friend[i].user_id+")>DEL</button></li>";
                }
            }  
            else
            {
                // document.getElementById('favlist').innerHTML = "add your favorate songs";

            } 
        }

    };
    xmlhttp.open("POST","php/friendlist.php?userid="+loginuserid,true);
    xmlhttp.send();
}
//function UpdateUserPassword(){
//}

function getPhoto(alb_id){//get photo and enter the album page
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {

        if (this.readyState == 4 && this.status == 200)
        {
            if(!this.responseText.includes("not_good"))
            {
                //alert(this.responseText);
                //var photo=JSON.parse(this.responseText);
                localStorage.setItem("photo_arr",this.responseText);//photo);
                localStorage.setItem("loguserid",loginuserid);
                localStorage.setItem("logusername",loginusername);
                localStorage.setItem("loguserfriends",userfriends);
                localStorage.setItem("loguseralbums",useralbums);
                localStorage.setItem("recentalb",alb_id);

                window.location.href="album.html"; 
            }  
            else
            {

                window.location.href="user_page.html";
            } 
        }

    };
    xmlhttp.open("POST","php/photo.php?albumid="+alb_id+"&userid="+loginuserid,true);
    xmlhttp.send();
}

function initialAlbum(){
    loginuserid=localStorage.getItem("loguserid");
    loginusername=localStorage.getItem("logusername");
    useralbums=localStorage.getItem("loguseralbums");
    userfriends=localStorage.getItem("loguserfriends");

    window.albid_=localStorage.getItem("recentalb");

    document.getElementById("username").innerHTML=loginusername;
    document.getElementById("idnumber").innerHTML="id "+loginuserid;

    getUserPic();
    
    console.log(userfriends);
    var friends="";
    var albums="";
    try{
        friends=JSON.parse(userfriends);
    }catch(error){//console.error(error);
    }
    try{
        albums=JSON.parse(useralbums);
    }catch(error){
    }

    for(var i=0;i<friends.length;i++)
    {
        document.getElementById("friendlisting").innerHTML+="<li onclick=shareTo("+friends[i].user_id+")>"+friends[i].userName+"</li>";
    }
    for(var i=0;i<albums.length;i++)
    {
        if(albums[i].albumName!="shared")
            document.getElementById("albumlisting").innerHTML+="<li onclick=addTo("+albums[i].album_id+")>"+albums[i].albumName+"</li>";
    }
    var photoJSON="";
    try{
        photoJSON=JSON.parse(localStorage.getItem("photo_arr"));
    }catch(error){}
    for(var i=0;i<photoJSON.length;i++)
    {
        document.getElementById("pic").innerHTML+="<div class='photoblock' id='pic"+i+"' onclick='selectPhoto("+photoJSON[i].photo_id+","+i+")'><img src='"+photoJSON[i].photoURL+"'></div>";
        //onclick='addtoAlbum("+photoJSON[i].photo_id+")'
    }
}
function selectioncan(){ //select cancel for photo
    var all=document.getElementsByClassName("photoblock");
    for(var i=0;i<all.length;i++)
        all[i].style.border="none";
    document.getElementById("picmenu").style.display="none";
    document.getElementById("friendlisting").style.display="none";
    document.getElementById("albumlisting").style.display="none";
    
    window.photoid_="";
}
function selectPhoto(photoid,picid){//select photo function to mark the photo and
    var e=window.event;//prevent parent events firing
    e.preventDefault();
    e.stopPropagation();
    
    var all=document.getElementsByClassName("photoblock");
    for(var i=0;i<all.length;i++)
        all[i].style.border="none";
    document.getElementById("pic"+picid).style.border="thick solid #0000FF";

    document.getElementById("picmenu").style.display="block";

    window.photoid_=photoid;
}
function addToBut(){// the button functions to add a photo to an album
    var e=window.event;//prevent parent events firing
    e.preventDefault();
    e.stopPropagation();
    
    document.getElementById("friendlisting").style.display="none";
    if(document.getElementById("albumlisting").style.display!="inline")
        document.getElementById("albumlisting").style.display="inline";
    else
        document.getElementById("albumlisting").style.display="none";
}
function addTo(albid)//add selected photo to album
{
    console.log(window.photoid_);
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200)
        {
            if(!this.responseText.includes("not_good"))
            {
                alert(this.responseText);
            }  
            else
            {
            } 
        }
    };
    xmlhttp.open("POST","php/addtoalbum.php?albumid="+albid+"&photoid="+window.photoid_,true);
    xmlhttp.send();
}
function shareToBut(){//the button functions to share a photo to a friend
    var e=window.event;//prevent parent events firing
    e.preventDefault();
    e.stopPropagation();
    
    document.getElementById("albumlisting").style.display="none";
    if(document.getElementById("friendlisting").style.display!="inline")
        document.getElementById("friendlisting").style.display="inline";
    else
        document.getElementById("friendlisting").style.display="none";
}
function shareTo(friendid){
    console.log(window.photoid_);
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200)
        {
            if(!this.responseText.includes("not_good"))
            {
                alert(this.responseText);
                console.log(this.responseText);
            }  
            else
            {
                alert(this.responseText);
                console.log(this.responseText);
            } 
        }
    };
    xmlhttp.open("POST","php/sharetofriend.php?friendid="+friendid+"&photoid="+window.photoid_,true);
    xmlhttp.send();
}
function deletePhoto(){
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200)
        {
            if(!this.responseText.includes("not_good"))
            {
                getPhoto(window.albid_);
            }  
            else
            {
            } 
        }
    };
    xmlhttp.open("POST","php/removephoto.php?albumid="+window.albid_+"&photoid="+window.photoid_+"&userid="+loginuserid,true);
    xmlhttp.send();
}
function showSelectFileN(){
    var filec=document.getElementById("floader").files;
    document.getElementById("uploaddesc").innerHTML=filec.length;
}
function upload(){
    document.getElementById("uploaddesc").innerHTML="......";
    const url = 'php/upload.php';

    //const files = document.querySelector('[type=file]').files;
    const files = document.getElementById("floader").files;
    const formData = new FormData();

    for (let i = 0; i < files.length; i++) {
        let file = files[i];

        formData.append('files[]', file);
    }
    formData.append("userid",loginuserid);

    for (var value of formData.values()) {
        console.log(value); 
    }
    fetch(url, {
        method: 'POST',
        body: formData,
    }).then(response => {
        console.log(response);
        document.getElementById("floader").value="";
        document.getElementById("uploaddesc").innerHTML="Upload";
    });
    //response.text.then(function(text){console.log(text);});

}
function addfriend(){
    var friendid=document.getElementById("searchfriend").value;
    if(friendid!='')
    {
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() 
        {

            if (this.readyState == 4 && this.status == 200)
            {
                if(!this.responseText.includes("not_good"))
                {
                    console.log(this.responseText);
                    alert(this.responseText);
                    document.getElementById("friendlist_t").innerHTML="";
                    getUserFriends();

                }  
                else
                {
                    // document.getElementById('favlist').innerHTML = "add your favorate songs";
                    alert(this.responseText);
                } 
            }

        };
        xmlhttp.open("POST","php/addfriend.php?userid="+loginuserid+"&friendid="+friendid,true);
        xmlhttp.send();    
    }
}
function deleteFriend(friendid){
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {

        if (this.readyState == 4 && this.status == 200)
        {
            if(!this.responseText.includes("not_good"))
            {
                console.log(this.responseText);
                alert(this.responseText);
                document.getElementById("friendlist_t").innerHTML="";
                getUserFriends();

            }  
            else
            {
                // document.getElementById('favlist').innerHTML = "add your favorate songs";
                alert(this.responseText);
            } 
        }

    };
    xmlhttp.open("POST","php/removefriend.php?userid="+loginuserid+"&friendid="+friendid,true);
    xmlhttp.send();  
}

