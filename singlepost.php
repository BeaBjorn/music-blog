<?php 
    /*
    Created by : Beatrice Bjorn
    For : Projekt - Bloggportal - webbutveckling II, DT093G
    Last updated : 2022-03-22
    */
?>


<!--Includes the config-file to the page-->
 <?php include("includes/config.php"); ?>

<!-- this code block checks if an id has been set and that the id is an integer. A new instance of the 
class Post is created and the function getBlogPostById with the argument $id is stored in a variable called $details. 
If an id has not been set the user will be sent back to the page allposts.php -->
<?php 
    if(isset($_GET['id'])){
        $id = intval($_GET['id']);

        $post = new Post();

        $details = $post->getBlogPostById($id);
        
    }else {
        header("location: allposts.php");
    }
?>

 <!--Includes the title and head-file to the page-->
<?php 
    $page_title = $details['titel'];
    include("includes/head.php");
 ?>

  <!--Includes the mainMenu-file to the page-->
 <?php
    include("includes/mainMenu.php");
?>

<!-- $details is used to print data from the database to the screen. -->
<div class="firstpageDiv">
<p><i>You are here : Start - View post - <?= $details['titel']; ?></i></p>
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
<!-- $details is used to print data from the database to the screen. -->
<h2 class="firstPageh2">Created by : <?= $details['userName']?><br /> date : <?= $details['posted']?></h2>
    <div class="postDiv"> 
        <article>
            <h2><?= $details['titel']; ?></h2>
            <p><?= $details['posttext']; ?></p>
            <p>Listen to <i><?= $details['titel']; ?> by <?= $details['artist'] ?></i> by clicking one of the icons below.</p>
                <div class="listen">
                <a class="youtube" href="<?= $details['youtube']?>" target="_blank"><img width="80" height="75" src="images/youtube.svg" alt="youtube"/></a>
                <a class="spotify" href="<?= $details['spotify']?>" target="_blank"><img width="80" height="75" src="images/spotify.svg" alt="spotify"/></a>
                </div>   
        </article>
    </div>

</div>

<!--Includes the footer-file to the page-->
<?php 
    include("includes/footer.php");
?>