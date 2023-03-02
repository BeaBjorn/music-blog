<?php 
    /*
    Created by : Beatrice Bjorn
    For : Projekt - Bloggportal - webbutveckling II, DT093G
    Last updated : 2022-03-22
    */
?>

<?php 
    //Class named "Account" with private properties
    class Account{
        //Private properties
        private $db;
        private $userName;
        private $firstName;
        private $surName;
        private $password;
        private $conf_password;
        private $agree;

    //cunstructor that connects to database or uses die to stop scripts from running if the connection to the database failed.
    //An error message will be shown on screen if the connection failed. 
        function __construct(){
            $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

            if($this->db->connect_errno > 0){
                die("Error connecting to database: " . $this->db-connect_error);
            }
        }

    // A function that takes two arguments, "userName" and "password" to login registered users on the website.    
    //An sql request gets all the information stored in the database table 'accounts' where userName is the same at the username 
    //entered in the login-form. If more than 0 rows are returned the password from the table is collected and compared to the 
    //password entered in the login-form by using the method "password_verify". 
    //If the if-statement returns true a sessionvariable is created to store the username of the logged in user. 
        public function loginUser(string $userName, string $password) : bool {
            $userName = $this->db->real_escape_string($userName);
            $password = $this->db->real_escape_string($password);
            $sql = "SELECT * FROM accounts WHERE userName='$userName';";

            $result = $this->db->query($sql);

            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $stored_pword = $row['password'];

                if(password_verify($password, $stored_pword)){
                    $_SESSION['userName'] = $userName;
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }

        // A function to register a user on the website. The function takes 5 arguments and returns either true or false.
        // The first if-statements checks that none of the set-methods have returned false
        /* real_escape_string is used to prevent special characters entered in the input fields in the form to 
        interfeer with the sql-request */
        /* The password entered in the password-field in the form will be hashed so that it is not possible to read 
        the password in the database */
        // The sql-requst inserts the values entered inthe input fields in the form to the right colimn in the database
        public function addAccount(string $userName, string $firstName, string $surName, string $password, string $conf_password) : bool {
            if(!$this->setFirstName($firstName)) return false;
            if(!$this->setSurName($surName)) return false;
            if(!$this->setUserName($userName)) return false;
            if(!$this->setPassword($password)) return false;
            if(!$this->setConf_password($password, $conf_password)) return false;
            if(!isset($_POST['agree'])) return false;

            $firstName = $this->db->real_escape_string($firstName);
            $surName = $this->db->real_escape_string($surName);
            $userName = $this->db->real_escape_string($userName);
            $password = $this->db->real_escape_string($password);
            $conf_password = $this->db->real_escape_string($conf_password);
           
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO accounts(userName, firstName, surName, password)VALUES('$userName', '$firstName', '$surName', '$hashed_password');";
            $result = $this->db->query($sql);
            return $result;
        }

        // A function using a session-variable to prevent users that are not logged in to access restricted pages on the website
        public function adminOnly() : bool {
            if(!isset($_SESSION['userName'])){
                header("location: login.php");
                exit;
            }
        }

        // A function that gets the account information stored in the database so that it can be dispayed on screen if needed
        // The sql-request is useing "order by" so that the data returned is displayed in alpabetic order
        public function accountInfo() : array {
            $sql = "SELECT * FROM accounts ORDER BY userName ASC;";

            $result = mysqli_query($this->db, $sql);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        // A function that checks weather a username already exists in the database or not 
        // real_escape_string is used to compare the name entered in the form with the name in the database
        // The sql-request gets checks if there is a username in the database that is the same as the username entered in the form
        /* If more than 0 rows are returned the name already exists and if less than 0 rows are being returned 
        that means the name does not exist in the database */
        public function nameTaken($userName) : bool {
            $userName = $this->db->real_escape_string($userName);
            $sql = "SELECT userName FROM accounts WHERE userName='$userName';";
            $result = mysqli_query($this->db, $sql);
            if($result->num_rows > 0) {
                return false;
            } else {
                return true;
            }
        }

        // A set-method that checks that the firstname entered in the form is longer than 0 characters
        public function setFirstName(string $firstName) : bool {
            if ($firstName !== "") {
                $this->firstName = $firstName;
                return true;
              }else{
                return false;
            }
        }

        // A set-method that checks that the surname entered in the form is longer than 0 characters
        public function setSurName(string $surName) : bool {
            if ($surName !== "") {
                $this->surName = $surName;
                return true;
              }else{
                return false;
            }
        }

        // A set-method that checks that the username entered in the form is longer than or equal to 4 characters
        public function setUserName(string $userName) : bool {
            if (strlen($userName) >= 4) {
                $this->userName = $userName;
                return true;
              }else{
                return false;
            }
        }

        // A set-method that checks that the password entered in the form is longer than or equal to 8 characters
        public function setPassword(string $password) : bool {
            if (strlen($password) >= 8) {
                $this->password = $password;
                return true;
              }else{
                return false;
            }
        }

        // A set-method that checks that the confirming password entered in the form is the same as te password entered in the input-field above
        public function setConf_password(string $password, string $conf_password) : bool {
            if ($password === $conf_password) {
                $this->conf_password = $conf_password;
                return true;
              }else{
                return false;
            }
        }

        // A set-method checking that the checkbox in the form i ticked (not equal to null)
        public function setAgree($agree) : bool {
            if ($agree !== null) {
                $this->agree = $agree;
                return true;
              }else{
                return false;
            }
        }

        // A destructor is called when the script stops running
        function __destruct(){
            mysqli_close($this->db);
        }
    }   