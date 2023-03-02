<?php 
    /*
    Created by : Beatrice Bjorn
    For : Projekt - Bloggportal - webbutveckling II, DT093G
    Last updated : 2022-03-22
    */
?>

<!--Includes the config-file to the page-->
<?php include("includes/config.php"); 

/* Checks if user is logged in, if not, the user is being redirected to the login page with a message saying that
the user has to be logged in to reach the admin page on this website. */
if(!isset($_SESSION['userName'])){
    header("location: login.php?message=You have to signed in to view the content on this page.");
}
?>

<!--Includes a titel, the head-file and the mainMenu-file to the page-->
<?php
    $page_title = "Administration";
    include("includes/head.php");
    include("includes/mainMenu.php");
?>


<div class="firstpageDiv">
    <p><i>You are here : Start - Sign in - Admin </i></p>
    <p>Signed in as :
        <!-- Displays the username of the logged in user by using the active session-variable -->   
        <?php 
        $userName = $_SESSION['userName'];
        echo $userName; ?>
    </p>

<h2 class="firstPageh2">Admin</h2>

<?php 
//Creates a new instance of the class Post
    $post = new Post();

// title, artist, posttext, youtube and spotify is set to empty strings    
    $titel= ""; $artist= ""; $posttext= ""; $youtube= ""; $spotify= "";

// To delete a blog post an if-statement checks if deleteid is set in the address bar and uses the intval method to ensure the id is an integer
    if(isset($_GET['deleteid'])){
        $deleteid = intval($_GET['deleteid']);
// The function deleteBlogPost ir run when there is an id present in the address bar        
// If blogpost was deletet successfully a confirming message is printed out and if not an error message is printed out
        if($post->deleteBlogPost($deleteid)){
            echo "<p class='confirmed'>Post deleted!</p>";
        }else{
            echo "<p class='error'>Something went wrong, try again!</p>";
        }
    }

// This if-statement checks weather the form has been submitted with all fields filled out correctly by using isset on the element with the name "titel"
    if(isset($_POST['titel'])){
// All the values submitted in the form is being stored in variables        
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

// A variable called confirmed is being set to true
        $confirmed = true; 

// These if statements run the set-methods created in the Post class and sets confirmed to false if the if-statement returns true
// An error message is printed to the screen if the statement returns true
        if(!$post->setTitel($titel)){
            $confirmed = false;
            echo  "<p class='error'>You have to add a title!</p>";
        }

        if(!$post->setArtist($artist)){
            $confirmed = false;
            echo  "<p class='error'>You have to add an artist!</p>";
        }  

        if(!$post->setPosttext($posttext)){
            $confirmed = false;
            echo  "<p class='error'>You have to write a post!</p>";
        }
        if(!$post->setYoutube($youtube)){
            $confirmed = false;
            echo  "<p class='error'>You have to add a valid link!</p>";
        }

        if(!$post->setSpotify($spotify)){
            $confirmed = false;
            echo  "<p class='error'>You have to add a valid link!</p>";
        }  


/* If all the input-fileds in the form have been filled out properly the function addBlogPost will run and add the blog post to the database and then reset 
the values in the input fileds to empty strings. A message confirming that the post has been added will show on the screen.
If the post was not added to the database an error message will show on the screen.
*/ 
        if($confirmed){
            if($post->addBlogPost($userName, $titel, $artist, $posttext, $youtube, $spotify)){
                echo "<p class='confirmed'>Post added!</p>";
                    $titel= ""; $artist= ""; $posttext= ""; $youtube= ""; $spotify= "";
            }else{
                echo "<p class='error'>Something went wrong, please try again</p>";
            }
        }
        else{
            echo "<p class='error'>Make sure all inout fields are filled</p>";
        }
}
?>

<!-- If the blog post fails to be added to the database the values inserted in the input fields are being
stored and stays on the screen so that the user do not have to rewrite all the information if the blog post is not succesfully added -->
<form class="adminForm" method="POST" action="admin.php">

    <label for="titelEditor">Name of song:</label> <br/>
    <textarea class="input" rows="1" cols="10" name="titel" id="titelEditor" placeholder="Song name"><?= $titel; ?></textarea><br/>
    <label for="editor3">Artist:</label> <br/>
    <textarea class="input" rows="1" cols="10" name="artist" id="editor3" placeholder="Name of artist" ><?= $posttext; ?></textarea><br/><br/>

    <label for="editor">Type your post here :</label> <br/>
    <textarea class="input" rows="10" cols="65" name="posttext" id="editor" placeholder="Post text" ><?= $posttext; ?></textarea><br/><br/>

    <label for="youtube">Paste youtube link here :</label> <br/>
    <input class="input" type="text" name="youtube" id="youtube" placeholder="Go to youtube and search for the song you want to share, copy the link top the song and paste here" value="<?= $youtube; ?>"><br/><br/>
    <label for="spotify">Paste spotify link here :</label> <br/>
    <input class="input" type="text" name="spotify" id="spotify" placeholder="Go to spotify and search for the song you want to share, click 'share' and copy link and paste here" value="<?= $spotify; ?>"><br/><br/>

    <input class="loginBtn" type="submit" value="Add post">
</form>

<h3>Your posts: </h3>
<table>
    <thead>
        <tr>
            <th>Titel</th>
            <th>Artist</th>
            <th>Date</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>

<!-- The function getSessionBlogPosts is used along with a foreach loop to make a list of all the blog posts created by the user whos logged in at the moment 

Anchor tags are added and linked to the id of the post to be able to delete and make changes to the blog posts -->    
        <?php 
            $post = new Post();
            $post_list = $post->getSessionBlogPosts();
            
            foreach($post_list as $p){
                ?>
                    <tr>
                        <td><?= $p['titel']; ?></td>
                        <td><?= $p['artist']; ?></td>
                        <td><?= $p['posted']; ?></td>
                        <td><a class="andra" href="update.php?id=<?= $p['id'] ?>">Edit</a></td>
                        <td><a class="radera" href="admin.php?deleteid=<?= $p['id'] ?>">Delete</a></td>
                    </tr>    
                <?php
            }
        ?>
    </tbody>
</table>
</div>

<!--Includes the footer-file to the page-->
<?php 
    include("includes/footer.php");
?>