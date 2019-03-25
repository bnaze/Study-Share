<?php
    //Stores file infomation in an object format
    class Document {
        //File info
        private $file_name;
        private $file_size;
        private $file_type;
        private $file_tmp;
        private $postTitle;
        private $eduLevel;
        private $subject;
        
        public $username;

        //Intialises object
        public function __construct($filename,$filesize,$filetype,$filetmp,$user){
            $this->file_name = $filename;
            $this->file_size = $filesize;
            $this->file_type = $filetype;
            $this->file_tmp = $filetmp;
            $this->username = $user;
        }

        //Getters for the object
        public function getFileTmp(){
            return $this->file_tmp;
        }

        public function getFileName(){
            return $this->file_name;
        }

        public function getDocumentOwner(){
            return $this->username;
        }
    }
       
?>