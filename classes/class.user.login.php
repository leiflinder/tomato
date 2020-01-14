<?php
class login{
    function loginform(){
    // actual HTML login form
    echo "<div class='account-wall'>";
    echo "<div id='my-tab-content' class='tab-content'>";
        echo "<div class='tab-pane active' id='login'>";
            echo "<img class='profile-img' src='images/login-icon.png'>";
            echo "<form class='form-signin' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
                echo "<input type='text' name='email' class='form-control' placeholder='Email' required autofocus />";
                echo "<input type='password' name='password' class='form-control' placeholder='Password' required />";
                echo "<input type='submit' class='btn btn-lg btn-primary btn-block' value='Log In' />";
            echo "</form>";
        echo "</div>";
    echo "</div>";
echo "</div>";
    }
}

?>