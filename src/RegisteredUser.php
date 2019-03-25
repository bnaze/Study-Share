<?php
include_once 'Document.php';
include_once 'DataInterface.php';
include_once 'Post.php';


class RegisteredUser{
    private $userid;
    private $username;
    private $firstname;
    private $surename;
    private $userType;
    private $dataInterfaceObj;

    public function __constructor(){
        $this->dataInterfaceObj = DataInterface::getInstance();
    }

    public function createNewPost($file_name, $file_size, $file_type, $file_tmp, $postTitle, $eduLevel, $subject){
        $this->console_log($eduLevel);
        $fileObj = new Document($file_name, $file_size, $file_type, $file_tmp, $this->username);
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/Study_Share_v2/src/users/' . $fileObj->getDocumentOwner();
        $targetFile = $targetDir;

        if($eduLevel == "A-Level"){
            $targetFile = $targetFile . '/' . "A-Level";
        }
        else{
            $targetFile = $targetFile . '/' . "GCSE";
        }
        
        //$targetFile = $targetFile.'/'.$fileObj->getFileName();
        $dataInterfaceObj = DataInterface::getInstance();
        $userID = $dataInterfaceObj->getUserID($this->username);
        $postID = $dataInterfaceObj->storePost($postTitle,$subject,$userID,$eduLevel,$targetFile,$file_name);

        $targetFile = $targetFile .'/' . $postID;

        $postObj = new Post($postID, $userID);
        $postObj->setTitle($postTitle);
        $postObj->setSubject($subject);
        $postObj->setEducationLevel($eduLevel);

        $this->console_log($targetFile);

        if(mkdir($targetFile)){
            $this->console_log("file made");
        }
        else{
            $this->console_log("file not made");
        }

        $targetFile = $targetFile . '/' . $fileObj->getFileName();
        if(move_uploaded_file($fileObj->getFileTmp(),$targetFile)){
            $this->console_log("sucessful upload");
        }
        else{
            $this->console_log("did not upload");
        }
        $this->console_log($fileObj->getFileTmp());
    
    }

    public function setUserName($value){
        $this->username = $value;
    }

    public function getUserName(){
        return $this->username;
    }

    public function console_log( $data ){
        echo '<script>';
        echo 'console.log('. json_encode( $data ) .')';
        echo '</script>';
    }  
    
    function setPassword($newPass){
        $dataInterfaceObj = DataInterface::getInstance();
        $username = $_SESSION['username'];
        $Query = "UPDATE Accounts SET password='$newPass' WHERE username='$username';";
        $result = $dataInterfaceObj->makeQuery($Query);
        if($result != NULL){
            $this->console_log("Password sucessfully changed");
            return true;
        }
        else{
            $this->console_log("Error with changing password");
            return false;
        }
    }
}
?>