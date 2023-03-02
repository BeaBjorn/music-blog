
<?php 
    /*
    Created by : Beatrice Bjorn
    For : Projekt - Bloggportal - webbutveckling II, DT093G
    Last updated : 2022-03-22
    */
?>

<!-- This code block uses session_unset to delete all the variables and then session_destroy to destroy the whole session.
The user is then redirected to index.php and exit() is used to stop the php code from running. -->
<?php 
    session_start();
    session_unset();
    session_destroy();

    header("location: index.php");
  
    exit();
?>