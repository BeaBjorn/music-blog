<?php 
    /*
    Created by : Beatrice Bjorn
    For : Projekt - Bloggportal - webbutveckling II, DT093G
    Last updated : 2022-03-22
    */
?>

<!-- The footer element saved in its own file to be able to include it on all pages -->
</main>
<footer>
    <div class="usersMobile">
        <!-- This list is being displayed when the website is accessed on a cellphone -->
        <p class="regUsersMobile">Registered users : </p>
        <!-- A php-block that starts an instance of the class Account and runs the function accountInfo
             A foreach loop is being used to loop through the data collected from the database and then display in on the screen in a link -->
            <?php 
                $accounts = new Account();
                $user = $accounts->accountInfo();

                foreach($user as $u){
                ?>
                <div class="usersListMob">
                    <a  href="usersPosts.php?userName=<?= $u['userName'] ?>"><?= $u['userName'] ?> (<?= $u['firstName'] ?> <?= $u['surName'] ?>)</a>
                </div>
                <?php
              }
            ?>
     <p class="regUsers"> The icons used for spotify and yutube comes from the website icon8 : <a href="https://icons8.com/">www.icon8.com</a></p>
    </div>
</footer>

<script src="js/app.js"></script>

    </body>
</html>
