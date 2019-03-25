<?php
    class DataInterface {
        //Instance of database controle class
        private static $DInstance = null;

        //Information for user to establish a connection with the database
        private $servername = "localhost";
        private $dbuser = "root";
        private $dbpassword = "password";
        private $dbname = "Study-Share";

        //Database connection
        private $conn;
        
        //Constructor - private, so can only be accessed within the class (singleton)
        private function __construct(){
            //Establishes connection
            $this->conn = mysqli_connect($this->servername, $this->dbuser, $this->dbpassword, $this->dbname);
            //If no connection could be made then an error is shown and the program stops
            if (mysqli_connect_trueerrno()){
                $this->console_log("Failed to connect to MySQL: " . mysqli_connect_error());
                die("DB Error: please try again later"); 
            }
        }
        
        //This enables singleton by returning an existing instance or creating a new one if there isn't one
        public static function getInstance(){
            if (self::$DInstance == null){
                self::$DInstance = new DataInterface();
            }
            return self::$DInstance;
        }
        
        //Searches for a username in the database and check to see if the password matches to be able to log the user in
        public function searchUser($username, $password){
            //The username feild is a unique feild with no repetition (key) in this table 
            //so there is no need to search more than 1 record from the returned results of this SQL query - only 1 is returned
            $Query = $this->makeQuery("SELECT * FROM Accounts WHERE username = '$username';");
            $CheckQuery = mysqli_num_rows($Query);
            //Given that the user exists a session is create with the userinformation retrieved from the DB fo later use
            if($CheckQuery == 1) {
                $row = mysqli_fetch_assoc($Query);
                if($password == $row["password"]){
                        if(isset($_SESSION) == false){
                            session_start();
                        }
                        $_SESSION['username'] = $username;
                        $_SESSION['userType'] = $row["userType"];
                        $_SESSION['firstname'] = $row["firstname"];
                        $_SESSION['lastname'] = $row["surename"];
                        $_SESSION['email'] = $row["email"];
                        $this->LogInOut(true);
                    return true;
                }
            //The following 2 else statements return a console message (for debuging purposes) 
            //Which indicate if the username doesn't exist or if the password didn't match the entry
            //However the user is not told which is the case as it's unecessary and poses secuirity issues
                else {
                    $this->console_log("User found, HOWEVER, password wrong");
                    return false;
                }
            }
            else {
                $this->console_log("User Username doesn't exist");
                return false;
            }
        }   

        //Stores a new user's information to offacially register them into the system
        public function storeNewUser($email, $username, $password, $firstname, $surename, $userType, $rePassword){
        //These check to see if the imformation submited from the form is valid and if they aren't a number is retured that
        //correspondes to an error message that wil lbe displayed

            //Checks to see if any feild in the form is empty
            if(empty($firstname) || empty($surename) || empty($email) || empty($username) || empty($password) || empty($rePassword)){
                $this->console_log("Feilds left empty!");
                return 1;
            }

            //Checks to see if Email is valid
            if((strpos($email, '@') || strpos($email, '.') || filter_var($email, FILTER_VALIDATE_EMAIL)) == false){
                $this->console_log("Email invalid");
                return 2;
            }

            //Checks to see if password is valid (contains the right amount of characters and some specail characters too)
            if((strlen($password) < 8) || (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-].*[0-9]|[0-9]/', $password)) == false){
                $this->console_log("password invalid");
                return 3;
            }

            //Checks to see if the retyped password feild matches the password feild
            if($password != $rePassword){
                $this->console_log("passwords don't match");
                return 4;
            }

            //Checks to see if the username the user has selected to register with is unique (if it's in use)
            $sqlCheckUser = $this->makeQuery("SELECT * FROM Accounts;");
            if ($sqlCheckUser != NULL) {
                $userExists = false;
                while($rows = mysqli_fetch_array($sqlCheckUser)) {
                    if($username == $rows["username"]){
                        $this->console_log("User Exists");
                        return 5;
                    }
                }
            }
            //Catchs SQL error and logs it
            else {
                $this->console_log("SQLCheckerFailed!");
                return 6;
            } 

            //If not errors have been found with the inputed information, it is stored in the database via SQL
            $sql =  "INSERT INTO Accounts (email,username,password,firstname,surename,userType) 
                    VALUES ('$email','$username', '$password', '$firstname', '$surename', '$userType');";
            $this->makeQuery($sql);

            //Creates a path for allocating user storage on server - with a GCSE and A-level folder for each user
            $pathnameAlevel = $_SERVER['DOCUMENT_ROOT'] . '/Study_Share_v2/src/users/' .$username . '/A-Level';
            $pathnameGCSE = $_SERVER['DOCUMENT_ROOT'] . '/Study_Share_v2/src/users/' .$username . '/GCSE';
            $this->console_log($pathnameAlevel);
            $this->console_log($pathnameGCSE);

            //creates a folder in the server in the previously specified path for the specific user
            if((mkdir($pathnameAlevel,0777,true)) && (mkdir($pathnameGCSE,0777,true))){
                $this->console_log("sucessful");
            }
            else{
                $this->console_log("unsucessful file creation for a level");
            }

            //Once the user registers they are logged in 
            $this->searchUser($username, $password);
            return 7;
        }

        //Stores user post in their desginated folder
        public function storePost($postTitle, $subject, $ownerID, $eduLevel, $path, $fileName){
            //Inserts information about the post in the "post" table
            //The system only stores the path of the folder in the server in the database, not the file's info
            $sql = "INSERT INTO Posts (ownerID, title, subject, educationLevel, path) 
                    VALUES ('$ownerID','$postTitle','$subject','$eduLevel','$path')";
            if($this->makeQuery($sql) != NULL){
                $this->console_log("post stored");
            }
            else{
                $this->console_log("post not stored");
                return false;
            };

            //The table store post with an incremented value for each one, this returns it once it's inserted in the the db
            $postID = mysqli_insert_id($this->conn);
            //The file name is appended to the path to give the completelocation of the file rather than it's directory 
            $updatedPath = $path . '/' . $postID .'/' . $fileName;
            $this->console_log("Log!");
            $this->console_log($updatedPath);
            $sqlUpdatePath = "UPDATE Posts SET path = '$updatedPath' WHERE postID = '$postID'";
            $this->makeQuery($sqlUpdatePath);
            return $postID;
        }


        //Extra function -----------------------------------------------------------------//

        //This function is to make javascript print out errors/relevant info with sepcifed messages on the console
        public function console_log($data) {
            echo '<script>';
            echo 'console.log('. json_encode( $data ) .')';
            echo '</script>';
        } 

        //Carries out query but also prints error messages for debuging purposes
        public function makeQuery($Query){
            $this->console_log("Seocnd Log here");
            $this->console_log($Query);
            $Q = mysqli_query($this->conn, $Query);
            if($Q == False) {
                $this->console_log("Error creating Entry");
                echo mysqli_error($this->conn);
                return Null;
            } 
            else {
                $this->console_log("Query was a success!"); 
                return $Q;   
            }
        }

        //Returns connection to the database
        public function getConnection() {
            return $this->conn;
        }

        //Logins in an out users with appropriate actions taken to set and unset a session
        public function LogInOut($InOrOut) {
            if($InOrOut){
                $_SESSION['loggedIn'] = true;
                $this->console_log("Logged in!");
            }
            elseif($InOrOut == false){
                if(isset($_SESSION)){
                    session_unset();
                    session_destroy();
                }
                $this->console_log("Logged out");
            }
            else {
                $this->console_log("Login/out error");
            }
        }

        //Gets GCSE post entries on DB
        public function getGCSEPosts(){
            $sql = mysqli_query($this->conn,"SELECT * FROM Posts WHERE educationLevel='GCSE'");
            return $sql;
        }

        //Gets A-Level post entries on DB
        public function getALevelPosts(){
            $sql = mysqli_query($this->conn,"SELECT * FROM Posts WHERE educationLevel='A-Level'");
            return $sql;
        }

        //Get's user's numenrical ID
        public function getUserID($username){
            $sql = mysqli_query($this->conn, "SELECT * FROM Accounts WHERE username = '$username'");
            $row = mysqli_fetch_array($sql);
            $userID = $row['userID'];
            return $userID;
        }
    }
?>	