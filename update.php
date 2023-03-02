<?php 
    /*
    Created by : Beatrice Bjorn
    For : Projekt - Bloggportal - webbutveckling II, DT093G
    Last updated : 2022-03-22
    */
?>

<!--Includes the config-file to the page-->
<?php include("includes/config.php"); ?>

<!-- Checks if a user is logged in, if not, the user is being redirected to the login page where a message saying that
the user have to be logged in to reach the admin page is displayed. -->
<?php 
    if(!isset($_SESSION['userName'])){
        header("location: login.php?message=You have to be signed in to access the content on this page!");
    }

//Creates a new instance of the class Post    
    $post = new Post();

// Checks if id is set in the address bar and uses intval to ensure the id is an integer
    if(isset($_GET['id'])){
        $id = intval($_GET['id']);

/* A variable called $details is created and stores the function getBlogPostById to get data from the database for the specific 
blog post selected by id. If no blogpost has been selected the user will be redirected back to te admin.php page */
     $details = $post->getBlogPostById($id);
        }else{
            header("location: admin.php");
        }
?>

<!--Includes the head-file to the page and adds the title to the page by using the variable $details-->
<?php 
    $page_title = "Edit - " . $details['titel'];
    include("includes/head.php");
?>

 <!--Includes the mainMenu-file to the page-->
<?php
    include("includes/mainMenu.php");
?>

<div class="firstpageDiv">
<p><i>You are here : Start - Sign in - Admin - Edit ( <?= $details['titel']; ?> ) </i></p>

<!-- Displays the username of the logged in user by using the active session-variable -->   
<p>Signed in as :
    <?php 
        $userName = $_SESSION['userName'];
        echo $userName; 
    ?>
</p>

<h2 class="firstPageh2">Edit post - <?= $details['titel']?></h2>

<?php 
// This if-statement checks weather the form has been submitted with all fields filled out correctly by using isset on the element with the name "titel" 
     if(isset($_POST['titel'])){
        $titel = $_POST['titel'];
        $artist = $_POST['artist'];
        $posttext = $_POST['posttext'];
        $youtube = $_POST['youtube'];
        $spotify = $_POST['spotify'];
        $userName = $_SESSION['userName'];

// htmlenteties is being used to convert html-tags so that the text stored in the database doesn't contain html-tags och script tags
// htmlenteties converts the html-tags to codes that look the same as the tags but doesn\t work the way html-tags do
        $titel = htmlentities($titel, ENT_QUOTES, 'UTF-8');
        $artist = htmlentities($artist, ENT_QUOTES, 'UTF-8');
        $posttext = htmlentities($posttext, ENT_QUOTES, 'UTF-8');
        $youtube = htmlentities($youtube, ENT_QUOTES, 'UTF-8');
        $spotify = htmlentities($spotify, ENT_QUOTES, 'UTF-8');

//$confirmed is set to true if all fields have been filled out properly    
        $confirmed = true;

// These if statements run the set-methods created in the Post class and sets confirmed to false if the if-statement returns true
// An error message is printed to the screen if the statement returns true  
        if(!$post->setTitel($titel)){
            $confirmed = false;
            echo "<p class='error'>Name of song required!</p>";
        }

        if(!$post->setArtist($artist)){
            $confirmed = false;
            echo  "<p class='error'>Name of artist required</p>";
        }  

        if(!$post->setPosttext($posttext)){
            $confirmed = false;
            echo "<p class='error'>Blog text required!</p>";
        }

        if(!$post->setYoutube($youtube)){
            $confirmed = false;
            echo  "<p class='error'>Valid link required</p>";
        }

        if(!$post->setSpotify($spotify)){
            $confirmed = false;
            echo  "<p class='error'>Valid link required</p>";
        }  


/* If all the input-fileds in the form have been filled out properly the function updateBlogPost will run and add the new information to the database
A message confirming that the post has been updated will show on the screen.
If the post was not updated to the database an error message will show on the screen.
*/           
        if($confirmed){
            if($post->updateBlogPost($id, $userName, $titel, $artist, $posttext, $youtube, $spotify)){
                echo "<p class='confirmed'>Post updated!</p>";
            }else{
                echo "<p class='error'>Something went wrong, post not updated</p>";
            }
        }else{
                echo "<p class='error'>Something went wrong, post not updated</p>";
        }
    }

?>

<!-- The data from the database is inserted into the input-fields to allow the user to make changes to the blog post-->
<form class="adminForm" method="POST" action="update.php?id=<?= $id; ?>">
    <label for="updateEditor">Edit title:</label>  <br />
    <textarea class="input" rows="1" cols="10" name="titel" id="updateEditor" placeholder="Title"><?= $details['titel']; ?></textarea><br/>
    <label for="editor3">Artist:</label> <br/>
    <textarea class="input" rows="1" cols="10" name="artist" id="editor3" placeholder="Artist" ><?= $details['artist']; ?></textarea><br/><br/>

    <label for="updateTitel">Post text</label> <br />
    <textarea class="input" rows="10" cols="65" name="posttext" id="updateTitel" placeholder="Type here..."><?= $details['posttext']; ?></textarea><br /><br/>

    <label for="youtube">Paste link here :</label> <br/>
    <input class="input" type="text" name="youtube" id="youtube" placeholder="Youtube link" value="<?= $details['youtube']?>"><br/><br/>

    <label for="spotify">Paste link here :</label> <br/>
    <input class="input" type="text" name="spotify" id="spotify" placeholder="Spotify link" value="<?= $details['spotify']?>"><br/><br/>

    <input class="loginBtn" type="submit" value="Edit post"><br /><hr /><br />

    <a href="admin.php" class="loginBtn">Back to admin page</a><br /><br />

</form>
</div>

<!--Includes the footer-file to the page-->
<?php 
    include("includes/footer.php");
?>