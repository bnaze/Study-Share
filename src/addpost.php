<?php
  //CheckLogin is included to see if the user is logged in
  //it redirects them to the index page with the sign in option if they are not logged in
  include_once 'CheckLogin.php';
  //Nav bar changes based on login state, so this script is included
  include_once 'NavBarState.php';
  //Add posts needs a registered user object to add files so it's included
  include_once 'RegisteredUser.php';

  if(isset($_FILES['fileToUpload'])) {
    //The $_files varaible stores infomation aobut the files submited in a form
    //This section of code gathers that information and stores it in variables for use
    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_type = $_FILES['fileToUpload']['type'];
    $file_tmp = $_FILES['fileToUpload']['tmp_name'];
    
    //This stores the input bo information 
    $postTitle = $_POST['title'];
    $eduLevel = $_POST['eduLevel'];
    $subject = $_POST['subject'];

    //Carries out the process of uploading the file to the server given the informaiton we got from the post form
    upload($file_name, $file_size, $file_type, $file_tmp, $postTitle, $eduLevel, $subject);
    //Based on which education level it correspondes to (A-level or GCSE) the user is redirected 
    //So they they can see the post as it's displayed on the global view post page
    if($eduLevel=="A-Level"){
        header("Location: ./alevel.php"); 
    }
    else{
        header("Location: ./gcse.php"); 
    }
  }

  //Uploads files to sever with relevant information 
  function upload($file_name,$file_size,$file_type,$file_tmp,$postTitle,$eduLevel,$subject){
      $username = $_SESSION['username'];
      $registeredUserObj = unserialize($_SESSION['registeredUser']);
      $registeredUserObj->createNewPost($file_name, $file_size, $file_type, $file_tmp, $postTitle, $eduLevel, $subject);

  }
?>