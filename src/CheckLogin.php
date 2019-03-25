<?php
    //Checks to see if session is set
    if(isset($_SESSION) == false){
        session_start();
    }
    //Checks to see if the user is logged in - if they are no they are redirected to the index page with a sign in button
    if(isset($_SESSION['loggedIn']) == false){
        header("location: index.php");
    }
    else {
        //loads variables with relavant session data
        $username = $_SESSION['username'];
        $userType = $_SESSION['userType'];
        $firstname = $_SESSION['firstname'];
        $lastname = $_SESSION['lastname'];
        $email = $_SESSION['email'];
    }
?>