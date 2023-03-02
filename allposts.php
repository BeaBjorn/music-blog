<?php 
    /*
    Created by : Beatrice Bjorn
    For : Projekt - Bloggportal - webbutveckling II, DT093G
    Last updated : 2022-03-22
    */
?>

<!--Includes the config-file to the page-->
<?php include("includes/config.php"); ?>

<!--Includes a titel and the head-file to the page-->
<?php 
    $page_title = "Alla Poster";
    include("includes/head.php");
 ?>

<!--Includes the mainMenu-file to the page-->
 <?php
    include("includes/mainMenu.php");
?>

<div class="firstpageDiv">
<p><i>You are here : Start - All posts </i></p>

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
<h2 class="firstPageh2">All posts</h2>

<i> - Click "view post" to listen to the song! </i>


<!-- An instance of the class Post is being created and the function getBlogPosts is run to collect the data from the table posts in the database
A foreach loop is being used to loop through the data and then display it on the screen
substr is used to shorten the text on the blog post if it cointains more than 500 characters
an anchor tag along with the id of the post is used to provide a link to see the whole content of the blog posts on a separate page. -->
<?php 
     $post = new Post();

     $post_list = $post->getBlogPosts();

     foreach($post_list as $p){
         ?>
        <div class="postDiv">
       
        <article>
        <p>Created : <?= $p['posted']; ?><br /> By : <?= $p['userName']; ?></p>
        <h3><?= $p['titel']; ?> - <?= $p['artist'] ?></h3>
            <?= substr($p['posttext'], 0, 501);?><a class="lasMer" href="singlepost.php?id=<?= $p['id']; ?>"> - View post</a>
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
