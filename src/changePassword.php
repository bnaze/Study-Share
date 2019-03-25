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
        <li><a href="./index.html">Home</a></li>  
        <li id="LoginButton" style="float:right"><button class="btn" name="logout" id="logoutbtn" style="width:250px;">logout</button></li>
        <li id="Uploadbtn" style="float:right"></li>
      </ul>
    </div>
    
  </form>
    <center>
        <div class="UserPageDiv" style="width:600px;">
            <form action="NewPass.php" method ="post" class="formbody" >
                <table class="UserTable">
                    <tr>
                        <td valign="top">
                            <h1>Change password</h1>
                            <p>Please fill in this form to change your password.</p>
                            <hr></hr>
                        </td> 
                    </tr>
                    <tr>
                        <td>
                            <p>
                                <label><b>Password</b></label>
                            </p>
                            <input type="password" placeholder="Enter Password" name="psw" id="Newgpsw" required>
                            
                            <p>
                                <label><b>Repeat Password</b></label>
                            </p>
                            <input type="password" placeholder="Repeat Password" name="psw-repeat" id="Newpsw-repeat" required>
                            <br/><br/>

                        
                            <tr>
                                <td valign="bottom">
                                    <input class="btn" type="submit" id="signupbtn" name="rePassSubmit" value="submit" style="width:438.5px;"/>
                                    <p id = "FormError"></p>
                                </td>
                            </tr>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </center>
</body>
</html>