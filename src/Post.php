<?php
    //Stores infomration about the post to later use
    class Post{
        private $postID;
        private $ownerID;
        private $title;
        private $subject;
        private $educationLevel;

        public function __construct($postid,$ownerid){
            $this->postID = $postid;
            $this->ownerID = $ownerid;
        }

        //Setters and getters to access the variables in the object 
        public function setTitle($value){
            $this->title = $value;
        }

        public function getPostID(){
            return $this->postID;
        }

        public function setSubject($value){
            $this->subject = $value;
        }

        public function setEducationLevel($value){
            $this->educationLevel = $value;
        }

    }
?>