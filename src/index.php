<?php 
  include_once 'index.html';
  //Adjust nav bar based on user state
  include_once 'NavBarState.php';

  //If the user is not logged in then they are redicted to login.php which deals with the session
  if(isset($_POST['login']) && (isset($_SESSION['loggedIn'])==false)){
    header("location: login.php");
  }
?>