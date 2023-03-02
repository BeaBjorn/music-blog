<?php 
    /*
    Created by : Beatrice Bjorn
    For : Projekt - Bloggportal - webbutveckling II, DT093G
    Last updated : 2022-03-22
    */
?>

<?php 
    //Class named "Post" with properties
    class Post{
        //properties
        private $db;
        private $id;
        private $titel;
        private $artist;
        private $posttext;
        private $userName;
        private $youtube;
        private $spotify;

    
    //cunstructor that connects to database or uses die to stop scripts from running if the connection to the database failed.
    //An error message will be shown on screen if the connection failed. 
        function __construct(){
           $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

            if($this->db->connect_errno > 0){
                die("Error connecting to database: " . $this->db-connect_error);
            }
        }

        // A function add blog posts on the website. The function takes 5 arguments and returns either true or false.
        // The first if-statements checks that none of the set-methods have returned false
        // The sql-requst inserts the values entered in the input fields in the form to the right colimn in the database
        public function addBlogPost(string $userName, string $titel, string $artist, string $posttext, string $youtube, string $spotify) : bool {
            if(!$this->setTitel($titel)) return false;
            if(!$this->setArtist($artist)) return false;
            if(!$this->setPosttext($posttext)) return false;
            if(!$this->setYoutube($youtube)) return false;
            if(!$this->setSpotify($spotify)) return false;

            $sql = "INSERT INTO posts(userName, titel, artist, posttext, youtube, spotify)VALUES('" . $_SESSION['userName'] . "', '" . $this->titel . "', '" . $this->artist . "', '" . $this->posttext . "', '" . $this->youtube . "', '" . $this->spotify . "');"; 

            return mysqli_query($this->db, $sql);
        }
            
        
        // A function used to update blog posts on the webbsite. 
        /* The function is very similar to the on above for adding blog posts but takes the additional argument "id" to decide which blog
        posts to update */
        // The sql-request is using "UPDATE" and "SET" to update the data in the database to the new data entered in the form
         public function updateBlogPost(int $id, string $userName, string $titel, string $artist, string $posttext, string $youtube, string $spotify) : bool {
            if(!$this->setTitel($titel)) return false;
            if(!$this->setArtist($artist)) return false;
            if(!$this->setPosttext($posttext)) return false;
            if(!$this->setYoutube($youtube)) return false;
            if(!$this->setSpotify($spotify)) return false;
            
            $sql = "UPDATE posts SET userName='" . $_SESSION['userName'] . "', titel='" . $this->titel . "', artist='" . $this->artist . "', posttext='" . $this->posttext . "', youtube='" . $this->youtube . "', spotify='" . $this->spotify . "' WHERE id=$id;";

            return mysqli_query($this->db, $sql);
        }

        // A function that collects the blog posts created by the registered user that is logged in at the time
        // The session variable that starts when a user logs in is used tand compared to the username stored in the database
        public function getSessionBlogPosts() : array {
            $userName = $_SESSION['userName'];
            $sql = "SELECT * FROM posts WHERE userName='$userName';";
            
            $result = mysqli_query($this->db, $sql);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        // A function that collects all the blogposts created by a specific user. 
        // This function is used to be able to display all blog posts by a specific user when a link including the name of the user is clicked
        public function getUsersBlogPosts(string $userName) : array {
            $userName = $this->db->real_escape_string($userName);
            $sql = "SELECT * FROM posts WHERE userName='$userName';";
            
            $result = mysqli_query($this->db, $sql);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        // A function used to display tha latest five posts on the index page of the website. 
        // The blogposts are limited to 5 and is displayed in descending order by the date and time they were posted
        public function getBlogPostsIndex() : array {
            $sql = "SELECT * FROM posts ORDER BY posted DESC LIMIT 5;";

            $result = mysqli_query($this->db, $sql);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        // This function gets all the blog posts from the database and displayes them in descending order by the date and time they were posted
        public function getBlogPosts() : array {
            $sql = "SELECT * FROM posts ORDER BY posted DESC;";

            $result = mysqli_query($this->db, $sql);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        // A function used to be able to display single blog posts from the database. 
        // The function is using the argument "id" and compares an id entered in a link to the id stored in the database. 
        public function getBlogPostById(int $id) : array {
            $id = intval($id);

            $sql = "SELECT * FROM posts WHERE id=$id;";

            $result = mysqli_query($this->db, $sql);
            return $result->fetch_assoc();
        }

        // A function to delete blog posts. This function also uses the id of the posts to decide which blog post is to be deleted  
        public function deleteBlogPost(int $id) : bool {
            $id = intval($id);

            $sql = "DELETE FROM posts WHERE id=$id;";

            return mysqli_query($this->db, $sql);
        }

        // A set-method that checks if the titel entered in the fomr is longer than 0 characters
        public function setTitel(string $titel) : bool {
            if($titel !== ""){
                $titel = $this->db->real_escape_string($titel);
                $this->titel = $titel;
                return true;
            }else{
                return false;
            }
        }

        // A set-method that checks if the artist entered in the fomr is longer than 0 characters
        public function setArtist(string $artist) : bool {
            if($artist !== ""){
                $artist = $this->db->real_escape_string($artist);
                $this->artist = $artist;
                return true;
            }else{
                return false;
            }
        }

        // A set-method that checks if the post text entered in the fomr is longer than 0 characters
        public function setPosttext(string $posttext) : bool {
            if($posttext !== ""){
                $posttext = $this->db->real_escape_string($posttext);
                $this->posttext = $posttext;
                return true;
            }else{
                return false;
            }
        }

        // A set-method that checks if the youtube link entered in the fomr is longer than 0 characters and is a valid URL
        public function setYoutube(string $youtube) : bool {
            if(filter_var($youtube, FILTER_VALIDATE_URL) && $youtube !== ""){
                $youtube = $this->db->real_escape_string($youtube);
                $this->youtube = $youtube;
                return true;
            }else{
                return false;
            }
        }

        // A set-method that checks if the spotify link entered in the fomr is longer than 0 characters and is a valid URL
        public function setSpotify(string $spotify) : bool {
            if(filter_var($spotify, FILTER_VALIDATE_URL) && $spotify !== ""){
                $spotify = $this->db->real_escape_string($spotify);
                $this->spotify = $spotify;
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
?>