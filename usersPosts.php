<?php 
    /*
    Created by : Beatrice Bjorn
    For : Projekt - Bloggportal - webbutveckling II, DT093G
    Last updated : 2022-03-22
    */
?>

<!--Includes the config-file to the page-->
<?php include("includes/config.php"); ?>

<!-- this code block checks if the userName has been set.
 A new instance of the class Post is created and the function getUsersBlogPosts with the argument $user is stored in a variable called $userPosts. 
If an userName has not been set the user will be sent back to the page index.php -->
<?php 
    if(isset($_GET['userName'])){

        $post = new Post();
        $user = $_GET['userName'];
        $userPosts = $post->getUsersBlogPosts($user);
        
    }else {
        header("location: index.php");
    }
?>

<!--Includes the head-file to the page and sets the titel of the page-->
<?php 
    $page_title = "All posts from :" .  $_GET['userName'];;
    include("includes/head.php");
 ?>

<!--Includes the mainMenu-file to the page-->
 <?php
    include("includes/mainMenu.php");
?>


<div class="firstpageDiv">
<p><i>You are here : Start - Register user -  <?= $_GET['userName']; ?></i></p>

<!-- Displays the username of the logged in user by using the active session-variable --> 
<?php 
    if(isset($_SESSION['userName'])){
        ?>
            <p>Signed in as : 
                <?php
                    $userName = $_SESSION['userName'];
                    echo $userName; 
                ?> 
            </p> 
        <?php
    }
?>

<h2 class="firstPageh2">All posts created by <?= $_GET['userName']; ?></h2>


<!-- A foreach loop that loops through the data stored in the database  and to display it on the screen-->
<?php 
     foreach($userPosts as $u){
        ?>
        <div class="postDiv">
        <article>
        <p class="timestamp2"><?= $u['posted']; ?></p>

        <h2><?= $u['titel']; ?></h2>
            <p><?= $u['posttext']; ?></p>
            <p>Listen to <i><?= $u['titel']; ?> by <?= $u['artist'] ?></i> by clicking one of the icons below. </p>
                <div class="listen">
                <a class="youtube" href="<?= $u['youtube']?>" target="_blank"><img width="80" height="75" src="images/youtube.svg" alt="youtube"/></a>
                <a class="spotify" href="<?= $u['spotify']?>" target="_blank"><img width="80" height="75" src="images/spotify.svg" alt="spotify"/></a>
                </div>   
        </article>
        </div>
         <?php
     }
?>
</div>

<!--Includes the footer-file to the page-->
<?php 
    include("includes/footer.php");
?>
