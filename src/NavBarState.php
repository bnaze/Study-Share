<?php
  include_once 'RegisteredUser.php';

  //If there is no session, one is started
  if(isset($_SESSION) == false){
    session_start();
  }

  //These variables hold what the navbar will contain depending on the state
  $loginbtn;
  $uploadBtn;
  $UserIcon;
  $registeredUserObj;
  
  //If the user has logged out
  if(isset($_POST['logout'])){
    //Thier session is destroyed
    session_unset();
    session_destroy();
    //Their logout button is replaced with a sign in button
    $loginbtn = '<button class="btn" name="login" id="loginbtn" style="width:250px;">Login/SignUp</button>';
    //The user page icon that directs you to the user page is set to not show
    $UserIcon = '';
    //The upload button is set to not show
    $uploadBtn = "<a></a>"; 
  }
  
  //If the user is logged in
  if(isset($_SESSION['loggedIn'])){ 
    //A logout button is prevoded
    $loginbtn = '<button class="btn" name="logout" id="logoutbtn" style="width:250px;">logout</button>';
    //And Icon that links to the user page is provided
    $UserIcon = '<a style="padding:3px;" href="./UserPage.php"><img src="./Images/UserIcon.png" width="50" height="50"/></a>';
    //A registered user object is created to intereact with with the username set and it's added to the session
    $registeredUserObj = new RegisteredUser;
    $registeredUserObj->setUserName($_SESSION['username']);
    $registeredUserSerialize = serialize($registeredUserObj);
    $_SESSION['registeredUser'] = $registeredUserSerialize;
    //The upload button is made availible 
    $uploadBtn = "<a href=addpost.html>Upload Notes</a>"; 
  
    //The signin button is removed and the other buttons are put onto the nav bar
    echo "<script>
      document.getElementById('loginbtn').remove;
      document.getElementById('LoginButton').innerHTML='$loginbtn';
      document.getElementById('Uploadbtn').innerHTML='$uploadBtn';
      document.getElementById('UserPageIcon').innerHTML='$UserIcon';
    </script>";
  }
  
  //By default only the sign in button shows
  else{
    $loginbtn = '<button class="btn" name="login" id="loginbtn" style="width:250px;">Login/SignUp</button>';
    $UserIcon = '';
    $uploadBtn = "<a></a>"; 
  }
  
  if(isset($_POST['login']) && (isset($_SESSION['loggedIn'])==false)){
    header("location: login.php");
  }

?>