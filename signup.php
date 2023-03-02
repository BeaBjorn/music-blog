<?php 
    /*
    Created by : Beatrice Bjorn
    For : Projekt - Bloggportal - webbutveckling II, DT093G
    Last updated : 2022-03-22
    */
?>

<!--Includes the config-file, the title, the head and the menu to the page-->
<?php include("includes/config.php"); 

    $page_title = "Skapa konto";
    include("includes/head.php");
    include("includes/mainMenu.php");
?>

<div class="firstpageDiv">
    <p><i>You are here : Start - Create account </i></p>
        <h2 class="firstPageh2">Create an account</h2>
            <form class="adminForm" method="POST" action="signup.php">
                <?php
                //Creates an instance of the class Account
                $account = new Account();

                // sets the cariables to empty strings
                $firstName = "";
                $surName = "";
                $userName = "";
                $password = "";
                $conf_password = "";

                // This if-statement checks weather the form has been submitted with all fields filled out correctly by using isset on the element with the name "userName"
                if(isset($_POST['userName'])){
                // All the values submitted in the form is being stored in variables   
                $firstName = $_POST['firstName'];
                $surName = $_POST['surName'];
                $userName = $_POST['userName'];
                $password = $_POST['password'];
                $conf_password = $_POST['conf_password'];

                // htmlenteties is being used to convert html-tags so that the text stored in the database doesn't contain html-tags och script tags
                // htmlenteties converts the html-tags to codes that look the same as the tags but doesn\t work the way html-tags do
                $firstName = htmlentities($firstName, ENT_QUOTES, 'UTF-8');
                $surName = htmlentities($surName, ENT_QUOTES, 'UTF-8');
                $userName = htmlentities($userName, ENT_QUOTES, 'UTF-8');
                $password = htmlentities($password, ENT_QUOTES, 'UTF-8');
                $conf_password = htmlentities($conf_password, ENT_QUOTES, 'UTF-8');
                    
                // A variable called confirmed is being set to true
                $confirmed = true;

                // These if-statements run the set-methods created in the Post class and sets confirmed to false if the if-statement returns true
                // An error message is printed to the screen if the if-statement returns true
                if(!$account->setUserName($userName)){
                    $confirmed = false;
                    echo "<p class='error'>Username has to contain at least 4 characters</p>";
                }

                if(!$account->nameTaken($userName)){
                    $confirmed = false;
                    echo "<p class='error'>User already exist, try logging in or use another username</p>";
                }

                if(!$account->setFirstName($firstName)){
                    $confirmed = false;
                    echo "<p class='error'>First name required</p>";
                }

                if(!$account->setSurName($surName)){
                    $confirmed = false;
                    echo "<p class='error'>Surname required</p>";
                }

                if(!$account->setPassword($password)){
                    $confirmed = false;
                    echo "<p class='error'>Password has to contain at least 8 characters</p>";
                }

                if(!$account->setConf_password($password, $conf_password)){
                    $confirmed = false;
                    echo "<p class='error'>Passwords are not matching!</p>";
                }

                if(!isset($_POST['agree'])){
                    $confirmed = false;
                    echo "<p class='error'>You have to agree to store you're personal details in</p>";
                }

                /* If all the input-fileds in the form have been filled out properly the function addAccount will run and add the information to the database and then reset 
                the values in the input fileds to empty strings. A message confirming that the account has been added will show on the screen.
                If the account was not added to the database an error message will show on the screen.
                */ 
                if($account->addAccount($userName, $firstName, $surName, $password, $conf_password)){
                    $firstName = "";
                    $surName = "";
                    $userName = "";
                    $password = "";
                    $conf_password = "";

                    echo  "<p class='confirmed'>Account created! Sign in to start creating posts<a href='login.php'> - Sign in!</a></p>";
                    }else{
                    echo "<p class='error'>Something went wrong, check all fileds and try again</p>";
                    }

            }
            ?>
                <!-- If the account fails to be added to the database the values inserted in the input fields are being
                stored and stays on the screen so that the user do not have to rewrite all the information if the account is not succesfully added -->
                <label for="userName">Username: </label> <br/>
                <input class="input" type="text" name="userName" id="userName" placeholder="Username" value="<?= $userName; ?>"><br/><br/>

                <label for="firstName">Firstname: </label> <br/>
                <input class="input" type="text" name="firstName" id="firstName" placeholder="Firstname" value="<?= $firstName; ?>"><br/><br/>

                <label for="surName">Surname: </label> <br/>
                <input class="input" type="text" name="surName" id="surName" placeholder="Surname" value="<?= $surName; ?>"><br/><br/>

                <label for="password">Password: </label> <br/>
                <input class="input" type="password" name="password" id="password" placeholder="Password" value="<?= $password; ?>"><br/><br/>

                <label for="conf_password">Confirm password: </label> <br/>
                <input class="input" type="password" name="conf_password" id="conf_password" placeholder="Password" value="<?= $conf_password; ?>"><br/><br/>

                <input type="checkbox" name="agree" id="agree" value=""> 
                <label for="agree">I agree that aboove information is stored in database</label><br/><br/>
                <input class="loginBtn" type="submit" value="Create account">

            </form>
</div>

<!--Includes the footer-file to the page-->
<?php 
    include("includes/footer.php");
?>

