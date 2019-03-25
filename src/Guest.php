<?php 
    include_once 'DataInterface.php';
    class Guest {
        //Registers a guest user
        public function register($email, $username, $password, $firstname, $surename, $userType, $rePassword) {
            $dataInterfaceObj = DataInterface::getInstance();
            return $dataInterfaceObj->storeNewUser($email, $username, $password, $firstname, $surename, $userType, $rePassword); 
        }
        
        //Logins a guest user
        public function login($username, $password) {
            $dataInterfaceObj = DataInterface::getInstance();
        
            //Checks if account exists, true or false
            $LoginResults = $dataInterfaceObj->searchUser($username, $password);
            return  $LoginResults;
        }
    }
?>