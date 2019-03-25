<?php
    include_once 'Guest.php';
    
    if (!empty($_POST)) {
        //Stores information form the register form for using to create a new user 
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['psw'];
        $firstname = $_POST['fname'];
        $surename = $_POST['sname'];
        $userType = $_POST['userType'];
        $rePassword = $_POST['psw-repeat'];

        $guestObj = new Guest;
        //Attempts to register a user
        $RegResults = $guestObj->register($email, $username, $password, $firstname, $surename, $userType, $rePassword);

        //Based on what the register functions returned (1-6 means an error occured and 7 means the suer was registered) errors are shown
        if ($RegResults != 7) {
            include_once 'login.html';
            //Specific errors describing the issues are printed on the form to show when it's reloaded
            echo "<script>
            var ErrorSection = document.getElementById('RegisterError');
            ErrorSection.style.color = 'red';";
            switch ($RegResults) {
                case 1:
                    echo "ErrorSection.innerHTML += 'Required fields are empty!';";
                    break;
                case 2:
                    echo "ErrorSection.innerHTML += 'Error: your email is invalid';";
                    break;
                case 3:
                    echo "ErrorSection.innerHTML += 'Error: Your password must be 8 characters long and have a special character!';";
                    break;
                case 4:
                    echo "ErrorSection.innerHTML += 'Error: Your passwords do not match';";
                    break;
                case 5:
                    echo "ErrorSection.innerHTML += 'Error: The username you selected is already in use';";
                    break;
                case 6:
                    echo "ErrorSection.innerHTML += 'Error: server error - please try again later';";
                    break;
                default:
                    echo "ErrorSection.innerHTML += 'Error: The fields were filled in incorrectly';";
                    break;
            }
            //Inputed infomration on the form is retained/kept in the input boxes
            echo "document.getElementById('Regemail').value = '$email';
                document.getElementById('Regusername').value = '$username';
                document.getElementById('Regfname').value = '$firstname';
                document.getElementById('Regsname').value = '$surename';
                document.getElementById('Regpsw').value = '$password';
                document.getElementById('Regpsw-repeat').value = '$rePassword';";
            echo "</script>";
        }

        //Redirects to intext page if the user registered fine as they are logged in afte rthey registered 
        else {
            console_log($_SESSION);
            header("Location: ./index.php");
        }
    }

    //For debuging purposes
    function console_log($data){
        echo '<script>';
        echo 'console.log('. json_encode( $data ) .')';
        echo '</script>';
    }

?>