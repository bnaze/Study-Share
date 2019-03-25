<?php
  include_once 'CheckLogin.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Study Share</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="./main.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>

<body>
  <form action="index.php" method="post">
    <div class="navbar">
      <ul>
        <li id="logo">Study Share</li>
        <li><a href="./index.php">Home</a></li>  
        <li id="LoginButton" style="float:right"><button class="btn" name="logout" id="logoutbtn" style="width:250px;">logout</button></li>
        <li id="Uploadbtn" style="float:right"><a href=addpost.html>Upload Notes</a></li>
      </ul>
    </div>
  </form>

    <center>
        <div class="UserPageDiv">
            <table class="UserTable" style="box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.3);">
                <tr>
                    <td colspan="2" align="right"> 
                        <div class="dropdown">
                          <button class="dropbtn">Account Settings    <i class="fa fa-angle-down"></i></button></button>
                          <div class="dropdown-content">
                              <a href="changePassword.php">Change password</a>
                          </div>
                        </div> 
                    <td>
                </tr>
                
                <tr>
                    <td><img src="./Images/DefaultProfilePic.png"/></td>
                    <td valign="top">
                        <table class="UserInfo">
                        <tr>
                            <td style="padding-top:2px; padding-bottom:0px;" colspan="2"><h2 style="margin-top:0px;" id="usernamePH">Username placeholder</h2></td></tr>
                        <tr>
                            <td style="width:30%">Name:</td> 
                            <td id="namePH">Placeholder name </td></tr>
                        <tr>
                            <td>email:</td> 
                            <td id="emailPH"> Placeholder email</td></tr>
                        <tr>
                            <td>User Type:</td> 
                            <td id="userTypePH"> Placeholder user type</td></tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <!--
        <div class="UserPageDiv" style="padding-top: 20px;">
          <div class="PostGrid" style="box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.3);">
              <div class="grid-item">1</div>
              <div class="grid-item">2</div>
              <div class="grid-item">3</div>  
          </div>
        </div>
        -->
    </center>
</body>
</html>

<?php
  //Displays user information on the user page 
  $username = $_SESSION['username'];
  $firstname = $_SESSION['firstname'];
  $surename = $_SESSION['lastname'];
  $email = $_SESSION['email'];
  $userType = $_SESSION['userType'];

  echo "<script>
      document.getElementById('usernamePH').innerHTML = '<b>' + '$username' + '</b>';
      document.getElementById('namePH').innerHTML = '<b>' + '$firstname' + ' ' + '$surename' + '</b>';
      document.getElementById('emailPH').innerHTML = '<b>' + '$email' + '</b>';
      document.getElementById('userTypePH').innerHTML = '<b>' + '$userType' + '</b>';
  </script>";
?>
