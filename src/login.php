<?php
    //Includes code for login
    include_once 'Guest.php';
    
    //If there is no current session, one is created
    if(isset($_SESSION) == false){
        session_start();
    }

    //If the user is not logged in they a redicted to the index page
    if(isset($_SESSION['loggedIn'])){
        header("Location: ./index.php");
    } 

    //If the user is in the login state then the username and password the entered is checks agianst the DB
    $guestObj = new Guest;
    if (!empty($_POST)) {
        $username = $_POST['loginUsername'];
        $password = $_POST['loginPassword'];


        //If the information they inputted is valid then they are redicted to the index page
        if($guestObj->login($username, $password)) {
            header("Location: index.php");
        }
        //if not it is noted an attempt was made
        else{
            $_SESSION['AttemptMade'] = true;
        }
    }

    //If there was an error loging i nthe login HTML page is reloaded and errors are printed 
    //Note that the info you put in the form is retained and re-filled in 
    include_once 'login.html';
    if(isset($_SESSION['AttemptMade'])){
        echo "<script>
            var ErrorSection = document.getElementById('loginError');
            ErrorSection.innerHTML += 'Error: Incorrect username/password inputed';
            ErrorSection.style.color = 'red';
            document.getElementById('loginUsername').value = '$username';
            document.getElementById('loginPassword').value = '$password';
        </script>";
    }
?>