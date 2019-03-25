<?php
  include_once 'DataInterface.php';

  $dataInterfaceObj = DataInterface::getInstance();
  $posts = $dataInterfaceObj->getGCSEPosts();
?>

<!DOCTYPE html>
<html class="no-js">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>GCSE Posts</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>

  <body>
  <form action="index.php" method="post">
    <div class="navbar">
      <ul>
        <li id="logo">Study Share</li>
        <li><a href="index.php">Home</a></li>  
        <li id="UserPageIcon" style="float:right;"></a></li>
        <li id="LoginButton" style="float:right"><button class="btn" name="login" id="loginbtn" style="width:250px;">Login/SignUp</button></li>
        <li id="Uploadbtn" style="float:right"></li>
      </ul>
    </div>
  </form>
      
      <div class="edutitle">
        <p>GCSE</p>
      </div>
      <div class="subBody"></div>

    <center>
      <table class="DefaultTable" style="box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.3);">
        <tr>
          <td style="padding:70px;">GCSE Posts<td>
        </tr>
        <tr>
          <td>
            
<?php
  //creates a new div for all the post entries
  echo '<div class="UserPageDiv" style="padding-top: 20px;">';

  //Adds a div entry for each entry in the system
  while($rows = mysqli_fetch_array($posts)) {
    echo'<div class="large-grid-item">
        <table>
          <tr>
            <td>
              <img src="./Images/FileIcon.png" height="150px" width="150px"/>
            </td>
            <td align="left">
              <table style="padding:10px;">
                <tr>
                  <td style="text-decoration: underline;"><b>'.ucfirst ($rows["title"]).'</b></td>
                <tr>
                <tr>
                  <td>
                    <a href="download.php?file='.$rows["path"].'">
                      <button class="btn" style="width:160px;">Download  <i class="fa fa-download"></i></button>
                    </a>
                  </td>
                </tr>
                <tr>
                  <td>
                    <button class="VoteButtons"><i class="fa fa-thumbs-o-up"></i></button>
                    <button class="VoteButtons"><i class="fa fa-thumbs-o-down"></i></button>
                    <button class="VoteButtons"><i class="fa fa-exclamation-triangle"></i></button>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>';
  }
?>
          </td>
        </tr>
      </table>
    </center>
  </body>
</html>

<?php
  //Changes nav bar based on login state
  include_once 'NavBarState.php';
?>