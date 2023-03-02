<?php 
    /*
    Created by : Beatrice Björn
    For : Projekt - Bloggportal - webbutveckling II, DT093G
    Last updated : 2022-03-22
    */ 
?>

<!--Includes the config-file to the page-->
<?php include("includes/config.php"); ?>

<!--Includes the head-file to the page-->
<?php 
    $page_title = "Startsida";
    include("includes/head.php");
?>

<!--Includes the mainMenu-file to the page-->
<?php
    include("includes/mainMenu.php");
?>

<div class="firstpageDiv">
    <p><i>You are here : Start</i></p>
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
    
    <h2 class="firstPageh2">Welcome to Bea's Music Blog!</h2>
    <p class="indexP">In this blog you can create a user account and share songs you like. You can also listen to songs and read posts from other users.
       <br />
       Have you got music that you want to share with others? Don't hesitate, sign up!<a href="signup.php"> - Create an account here! </a>
    </p>

<h2 class="firstPageh2">Most recent posts</h2>
<i> - Click "view post" to listen to the song!  </i>

<!-- This code block creates a new instance of te class named Post. The function named getBlogPostsIndex is run and a 
foreach-loop is used to loop through the data in the database table posts. The method substr is used to only show the first 500 characters of the text in the blogpost 
and an anchor tag along with the id of the post is used to provide a link to see the whole content of the blog posts on a separate page. -->
<?php 
     $post = new Post();

     $post_list = $post->getBlogPostsIndex();

     foreach($post_list as $p){
?>
       <div class="postDiv">   
     
        <article>
        <p>Created : <?= $p['posted']; ?><br /> By : <?= $p['userName']; ?></p>
        <h3><?= $p['titel']; ?> - <?= $p['artist'] ?></h3>
       
                <p><?=substr($p['posttext'], 0, 501);?></p><a class="lasMer" href="singlepost.php?id=<?= $p['id']; ?>"> - Show post</a><br />
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