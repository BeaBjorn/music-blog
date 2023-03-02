<?php 
    /*
    Created by : Beatrice Bjorn
    For : Projekt - Bloggportal - webbutveckling II, DT093G
    Last updated : 2022-03-22
    */
?>

<!-- The mainMenu.php includes the main menu for te website and is stored in its own file so that it can be included on all files on the website. -->
<header>
  <div class="topBanner">
      <a href="index.php">
         <img alt="logotype" class="logo" width="130" height="114" src="images/logotypmb.svg">
      </a>
      <div class="h1">
               <h1>BEA'S MUSIC BLOG</h1> 
      </div>

   </div>
<!-- The span-element includes the date created in Javascript -->
 <p><span id="date"></span></p>
   <nav>
  
   <ul class="menu">
      <!-- The menu is displayed differently depending on weather a user is logged in or not. 
      If the session-variable exists the user is logged in and the first menu in the block below is shown on the website
      If the session-variable doesnt exist the user is logged out and and the second menu in the block below is shown -->
         <?php 
            if(isset($_SESSION['userName'])){
               ?>
               <li class="menulist"><a href="index.php" class="menuItem">Start</a></li>
               <li class="menulist"> <a href="allposts.php" class="menuItem">All posts</a></li>
               <li style="display: none" id="login" class="menulist"> <a href="login.php" class="menuItem">Sign in</a></li>
               <li style="display: none" id="createAccount" class="menulist"> <a href="signup.php" class="menuItem">Create an account</a></li>
               <li class="menulist"><a href="admin.php" class="menuItem">Admin</a></li>
               <li class="menulist"> <a href="logout.php" class="menuItem">Log out</a></li>
            <?php
            }else{
            ?>
               <li class="menulist"><a href="index.php" class="menuItem">Start</a></li>
               <li class="menulist"> <a href="allposts.php" class="menuItem">All posts</a></li>
               <li id="login" class="menulist"> <a href="login.php" class="menuItem">Sign in</a></li>
               <li id="createAccount" class="menulist"> <a href="signup.php" class="menuItem">Create an account</a></li>
            <?php
            }
            ?>

      </ul>
      <button class="hamburger">
                <img class="openMenu" width="50" height="50" alt="button to open manu" src="images/dropMenu.svg">
                <img class="closeMenu" width="50" height="50" alt="button to close menu" src="images/closeIcon.svg">
      </button>

      <img alt="" class="navImg" width="200" height="600" src="images/musicBar.svg">
    

      <div class="usersDesktop">
      <!-- This list is being displayed when the website is being accessed on a desctop -->
      <p>Registered users : </p>
        <!-- A php-block that starts an instance of the class Account and runs the function accountInfo
             A foreach loop is being used to loop through the data collected from the database and then display in on the screen in a link -->
      <?php 
         $account = new Account();
        
         $user = $account->accountInfo();
         foreach($user as $u){
            ?>
         <div class="usersList">
         <a  href="usersPosts.php?userName=<?= $u['userName'] ?>"><?= $u['userName'] ?> (<?= $u['firstName'] ?> <?= $u['surName'] ?>)</a>
         </div>
          <?php
         }
      ?>
      <p> The icons used for spotify and yutube comes from the website icon8 : <a href="https://icons8.com/">www.icon8.com</a></p>
      </div>

   </nav>

</header>

<main>
     