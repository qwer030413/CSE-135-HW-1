<!-- I think this is going to make things easier -->
<!-- not logged in then kick out -->
<?php
session_start();
function loggedIn(){
    if(!isset($_SESSION['user'])){
        header("Location: login.php");
        exit;
    }
}
// if they have no roles then kick them out
function Role($roles){
    loggedIn();
    // the roles is an array since there could be multiple roles that can view a page
    if(!in_array($_SESSION['user']['role'],$roles)){
        http_response_code(403);
        echo "403 Forbidden";
        exit;
    }
}