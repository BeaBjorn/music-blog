<?php 
    /*
    Created by : Beatrice Bjorn
    For : Projekt - Bloggportal - webbutveckling II, DT093G
    Last updated : 2022-03-22
    */
?>

<?php 
//Includes the config-file to the page
    include("includes/config.php");

//Connect to the database and sends out an error message if the connection failed
    $db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
    if($db->connect_errno > 0){
        die("Fel vid databasanslutning: " . $db->connect_error);
}

// This sql-request checks the if any of the tables below exists in the database
// If the tables exists they are being deleted
$sql = "DROP TABLE IF EXISTS accounts, posts;";      


// This sql-request creates a table called accounts in the database
// The table consists of 5 columns, the one with the name "userName" is the primary key for the table
// To store the date when a post was added to the database the "current_timestamp" method is being used
$sql .= "CREATE TABLE accounts(
    userName VARCHAR(128) PRIMARY KEY NOT NULL,
    firstName VARCHAR(80) NOT NULL, 
    surName VARCHAR(80) NOT NULL, 
    password VARCHAR(260) NOT NULL, 
    joined timestamp NOT NULL DEFAULT current_timestamp()
    );";

// This sql-request creates a table called posts in the database
// The table consists of 9 columns, the one with the name "id" is the primary key and is being auto icremented when an account is being added to the database
// To store the date when a post was added to the database the "current_timestamp" method is being used
// userName is the foreign key in this table to link this table to the accounts table 
$sql .= "CREATE TABLE posts(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    titel VARCHAR(128) NOT NULL, 
    artist VARCHAR(128) NOT NULL, 
    posttext TEXT NOT NULL, 
    youtube TEXT NOT NULL,
    spotify TEXT NOT NULL,
    posted timestamp NOT NULL DEFAULT current_timestamp(),
    userName VARCHAR(100) NOT NULL,
    CONSTRAINT FK_userName FOREIGN KEY(userName)REFERENCES accounts(userName)
    );";

//prints sql questions with the tables to the screen
echo "<pre>$sql</pre>";

// This prints a message to the screen saying weather the installation of the tables inthe database was successful or not
if($db->multi_query($sql)){
    echo "Tabell installerad i databas!";
}else{
    echo "Något gick snett vid installation av tabell.";
}
?>