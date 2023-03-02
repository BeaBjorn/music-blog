<?php 
    /*
    Created by : Beatrice Bjorn
    For : Projekt - Bloggportal - webbutveckling II, DT093G
    Last updated : 2022-03-22
    */
?>

<?php
// Starts the session for logged in users
session_start();

// Sets the title of the website followed by a devider
    $site_title = "Beas Musikblogg";
    $divider = " | "; 

//Includes all the classes
    spl_autoload_register(function($class_name){
        include 'classes/' . $class_name . '.class.php';
    });

//A variable called "devmode" set to true if the website is being developed
    $devmode = false;
// If "devmode" is true error-reporting starts and the website connects to the local database
// If "devmode" is false the error-reporting stops and the website connects to a public database 
    if($devmode){
        error_reporting(-1);
        ini_set("display_errors", 1);
        define("DBHOST", "localhost");
        define("DBUSER", "musicdb");
        define("DBPASS", "password");
        define("DBDATABASE", "musicdb");
    }else{
        define("DBHOST", "studentmysql.miun.se");
        define("DBUSER", "bebj2100");
        define("DBPASS", "5wqnN9VDz9");
        define("DBDATABASE", "bebj2100");
    }    
?>
  
 