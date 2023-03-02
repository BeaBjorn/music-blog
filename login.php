<?php 
    /*
    Created by : Beatrice Bjorn
    For : Projekt - Bloggportal - webbutveckling II, DT093G
    Last updated : 2022-03-22
    */
?>
<!--Includes the config-file to the page-->
<?php include("includes/config.php"); ?>

<!--Includes the titel, the head-file and the mainMenu-file to the page-->
<?php
    $page_title = "Logga in";
    include("includes/head.php");
    include("includes/mainMenu.php");
?>

<div class="firstpageDiv">
<p><i>You are here : Start - Sign in </i></p>
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
<h2 class="loginh2">Sign in</h2>

<!-- checks if message has been printet to the address bar, if so a message defined in admin.php will show. -->
<?php
if(isset($_GET['message'])){
    echo "<p class='error'>" . $_GET['message'] . "</p>";
}
?>

<!-- the method POST is being used to send the form -->
<form method="POST" action="login.php">
<?php

// The variables userName and password are being set to empty strings
        $userName = "";
        $password = "";

// This if-statement checks weather the form has been submitted with all fields filled out correctly by using isset on the element with the name "userName"   
    if(isset($_POST['userName'])){

// The values submitted in the form is being stored in variables     
        $userName = $_POST['userName'];
        $password = $_POST['password'];

// htmlenteties is being used to convert html-tags so that the text stored in the database doesn't contain html-tags och script tags
// htmlenteties converts the html-tags to codes that look the same as the tags but doesn\t work the way html-tags do
        $userName = htmlentities($userName, ENT_QUOTES, 'UTF-8');
        $password = htmlentities($password, ENT_QUOTES, 'UTF-8');

// An instance of the class Account is being created     
        $account = new Account();
  
/* If the input-fileds in the form has been filled out properly the function loginUser will run and the user will be sent to the administration page of the website
If the user was not logged in an error message will show saying that either the username or the password.*/ 
        if($account->loginUser($userName, $password)){
            header("location: admin.php");
        }else{
            echo "<p class='error'>Wrong username or password, try again.</p>";
        }
    }

    ?>

<!-- If the user fails to login the values inserted in the input fields are being stored and stays on the screen so that the user do not have to rewrite the information previously entered -->
    <label for="userName">Username:</label> <br/>
    <input class="input" type="text" name="userName" id="userName" placeholder="username" value="<?= $userName; ?>"><br/><br/>
    <label for="password">Password:</label> <br/>
    <input class="input" type="password" name="password" id="password" placeholder="Password" value="<?= $password ?>"><br/>
    <input class="loginBtn" type="submit" value="Sign in">
    
</form>

</div>

<!--Includes the footer-file to the page-->
<?php 
    include("includes/footer.php");
?>


