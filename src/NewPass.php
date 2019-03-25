<?php
include_once 'RegisteredUser.php';
include_once 'ChangePassword.php';

$password = $_POST['psw'];
$rePassword = $_POST['psw-repeat'];

if($password != $rePassword){
    //Passwords don't match
    echo "<script>
        document.getElementById('FormError').innerHTML = 'The passwords you enter do not match!'
        document.getElementById('FormError').style.color = 'red';
        document.getElementById('Newpsw-repeat').value = '$password';
        document.getElementById('Newgpsw').value = '$rePassword';
    </script>";
}
elseif((strlen($password) < 8) || (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-].*[0-9]|[0-9]/', $password)) == false){
    //Invalid new pass
    echo "<script>
        document.getElementById('FormError').innerHTML = 'Your password needs to contain 8 chatacters with atleast 1 specail character! please try again!'
        document.getElementById('FormError').style.color = 'red';
        document.getElementById('Newpsw-repeat').value = '$password';
        document.getElementById('Newgpsw').value = '$rePassword';
    </script>";
}
else {
    //Everything is fine
    $RegisteredUserObj = new RegisteredUser();
    $result = $RegisteredUserObj->setPassword($password);
    if ($result){
        //redirct with confirmation message
        $RegisteredUserObj->console_log("Success changing password!");
        echo "<script>
            if (!alert('Password Successfully changed! Redirecting you to your user page.')){
                window.location.href = 'http://localhost/Study_Share_v2/src/UserPage.php';
            }
        </script>";
    }
    else {
        //error
        $RegisteredUserObj->console_log("Error changing password!");
    }
}
?>